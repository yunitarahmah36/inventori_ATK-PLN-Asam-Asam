<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LandingBookController extends Controller
{
    /**
     * Tampilkan halaman publik peminjaman buku dan katalog koleksi.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $category = $request->input('category');
        $availability = $request->input('availability');

        // Query koleksi buku beserta peminjam aktif
        $booksQuery = Book::with(['activeLoans' => function ($q) {
            $q->orderBy('due_date', 'asc');
        }]);

        if (!empty($search)) {
            $booksQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhereHas('activeLoans', function ($lq) use ($search) {
                      $lq->where('borrower_name', 'like', "%{$search}%")
                         ->orWhere('borrower_department', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($category)) {
            $booksQuery->where('category', $category);
        }

        if ($availability === 'available') {
            $booksQuery->where('available_stock', '>', 0);
        } elseif ($availability === 'empty') {
            $booksQuery->where('available_stock', '<=', 0);
        }

        $books = $booksQuery->orderBy('title', 'asc')->get();

        // Daftar buku yang memiliki stok untuk pilihan form
        $availableBooks = Book::where('available_stock', '>', 0)
            ->orderBy('title', 'asc')
            ->get();

        // Kategori buku untuk filter
        $categories = Book::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        // Daftar seluruh peminjaman aktif untuk tabel informasi peminjam
        $activeLoansQuery = BookLoan::with('book')
            ->whereIn('status', [BookLoan::STATUS_DIPINJAM, BookLoan::STATUS_TERLAMBAT]);

        if (!empty($search)) {
            $activeLoansQuery->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                  ->orWhere('borrower_department', 'like', "%{$search}%")
                  ->orWhereHas('book', function ($bq) use ($search) {
                      $bq->where('title', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%");
                  });
            });
        }

        $activeLoans = $activeLoansQuery->orderBy('loan_date', 'desc')->get();

        // Ringkasan statistik buku
        $stats = [
            'total_titles'    => Book::count(),
            'total_stock'     => (int) Book::sum('total_stock'),
            'available_stock' => (int) Book::sum('available_stock'),
            'borrowed_stock'  => max(0, (int) (Book::sum('total_stock') - Book::sum('available_stock'))),
            'active_loans'    => BookLoan::whereIn('status', [BookLoan::STATUS_DIPINJAM, BookLoan::STATUS_TERLAMBAT])->count(),
        ];

        return view('landing-books.index', compact(
            'books',
            'availableBooks',
            'categories',
            'activeLoans',
            'stats',
            'search',
            'category',
            'availability'
        ));
    }

    /**
     * Simpan pengajuan peminjaman buku dari form publik.
     */
    public function storeLoan(Request $request)
    {
        // Normalisasi data peminjaman agar mendukung multi-buku (items) maupun single buku (backward compatibility)
        $rawItems = $request->input('items');
        if (empty($rawItems) && $request->filled('book_id')) {
            $rawItems = [
                [
                    'book_id'  => $request->input('book_id'),
                    'quantity' => $request->input('quantity', 1),
                ]
            ];
            $request->merge(['items' => $rawItems]);
        }

        $validated = $request->validate([
            'borrower_name'       => 'required|string|max:100',
            'borrower_department' => 'required|string|max:100',
            'borrower_phone'      => 'nullable|string|max:30',
            'loan_date'           => 'required|date',
            'due_date'            => 'required|date|after_or_equal:loan_date',
            'notes'               => 'nullable|string|max:500',
            'items'               => 'required|array|min:1',
            'items.*.book_id'     => 'required|exists:books,id',
            'items.*.quantity'    => 'required|integer|min:1',
        ], [
            'borrower_name.required'       => 'Nama peminjam wajib diisi.',
            'borrower_department.required' => 'Bagian / Divisi wajib diisi.',
            'loan_date.required'           => 'Tanggal peminjaman wajib diisi.',
            'due_date.required'            => 'Tanggal rencana pengembalian wajib diisi.',
            'due_date.after_or_equal'      => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',
            'items.required'               => 'Silakan pilih minimal 1 judul buku yang ingin dipinjam.',
            'items.min'                    => 'Silakan pilih minimal 1 judul buku yang ingin dipinjam.',
            'items.*.book_id.required'     => 'Silakan pilih judul buku.',
            'items.*.book_id.exists'       => 'Buku yang dipilih tidak ditemukan dalam sistem.',
            'items.*.quantity.required'    => 'Jumlah eksemplar buku wajib diisi.',
            'items.*.quantity.min'         => 'Jumlah peminjaman minimal 1 eksemplar per judul buku.',
        ]);

        try {
            $result = DB::transaction(function () use ($validated) {
                // Gabungkan kuantitas jika ada judul buku yang sama dipilih lebih dari 1 kali
                $aggregatedItems = [];
                foreach ($validated['items'] as $item) {
                    $bookId = (int) $item['book_id'];
                    $qty = (int) $item['quantity'];
                    if (!isset($aggregatedItems[$bookId])) {
                        $aggregatedItems[$bookId] = 0;
                    }
                    $aggregatedItems[$bookId] += $qty;
                }

                $createdLoans = [];
                $receiptBooks = [];
                $totalQuantity = 0;

                $today = Carbon::today();
                $dueDate = Carbon::parse($validated['due_date']);
                $initialStatus = $dueDate->lt($today) ? BookLoan::STATUS_TERLAMBAT : BookLoan::STATUS_DIPINJAM;

                foreach ($aggregatedItems as $bookId => $qty) {
                    $book = Book::lockForUpdate()->findOrFail($bookId);

                    if ($book->available_stock < $qty) {
                        throw new \Exception("Stok buku \"{$book->title}\" tidak mencukupi. Sisa stok tersedia saat ini: {$book->available_stock} eksemplar, sedangkan yang diajukan: {$qty} eksemplar.");
                    }

                    // Simpan transaksi peminjaman buku
                    $newLoan = BookLoan::create([
                        'loan_code'           => null,
                        'book_id'             => $book->id,
                        'borrower_name'       => trim($validated['borrower_name']),
                        'borrower_department' => trim($validated['borrower_department']),
                        'borrower_phone'      => !empty($validated['borrower_phone']) ? trim($validated['borrower_phone']) : null,
                        'loan_date'           => $validated['loan_date'],
                        'due_date'            => $validated['due_date'],
                        'return_date'         => null,
                        'quantity'            => $qty,
                        'status'              => $initialStatus,
                        'notes'               => !empty($validated['notes']) ? trim($validated['notes']) : null,
                        'handled_by'          => null, // Diajukan melalui form mandiri publik
                    ]);

                    // Kurangi stok ketersediaan buku secara otomatis
                    $book->decrement('available_stock', $qty);

                    $createdLoans[] = $newLoan;
                    $receiptBooks[] = [
                        'id'       => $book->id,
                        'title'    => $book->title,
                        'quantity' => $qty,
                    ];
                    $totalQuantity += $qty;
                }

                $firstLoan = $createdLoans[0];
                $bookTitlesSummary = count($receiptBooks) === 1
                    ? $receiptBooks[0]['title']
                    : count($receiptBooks) . ' Judul Buku (' . implode(', ', array_map(fn($b) => "{$b['title']} [{$b['quantity']} eksemplar]", $receiptBooks)) . ')';

                $receipt = [
                    'borrower_name'       => $firstLoan->borrower_name,
                    'borrower_department' => $firstLoan->borrower_department,
                    'borrower_phone'      => $firstLoan->borrower_phone,
                    'book_title'          => $bookTitlesSummary,
                    'quantity'            => $totalQuantity,
                    'books'               => $receiptBooks,
                    'total_titles'        => count($receiptBooks),
                    'total_quantity'      => $totalQuantity,
                    'loan_date'           => $firstLoan->loan_date ? Carbon::parse($firstLoan->loan_date)->format('d F Y') : '-',
                    'due_date'            => $firstLoan->due_date ? Carbon::parse($firstLoan->due_date)->format('d F Y') : '-',
                    'notes'               => $firstLoan->notes,
                ];

                $successMsg = count($receiptBooks) === 1
                    ? "Peminjaman buku \"{$receiptBooks[0]['title']}\" ({$totalQuantity} eksemplar) berhasil diajukan!"
                    : "Peminjaman " . count($receiptBooks) . " judul buku (total {$totalQuantity} eksemplar) berhasil diajukan!";

                return [
                    'receipt' => $receipt,
                    'message' => $successMsg,
                ];
            });

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Peminjaman buku berhasil diajukan!',
                    'receipt' => $result['receipt'],
                ]);
            }

            return redirect()->to(route('public.books.index') . '#form-peminjaman')
                ->with('success_peminjaman_buku', $result['message'])
                ->with('receipt_peminjaman', $result['receipt']);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return redirect()->to(route('public.books.index') . '#form-peminjaman')
                ->withInput()
                ->with('error_peminjaman_buku', $e->getMessage());
        }
    }

    /**
     * Proses pengembalian buku (memperbarui stok dan riwayat transaksi).
     */
    public function returnLoan(Request $request, BookLoan $loan)
    {
        if ($loan->isReturned()) {
            $msg = "Transaksi peminjaman buku \"{$loan->book->title}\" oleh {$loan->borrower_name} sudah tercatat dikembalikan sebelumnya.";
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }

            return redirect()->route('public.books.index')
                ->with('info_peminjaman_buku', $msg);
        }

        try {
            DB::transaction(function () use ($loan) {
                $book = Book::lockForUpdate()->findOrFail($loan->book_id);

                // Tambahkan kembali stok buku yang tersedia
                $book->increment('available_stock', $loan->quantity);

                // Update status transaksi
                $loan->update([
                    'status'      => BookLoan::STATUS_DIKEMBALIKAN,
                    'return_date' => Carbon::now(),
                ]);
            });

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Buku \"{$loan->book->title}\" ({$loan->quantity} eksemplar) berhasil dikembalikan. Stok tersedia diperbarui secara otomatis.",
                ]);
            }

            return redirect()->route('public.books.index')
                ->with('success_peminjaman_buku', "Buku \"{$loan->book->title}\" ({$loan->quantity} eksemplar) berhasil dikembalikan. Stok tersedia diperbarui secara otomatis.");
        } catch (\Exception $e) {
            Log::error('Error returning public book loan: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses pengembalian buku: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->route('public.books.index')
                ->with('error_peminjaman_buku', 'Gagal memproses pengembalian buku: ' . $e->getMessage());
        }
    }
}
