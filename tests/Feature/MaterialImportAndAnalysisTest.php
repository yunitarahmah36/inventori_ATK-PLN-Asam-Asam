<?php

namespace Tests\Feature;

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

    private function createExcelUpload(array $dataRows): UploadedFile
    {
        $rows = array_merge([
            ['No Material', 'Nama Material', 'Tanggal Masuk', 'Jumlah Item', 'Satuan', 'Deskripsi'],
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

    public function test_import_allows_same_material_number_with_same_name_normalized_preventing_duplicate_data(): void
    {
        $admin = $this->createUser();

        // Material sudah ada di database
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Tempat Pensil',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        // File Excel mengunggah No Material yang sama dengan nama berhuruf besar dan spasi berlebih
        $file = $this->createExcelUpload([
            ['MAT001', '  TEMPAT   PENSIL ', '2026-10-09', 15, 'Pcs', 'Penambahan stok'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        // Pastikan tidak ada data ganda (tetap 1 baris di tabel materials)
        $this->assertEquals(1, Material::count());

        // Pastikan stok bertambah: 10 + 15 = 25
        $material = Material::first();
        $this->assertEquals(25, $material->quantity);

        // Pastikan riwayat pergerakan stok tercatat
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'material_number' => 'MAT001',
            'activity'        => 'Import',
            'quantity_before' => 10,
            'quantity_after'  => 25,
            'quantity_change' => 15,
        ]);
    }

    public function test_import_allows_multiple_rows_of_same_no_material_with_normalized_name_in_file(): void
    {
        $admin = $this->createUser();

        $file = $this->createExcelUpload([
            ['MAT010', 'TEMPAT PENSIL', '2026-10-09', 5, 'Pcs', 'Baris 2'],
            ['MAT010', 'tempat pensil', '2026-10-09', 8, 'Pcs', 'Baris 3'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        // Cegah data ganda: hanya 1 record di tabel materials
        $this->assertEquals(1, Material::count());

        // Total stok digabungkan: 5 + 8 = 13
        $mat = Material::where('material_number', 'MAT010')->first();
        $this->assertNotNull($mat);
        $this->assertEquals(13, $mat->quantity);
    }

    public function test_import_rejects_duplicate_material_number_with_different_name_against_database(): void
    {
        $admin = $this->createUser();

        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Tempat Pensil',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $file = $this->createExcelUpload([
            ['MAT001', 'Buku Gambar', '2026-10-09', 5, 'Box', 'Barang baru'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertSessionHas('import_errors');
        $errors = session('import_errors');

        $this->assertTrue(collect($errors)->contains(function ($msg) {
            return str_contains($msg, "sudah terdaftar di sistem untuk material 'Tempat Pensil'")
                && str_contains($msg, "tertulis 'Buku Gambar'")
                && str_contains($msg, 'No Material yang sama tidak boleh digunakan untuk nama material yang berbeda');
        }));

        // Database tidak berubah
        $this->assertEquals(1, Material::count());
    }

    public function test_import_rejects_in_file_duplicate_material_number_with_different_name(): void
    {
        $admin = $this->createUser();

        $file = $this->createExcelUpload([
            ['MAT005', 'Spidol Hitam', '2026-10-09', 10, 'Pcs', 'Baris 2'],
            ['MAT005', 'Spidol Merah', '2026-10-09', 10, 'Pcs', 'Baris 3'],
        ]);

        $response = $this->actingAs($admin)->post('/materials/import', [
            'file' => $file,
        ]);

        $response->assertSessionHas('import_errors');
        $errors = session('import_errors');

        $this->assertTrue(collect($errors)->contains(function ($msg) {
            return str_contains($msg, 'sama dengan Baris 2 tetapi memiliki nama material berbeda')
                && str_contains($msg, 'Spidol Merah')
                && str_contains($msg, 'Spidol Hitam');
        }));

        // Tidak ada yang diimport
        $this->assertEquals(0, Material::count());
    }

    public function test_manual_store_allows_same_no_material_for_normalized_same_name_and_prevents_duplicate_data(): void
    {
        $admin = $this->createUser();

        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Tempat Pensil',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        // Input manual dengan huruf kapital dan spasi berlebih
        $response = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT001',
            'name'            => '   TEMPAT   PENSIL  ',
            'entry_date'      => '2026-10-09',
            'quantity'        => 20,
            'unit'            => 'Pcs',
            'description'     => 'Tambah stok manual',
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        // Mencegah data ganda
        $this->assertEquals(1, Material::count());

        $mat = Material::first();
        $this->assertEquals(30, $mat->quantity);

        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $mat->id,
            'material_number' => 'MAT001',
            'activity'        => 'Tambah',
            'quantity_before' => 10,
            'quantity_after'  => 30,
            'quantity_change' => 20,
        ]);
    }

    public function test_manual_store_rejects_same_no_material_with_different_name(): void
    {
        $admin = $this->createUser();

        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Tempat Pensil',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT001',
            'name'            => 'Penghapus Karet',
            'entry_date'      => '2026-10-09',
            'quantity'        => 5,
            'unit'            => 'Buah',
        ]);

        $response->assertSessionHasErrors(['material_number']);

        // Data tidak berubah
        $this->assertEquals(1, Material::count());
        $this->assertEquals(10, Material::first()->quantity);
    }

    public function test_material_analysis_does_not_merge_materials_with_same_name_and_different_material_number(): void
    {
        $admin = $this->createUser();

        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Map Dokumen',
            'entry_date'      => '2026-10-01',
            'quantity'        => 15,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Map Dokumen',
            'entry_date'      => '2026-10-02',
            'quantity'        => 25,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/material-analysis');
        $response->assertStatus(200);

        // Keduanya tampil terpisah sebagai dua entitas unik
        $response->assertSee('MAT001');
        $response->assertSee('MAT002');
        $response->assertSee('2 Data Material');
    }
}
