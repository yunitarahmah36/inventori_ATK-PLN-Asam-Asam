<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MaterialAnalysisMovementHistoryTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role = 'Admin'): User
    {
        return User::create([
            'name'     => $role . ' ' . uniqid(),
            'username' => strtolower($role) . '_' . uniqid(),
            'email'    => strtolower($role) . '_' . uniqid() . '@pln.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role'     => $role,
        ]);
    }

    public function test_material_analysis_detail_page_requires_authentication(): void
    {
        $response = $this->get('/material-analysis/sample-mat');
        $response->assertRedirect('/login');
    }

    public function test_material_analysis_renders_stock_movement_history_matching_stock_history_format(): void
    {
        $admin = $this->createUser();
        $mat = Material::create([
            'material_number' => 'MAT-101',
            'name'            => 'Buku Catatan Agenda',
            'unit'            => 'Pcs',
            'quantity'        => 20,
            'min_stock'       => 15,
        ]);

        $movement = StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_change' => 20,
            'quantity_after'  => 20,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'description'     => 'Stok awal buku catatan',
            'created_at'      => Carbon::now(),
        ]);

        $slug = Str::slug($mat->material_number);
        $response = $this->actingAs($admin)->get("/material-analysis/{$slug}");

        $response->assertStatus(200);

        // Header tabel format Riwayat Stok (9 kolom)
        $response->assertSee('No');
        $response->assertSee('Tanggal & Waktu', false);
        $response->assertSee('Pengguna');
        $response->assertSee('Material');
        $response->assertSee('Aktivitas');
        $response->assertSee('Stok Sebelum');
        $response->assertSee('Perubahan');
        $response->assertSee('Stok Sesudah');
        $response->assertSee('Keterangan');

        // Form filter identik dengan Riwayat Stok
        $response->assertSee('Cari Riwayat');
        $response->assertSee('Semua Aktivitas');
        $response->assertSee('Dari Tanggal');
        $response->assertSee('Sampai Tanggal');
        $response->assertSee('Filter');

        // Dropdown per-page & Export PDF
        $response->assertSee('Tampilkan');
        $response->assertSee('Export PDF');
        $response->assertSee('Stok awal buku catatan');
        $response->assertSee('+20');
    }

    public function test_material_analysis_only_displays_movements_for_selected_material(): void
    {
        $admin = $this->createUser();

        $matA = Material::create([
            'material_number' => 'MAT-A',
            'name'            => 'Kertas HVS Folio 70gr',
            'unit'            => 'Rim',
            'quantity'        => 50,
            'min_stock'       => 15,
        ]);

        $matB = Material::create([
            'material_number' => 'MAT-B',
            'name'            => 'Spidol Whiteboard Hitam',
            'unit'            => 'Pcs',
            'quantity'        => 30,
            'min_stock'       => 15,
        ]);

        StockMovement::create([
            'material_id'     => $matA->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_change' => 50,
            'quantity_after'  => 50,
            'material_name'   => $matA->name,
            'material_number' => $matA->material_number,
            'description'     => 'Pengadaan Kertas HVS Folio',
        ]);

        StockMovement::create([
            'material_id'     => $matB->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_change' => 30,
            'quantity_after'  => 30,
            'material_name'   => $matB->name,
            'material_number' => $matB->material_number,
            'description'     => 'Pengadaan Spidol Whiteboard',
        ]);

        $slugA = Str::slug($matA->material_number);
        $response = $this->actingAs($admin)->get("/material-analysis/{$slugA}");

        $response->assertStatus(200);
        $response->assertSee('Pengadaan Kertas HVS Folio');
        $response->assertDontSee('Pengadaan Spidol Whiteboard');
    }

    public function test_material_analysis_filters_by_activity(): void
    {
        $admin = $this->createUser();
        $mat = Material::create([
            'material_number' => 'MAT-FILTER-ACT',
            'name'            => 'Tinta Printer Epson 003',
            'unit'            => 'Botol',
            'quantity'        => 10,
            'min_stock'       => 5,
        ]);

        StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_change' => 15,
            'quantity_after'  => 15,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'description'     => 'Masuk dari pengadaan batch 1',
        ]);

        StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Keluar',
            'quantity_before' => 15,
            'quantity_change' => -5,
            'quantity_after'  => 10,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'recipient'       => 'Divisi Pemeliharaan',
            'description'     => 'Dipakai untuk cetak laporan bulanan',
        ]);

        $slug = Str::slug($mat->material_number);

        // Filter aktivitas: Tambah
        $responseTambah = $this->actingAs($admin)->get("/material-analysis/{$slug}?activity=Tambah");
        $responseTambah->assertStatus(200);
        $responseTambah->assertSee('Masuk dari pengadaan batch 1');
        $responseTambah->assertDontSee('Dipakai untuk cetak laporan bulanan');

        // Filter aktivitas: Keluar
        $responseKeluar = $this->actingAs($admin)->get("/material-analysis/{$slug}?activity=Keluar");
        $responseKeluar->assertStatus(200);
        $responseKeluar->assertSee('Dipakai untuk cetak laporan bulanan');
        $responseKeluar->assertDontSee('Masuk dari pengadaan batch 1');
    }

    public function test_material_analysis_filters_by_date_range(): void
    {
        $admin = $this->createUser();
        $mat = Material::create([
            'material_number' => 'MAT-DATE',
            'name'            => 'Baterai AA Alkaline',
            'unit'            => 'Pack',
            'quantity'        => 25,
            'min_stock'       => 10,
        ]);

        $movJan = StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_change' => 20,
            'quantity_after'  => 20,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'description'     => 'Pembelian Januari 2026',
            'created_at'      => Carbon::create(2026, 1, 15, 10, 0, 0),
        ]);

        $movFeb = StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 20,
            'quantity_change' => 5,
            'quantity_after'  => 25,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'description'     => 'Pembelian Februari 2026',
            'created_at'      => Carbon::create(2026, 2, 20, 14, 0, 0),
        ]);

        $slug = Str::slug($mat->material_number);

        // Filter Februari saja
        $response = $this->actingAs($admin)->get("/material-analysis/{$slug}?start_date=2026-02-01&end_date=2026-02-28");
        $response->assertStatus(200);
        $response->assertSee('Pembelian Februari 2026');
        $response->assertDontSee('Pembelian Januari 2026');
    }

    public function test_material_analysis_filters_by_search_query(): void
    {
        $admin = $this->createUser();
        $mat = Material::create([
            'material_number' => 'MAT-SEARCH',
            'name'            => 'Stapler HD-10',
            'unit'            => 'Pcs',
            'quantity'        => 12,
            'min_stock'       => 5,
        ]);

        StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_change' => 10,
            'quantity_after'  => 10,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'description'     => 'Kebutuhan ruang arsip',
        ]);

        StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Keluar',
            'quantity_before' => 10,
            'quantity_change' => -2,
            'quantity_after'  => 8,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'recipient'       => 'Pak Hartono (Keuangan)',
            'description'     => 'Kebutuhan bendahara',
        ]);

        $slug = Str::slug($mat->material_number);

        // Search penerima 'Hartono'
        $response = $this->actingAs($admin)->get("/material-analysis/{$slug}?search=Hartono");
        $response->assertStatus(200);
        $response->assertSee('Pak Hartono (Keuangan)');
        $response->assertDontSee('Kebutuhan ruang arsip');
    }

    public function test_material_analysis_respects_per_page_and_empty_state(): void
    {
        $admin = $this->createUser();
        $mat = Material::create([
            'material_number' => 'MAT-PAGE',
            'name'            => 'Penghapus Papan Tulis',
            'unit'            => 'Pcs',
            'quantity'        => 100,
            'min_stock'       => 15,
        ]);

        for ($i = 1; $i <= 15; $i++) {
            StockMovement::create([
                'material_id'     => $mat->id,
                'user_id'         => $admin->id,
                'activity'        => 'Tambah',
                'quantity_before' => $i - 1,
                'quantity_change' => 1,
                'quantity_after'  => $i,
                'material_name'   => $mat->name,
                'material_number' => $mat->material_number,
                'description'     => "Pergerakan batch ke-{$i}",
                'created_at'      => Carbon::now()->addMinutes($i),
            ]);
        }

        $slug = Str::slug($mat->material_number);

        // Paginate 10 per page
        $response = $this->actingAs($admin)->get("/material-analysis/{$slug}?per_page=10");
        $response->assertStatus(200);
        $response->assertSee('Menampilkan');
        $response->assertSee('1–10');
        $response->assertSee('15');
        $response->assertSee('Berikutnya');

        // Empty state when filter has no results
        $responseEmpty = $this->actingAs($admin)->get("/material-analysis/{$slug}?search=TIDAK_ADA_DATA_INI");
        $responseEmpty->assertStatus(200);
        $responseEmpty->assertSee('Belum Ada Riwayat Stok');
        $responseEmpty->assertSee('Belum terdapat aktivitas perubahan stok untuk material ini.');
    }

    public function test_material_analysis_displays_recipient_with_role_label(): void
    {
        $admin = $this->createUser();
        $mat = Material::create([
            'material_number' => 'MAT-RECIP',
            'name'            => 'Flashdisk 32GB Sandisk',
            'unit'            => 'Pcs',
            'quantity'        => 5,
            'min_stock'       => 2,
        ]);

        StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $admin->id,
            'activity'        => 'Keluar',
            'quantity_before' => 6,
            'quantity_change' => -1,
            'quantity_after'  => 5,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'recipient'       => 'Ahmad Zaki (Operasi)',
            'description'     => 'Pemindahan data SCADA',
        ]);

        $slug = Str::slug($mat->material_number);
        $response = $this->actingAs($admin)->get("/material-analysis/{$slug}");

        $response->assertStatus(200);
        $response->assertSee('Ahmad Zaki (Operasi)');
        $response->assertSee('Peminjam / Pengambil');
    }
}
