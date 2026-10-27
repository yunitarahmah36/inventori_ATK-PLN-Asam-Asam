<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingBookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard user if needed
        User::factory()->create([
            'role'     => 'Admin',
            'username' => 'admin_test',
        ]);
    }

    public function test_navbar_contains_peminjaman_buku_and_hero_has_no_book_elements(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // 1. Navbar contains Peminjaman Buku menu item
        $response->assertSee('nav-link-book-featured');
        $response->assertSee('Peminjaman Buku');
        $response->assertSee('Catat Pengambilan');
        $response->assertSee('Cek Stok');
        $response->assertSee('Alur Prosedur');

        // Pastikan tidak ada tombol atau section peminjaman buku di dalam hero
        $content = $response->getContent();
        preg_match('/<section class="hero-section" id="hero">(.*?)<\/section>/s', $content, $matches);
        $this->assertNotEmpty($matches, 'Hero section found');
        $heroContent = $matches[1];
        $this->assertStringNotContainsString('Peminjaman Buku', $heroContent, 'Hero section must not contain Peminjaman Buku');
    }

    public function test_public_book_page_displays_form_catalog_and_stats(): void
    {
        $book = Book::create([
            'book_code'       => 'BK-001',
            'title'           => 'Panduan Operasi Turbin UBP',
            'author'          => 'Tim Engineering PLN',
            'category'        => 'Operasi',
            'total_stock'     => 10,
            'available_stock' => 7,
        ]);

        $response = $this->get('/peminjaman-buku');
        $response->assertStatus(200);

        // 1. Tanpa navbar, tetapi ada tombol kembali ke halaman utama
        $response->assertDontSee('id="navbar"', false);
        $response->assertDontSee('nav-menu', false);
        $response->assertSee('btn-back-home');
        $response->assertSee('Kembali ke Halaman Utama');

        // 2 & 3. Halaman khusus peminjaman buku & formulir
        $response->assertSee('Form Pengajuan Peminjaman Buku');
        $response->assertSee('Nama Peminjam');
        $response->assertSee('Bagian / Divisi');
        $response->assertSee('Pilih Judul Buku');
        $response->assertSee('Jumlah Buku (Eksemplar)');
        $response->assertSee('Tanggal Peminjaman');
        $response->assertSee('Tanggal Rencana Pengembalian');
        $response->assertSee('Ajukan Peminjaman');

        // 4. Katalog buku menampilkan judul, penulis, kategori, stok
        $response->assertSee('Katalog Koleksi Buku Perpustakaan');
        $response->assertSee('Panduan Operasi Turbin UBP');
        $response->assertSee('Tim Engineering PLN');
        $response->assertSee('Operasi');
        $response->assertSee('Total Stok');
        $response->assertSee('Tersedia');
        $response->assertSee('Dipinjam');

        // 5. Informasi Peminjam Aktif (via modal, tidak lagi di-render langsung di tabel katalog)
        $response->assertSee('borrowersModal');
        $response->assertSee('Lihat Peminjam');
        $response->assertDontSee('desktop-loans-table');
        $response->assertDontSee('mobile-loans-list');
        $response->assertSee('pageProgressBar');
    }

    public function test_submitting_loan_decrements_available_stock_and_creates_loan_record(): void
    {
        $book = Book::create([
            'book_code'       => 'BK-002',
            'title'           => 'Buku SOP Pemeliharaan Boiler',
            'author'          => 'Divisi Pemeliharaan',
            'category'        => 'Teknik',
            'total_stock'     => 5,
            'available_stock' => 5,
        ]);

        $loanData = [
            'borrower_name'       => 'Budi Santoso',
            'borrower_department' => 'Pemeliharaan',
            'borrower_phone'      => '08123456789',
            'book_id'             => $book->id,
            'quantity'            => 2,
            'loan_date'           => Carbon::today()->format('Y-m-d'),
            'due_date'            => Carbon::today()->addDays(7)->format('Y-m-d'),
            'notes'               => 'Untuk studi pemeliharaan unit 1',
        ];

        $response = $this->post('/peminjaman-buku', $loanData);
        $response->assertStatus(302);
        $response->assertSessionHas('success_peminjaman_buku');

        // Database checks: stock reduced from 5 to 3
        $book->refresh();
        $this->assertEquals(3, $book->available_stock);
        $this->assertEquals(5, $book->total_stock);

        // BookLoan record created
        $this->assertDatabaseHas('book_loans', [
            'book_id'             => $book->id,
            'borrower_name'       => 'Budi Santoso',
            'borrower_department' => 'Pemeliharaan',
            'quantity'            => 2,
            'status'              => BookLoan::STATUS_DIPINJAM,
        ]);
    }

    public function test_submitting_loan_exceeding_stock_is_rejected(): void
    {
        $book = Book::create([
            'book_code'       => 'BK-003',
            'title'           => 'Manual Generator UBP',
            'author'          => 'Tim Teknik',
            'category'        => 'Teknik',
            'total_stock'     => 3,
            'available_stock' => 1,
        ]);

        $loanData = [
            'borrower_name'       => 'Eko Prasetyo',
            'borrower_department' => 'Operasi',
            'book_id'             => $book->id,
            'quantity'            => 3, // Melebihi sisa 1
            'loan_date'           => Carbon::today()->format('Y-m-d'),
            'due_date'            => Carbon::today()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->post('/peminjaman-buku', $loanData);
        $response->assertStatus(302);
        $response->assertSessionHas('error_peminjaman_buku');

        // Stock remains 1
        $book->refresh();
        $this->assertEquals(1, $book->available_stock);
    }

    public function test_returning_book_increments_available_stock_and_updates_status(): void
    {
        $book = Book::create([
            'book_code'       => 'BK-004',
            'title'           => 'Keselamatan Kerja Pembangkit (K3L)',
            'author'          => 'Divisi K3L',
            'category'        => 'K3L',
            'total_stock'     => 10,
            'available_stock' => 8, // 2 sedang dipinjam
        ]);

        $loan = BookLoan::create([
            'book_id'             => $book->id,
            'borrower_name'       => 'Rian Hidayat',
            'borrower_department' => 'K3L',
            'loan_date'           => Carbon::today()->subDays(3)->format('Y-m-d'),
            'due_date'            => Carbon::today()->addDays(4)->format('Y-m-d'),
            'quantity'            => 2,
            'status'              => BookLoan::STATUS_DIPINJAM,
        ]);

        $response = $this->post("/peminjaman-buku/kembalikan/{$loan->id}");
        $response->assertStatus(302);
        $response->assertSessionHas('success_peminjaman_buku');

        // Stock restored from 8 to 10
        $book->refresh();
        $this->assertEquals(10, $book->available_stock);

        // Status updated to Dikembalikan
        $loan->refresh();
        $this->assertEquals(BookLoan::STATUS_DIKEMBALIKAN, $loan->status);
        $this->assertNotNull($loan->return_date);
    }

    public function test_catalog_and_borrower_search_works_properly(): void
    {
        $bookA = Book::create([
            'book_code'       => 'BK-A',
            'title'           => 'Kimia Air dan Siklus Steam',
            'author'          => 'Laboratorium UBP',
            'category'        => 'Kimia',
            'total_stock'     => 5,
            'available_stock' => 5,
        ]);

        $bookB = Book::create([
            'book_code'       => 'BK-B',
            'title'           => 'Manajemen Lingkungan Pembangkit',
            'author'          => 'Tim Hijau',
            'category'        => 'K3L',
            'total_stock'     => 4,
            'available_stock' => 2,
        ]);

        BookLoan::create([
            'book_id'             => $bookB->id,
            'borrower_name'       => 'Bambang Wijaya',
            'borrower_department' => 'Kimia',
            'loan_date'           => Carbon::today()->format('Y-m-d'),
            'due_date'            => Carbon::today()->addDays(7)->format('Y-m-d'),
            'quantity'            => 2,
            'status'              => BookLoan::STATUS_DIPINJAM,
        ]);

        // Search by book title
        $respTitle = $this->get('/peminjaman-buku?search=Siklus+Steam');
        $respTitle->assertStatus(200);
        $respTitle->assertSee('Kimia Air dan Siklus Steam');
        $respTitle->assertSee('Menampilkan <strong>1</strong> judul buku', false);

        // Search by borrower name
        $respBorrower = $this->get('/peminjaman-buku?search=Bambang');
        $respBorrower->assertStatus(200);
        $respBorrower->assertSee('Bambang Wijaya');
    }

    public function test_ajax_loan_submission_and_return_responses_work_as_spa(): void
    {
        $book = Book::create([
            'book_code'       => 'BK-SPA',
            'title'           => 'Buku Sistem Kendali PLC',
            'author'          => 'Tim Listrik',
            'category'        => 'Listrik',
            'total_stock'     => 6,
            'available_stock' => 6,
        ]);

        // 1. AJAX loan submission
        $loanData = [
            'borrower_name'       => 'Ahmad Fauzi',
            'borrower_department' => 'Listrik',
            'borrower_phone'      => '081999888777',
            'book_id'             => $book->id,
            'quantity'            => 2,
            'loan_date'           => Carbon::today()->format('Y-m-d'),
            'due_date'            => Carbon::today()->addDays(7)->format('Y-m-d'),
        ];

        $responseAjax = $this->postJson('/peminjaman-buku', $loanData);
        $responseAjax->assertStatus(200)
                     ->assertJson([
                         'success' => true,
                         'message' => 'Peminjaman buku berhasil diajukan!',
                     ])
                     ->assertJsonStructure([
                         'success',
                         'message',
                         'receipt' => [
                             'borrower_name',
                             'book_title',
                             'quantity',
                         ],
                     ]);

        $book->refresh();
        $this->assertEquals(4, $book->available_stock);

        // 2. AJAX return submission
        $loan = BookLoan::where('book_id', $book->id)->first();
        $this->assertNotNull($loan);

        $responseReturnAjax = $this->postJson("/peminjaman-buku/kembalikan/{$loan->id}");
        $responseReturnAjax->assertStatus(200)
                           ->assertJson([
                               'success' => true,
                           ]);

        $book->refresh();
        $this->assertEquals(6, $book->available_stock);
    }

    public function test_submitting_multi_book_loan_decrements_stock_for_all_selected_books_and_displays_receipt(): void
    {
        $book1 = Book::create([
            'book_code'       => 'BK-MULTI-1',
            'title'           => 'Panduan Operasi Turbin Steam',
            'author'          => 'Tim Teknik Turbin',
            'category'        => 'Operasi',
            'total_stock'     => 10,
            'available_stock' => 10,
        ]);

        $book2 = Book::create([
            'book_code'       => 'BK-MULTI-2',
            'title'           => 'SOP Pemeliharaan Trafo Daya',
            'author'          => 'Tim Listrik',
            'category'        => 'Listrik',
            'total_stock'     => 5,
            'available_stock' => 5,
        ]);

        $book3 = Book::create([
            'book_code'       => 'BK-MULTI-3',
            'title'           => 'Buku Panduan K3 Lingkungan Pembangkit',
            'author'          => 'Tim K3L',
            'category'        => 'K3L',
            'total_stock'     => 8,
            'available_stock' => 8,
        ]);

        $payload = [
            'borrower_name'       => 'Dewi Lestari',
            'borrower_department' => 'K3L & Lingkungan',
            'borrower_phone'      => '081233445566',
            'loan_date'           => Carbon::today()->toDateString(),
            'due_date'            => Carbon::today()->addDays(7)->toDateString(),
            'notes'               => 'Peminjaman multi-buku untuk referensi audit ISO',
            'items'               => [
                ['book_id' => $book1->id, 'quantity' => 2],
                ['book_id' => $book2->id, 'quantity' => 1],
                ['book_id' => $book3->id, 'quantity' => 3],
            ],
        ];

        $response = $this->postJson('/peminjaman-buku', $payload);
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Peminjaman buku berhasil diajukan!',
                 ])
                 ->assertJsonPath('receipt.borrower_name', 'Dewi Lestari')
                 ->assertJsonPath('receipt.total_titles', 3)
                 ->assertJsonPath('receipt.quantity', 6);

        // Pastikan stok masing-masing buku berkurang dengan benar
        $book1->refresh();
        $book2->refresh();
        $book3->refresh();

        $this->assertEquals(8, $book1->available_stock); // 10 - 2
        $this->assertEquals(4, $book2->available_stock); // 5 - 1
        $this->assertEquals(5, $book3->available_stock); // 8 - 3

        // Pastikan record BookLoan tersimpan untuk masing-masing buku dengan identitas peminjam yang sama
        $this->assertDatabaseHas('book_loans', [
            'book_id'       => $book1->id,
            'borrower_name' => 'Dewi Lestari',
            'quantity'      => 2,
            'status'        => BookLoan::STATUS_DIPINJAM,
        ]);
        $this->assertDatabaseHas('book_loans', [
            'book_id'       => $book2->id,
            'borrower_name' => 'Dewi Lestari',
            'quantity'      => 1,
            'status'        => BookLoan::STATUS_DIPINJAM,
        ]);
        $this->assertDatabaseHas('book_loans', [
            'book_id'       => $book3->id,
            'borrower_name' => 'Dewi Lestari',
            'quantity'      => 3,
            'status'        => BookLoan::STATUS_DIPINJAM,
        ]);
    }

    public function test_multi_book_loan_is_rejected_and_rolled_back_if_any_book_exceeds_stock(): void
    {
        $book1 = Book::create([
            'book_code'       => 'BK-ROLL-1',
            'title'           => 'Buku Sistem Boiler Aman',
            'author'          => 'Tim Boiler',
            'category'        => 'Operasi',
            'total_stock'     => 5,
            'available_stock' => 5,
        ]);

        $book2 = Book::create([
            'book_code'       => 'BK-ROLL-2',
            'title'           => 'Buku Proteksi Generator Langka',
            'author'          => 'Tim Proteksi',
            'category'        => 'Listrik',
            'total_stock'     => 2,
            'available_stock' => 1, // Sisa hanya 1
        ]);

        $payload = [
            'borrower_name'       => 'Hendra Saputra',
            'borrower_department' => 'Operasi',
            'loan_date'           => Carbon::today()->toDateString(),
            'due_date'            => Carbon::today()->addDays(7)->toDateString(),
            'items'               => [
                ['book_id' => $book1->id, 'quantity' => 2], // Cukup
                ['book_id' => $book2->id, 'quantity' => 3], // Melebihi sisa 1 eksemplar
            ],
        ];

        $response = $this->postJson('/peminjaman-buku', $payload);
        $response->assertStatus(422)
                 ->assertJson([
                     'success' => false,
                 ]);

        // Pastikan tidak ada stok buku yang berkurang (atomic rollback)
        $book1->refresh();
        $book2->refresh();
        $this->assertEquals(5, $book1->available_stock);
        $this->assertEquals(1, $book2->available_stock);

        // Pastikan tidak ada transaksi BookLoan yang tersimpan
        $this->assertDatabaseMissing('book_loans', [
            'borrower_name' => 'Hendra Saputra',
        ]);
    }

    public function test_public_page_contains_multi_book_form_elements_and_eksemplar_units(): void
    {
        $response = $this->get('/peminjaman-buku');
        $response->assertStatus(200);

        // Cek elemen multi-book
        $response->assertSee('Daftar Buku yang Ingin Dipinjam');
        $response->assertSee('Tambah Judul Buku Lain');
        $response->assertSee('bookItemRowTemplate');
        $response->assertSee('Bebas Banyak Judul');

        // Cek konsistensi satuan eksemplar di form dan katalog
        $response->assertSee('Eksemplar');
        $response->assertDontSee('Unit</span>', false);
    }

    public function test_receipt_session_hides_form_and_shows_catat_peminjaman_baru_button(): void
    {
        $book = Book::create([
            'book_code'       => 'BK-RECEIPT-1',
            'title'           => 'Buku SOP Turbin Uap',
            'author'          => 'Enjiniring PLN',
            'category'        => 'Operasi',
            'total_stock'     => 5,
            'available_stock' => 5,
        ]);

        $receiptData = [
            'borrower_name'       => 'Ahmad Kurnia',
            'borrower_department' => 'Operasi',
            'borrower_phone'      => '08123456789',
            'loan_date'           => Carbon::today()->toDateString(),
            'due_date'            => Carbon::today()->addDays(7)->toDateString(),
            'notes'               => 'Untuk referensi shift malam',
            'quantity'            => 2,
            'books'               => [
                ['title' => 'Buku SOP Turbin Uap', 'quantity' => 2],
            ],
        ];

        $response = $this->withSession([
            'success_peminjaman_buku' => 'Peminjaman berhasil diajukan!',
            'receipt_peminjaman'      => $receiptData,
        ])->get('/peminjaman-buku');

        $response->assertStatus(200);
        $response->assertSee('+ Catat Peminjaman Baru');
        $response->assertSee('Tanda Terima Peminjaman Buku');
        $response->assertSee('Ahmad Kurnia');
        $response->assertSee('2 Eksemplar');
        // Form harus memiliki style="display: none;" saat resi aktif
        $response->assertSee('style="display: none;"', false);
    }
}


