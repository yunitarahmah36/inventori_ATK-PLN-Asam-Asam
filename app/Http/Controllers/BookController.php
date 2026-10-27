<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $availability = $request->query('availability');

        $query = Book::with('creator');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('book_code', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($availability === 'available') {
            $query->where('available_stock', '>', 0);
        } elseif ($availability === 'empty') {
            $query->where('available_stock', '<=', 0);
        }

        $perPage = $request->input('per_page', 25);
        if ($perPage === 'all' || $perPage === 'Semua') {
            $perPageLimit = 999999;
        } else {
            $perPage = in_array((int)$perPage, [10, 25, 50, 100], true) ? (int)$perPage : 25;
            $perPageLimit = (int)$perPage;
        }

        $books = $query->orderBy('title', 'asc')->paginate($perPageLimit)->withQueryString();

        $categories = Book::select('category')->whereNotNull('category')->distinct()->pluck('category');

        $stats = [
            'total_titles'    => Book::count(),
            'total_stock'     => (int) Book::sum('total_stock'),
            'available_stock' => (int) Book::sum('available_stock'),
            'borrowed_stock'  => (int) (Book::sum('total_stock') - Book::sum('available_stock')),
        ];

        return view('books.index', compact('books', 'categories', 'stats', 'search', 'category', 'availability', 'perPage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'nullable|string|max:150',
            'category'       => 'nullable|string|max:100',
            'total_stock'    => 'required|integer|min:1',
            'description'    => 'nullable|string|max:1000',
        ], [
            'title.required'       => 'Judul buku wajib diisi.',
            'total_stock.required' => 'Jumlah stok buku wajib diisi.',
            'total_stock.min'      => 'Jumlah stok minimal 1 eksemplar.',
        ]);

        $bookCode = null;
        if ($request->filled('book_code')) {
            $bookCode = strtoupper(trim($request->input('book_code')));
        } else {
            $count = (int) Book::max('id') + 1;
            do {
                $bookCode = 'BK-PLN-' . str_pad($count++, 3, '0', STR_PAD_LEFT);
            } while (Book::where('book_code', $bookCode)->exists());
        }

        Book::create([
            'book_code'       => $bookCode,
            'title'           => trim($validated['title']),
            'author'          => $validated['author'] ?? null,
            'category'        => $validated['category'] ?? null,
            'total_stock'     => (int) $validated['total_stock'],
            'available_stock' => (int) $validated['total_stock'],
            'description'     => $validated['description'] ?? null,
            'created_by'      => Auth::id(),
        ]);

        return redirect()->route('books.index')->with('success', 'Buku "' . $validated['title'] . '" berhasil ditambahkan ke katalog.');
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'nullable|string|max:150',
            'category'       => 'nullable|string|max:100',
            'total_stock'    => 'required|integer|min:1',
            'description'    => 'nullable|string|max:1000',
        ], [
            'title.required'       => 'Judul buku wajib diisi.',
            'total_stock.required' => 'Jumlah stok buku wajib diisi.',
            'total_stock.min'      => 'Jumlah stok minimal 1 eksemplar.',
        ]);

        $borrowedStock = max(0, $book->total_stock - $book->available_stock);
        $newTotalStock = (int) $validated['total_stock'];

        if ($newTotalStock < $borrowedStock) {
            return redirect()->route('books.index')->with('error', "Stok total tidak boleh lebih kecil dari jumlah buku yang saat ini sedang dipinjam ({$borrowedStock} eksemplar).");
        }

        $newAvailableStock = $newTotalStock - $borrowedStock;

        $book->update([
            'title'           => trim($validated['title']),
            'author'          => $validated['author'] ?? null,
            'category'        => $validated['category'] ?? null,
            'total_stock'     => $newTotalStock,
            'available_stock' => $newAvailableStock,
            'description'     => $validated['description'] ?? null,
        ]);

        return redirect()->route('books.index')->with('success', 'Data buku "' . $book->title . '" berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->activeLoans()->exists()) {
            return redirect()->route('books.index')->with('error', 'Buku tidak dapat dihapus karena masih memiliki transaksi peminjaman aktif/belum dikembalikan.');
        }

        $title = $book->title;
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku "' . $title . '" berhasil dihapus dari katalog.');
    }
}
