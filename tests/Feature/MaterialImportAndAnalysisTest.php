<?php

namespace Tests\Feature;

use App\Imports\MaterialsImport;
use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class MaterialImportAndAnalysisTest extends TestCase
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

    /**
     * Buat file Excel 3 kolom sesuai template baru: No. Material, Nama Material, Satuan
     */
    private function createExcelUpload(array $dataRows): UploadedFile
    {
        $rows = array_merge([
            ['No. Material', 'Nama Material', 'Satuan'],
        ], $dataRows);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($rows, null, 'A1');

        $tempFile = tempnam(sys_get_temp_dir(), 'test_mat_') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return new UploadedFile(
            $tempFile,
            'materials_test.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
    }

    public function test_import_first_time_creates_new_master_materials_without_altering_stock(): void
    {
        $admin = $this->createUser();

        $file = $this->createExcelUpload([
            ['MAT001', 'Kertas HVS A4 70gr', 'Rim'],
            ['MAT002', 'Spidol Boardmarker Hitam', 'Pcs'],
        ]);

        // Upload file untuk analisis preview
        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertRedirect('/materials/import');
        $this->assertTrue(session()->has('import_preview'));

        $preview = session('import_preview');
        $this->assertEquals(2, $preview['new_count']);
        $this->assertEquals(0, $preview['duplicate_count']);
        $this->assertEquals(0, $preview['conflict_count']);

        // Konfirmasi import
        $confirmResponse = $this->actingAs($admin)->post('/materials/import/confirm');
        $confirmResponse->assertRedirect('/materials');
        $confirmResponse->assertSessionHas('success');

        $this->assertEquals(2, Material::count());

        $mat1 = Material::where('material_number', 'MAT001')->first();
        $this->assertNotNull($mat1);
        $this->assertEquals('Kertas HVS A4 70gr', $mat1->name);
        $this->assertEquals('Rim', $mat1->unit);
        $this->assertEquals(0, $mat1->quantity); // Stok master data awal 0

        // Pastikan tidak ada riwayat pergerakan stok otomatis
        $this->assertEquals(0, StockMovement::count());
    }

    public function test_import_skips_duplicates_and_never_modifies_existing_stock(): void
    {
        $admin = $this->createUser();

        // Material sudah terdaftar dengan stok 50
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'unit'            => 'Rim',
            'quantity'        => 50,
            'is_active'       => true,
            'created_by'      => $admin->id,
        ]);

        // Upload file dengan data yang sama
        $file = $this->createExcelUpload([
            ['MAT001', 'Kertas HVS A4 70gr', 'Rim'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertRedirect('/materials/import');
        $preview = session('import_preview');

        $this->assertEquals(0, $preview['new_count']);
        $this->assertEquals(1, $preview['duplicate_count']);
        $this->assertEquals(0, $preview['conflict_count']);

        // Konfirmasi tidak menambah data baru
        $mat = Material::where('material_number', 'MAT001')->first();
        $this->assertEquals(50, $mat->quantity); // Stok tidak boleh berubah
        $this->assertEquals(1, Material::count()); // Tidak menduplikasi record
    }

    public function test_import_mixed_data_imports_new_and_skips_duplicates(): void
    {
        $admin = $this->createUser();

        // Material lama sudah ada
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'unit'            => 'Rim',
            'quantity'        => 20,
            'is_active'       => true,
        ]);

        // File berisi campuran: MAT001 (lama/duplikat), MAT002 (baru), MAT003 (baru)
        $file = $this->createExcelUpload([
            ['MAT001', 'Kertas HVS A4', 'Rim'],
            ['MAT002', 'Buku Ekspedisi', 'Buku'],
            ['MAT003', 'Tinta Printer Epson', 'Botol'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $preview = session('import_preview');
        $this->assertEquals(2, $preview['new_count']);
        $this->assertEquals(1, $preview['duplicate_count']);

        // Konfirmasi simpan data baru
        $this->actingAs($admin)->post('/materials/import/confirm');

        $this->assertEquals(3, Material::count());
        $this->assertDatabaseHas('materials', ['material_number' => 'MAT002']);
        $this->assertDatabaseHas('materials', ['material_number' => 'MAT003']);

        // Stok material lama tetap tidak berubah
        $mat1 = Material::where('material_number', 'MAT001')->first();
        $this->assertEquals(20, $mat1->quantity);
    }

    public function test_import_detects_conflict_when_same_material_number_has_different_name(): void
    {
        $admin = $this->createUser();

        // Di database: MAT001 adalah "Kertas HVS A4"
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'unit'            => 'Rim',
            'quantity'        => 10,
        ]);

        // Di Excel: MAT001 ditulis sebagai "Spidol Hitam" (KONFLIK!)
        $file = $this->createExcelUpload([
            ['MAT001', 'Spidol Hitam', 'Pcs'],
            ['MAT002', 'Penggaris 30cm', 'Pcs'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $preview = session('import_preview');
        $this->assertEquals(1, $preview['conflict_count']);
        $this->assertEquals(1, $preview['new_count']); // MAT002 tetap dikenali sebagai baru

        // Cek pesan konflik
        $this->assertNotEmpty($preview['conflicts']);
        $this->assertStringContainsString('MAT001', $preview['conflicts'][0]['reason']);

        // Konfirmasi hanya mengimpor MAT002, menolak MAT001
        $this->actingAs($admin)->post('/materials/import/confirm');

        $this->assertEquals(2, Material::count());
        $this->assertDatabaseHas('materials', ['material_number' => 'MAT002', 'name' => 'Penggaris 30cm']);
        $this->assertDatabaseHas('materials', ['material_number' => 'MAT001', 'name' => 'Kertas HVS A4']);
    }

    public function test_import_detects_conflict_when_name_already_registered_for_different_number(): void
    {
        $admin = $this->createUser();

        // Di database: MAT001 dengan nama "Pulpen Standard"
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Pulpen Standard',
            'unit'            => 'Pcs',
        ]);

        // Di Excel: MAT002 dengan nama "Pulpen Standard" (Nama sudah terdaftar untuk MAT001 -> KONFLIK!)
        $file = $this->createExcelUpload([
            ['MAT002', 'Pulpen Standard', 'Pcs'],
        ]);

        $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $preview = session('import_preview');
        $this->assertEquals(0, $preview['new_count']);
        $this->assertEquals(1, $preview['conflict_count']);
        $this->assertStringContainsString('Pulpen Standard', $preview['conflicts'][0]['reason']);
        $this->assertStringContainsString('MAT001', $preview['conflicts'][0]['reason']);
    }

    public function test_import_notifies_when_all_data_is_already_registered(): void
    {
        $admin = $this->createUser();

        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'unit'            => 'Rim',
        ]);
        Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Spidol Snowman',
            'unit'            => 'Pcs',
        ]);

        $file = $this->createExcelUpload([
            ['MAT001', 'Kertas HVS A4', 'Rim'],
            ['MAT002', 'Spidol Snowman', 'Pcs'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertRedirect('/materials/import');
        $preview = session('import_preview');

        $this->assertEquals(0, $preview['new_count']);
        $this->assertEquals(2, $preview['duplicate_count']);
        $this->assertEquals(0, $preview['conflict_count']);

        // Mengunjungi halaman import menampilkan pemberitahuan bahwa tidak ada data baru
        $pageResponse = $this->actingAs($admin)->get('/materials/import');
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee('Tidak Ada Data Baru');
        $pageResponse->assertSee('Seluruh 2 data material dalam file Excel sudah terdaftar di sistem.');
    }
}
