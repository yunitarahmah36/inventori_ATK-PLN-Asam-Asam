<?php

namespace Tests\Feature;

use App\Imports\StockInImport;
use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class StockInTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role = 'Admin'): User
    {
        return User::create([
            'name'     => $role,
            'username' => strtolower($role) . '_' . uniqid(),
            'email'    => strtolower($role) . '_' . uniqid() . '@pln.com',
            'password' => Hash::make('password123'),
            'role'     => $role,
        ]);
    }

    public function test_stock_in_requires_authentication(): void
    {
        $response = $this->get(route('materials.stock-in.index'));
        $response->assertRedirect('/login');

        $responsePost = $this->post(route('materials.stock-in.store'), [
            'material_id' => 1,
            'quantity'    => 10,
            'entry_date'  => '2026-10-09',
            'description' => 'Test',
        ]);
        $responsePost->assertRedirect('/login');
    }

    public function test_stock_in_page_can_be_accessed_by_authenticated_user(): void
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->get(route('materials.stock-in.index'));

        $response->assertStatus(200);
        $response->assertSee('Stok Masuk');
        $response->assertSee('Pencatatan Stok Masuk');
        $response->assertSee('Input Stok Masuk');
        $response->assertSee('Import Excel');
        $response->assertSee('manualStockInModal');
        $response->assertSee('importStockInModal');
    }

    public function test_sidebar_renders_data_material_submenu_with_stok_masuk(): void
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->get(route('materials.index'));

        $response->assertStatus(200);
        $response->assertSee('navGroupMaterials');
        $response->assertSee('materialSubmenu');
        $response->assertSee('Daftar Material');
        $response->assertSee('Stok Masuk');
    }

    public function test_manual_stock_in_successfully_increments_stock_and_creates_movement(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 80gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 20,
            'unit'            => 'Rim',
            'description'     => 'Stok Awal',
        ]);

        $response = $this->actingAs($user)->post(route('materials.stock-in.store'), [
            'material_id' => $material->id,
            'quantity'    => 15,
            'entry_date'  => '2026-10-09',
            'description' => 'Pengadaan Rutin Triwulan IV',
        ]);

        $response->assertRedirect(route('materials.stock-in.index'));
        $response->assertSessionHas('success');

        // Pastikan stok bertambah dari 20 menjadi 35
        $material->refresh();
        $this->assertEquals(35, $material->quantity);

        // Pastikan tercatat ke StockMovement
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'material_name'   => 'Kertas HVS A4 80gr',
            'material_number' => 'MAT001',
            'user_id'         => $user->id,
            'activity'        => 'Tambah',
            'quantity_before' => 20,
            'quantity_after'  => 35,
            'quantity_change' => 15,
            'description'     => 'Pengadaan Rutin Triwulan IV',
        ]);
    }

    public function test_manual_stock_in_fails_if_quantity_is_zero_or_negative(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Spidol Whiteboard',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
        ]);

        // Coba kuantitas 0
        $responseZero = $this->actingAs($user)->post(route('materials.stock-in.store'), [
            'material_id' => $material->id,
            'quantity'    => 0,
            'entry_date'  => '2026-10-09',
            'description' => 'Test 0',
        ]);
        $responseZero->assertSessionHasErrors(['quantity']);

        // Coba kuantitas negatif
        $responseNeg = $this->actingAs($user)->post(route('materials.stock-in.store'), [
            'material_id' => $material->id,
            'quantity'    => -5,
            'entry_date'  => '2026-10-09',
            'description' => 'Test negatif',
        ]);
        $responseNeg->assertSessionHasErrors(['quantity']);

        $material->refresh();
        $this->assertEquals(10, $material->quantity);
    }

    public function test_manual_stock_in_fails_if_material_does_not_exist(): void
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->post(route('materials.stock-in.store'), [
            'material_id' => 99999, // tidak ada di database
            'quantity'    => 10,
            'entry_date'  => '2026-10-09',
            'description' => 'Test non existent',
        ]);

        $response->assertSessionHasErrors(['material_id']);
    }

    public function test_download_template_returns_excel_file(): void
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->get(route('materials.stock-in.template'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_import_excel_stock_in_successfully_handles_mixed_and_repeated_materials(): void
    {
        $user = $this->createUser('Admin');

        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Rim',
        ]);

        $mat2 = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Spidol Hitam',
            'entry_date'      => '2026-10-01',
            'quantity'        => 5,
            'unit'            => 'Pcs',
        ]);

        // Simulasikan baris Excel bercampur dan berulang
        $rows = collect([
            [
                'no_material'   => 'MAT001',
                'nama_material' => 'Kertas HVS A4',
                'tanggal_masuk' => '2026-10-08',
                'jumlah_masuk'  => 10,
                'satuan'        => 'Rim',
                'keterangan'    => 'Pengadaan Batch 1',
            ],
            [
                'no_material'   => 'MAT002',
                'nama_material' => 'Spidol Hitam',
                'tanggal_masuk' => '2026-10-08',
                'jumlah_masuk'  => 15,
                'satuan'        => 'Pcs',
                'keterangan'    => 'Pengadaan Batch 1',
            ],
            [
                'no_material'   => 'MAT001', // Berulang!
                'nama_material' => 'Kertas HVS A4',
                'tanggal_masuk' => '2026-10-09',
                'jumlah_masuk'  => 20,
                'satuan'        => 'Rim',
                'keterangan'    => 'Pengadaan Tambahan Batch 2',
            ],
        ]);

        $this->actingAs($user);
        $importer = new StockInImport();
        $importer->collection($rows);

        $mat1->refresh();
        $mat2->refresh();

        // MAT001: 10 + 10 + 20 = 40
        $this->assertEquals(40, $mat1->quantity);

        // MAT002: 5 + 15 = 20
        $this->assertEquals(20, $mat2->quantity);

        // Pastikan 3 riwayat pergerakan stok tercatat
        $this->assertEquals(3, StockMovement::where('activity', 'Tambah')->count());
    }

    public function test_import_excel_stock_in_rejects_and_rolls_back_if_unregistered_material_number_exists(): void
    {
        $user = $this->createUser('Admin');

        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Rim',
        ]);

        // Baris kedua memiliki No Material yang BELUM terdaftar
        $rows = collect([
            [
                'no_material'   => 'MAT001',
                'nama_material' => 'Kertas HVS A4',
                'jumlah_masuk'  => 10,
                'tanggal_masuk' => '2026-10-09',
                'keterangan'    => 'Batch Valid',
            ],
            [
                'no_material'   => 'MAT999_BELUM_ADA', // TIDAK TERDAFTAR
                'nama_material' => 'Barang Tidak Terdaftar',
                'jumlah_masuk'  => 5,
                'tanggal_masuk' => '2026-10-09',
                'keterangan'    => 'Batch Tidak Valid',
            ],
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        try {
            $importer = new StockInImport();
            $importer->collection($rows);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Pastikan stok MAT001 TIDAK BERUBAH (tidak ada partial commit!)
            $mat1->refresh();
            $this->assertEquals(10, $mat1->quantity);

            // Pastikan tidak ada movement tersimpan
            $this->assertEquals(0, StockMovement::count());

            // Pastikan pesan error menyebutkan No Material dan nomor baris (Baris 3) yang bermasalah
            $errors = $e->errors();
            $this->assertArrayHasKey('import_errors', $errors);
            $this->assertStringContainsString('MAT999_BELUM_ADA', json_encode($errors));
            $this->assertStringContainsString('Baris 3', json_encode($errors));

            throw $e;
        }
    }

    public function test_import_excel_stock_in_rejects_when_material_number_correct_but_name_differs(): void
    {
        $user = $this->createUser('Admin');

        $mat = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        // No Material benar (MAT001), tetapi nama material berbeda (Spidol Snowman)
        $rows = collect([
            [
                'no_material'   => 'MAT001',
                'nama_material' => 'Spidol Snowman', // Nama berbeda!
                'jumlah_masuk'  => 10,
                'tanggal_masuk' => '2026-10-09',
                'keterangan'    => 'Salah Nama',
            ],
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        try {
            $importer = new StockInImport();
            $importer->collection($rows);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $mat->refresh();
            $this->assertEquals(50, $mat->quantity); // Stok tidak boleh berubah!

            $errors = $e->errors();
            $this->assertArrayHasKey('import_errors', $errors);
            $this->assertStringContainsString('Baris 2', json_encode($errors));
            $this->assertStringContainsString('MAT001', json_encode($errors));
            $this->assertStringContainsString('Spidol Snowman', json_encode($errors));

            throw $e;
        }
    }

    public function test_import_excel_stock_in_rejects_when_name_correct_but_material_number_differs(): void
    {
        $user = $this->createUser('Admin');

        $mat = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        // Nama benar (Kertas HVS A4), tetapi No Material berbeda (MAT999)
        $rows = collect([
            [
                'no_material'   => 'MAT999', // No Material berbeda!
                'nama_material' => 'Kertas HVS A4',
                'jumlah_masuk'  => 10,
                'tanggal_masuk' => '2026-10-09',
                'keterangan'    => 'Salah Nomor',
            ],
        ]);

        $this->expectException(\Illuminate\Validation\ValidationException::class);

        try {
            $importer = new StockInImport();
            $importer->collection($rows);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $mat->refresh();
            $this->assertEquals(50, $mat->quantity); // Stok tidak boleh berubah!

            $errors = $e->errors();
            $this->assertArrayHasKey('import_errors', $errors);
            $this->assertStringContainsString('Baris 2', json_encode($errors));
            $this->assertStringContainsString('MAT999', json_encode($errors));
            $this->assertStringContainsString('Kertas HVS A4', json_encode($errors));

            throw $e;
        }
    }

    public function test_import_excel_stock_in_accepts_when_both_match_with_normalization(): void
    {
        $user = $this->createUser('Admin');

        $mat = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
        ]);

        // No Material dan Nama Material sama setelah normalisasi spasi dan huruf besar/kecil
        $rows = collect([
            [
                'no_material'   => '  mat001  ',
                'nama_material' => '  kertas   hvs   a4  ',
                'jumlah_masuk'  => 15,
                'tanggal_masuk' => '2026-10-09',
                'keterangan'    => 'Normalisasi Sukses',
            ],
        ]);

        $this->actingAs($user);
        $importer = new StockInImport();
        $importer->collection($rows);

        $mat->refresh();
        $this->assertEquals(65, $mat->quantity); // 50 + 15 = 65
        $this->assertEquals(1, $importer->processedRowsCount);
        $this->assertEquals(1, StockMovement::where('material_id', $mat->id)->count());
    }

    public function test_stock_cannot_be_edited_directly_via_materials_edit(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT010',
            'name'            => 'Map Folder Plastik',
            'entry_date'      => '2026-10-01',
            'quantity'        => 25,
            'unit'            => 'Pcs',
        ]);

        // Coba manipulasi field quantity di update form
        $response = $this->actingAs($user)->put(route('materials.update', $material->id), [
            'material_number' => 'MAT010',
            'name'            => 'Map Folder Plastik Updated',
            'entry_date'      => '2026-10-01',
            'quantity'        => 9999, // manipulasi tidak boleh mengubah stok!
            'unit'            => 'Pcs',
        ]);

        $response->assertRedirect(route('materials.index'));

        $material->refresh();
        $this->assertEquals(25, $material->quantity); // Tetap 25!
    }

    public function test_stock_out_action_remains_available_on_materials_index(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT011',
            'name'            => 'Buku Folio Bergaris',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Buku',
        ]);

        $response = $this->actingAs($user)->get(route('materials.index'));
        $response->assertStatus(200);
        $response->assertSee('btn-open-stock-out-modal');
        $response->assertSee(route('materials.stock-out', $material->id));
    }

    public function test_stock_in_pagination_renders_cleanly_with_custom_template_and_spa_links(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT-PAG-01',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 500,
            'unit'            => 'Rim',
        ]);

        // Buat 30 transaksi stok masuk
        for ($i = 1; $i <= 30; $i++) {
            StockMovement::create([
                'material_id'     => $material->id,
                'material_number' => $material->material_number,
                'material_name'   => $material->name,
                'activity'        => 'Tambah',
                'quantity_change' => 10,
                'quantity_before' => ($i - 1) * 10,
                'quantity_after'  => $i * 10,
                'description'     => "Pengadaan Batch #{$i}",
                'user_id'         => $user->id,
            ]);
        }

        $response = $this->actingAs($user)->get(route('materials.stock-in.index', ['per_page' => 10]));
        $response->assertStatus(200);

        // Informasi total data
        $response->assertSee('Menampilkan <strong>1–10</strong> dari <strong>30</strong> transaksi', false);

        // Komponen navigasi pagination
        $response->assertSee('pagination-nav');
        $response->assertSee('pagination-list');
        $response->assertSee('page-prev');
        $response->assertSee('page-next');
        $response->assertSee('chevron_left');
        $response->assertSee('chevron_right');
        $response->assertSee('data-spa-link');
        $response->assertSee('Sebelumnya');
        // Dropdown baris per halaman
        $response->assertSee('per_page_select');
        $response->assertSee('Tampilkan:');
        $response->assertSee('changePerPage(this.value)', false);

        // Uji Halaman 2
        $responsePage2 = $this->actingAs($user)->get(route('materials.stock-in.index', ['per_page' => 10, 'page' => 2]));
        $responsePage2->assertStatus(200);
        $responsePage2->assertSee('Menampilkan <strong>11–20</strong> dari <strong>30</strong> transaksi', false);
        $responsePage2->assertSee('<span class="page-link page-num active">2</span>', false);
        $responsePage2->assertSee('page=1');
        $responsePage2->assertSee('page=3');

        // Uji Tampilkan Semua data
        $responseAll = $this->actingAs($user)->get(route('materials.stock-in.index', ['per_page' => 'all']));
        $responseAll->assertStatus(200);
        $responseAll->assertSee('Menampilkan <strong>1–30</strong> dari <strong>30</strong> transaksi', false);
    }

    public function test_download_stock_in_template_returns_excel_with_headers_only(): void
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->get(route('materials.stock-in.template'));

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('content-disposition') ?? '', 'template-stok-masuk-atk.xlsx')
        );

        $export = new \App\Exports\StockInTemplateExport();
        $arrayData = $export->array();

        // Hanya 1 baris (hanya header kolom, tanpa baris data contoh)
        $this->assertCount(1, $arrayData);
        $this->assertEquals([
            'No Material',
            'Nama Material',
            'Tanggal Masuk',
            'Jumlah Masuk',
            'Keterangan',
        ], $arrayData[0]);

        // Pastikan kolom C diformat sebagai dd/mm/yyyy
        $columnFormats = $export->columnFormats();
        $this->assertEquals('dd/mm/yyyy', $columnFormats['C']);
        $this->assertEquals('0', $columnFormats['D']);
    }

    public function test_manual_stock_in_persists_custom_entry_date_to_movement_and_displays_on_page(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT005',
            'name'            => 'Buku Catatan Ekspedisi',
            'entry_date'      => '2026-01-01',
            'quantity'        => 5,
            'unit'            => 'Buku',
        ]);

        $customDate = '2026-05-15';

        $response = $this->actingAs($user)->post(route('materials.stock-in.store'), [
            'material_id' => $material->id,
            'quantity'    => 20,
            'entry_date'  => $customDate,
            'description' => 'Penerimaan Buku Catatan Periode Mei',
        ]);

        $response->assertRedirect(route('materials.stock-in.index'));

        // Cek pergerakan stok: created_at harus menyimpan tanggal 2026-05-15
        $movement = StockMovement::where('material_id', $material->id)
            ->where('activity', 'Tambah')
            ->first();

        $this->assertNotNull($movement);
        $this->assertEquals('2026-05-15', $movement->created_at->format('Y-m-d'));

        // Material juga harus terupdate tanggal masuknya
        $material->refresh();
        $this->assertEquals('2026-05-15', $material->entry_date->format('Y-m-d'));

        // Halaman Stok Masuk harus menampilkan tanggal yang diinput (15 Mei 2026)
        $pageResponse = $this->actingAs($user)->get(route('materials.stock-in.index'));
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee('15 Mei 2026');
    }

    public function test_import_excel_stock_in_supports_dd_mm_yyyy_format_and_persists_entry_date(): void
    {
        $user = $this->createUser('Admin');

        $mat = Material::create([
            'material_number' => 'MAT006',
            'name'            => 'Kertas Buffalo Kuning',
            'entry_date'      => '2026-01-01',
            'quantity'        => 10,
            'unit'            => 'Rim',
        ]);

        $rows = collect([
            [
                'no_material'   => 'MAT006',
                'nama_material' => 'Kertas Buffalo Kuning',
                'tanggal_masuk' => '25/08/2026', // Format DD/MM/YYYY
                'jumlah_masuk'  => 30,
                'keterangan'    => 'Pengadaan Kertas Agustus',
            ],
        ]);

        $this->actingAs($user);
        $importer = new StockInImport();
        $importer->collection($rows);

        $movement = StockMovement::where('material_id', $mat->id)
            ->where('activity', 'Tambah')
            ->first();

        $this->assertNotNull($movement);
        $this->assertEquals('2026-08-25', $movement->created_at->format('Y-m-d'));

        $mat->refresh();
        $this->assertEquals('2026-08-25', $mat->entry_date->format('Y-m-d'));
        $this->assertEquals(40, $mat->quantity);

        // Halaman Stok Masuk menampilkan tanggal 25 Agt 2026
        $pageResponse = $this->actingAs($user)->get(route('materials.stock-in.index'));
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee('25 Agt 2026');
    }

    public function test_import_excel_stock_in_validates_required_and_invalid_date_format(): void
    {
        $user = $this->createUser('Admin');

        Material::create([
            'material_number' => 'MAT007',
            'name'            => 'Tinta Stempel',
            'entry_date'      => '2026-01-01',
            'quantity'        => 10,
            'unit'            => 'Botol',
        ]);

        // Uji jika tanggal kosong
        $rowsEmptyDate = collect([
            [
                'no_material'   => 'MAT007',
                'nama_material' => 'Tinta Stempel',
                'tanggal_masuk' => '',
                'jumlah_masuk'  => 5,
                'keterangan'    => 'Test',
            ],
        ]);

        $this->actingAs($user);
        $importer = new StockInImport();

        try {
            $importer->collection($rowsEmptyDate);
            $this->fail('Harusnya gagal karena tanggal masuk kosong');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertArrayHasKey('import_errors', $e->errors());
            $this->assertTrue(str_contains($e->errors()['import_errors'][0], 'Kolom Tanggal Masuk wajib diisi'));
        }

        // Uji jika format tanggal ngawur / tidak valid
        $rowsInvalidDate = collect([
            [
                'no_material'   => 'MAT007',
                'nama_material' => 'Tinta Stempel',
                'tanggal_masuk' => '99/99/9999',
                'jumlah_masuk'  => 5,
                'keterangan'    => 'Test',
            ],
        ]);

        try {
            $importer->collection($rowsInvalidDate);
            $this->fail('Harusnya gagal karena format tanggal tidak valid');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->assertArrayHasKey('import_errors', $e->errors());
            $this->assertTrue(str_contains($e->errors()['import_errors'][0], 'Format tanggal tidak dikenali'));
        }
    }
}
