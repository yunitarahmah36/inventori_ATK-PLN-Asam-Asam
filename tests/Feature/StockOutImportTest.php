<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class StockOutImportTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role = 'Admin'): User
    {
        return User::create([
            'name'     => $role . ' ' . uniqid(),
            'username' => strtolower($role) . '_' . uniqid(),
            'email'    => strtolower($role) . '_' . uniqid() . '@pln.com',
            'password' => Hash::make('password123'),
            'role'     => $role,
        ]);
    }

    /**
     * Helper membuat file Excel upload sesuai format template Stok Keluar
     * Kolom: Tanggal, No. Material, Nama Pengambil, Bagian/Divisi, Jumlah Keluar, Keterangan
     */
    private function createStockOutExcel(array $dataRows): UploadedFile
    {
        $rows = array_merge([
            ['Tanggal', 'No. Material', 'Nama Pengambil', 'Bagian/Divisi', 'Jumlah Keluar', 'Keterangan'],
        ], $dataRows);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($rows, null, 'A1');

        $tempFile = tempnam(sys_get_temp_dir(), 'test_stockout_') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return new UploadedFile(
            $tempFile,
            'import_stok_keluar.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
    }

    public function test_stock_out_page_renders_import_excel_and_download_template_buttons(): void
    {
        $admin = $this->createUser();

        $response = $this->actingAs($admin)->get(route('materials.stock-out.index'));

        $response->assertStatus(200);
        $response->assertSee('Import Excel');
        $response->assertSee('Download Template');
        $response->assertSee(route('materials.stock-out.template'));
        $response->assertSee('importStockOutModal');
    }

    public function test_download_template_returns_excel_file(): void
    {
        $admin = $this->createUser();

        $response = $this->actingAs($admin)->get(route('materials.stock-out.template'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
        $this->assertStringContainsString('Template_Stok_Keluar_ATK_PLN.xlsx', (string) $response->headers->get('content-disposition'));
    }

    public function test_import_requires_file_and_valid_xlsx(): void
    {
        $admin = $this->createUser();

        // 1. Tanpa file
        $responseEmpty = $this->actingAs($admin)->post(route('materials.stock-out.import'), []);
        $responseEmpty->assertSessionHasErrors('file');

        // 2. File bukan .xlsx (.txt)
        $fakeTxt = UploadedFile::fake()->create('dokumen.txt', 10, 'text/plain');
        $responseTxt = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $fakeTxt,
        ]);
        $responseTxt->assertSessionHasErrors('file');
    }

    public function test_import_analyzes_preview_and_matches_existing_materials(): void
    {
        $admin = $this->createUser();

        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        $mat2 = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Spidol Boardmarker Hitam',
            'entry_date'      => '2026-10-01',
            'quantity'        => 30,
            'unit'            => 'Pcs',
        ]);

        $file = $this->createStockOutExcel([
            ['14/10/2026', 'MAT001', 'Ahmad Dani', 'Pemeliharaan', 10, 'Kebutuhan cetak laporan'],
            ['14/10/2026', 'MAT002', 'Siti Rahma', 'Operasi', 5, 'Kebutuhan ruang kontrol'],
        ]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('materials.stock-out.index'));
        $this->assertTrue(session()->has('stock_out_import_preview'));

        $preview = session('stock_out_import_preview');
        $this->assertEquals(2, $preview['total_rows']);
        $this->assertEquals(2, $preview['valid_count']);
        $this->assertEquals(0, $preview['invalid_count']);
        $this->assertEquals(15, $preview['total_valid_quantity']);
        $this->assertEquals(2, $preview['valid_materials_count']);

        // Data stok di database belum berubah saat pratinjau
        $this->assertEquals(50, $mat1->fresh()->quantity);
        $this->assertEquals(30, $mat2->fresh()->quantity);
        $this->assertEquals(0, StockMovement::count());
    }

    public function test_confirm_import_saves_stock_out_transactions_and_deducts_stock(): void
    {
        $admin = $this->createUser();

        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        $mat2 = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Spidol Boardmarker Hitam',
            'entry_date'      => '2026-10-01',
            'quantity'        => 30,
            'unit'            => 'Pcs',
        ]);

        $file = $this->createStockOutExcel([
            ['14/10/2026', 'MAT001', 'Ahmad Dani', 'Pemeliharaan', 12, 'Kebutuhan cetak laporan'],
            ['14/10/2026', 'MAT002', 'Siti Rahma', 'Operasi', 8, 'Kebutuhan ruang kontrol'],
        ]);

        $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        // Konfirmasi import
        $confirmResponse = $this->actingAs($admin)->post(route('materials.stock-out.import.confirm'));
        $confirmResponse->assertRedirect(route('materials.stock-out.index'));
        $confirmResponse->assertSessionHas('success');

        // Sesi pratinjau dibersihkan
        $this->assertFalse(session()->has('stock_out_import_preview'));

        // Stok material terpotong otomatis
        $this->assertEquals(38, $mat1->fresh()->quantity);
        $this->assertEquals(22, $mat2->fresh()->quantity);

        // Tercatat ke StockMovement
        $movements = StockMovement::where('activity', 'Keluar')->get();
        $this->assertCount(2, $movements);

        $mov1 = $movements->firstWhere('material_id', $mat1->id);
        $this->assertNotNull($mov1);
        $this->assertEquals(-12, $mov1->quantity_change);
        $this->assertEquals(50, $mov1->quantity_before);
        $this->assertEquals(38, $mov1->quantity_after);
        $this->assertEquals('Ahmad Dani (Pemeliharaan)', $mov1->recipient);
        $this->assertEquals('Kebutuhan cetak laporan', $mov1->description);

        $mov2 = $movements->firstWhere('material_id', $mat2->id);
        $this->assertNotNull($mov2);
        $this->assertEquals(-8, $mov2->quantity_change);
        $this->assertEquals(30, $mov2->quantity_before);
        $this->assertEquals(22, $mov2->quantity_after);
        $this->assertEquals('Siti Rahma (Operasi)', $mov2->recipient);
    }

    public function test_import_rejects_unregistered_material_number_and_never_creates_new_material(): void
    {
        $admin = $this->createUser();

        $initialMaterialCount = Material::count();

        $file = $this->createStockOutExcel([
            ['14/10/2026', 'MAT999_TIDAK_ADA', 'Budi Santoso', 'Logistik', 5, 'Material belum ada'],
        ]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('materials.stock-out.index'));
        $preview = session('stock_out_import_preview');

        $this->assertEquals(0, $preview['valid_count']);
        $this->assertEquals(1, $preview['invalid_count']);
        $this->assertStringContainsString('tidak ditemukan di database', $preview['invalid_rows'][0]['reason']);

        // Pastikan tidak ada material baru yang terbuat
        $this->assertEquals($initialMaterialCount, Material::count());
    }

    public function test_import_rejects_quantity_exceeding_available_stock(): void
    {
        $admin = $this->createUser();

        $mat = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Rim',
        ]);

        $file = $this->createStockOutExcel([
            ['14/10/2026', 'MAT001', 'Hendra', 'Umum', 25, 'Permintaan berlebih'],
        ]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('materials.stock-out.index'));
        $preview = session('stock_out_import_preview');

        $this->assertEquals(0, $preview['valid_count']);
        $this->assertEquals(1, $preview['invalid_count']);
        $this->assertStringContainsString('Stok tidak mencukupi', $preview['invalid_rows'][0]['reason']);
    }

    public function test_import_rejects_cumulative_quantity_exceeding_stock_for_same_material(): void
    {
        $admin = $this->createUser();

        $mat = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 15,
            'unit'            => 'Rim',
        ]);

        $file = $this->createStockOutExcel([
            ['14/10/2026', 'MAT001', 'Budi', 'Divisi A', 10, 'Permintaan 1'],
            ['14/10/2026', 'MAT001', 'Rudi', 'Divisi B', 8, 'Permintaan 2 (Total 18 > 15)'],
        ]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $preview = session('stock_out_import_preview');

        $this->assertEquals(1, $preview['valid_count']);
        $this->assertEquals(1, $preview['invalid_count']);
        $this->assertEquals(10, $preview['valid_rows'][0]['quantity']);
        $this->assertStringContainsString('melebihi stok yang ada', $preview['invalid_rows'][0]['reason']);
    }

    public function test_import_rejects_non_positive_quantity_and_invalid_date(): void
    {
        $admin = $this->createUser();

        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        $file = $this->createStockOutExcel([
            ['tanggal_ngawur', 'MAT001', 'Budi', 'Divisi A', 10, 'Tanggal salah'],
            ['14/10/2026', 'MAT001', 'Rudi', 'Divisi B', -5, 'Qty negatif'],
            ['14/10/2026', 'MAT001', 'Dedi', 'Divisi C', 0, 'Qty nol'],
        ]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $preview = session('stock_out_import_preview');
        $this->assertEquals(0, $preview['valid_count']);
        $this->assertEquals(3, $preview['invalid_count']);
    }

    public function test_cancel_import_clears_session_preview(): void
    {
        $admin = $this->createUser();

        session(['stock_out_import_preview' => [
            'total_rows'  => 1,
            'valid_count' => 1,
            'valid_rows'  => [],
        ]]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import.cancel'));

        $response->assertRedirect(route('materials.stock-out.index'));
        $this->assertFalse(session()->has('stock_out_import_preview'));
    }

    public function test_import_rejects_row_when_exit_date_is_earlier_than_material_entry_date(): void
    {
        $admin = $this->createUser();

        $mat = Material::create([
            'material_number' => 'MAT-DATE-01',
            'name'            => 'Kertas Folio F4',
            'entry_date'      => '2026-10-10',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        // File dengan tanggal keluar 05/10/2026 (lebih awal dari entry_date 10/10/2026)
        $file = $this->createStockOutExcel([
            ['05/10/2026', 'MAT-DATE-01', 'Budi Santoso', 'Keuangan', 10, 'Pengeluaran sebelum barang masuk'],
        ]);

        $response = $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $response->assertRedirect(route('materials.stock-out.index'));
        $this->assertTrue(session()->has('stock_out_import_preview'));

        $preview = session('stock_out_import_preview');
        $this->assertEquals(0, $preview['valid_count']);
        $this->assertEquals(1, $preview['invalid_count']);

        $invalid = $preview['invalid_rows'][0];
        $this->assertEquals('MAT-DATE-01', $invalid['material_number']);
        $this->assertStringContainsString('Tanggal stok keluar tidak boleh lebih awal dari tanggal masuk material', $invalid['reason']);

        // Pastikan tidak ada transaksi yang disimpan
        $this->assertEquals(0, StockMovement::count());
        $this->assertEquals(50, $mat->fresh()->quantity);
    }

    public function test_import_validates_date_based_on_stock_movement_in_database(): void
    {
        $admin = $this->createUser();

        $mat = Material::create([
            'material_number' => 'MAT-DATE-02',
            'name'            => 'Tinta Printer Epson',
            'entry_date'      => '2026-10-01',
            'quantity'        => 20,
            'unit'            => 'Botol',
        ]);

        // Simulasikan transaksi stok masuk pada tanggal 12/10/2026
        StockMovement::create([
            'material_id'     => $mat->id,
            'material_name'   => $mat->name,
            'material_number' => $mat->material_number,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => 20,
            'quantity_change' => 20,
            'created_at'      => \Carbon\Carbon::parse('2026-10-12 09:00:00'),
        ]);

        // Baris 1: 08/10/2026 (lebih awal dari stok masuk 12/10/2026) -> harus ditolak
        // Baris 2: 15/10/2026 (setelah stok masuk 12/10/2026) -> valid
        $file = $this->createStockOutExcel([
            ['08/10/2026', 'MAT-DATE-02', 'Doni', 'IT Support', 2, 'Sebelum stok masuk'],
            ['15/10/2026', 'MAT-DATE-02', 'Rian', 'SDM', 3, 'Setelah stok masuk'],
        ]);

        $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $preview = session('stock_out_import_preview');
        $this->assertEquals(1, $preview['valid_count']);
        $this->assertEquals(1, $preview['invalid_count']);

        // Baris bermasalah terdeteksi dengan tepat
        $this->assertEquals(2, $preview['invalid_rows'][0]['row']);
        $this->assertStringContainsString('Tanggal stok keluar tidak boleh lebih awal dari tanggal masuk material', $preview['invalid_rows'][0]['reason']);

        // Baris valid dapat dikonfirmasi
        $this->assertEquals(3, $preview['valid_rows'][0]['row']);
        $this->assertEquals(3, $preview['valid_rows'][0]['quantity']);

        // Saat konfirmasi, hanya baris valid yang disimpan
        $this->actingAs($admin)->post(route('materials.stock-out.import.confirm'));
        $this->assertEquals(17, $mat->fresh()->quantity);
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $mat->id,
            'activity'        => 'Keluar',
            'quantity_change' => -3,
        ]);
    }

    public function test_import_validates_dates_per_material_number_individually(): void
    {
        $admin = $this->createUser();

        // Material A masuk tanggal 10 Oktober 2026
        $matA = Material::create([
            'material_number' => 'MAT-A',
            'name'            => 'Material A',
            'entry_date'      => '2026-10-10',
            'quantity'        => 30,
            'unit'            => 'Pcs',
        ]);

        // Material B masuk tanggal 1 Oktober 2026
        $matB = Material::create([
            'material_number' => 'MAT-B',
            'name'            => 'Material B',
            'entry_date'      => '2026-10-01',
            'quantity'        => 30,
            'unit'            => 'Pcs',
        ]);

        // Tanggal keluar sama-sama 05/10/2026:
        // Untuk MAT-A: 05/10/2026 < 10/10/2026 -> INVALID
        // Untuk MAT-B: 05/10/2026 >= 01/10/2026 -> VALID
        $file = $this->createStockOutExcel([
            ['05/10/2026', 'MAT-A', 'User 1', 'Divisi 1', 5, 'Uji Material A'],
            ['05/10/2026', 'MAT-B', 'User 2', 'Divisi 2', 5, 'Uji Material B'],
        ]);

        $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $preview = session('stock_out_import_preview');
        $this->assertEquals(1, $preview['valid_count']);
        $this->assertEquals(1, $preview['invalid_count']);

        $this->assertEquals('MAT-A', $preview['invalid_rows'][0]['material_number']);
        $this->assertStringContainsString('Tanggal stok keluar tidak boleh lebih awal dari tanggal masuk material', $preview['invalid_rows'][0]['reason']);

        $this->assertEquals('MAT-B', $preview['valid_rows'][0]['material_number']);
    }

    public function test_import_allows_same_day_stock_out(): void
    {
        $admin = $this->createUser();

        $mat = Material::create([
            'material_number' => 'MAT-SAMEDAY',
            'name'            => 'Spidol Whiteboard',
            'entry_date'      => '2026-10-10',
            'quantity'        => 20,
            'unit'            => 'Pcs',
        ]);

        // Tanggal keluar sama dengan tanggal masuk (10/10/2026) -> diperbolehkan
        $file = $this->createStockOutExcel([
            ['10/10/2026', 'MAT-SAMEDAY', 'Agus', 'Operasional', 4, 'Pengeluaran di hari yang sama'],
        ]);

        $this->actingAs($admin)->post(route('materials.stock-out.import'), [
            'file' => $file,
        ]);

        $preview = session('stock_out_import_preview');
        $this->assertEquals(1, $preview['valid_count']);
        $this->assertEquals(0, $preview['invalid_count']);
    }
}

