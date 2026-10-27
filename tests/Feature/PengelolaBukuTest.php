<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PengelolaBukuTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role = 'Pengelola Buku'): User
    {
        return User::create([
            'name'     => 'User ' . $role,
            'username' => strtolower(str_replace(' ', '_', $role)) . '_' . uniqid(),
            'email'    => strtolower(str_replace(' ', '_', $role)) . '_' . uniqid() . '@pln.com',
            'password' => Hash::make('password123'),
            'role'     => $role,
        ]);
    }

    private function createBook(int $totalStock = 5, int $availableStock = 5): Book
    {
        return Book::create([
            'book_code'       => 'BK-' . uniqid(),
            'title'           => 'Buku Pedoman K3 PLTU Asam Asam',
            'author'          => 'Tim K3 PLN',
            'publisher'       => 'PLN Press',
            'year'            => '2024',
            'category'        => 'K3 & Lingkungan',
            'total_stock'     => $totalStock,
            'available_stock' => $availableStock,
            'shelf_location'  => 'Rak A1',
            'description'     => 'Buku panduan keselamatan kerja PLTU.',
        ]);
    }

    public function test_guest_cannot_access_books_or_book_loans(): void
    {
        $this->get('/books')->assertRedirect('/login');
        $this->get('/book-loans')->assertRedirect('/login');
    }

    public function test_pengelola_buku_can_access_books_and_loans_pages(): void
    {
        $user = $this->createUser('Pengelola Buku');

        $this->actingAs($user)->get('/books')->assertStatus(200);
        $this->actingAs($user)->get('/book-loans')->assertStatus(200);
    }

    public function test_pengelola_buku_can_view_book_stock_availability(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $book = $this->createBook(10, 7);

        $response = $this->actingAs($user)->get('/books');
        $response->assertStatus(200);
        $response->assertSee($book->title);
        $response->assertSee($book->book_code);
        $response->assertSee('7');
        $response->assertSee('10 Eksemplar');
        $response->assertSee('Tersedia');
    }

    public function test_pengelola_buku_can_add_new_book(): void
    {
        $user = $this->createUser('Pengelola Buku');

        $payload = [
            'title'          => 'SOP Pemeliharaan Boiler PLTU',
            'author'         => 'Divisi Pemeliharaan',
            'category'       => 'Teknik & Operasi',
            'total_stock'    => 4,
            'description'    => 'Standar operasional boiler.',
        ];

        $response = $this->actingAs($user)->post('/books', $payload);
        $response->assertRedirect('/books');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('books', [
            'title'           => 'SOP Pemeliharaan Boiler PLTU',
            'author'          => 'Divisi Pemeliharaan',
            'category'        => 'Teknik & Operasi',
            'total_stock'     => 4,
            'available_stock' => 4,
        ]);
    }

    public function test_recording_loan_automatically_decrements_available_book_stock(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $book = $this->createBook(5, 5);

        $loanData = [
            'book_id'             => $book->id,
            'borrower_name'       => 'Bambang Sudirman',
            'borrower_department' => 'Operasi PLTU Unit 1',
            'borrower_phone'      => '081234567890',
            'loan_date'           => Carbon::today()->toDateString(),
            'due_date'            => Carbon::today()->addDays(7)->toDateString(),
            'quantity'            => 2,
            'notes'               => 'Peminjaman untuk training teknisi baru',
        ];

        $response = $this->actingAs($user)->post('/book-loans', $loanData);
        $response->assertRedirect('/book-loans');
        $response->assertSessionHas('success');

        // Pastikan transaksi peminjaman tersimpan
        $this->assertDatabaseHas('book_loans', [
            'book_id'             => $book->id,
            'borrower_name'       => 'Bambang Sudirman',
            'borrower_department' => 'Operasi PLTU Unit 1',
            'quantity'            => 2,
            'status'              => BookLoan::STATUS_DIPINJAM,
        ]);

        // Pastikan stok ketersediaan buku berkurang otomatis dari 5 menjadi 3
        $book->refresh();
        $this->assertEquals(3, $book->available_stock);
        $this->assertEquals(5, $book->total_stock);
    }

    public function test_loan_cannot_exceed_available_stock(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $book = $this->createBook(3, 1);

        $loanData = [
            'book_id'             => $book->id,
            'borrower_name'       => 'Doni Saputra',
            'borrower_department' => 'Rendal Operasi',
            'loan_date'           => Carbon::today()->toDateString(),
            'due_date'            => Carbon::today()->addDays(5)->toDateString(),
            'quantity'            => 2, // Melebihi stok tersedia (1)
        ];

        $response = $this->actingAs($user)->post('/book-loans', $loanData);
        $response->assertSessionHas('error');

        // Pastikan stok tidak berubah
        $book->refresh();
        $this->assertEquals(1, $book->available_stock);
    }

    public function test_returning_book_automatically_increments_available_book_stock_and_updates_status(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $book = $this->createBook(5, 3); // 2 sedang dipinjam

        $loan = BookLoan::create([
            'book_id'             => $book->id,
            'borrower_name'       => 'Hendra Wijaya',
            'borrower_department' => 'K3 Lingkungan',
            'loan_date'           => Carbon::today()->subDays(5)->toDateString(),
            'due_date'            => Carbon::today()->addDays(2)->toDateString(),
            'quantity'            => 2,
            'status'              => BookLoan::STATUS_DIPINJAM,
            'handled_by'          => $user->id,
        ]);

        $returnData = [
            'return_date' => Carbon::today()->toDateString(),
            'notes'       => 'Buku kembali lengkap dan rapi',
        ];

        $response = $this->actingAs($user)->post("/book-loans/{$loan->id}/return", $returnData);
        $response->assertRedirect('/book-loans');
        $response->assertSessionHas('success');

        // Pastikan status transaksi terupdate menjadi 'Dikembalikan'
        $loan->refresh();
        $this->assertEquals(BookLoan::STATUS_DIKEMBALIKAN, $loan->status);
        $this->assertNotNull($loan->return_date);

        // Pastikan stok buku bertambah kembali dari 3 menjadi 5
        $book->refresh();
        $this->assertEquals(5, $book->available_stock);
    }

    public function test_overdue_loans_are_identified_and_displayed_as_terlambat(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $book = $this->createBook(5, 4);

        $overdueLoan = BookLoan::create([
            'book_id'             => $book->id,
            'borrower_name'       => 'Rahmat Hidayat',
            'borrower_department' => 'Logistik',
            'loan_date'           => Carbon::today()->subDays(10)->toDateString(),
            'due_date'            => Carbon::today()->subDays(2)->toDateString(), // Terlambat 2 hari
            'quantity'            => 1,
            'status'              => BookLoan::STATUS_DIPINJAM,
        ]);

        $response = $this->actingAs($user)->get('/book-loans?status=Terlambat');
        $response->assertStatus(200);
        $response->assertSee('Rahmat Hidayat');
        $response->assertSee('Terlambat');

        // Status di database otomatis terupdate jadi Terlambat
        $overdueLoan->refresh();
        $this->assertEquals(BookLoan::STATUS_TERLAMBAT, $overdueLoan->status);
    }

    public function test_pengelola_buku_cannot_access_user_management(): void
    {
        $pengelolaBuku = $this->createUser('Pengelola Buku');

        // Pengelola Buku dilarang mengakses manajemen pengguna (403 Forbidden)
        $response = $this->actingAs($pengelolaBuku)->get('/users');
        $response->assertStatus(403);
    }

    public function test_pengelola_buku_cannot_access_materials_management(): void
    {
        $pengelolaBuku = $this->createUser('Pengelola Buku');

        // Pengelola Buku dibatasi dari pengelolaan material umum/keuangan
        $response = $this->actingAs($pengelolaBuku)->get('/materials');
        $response->assertStatus(403);
    }

    public function test_admin_can_manage_users_and_assign_pengelola_buku_role(): void
    {
        $admin = $this->createUser('Admin');

        // Admin bisa membuka halaman manajemen pengguna
        $response = $this->actingAs($admin)->get('/users');
        $response->assertStatus(200);
        $response->assertSeeText('Manajemen User & Role Akses');

        // Admin bisa membuat user baru dengan role Pengelola Buku
        $userData = [
            'name'     => 'Staf Perpustakaan Baru',
            'username' => 'staf_buku_pln',
            'email'    => 'stafbuku@pln.co.id',
            'password' => 'secret123',
            'role'     => 'Pengelola Buku',
        ];

        $postResponse = $this->actingAs($admin)->post('/users', $userData);
        $postResponse->assertRedirect('/users');
        $postResponse->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => 'staf_buku_pln',
            'email'    => 'stafbuku@pln.co.id',
            'role'     => 'Pengelola Buku',
        ]);
    }

    public function test_sidebar_displays_appropriate_menu_for_pengelola_buku(): void
    {
        $pengelolaBuku = $this->createUser('Pengelola Buku');

        $response = $this->actingAs($pengelolaBuku)->get('/dashboard');
        $response->assertStatus(200);

        // Menu Pengelola Buku tampil di sidebar
        $response->assertSeeText('Data Buku & Stok');
        $response->assertSeeText('Peminjaman & Pengembalian');

        // Menu yang bukan kewenangannya tidak tampil di sidebar
        $response->assertDontSee('Daftar Material');
        $response->assertDontSee('Analisis Material');
        $response->assertDontSee('Manajemen User');
    }

    public function test_pengelola_buku_can_search_books_with_filters(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $bookA = \App\Models\Book::create([
            'book_code'       => 'BK-SEARCH-001',
            'title'           => 'Panduan Turbin Uap PLTU',
            'author'          => 'Tim Engineering',
            'category'        => 'Teknik Mesin',
            'total_stock'     => 5,
            'available_stock' => 5,
            'created_by'      => $user->id,
        ]);

        $bookB = \App\Models\Book::create([
            'book_code'       => 'BK-SEARCH-002',
            'title'           => 'Manajemen Keselamatan K3',
            'author'          => 'Divisi K3',
            'category'        => 'K3 & Lingkungan',
            'total_stock'     => 3,
            'available_stock' => 0,
            'created_by'      => $user->id,
        ]);

        // Cari berdasarkan judul buku
        $response = $this->actingAs($user)->get('/books?search=Turbin');
        $response->assertStatus(200);
        $response->assertSee('Panduan Turbin Uap PLTU');
        $response->assertDontSee('Manajemen Keselamatan K3');

        // Filter berdasarkan kategori
        $catResponse = $this->actingAs($user)->get('/books?category=K3+%26+Lingkungan');
        $catResponse->assertStatus(200);
        $catResponse->assertSee('Manajemen Keselamatan K3');
        $catResponse->assertDontSee('Panduan Turbin Uap PLTU');

        // Filter ketersediaan stok
        $availResponse = $this->actingAs($user)->get('/books?availability=available');
        $availResponse->assertStatus(200);
        $availResponse->assertSee('Panduan Turbin Uap PLTU');
        $availResponse->assertDontSee('Manajemen Keselamatan K3');
    }

    public function test_pengelola_buku_can_search_book_loans_with_filters(): void
    {
        $user = $this->createUser('Pengelola Buku');
        $book = $this->createBook(5, 5);

        $loanA = \App\Models\BookLoan::create([
            'book_id'             => $book->id,
            'borrower_name'       => 'Ahmad Ramadhan',
            'borrower_department' => 'Operasi Boiler',
            'borrower_phone'      => '081234567890',
            'loan_date'           => now()->toDateString(),
            'due_date'            => now()->addDays(7)->toDateString(),
            'quantity'            => 1,
            'status'              => \App\Models\BookLoan::STATUS_DIPINJAM,
            'handled_by'          => $user->id,
        ]);

        $loanB = \App\Models\BookLoan::create([
            'book_id'             => $book->id,
            'borrower_name'       => 'Siti Nurhaliza',
            'borrower_department' => 'Keuangan',
            'borrower_phone'      => '081298765432',
            'loan_date'           => now()->subDays(10)->toDateString(),
            'due_date'            => now()->subDays(3)->toDateString(),
            'quantity'            => 1,
            'status'              => \App\Models\BookLoan::STATUS_TERLAMBAT,
            'handled_by'          => $user->id,
        ]);

        // Cari berdasarkan nama peminjam
        $response = $this->actingAs($user)->get('/book-loans?search=Ahmad');
        $response->assertStatus(200);
        $response->assertSee('Ahmad Ramadhan');
        $response->assertDontSee('Siti Nurhaliza');

        // Filter berdasarkan status
        $statusResponse = $this->actingAs($user)->get('/book-loans?status=Terlambat');
        $statusResponse->assertStatus(200);
        $statusResponse->assertSee('Siti Nurhaliza');
        $statusResponse->assertDontSee('Ahmad Ramadhan');
    }

    public function test_pagination_renders_cleanly_with_data_info_and_links(): void
    {
        $user = $this->createUser('Pengelola Buku');

        // Buat 15 buku (melebihi per-page 12)
        for ($i = 1; $i <= 15; $i++) {
            \App\Models\Book::create([
                'book_code'       => sprintf('BK-PAG-%03d', $i),
                'title'           => sprintf('Buku Referensi Seri %02d', $i),
                'author'          => 'Penulis UBP',
                'category'        => 'Operasi',
                'total_stock'     => 5,
                'available_stock' => 5,
                'created_by'      => $user->id,
            ]);
        }

        // Test default per_page (25 data)
        $responseDefault = $this->actingAs($user)->get('/books');
        $responseDefault->assertStatus(200);
        $responseDefault->assertSee('table-footer');
        $responseDefault->assertSee('Menampilkan');
        $responseDefault->assertSee('per_page_select');
        $responseDefault->assertSee('10 data per halaman');
        $responseDefault->assertSee('25 data per halaman');
        $responseDefault->assertSee('50 data per halaman');
        $responseDefault->assertSee('100 data per halaman');
        $responseDefault->assertSee('1–15');

        // Test with per_page=10 (Halaman 1)
        $responseP1 = $this->actingAs($user)->get('/books?per_page=10');
        $responseP1->assertStatus(200);
        $responseP1->assertSee('1–10');
        $responseP1->assertSee('15');
        $responseP1->assertSee('pagination-nav');
        $responseP1->assertSee('Berikutnya');

        // Test with per_page=10 (Halaman 2)
        $responseP2 = $this->actingAs($user)->get('/books?per_page=10&page=2');
        $responseP2->assertStatus(200);
        $responseP2->assertSee('11–15');
        $responseP2->assertSee('Sebelumnya');

        // Test book-loans pagination & per_page selector
        $responseLoans = $this->actingAs($user)->get('/book-loans');
        $responseLoans->assertStatus(200);
        $responseLoans->assertSee('per_page_select');
        $responseLoans->assertSee('10 data per halaman');
        $responseLoans->assertSee('25 data per halaman');
        $responseLoans->assertSee('50 data per halaman');
        $responseLoans->assertSee('100 data per halaman');
    }
}
