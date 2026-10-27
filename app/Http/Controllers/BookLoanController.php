<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookLoanController extends Controller
{
    public function index(Request $request)
    {
        // Perbarui otomatis peminjaman yang telah melewati jatuh tempo menjadi status 'Terlambat'
        BookLoan::where('status', BookLoan::STATUS_DIPINJAM)
            ->whereDate('due_date', '<', Carbon::today()->toDateString())
            ->update(['status' => BookLoan::STATUS_TERLAMBAT]);

        $search = $request->query('search');
        $tab = $request->query('status', 'all');

        $query = BookLoan::with(['book', 'handler']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                  ->orWhere('borrower_department', 'like', "%{$search}%")
                  ->orWhereHas('book', function ($bq) use ($search) {
                      $bq->where('title', 'like', "%{$search}%")
                         ->orWhere('book_code', 'like', "%{$search}%");
                  });
            });
        }

        if ($tab === 'active' || $tab === BookLoan::STATUS_DIPINJAM) {
            $query->where('status', BookLoan::STATUS_DIPINJAM);
        } elseif ($tab === 'returned' || $tab === BookLoan::STATUS_DIKEMBALIKAN) {
            $query->where('status', BookLoan::STATUS_DIKEMBALIKAN);
        } elseif ($tab === 'overdue' || $tab === BookLoan::STATUS_TERLAMBAT) {
            $query->where('status', BookLoan::STATUS_TERLAMBAT);
        }

        $perPage = $request->input('per_page', 25);
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageLimit = 999999;
        } else {
            $perPage = in_array((int)$perPage, [10, 25, 50, 100], true) ? (int)$perPage : 25;
            $perPageLimit = (int)$perPage;
        }

        $loans = $query->orderBy('loan_date', 'desc')
                       ->orderBy('id', 'desc')
                       ->paginate($perPageLimit)
                       ->withQueryString();

        $stats = [
            'total'    => BookLoan::count(),
            'active'   => BookLoan::where('status', BookLoan::STATUS_DIPINJAM)->count(),
            'returned' => BookLoan::where('status', BookLoan::STATUS_DIKEMBALIKAN)->count(),
            'overdue'  => BookLoan::where('status', BookLoan::STATUS_TERLAMBAT)->count(),
        ];

        // Daftar buku untuk pilihan di modal peminjaman baru
        $availableBooks = Book::where('available_stock', '>', 0)->orderBy('title', 'asc')->get();

        return view('book-loans.index', compact('loans', 'stats', 'search', 'tab', 'availableBooks', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id'             => 'required|exists:books,id',
            'borrower_name'       => 'required|string|max:100',
            'borrower_department' => 'nullable|string|max:100',
            'borrower_phone'      => 'nullable|string|max:30',
            'loan_date'           => 'required|date',
            'due_date'            => 'required|date|after_or_equal:loan_date',
            'quantity'            => 'required|integer|min:1',
            'notes'               => 'nullable|string|max:500',
        ], [
            'book_id.required'             => 'Silakan pilih buku yang akan dipinjam.',
            'book_id.exists'               => 'Buku yang dipilih tidak ditemukan.',
            'borrower_name.required'       => 'Nama peminjam wajib diisi.',
            'loan_date.required'           => 'Tanggal peminjaman wajib diisi.',
            'due_date.required'            => 'Tanggal rencana pengembalian wajib diisi.',
            'due_date.after_or_equal'      => 'Tanggal pengembalian tidak boleh sebelum tanggal peminjaman.',
            'quantity.required'            => 'Jumlah buku wajib diisi.',
            'quantity.min'                 => 'Jumlah peminjaman minimal 1 eksemplar.',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $book = Book::lockForUpdate()->findOrFail($validated['book_id']);

            $qty = (int) $validated['quantity'];

            if ($book->available_stock < $qty) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Stok buku \"{$book->title}\" tidak mencukupi. Stok tersedia saat ini: {$book->available_stock} eksemplar.");
            }

            // Tentukan status awal berdasarkan due_date
            $today = Carbon::today();
            $dueDate = Carbon::parse($validated['due_date']);
            $initialStatus = $dueDate->lt($today) ? BookLoan::STATUS_TERLAMBAT : BookLoan::STATUS_DIPINJAM;

            // Simpan transaksi peminjaman (tanpa kode otomatis)
            $loan = BookLoan::create([
                'loan_code'           => null,
                'book_id'             => $book->id,
                'borrower_name'       => trim($validated['borrower_name']),
                'borrower_department' => $validated['borrower_department'] ?? null,
                'borrower_phone'      => $validated['borrower_phone'] ?? null,
                'loan_date'           => $validated['loan_date'],
                'due_date'            => $validated['due_date'],
                'return_date'         => null,
                'quantity'            => $qty,
                'status'              => $initialStatus,
                'notes'               => $validated['notes'] ?? null,
                'handled_by'          => Auth::id(),
            ]);

            // Perbarui stok ketersediaan buku secara otomatis (stok berkurang)
            $book->decrement('available_stock', $qty);

            return redirect()->route('book-loans.index')
                ->with('success', "Peminjaman buku \"{$book->title}\" oleh {$loan->borrower_name} berhasil dicatat. Stok buku otomatis berkurang sebanyak {$qty} eksemplar.");
        });
    }

    /**
     * Memproses transaksi pengembalian buku
     */
    public function returnBook(Request $request, BookLoan $bookLoan)
    {
        if ($bookLoan->status === BookLoan::STATUS_DIKEMBALIKAN) {
            return redirect()->route('book-loans.index')
                ->with('error', 'Transaksi peminjaman ini sudah berstatus dikembalikan sebelumnya.');
        }

        $validated = $request->validate([
            'return_date' => 'required|date',
            'notes'       => 'nullable|string|max:500',
        ], [
            'return_date.required' => 'Tanggal pengembalian buku wajib diisi.',
            'return_date.date'     => 'Format tanggal pengembalian tidak valid.',
        ]);

        return DB::transaction(function () use ($bookLoan, $validated) {
            $book = Book::lockForUpdate()->findOrFail($bookLoan->book_id);

            $returnDate = $validated['return_date'];
            $notes = $validated['notes'] ? trim($validated['notes']) : null;

            $currentNotes = $bookLoan->notes;
            if ($notes) {
                $currentNotes = $currentNotes ? "{$currentNotes} | Pengembalian: {$notes}" : "Pengembalian: {$notes}";
            }

            // Perbarui status peminjaman menjadi 'Dikembalikan'
            $bookLoan->update([
                'return_date' => $returnDate,
                'status'      => BookLoan::STATUS_DIKEMBALIKAN,
                'notes'       => $currentNotes,
                'handled_by'  => Auth::id(),
            ]);

            // Perbarui stok ketersediaan buku secara otomatis (stok bertambah kembali)
            $book->increment('available_stock', $bookLoan->quantity);

            return redirect()->route('book-loans.index')
                ->with('success', "Transaksi pengembalian buku \"{$book->title}\" berhasil diproses. Stok ketersediaan buku otomatis bertambah kembali ({$bookLoan->quantity} eksemplar).");
        });
    }

    public function update(Request $request, BookLoan $bookLoan)
    {
        $validated = $request->validate([
            'borrower_name'       => 'required|string|max:100',
            'borrower_department' => 'nullable|string|max:100',
            'borrower_phone'      => 'nullable|string|max:30',
            'loan_date'           => 'required|date',
            'due_date'            => 'required|date|after_or_equal:loan_date',
            'notes'               => 'nullable|string|max:500',
        ]);

        $status = $bookLoan->status;
        if ($status !== BookLoan::STATUS_DIKEMBALIKAN) {
            $dueDate = Carbon::parse($validated['due_date']);
            $status = $dueDate->lt(Carbon::today()) ? BookLoan::STATUS_TERLAMBAT : BookLoan::STATUS_DIPINJAM;
        }

        $bookLoan->update([
            'borrower_name'       => trim($validated['borrower_name']),
            'borrower_department' => $validated['borrower_department'] ?? null,
            'borrower_phone'      => $validated['borrower_phone'] ?? null,
            'loan_date'           => $validated['loan_date'],
            'due_date'            => $validated['due_date'],
            'status'              => $status,
            'notes'               => $validated['notes'] ?? null,
        ]);

        return redirect()->route('book-loans.index')->with('success', 'Data transaksi peminjaman berhasil diperbarui.');
    }

    public function destroy(BookLoan $bookLoan)
    {
        return DB::transaction(function () use ($bookLoan) {
            // Jika transaksi dihapus saat status belum dikembalikan, kembalikan stok buku
            if ($bookLoan->status !== BookLoan::STATUS_DIKEMBALIKAN) {
                $book = Book::lockForUpdate()->find($bookLoan->book_id);
                if ($book) {
                    $book->increment('available_stock', $bookLoan->quantity);
                }
            }

            $title = $bookLoan->book->title ?? 'Buku';
            $borrower = $bookLoan->borrower_name;
            $bookLoan->delete();

            return redirect()->route('book-loans.index')->with('success', "Transaksi peminjaman buku \"{$title}\" oleh {$borrower} berhasil dihapus.");
        });
    }
}
