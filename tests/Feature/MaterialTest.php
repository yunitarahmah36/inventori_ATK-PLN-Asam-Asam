<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MaterialTest extends TestCase
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

    public function test_materials_page_requires_login(): void
    {
        $response = $this->get('/materials');
        $response->assertRedirect('/login');
    }

    public function test_all_user_roles_can_access_materials_page(): void
    {
        foreach (['Admin', 'Keuangan', 'Umum'] as $role) {
            $user = $this->createUser($role);
            $response = $this->actingAs($user)->get('/materials');
            $response->assertStatus(200);
            $response->assertSee('Data Material');
            $response->assertSee('Tambah Material');
            $response->assertSee('Import Excel');
            $response->assertSee('Export Excel');
        }
    }

    public function test_materials_page_shows_empty_state_when_no_data(): void
    {
        $admin = $this->createUser('Admin');
        $response = $this->actingAs($admin)->get('/materials');

        $response->assertStatus(200);
        $response->assertSee('Belum ada data material');
        $response->assertSee('Silakan daftarkan material baru atau import data master melalui file Excel.');
    }

    public function test_materials_page_displays_master_material_columns(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => '2026-10-01',
            'quantity'        => 120, // kuantitas di database
            'unit'            => 'Rim',
            'is_active'       => true,
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/materials');
        $response->assertStatus(200);
        $response->assertSee('MAT001');
        $response->assertSee('Kertas HVS A4 70gr');
        $response->assertSee('Rim');

        // Pastikan kolom stok dan tanggal masuk TIDAK ditampilkan di header tabel Data Material
        $response->assertDontSee('Tanggal Masuk');
        $response->assertDontSee('Jumlah Item');
    }

    public function test_search_filters_material_by_number_and_name(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'unit'            => 'Rim',
            'quantity'        => 0,
            'is_active'       => true,
            'created_by'      => $admin->id,
        ]);
        Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Pulpen Pilot G2',
            'unit'            => 'Pcs',
            'quantity'        => 0,
            'is_active'       => true,
            'created_by'      => $admin->id,
        ]);

        // Cari berdasarkan nama
        $resName = $this->actingAs($admin)->get('/materials?search=Pulpen');
        $resName->assertSee('Pulpen Pilot G2');
        $resName->assertDontSee('Kertas HVS A4');

        // Cari berdasarkan nomor
        $resNumber = $this->actingAs($admin)->get('/materials?search=MAT001');
        $resNumber->assertSee('Kertas HVS A4');
        $resNumber->assertDontSee('Pulpen Pilot G2');
    }

    public function test_store_creates_master_material_and_records_stock_movement(): void
    {
        $admin = $this->createUser('Admin');

        $response = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT010',
            'name'            => 'Spidol Snowman Hitam',
            'unit'            => 'Pcs',
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        // Pastikan tersimpan dengan stok 0 dan aktif
        $this->assertDatabaseHas('materials', [
            'material_number' => 'MAT010',
            'name'            => 'Spidol Snowman Hitam',
            'unit'            => 'Pcs',
            'quantity'        => 0,
            'is_active'       => true,
        ]);

        // Pastikan tercatat di riwayat stok (stock_movements) dengan aktivitas Tambah
        $this->assertDatabaseHas('stock_movements', [
            'material_number' => 'MAT010',
            'material_name'   => 'Spidol Snowman Hitam',
            'activity'        => 'Tambah',
            'quantity_change' => 0,
        ]);
    }

    public function test_store_validates_required_and_unique_fields(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Existing Material',
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        // Coba kirim data kosong dan duplikat No. Material
        $response = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT001', // duplikat
            'name'            => '',       // kosong
            'unit'            => '',       // kosong
        ]);

        $response->assertSessionHasErrors(['material_number', 'name', 'unit']);
    }

    public function test_store_rejects_duplicate_material_name_case_insensitive(): void
    {
        $admin = $this->createUser('Admin');

        // Daftarkan material pertama
        $res1 = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT005',
            'name'            => 'STEPLES',
            'unit'            => 'Pcs',
        ]);
        $res1->assertRedirect('/materials');

        // Coba daftarkan material kedua dengan nama sama (huruf kecil: steples) tetapi nomor berbeda (MAT007)
        $res2 = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT007',
            'name'            => 'steples',
            'unit'            => 'Roll',
        ]);

        // Harus ditolak dengan validasi error pada 'name'
        $res2->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('materials', [
            'material_number' => 'MAT007',
        ]);
    }

    public function test_update_rejects_duplicate_material_name_from_another_material(): void
    {
        $admin = $this->createUser('Admin');

        $mat1 = Material::create([
            'material_number' => 'MAT005',
            'name'            => 'STEPLES',
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $mat2 = Material::create([
            'material_number' => 'MAT006',
            'name'            => 'CORECCTOR',
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        // Coba ubah mat2 namanya menjadi sama dengan mat1
        $response = $this->actingAs($admin)->put("/materials/{$mat2->id}", [
            'material_number' => 'MAT006',
            'name'            => 'steples',
            'unit'            => 'Pcs',
        ]);

        $response->assertSessionHasErrors(['name']);
        $mat2->refresh();
        $this->assertEquals('CORECCTOR', $mat2->name);
    }

    public function test_update_modifies_master_material_without_changing_stock(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT005',
            'name'            => 'Buku Tulis',
            'quantity'        => 30, // stok yang sudah ada
            'unit'            => 'Buah',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->put("/materials/{$material->id}", [
            'material_number' => 'MAT005',
            'name'            => 'Buku Tulis Bergaris 58 Lembar',
            'unit'            => 'Buku',
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        $material->refresh();
        $this->assertEquals('Buku Tulis Bergaris 58 Lembar', $material->name);
        $this->assertEquals('Buku', $material->unit);
        $this->assertEquals(30, $material->quantity); // Stok tetap 30, tidak terpengaruh!
    }

    public function test_update_syncs_stock_movement_snapshots_when_name_changes_and_keeps_material_number_immutable(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT006',
            'name'            => 'Lakban Bening',
            'quantity'        => 10,
            'unit'            => 'Roll',
            'created_by'      => $admin->id,
        ]);

        $movement = StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => 'Lakban Bening',
            'material_number' => 'MAT006',
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => 10,
            'quantity_change' => 10,
        ]);

        // Coba kirim data update dengan nama baru dan No. Material berbeda
        $response = $this->actingAs($admin)->put("/materials/{$material->id}", [
            'material_number' => 'MAT006-TAMPERED',
            'name'            => 'Lakban Bening Tebal',
            'unit'            => 'Roll',
        ]);

        $response->assertRedirect('/materials');

        $material->refresh();
        // No. Material tetap MAT006 (tidak dapat diubah)
        $this->assertEquals('MAT006', $material->material_number);
        $this->assertEquals('Lakban Bening Tebal', $material->name);

        $movement->refresh();
        $this->assertEquals('MAT006', $movement->material_number);
        $this->assertEquals('Lakban Bening Tebal', $movement->material_name);
        $this->assertEquals($material->id, $movement->material_id);
    }

    public function test_update_does_not_change_material_number_even_if_submitted(): void
    {
        $admin = $this->createUser('Admin');
        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Barang Satu',
            'unit'            => 'Pcs',
        ]);

        $res = $this->actingAs($admin)->put("/materials/{$mat1->id}", [
            'material_number' => 'MAT999',
            'name'            => 'Barang Satu Update',
            'unit'            => 'Box',
        ]);

        $res->assertRedirect('/materials');

        $mat1->refresh();
        // Nomor material harus tetap MAT001
        $this->assertEquals('MAT001', $mat1->material_number);
        $this->assertEquals('Barang Satu Update', $mat1->name);
        $this->assertEquals('Box', $mat1->unit);
    }

    public function test_destroy_deletes_permanently_if_no_stock_history(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT009',
            'name'            => 'Barang Belum Dipakai',
            'quantity'        => 0,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->delete("/materials/{$material->id}");
        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('materials', [
            'id' => $material->id,
        ]);
    }

    public function test_destroy_deletes_material_and_preserves_stock_history(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT011',
            'name'            => 'Barang Dengan Riwayat',
            'quantity'        => 15,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        // Buat relasi riwayat stok
        $movement = StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => $admin->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => 15,
            'quantity_change' => 15,
        ]);

        $response = $this->actingAs($admin)->delete("/materials/{$material->id}");
        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        // Material dihapus dari tabel materials
        $this->assertDatabaseMissing('materials', [
            'id' => $material->id,
        ]);

        // Riwayat pergerakan stok tetap utuh dan snapshot terjaga
        $movement->refresh();
        $this->assertNull($movement->material_id);
        $this->assertEquals('Barang Dengan Riwayat', $movement->material_name);
        $this->assertEquals('MAT011', $movement->material_number);

        // Tercatat pula log aktivitas 'Hapus'
        $this->assertDatabaseHas('stock_movements', [
            'activity'        => 'Hapus',
            'material_number' => 'MAT011',
        ]);
    }

    public function test_bulk_destroy_deletes_selected_materials(): void
    {
        $admin = $this->createUser('Admin');
        $mat1 = Material::create(['material_number' => 'MAT021', 'name' => 'Barang A', 'unit' => 'Pcs']);
        $mat2 = Material::create(['material_number' => 'MAT022', 'name' => 'Barang B', 'unit' => 'Pcs']);
        $mat3 = Material::create(['material_number' => 'MAT023', 'name' => 'Barang C', 'unit' => 'Pcs']);

        $response = $this->actingAs($admin)->post('/materials/bulk-destroy', [
            'ids' => [$mat1->id, $mat2->id],
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('materials', ['id' => $mat1->id]);
        $this->assertDatabaseMissing('materials', ['id' => $mat2->id]);
        $this->assertDatabaseHas('materials', ['id' => $mat3->id]);
    }

    public function test_delete_all_removes_all_master_materials(): void
    {
        $admin = $this->createUser('Admin');
        Material::create(['material_number' => 'MAT031', 'name' => 'Barang X', 'unit' => 'Pcs']);
        Material::create(['material_number' => 'MAT032', 'name' => 'Barang Y', 'unit' => 'Pcs']);

        $response = $this->actingAs($admin)->post('/materials/delete-all');
        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        $this->assertEquals(0, Material::count());
    }

    public function test_export_downloads_master_materials_excel_file(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 Test Export',
            'unit'            => 'Rim',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/materials/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_download_template_downloads_3_column_excel_template(): void
    {
        $admin = $this->createUser('Admin');

        $response = $this->actingAs($admin)->get('/materials/import/template');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_materials_default_order_is_latest_and_supports_sorting(): void
    {
        $admin = $this->createUser('Admin');

        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Buku Tulis A',
            'unit'            => 'Pcs',
            'created_at'      => now()->subDays(2),
        ]);

        $mat2 = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Amplop Cokelat',
            'unit'            => 'Pcs',
            'created_at'      => now()->subDays(1),
        ]);

        $mat3 = Material::create([
            'material_number' => 'MAT003',
            'name'            => 'Zebra Pen',
            'unit'            => 'Pcs',
            'created_at'      => now(),
        ]);

        // Default: data terbaru di posisi teratas
        $responseDefault = $this->actingAs($admin)->get('/materials');
        $responseDefault->assertStatus(200);
        $materialsDefault = $responseDefault->viewData('materials');
        $this->assertEquals($mat3->id, $materialsDefault->first()->id);
        $this->assertEquals($mat1->id, $materialsDefault->last()->id);

        // Sort Nama A - Z
        $responseNameAsc = $this->actingAs($admin)->get('/materials?sort=name_asc');
        $materialsNameAsc = $responseNameAsc->viewData('materials');
        $this->assertEquals($mat2->id, $materialsNameAsc->first()->id); // Amplop Cokelat
        $this->assertEquals($mat3->id, $materialsNameAsc->last()->id);  // Zebra Pen

        // Sort Terlama
        $responseOldest = $this->actingAs($admin)->get('/materials?sort=oldest');
        $materialsOldest = $responseOldest->viewData('materials');
        $this->assertEquals($mat1->id, $materialsOldest->first()->id); // Buku Tulis A
    }

    public function test_export_respects_sorting_and_per_page_limit(): void
    {
        $admin = $this->createUser('Admin');

        Material::create(['material_number' => 'MAT001', 'name' => 'Kertas A4', 'unit' => 'Rim']);
        Material::create(['material_number' => 'MAT002', 'name' => 'Buku Tulis', 'unit' => 'Pcs']);
        Material::create(['material_number' => 'MAT003', 'name' => 'Amplop Putih', 'unit' => 'Pcs']);

        // Uji collection export langsung dengan parameter sort name_asc dan limit per_page 2
        $export = new \App\Exports\MaterialsExport(null, 'name_asc', 2, 1);
        $collection = $export->collection();

        // 5 baris pertama: 3 judul/info + 1 baris kosong + 1 header (index 0..4)
        // Data dimulai pada index 5
        $firstDataRow = $collection->get(5);
        $secondDataRow = $collection->get(6);

        $this->assertEquals('Amplop Putih', $firstDataRow[2]); // Urutan A-Z pertama
        $this->assertEquals('Buku Tulis', $secondDataRow[2]);  // Urutan A-Z kedua
        $this->assertNull($collection->get(7)); // Hanya 2 data yang diexport karena limit per_page = 2

        // Uji endpoint HTTP export dengan query string
        $response = $this->actingAs($admin)->get('/materials/export?sort=name_asc&per_page=2');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
