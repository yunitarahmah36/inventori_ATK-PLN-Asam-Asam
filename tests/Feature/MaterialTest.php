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

    public function test_store_creates_master_material_without_altering_stock_or_creating_movement(): void
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

        // Pastikan TIDAK membuat catatan di stock_movements (stok tidak tersentuh)
        $this->assertDatabaseMissing('stock_movements', [
            'material_number' => 'MAT010',
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

    public function test_update_syncs_stock_movement_snapshots_when_material_number_or_name_changes(): void
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

        // Ubah nomor dan nama material
        $response = $this->actingAs($admin)->put("/materials/{$material->id}", [
            'material_number' => 'MAT006-REV',
            'name'            => 'Lakban Bening Tebal',
            'unit'            => 'Roll',
        ]);

        $response->assertRedirect('/materials');

        $movement->refresh();
        $this->assertEquals('MAT006-REV', $movement->material_number);
        $this->assertEquals('Lakban Bening Tebal', $movement->material_name);
        $this->assertEquals($material->id, $movement->material_id);
    }

    public function test_update_validates_unique_material_number_excluding_itself(): void
    {
        $admin = $this->createUser('Admin');
        $mat1 = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Barang Satu',
            'unit'            => 'Pcs',
        ]);
        $mat2 = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Barang Dua',
            'unit'            => 'Pcs',
        ]);

        // Update mat1 menggunakan nomor miliknya sendiri (harus berhasil)
        $resSelf = $this->actingAs($admin)->put("/materials/{$mat1->id}", [
            'material_number' => 'MAT001',
            'name'            => 'Barang Satu Update',
            'unit'            => 'Pcs',
        ]);
        $resSelf->assertSessionHasNoErrors();

        // Update mat1 menggunakan nomor milik mat2 (harus gagal validasi)
        $resConflict = $this->actingAs($admin)->put("/materials/{$mat1->id}", [
            'material_number' => 'MAT002',
            'name'            => 'Barang Satu Update',
            'unit'            => 'Pcs',
        ]);
        $resConflict->assertSessionHasErrors(['material_number']);
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

    public function test_destroy_deactivates_material_if_has_stock_history_to_protect_relations(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT011',
            'name'            => 'Barang Dengan Riwayat',
            'quantity'        => 15,
            'unit'            => 'Pcs',
            'is_active'       => true,
            'created_by'      => $admin->id,
        ]);

        // Buat relasi riwayat stok
        StockMovement::create([
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

        // Material TIDAK dihapus dari database, melainkan dinonaktifkan
        $this->assertDatabaseHas('materials', [
            'id'        => $material->id,
            'is_active' => false,
        ]);

        // Riwayat pergerakan stok tetap utuh
        $this->assertDatabaseHas('stock_movements', [
            'material_id' => $material->id,
        ]);
    }

    public function test_deactivated_material_cannot_be_selected_for_stock_in_or_stock_out(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT012',
            'name'            => 'Barang Nonaktif',
            'quantity'        => 5,
            'unit'            => 'Pcs',
            'is_active'       => false, // Nonaktif
            'created_by'      => $admin->id,
        ]);

        // Coba catat stok masuk manual
        $resStockIn = $this->actingAs($admin)->post('/materials/stock-in', [
            'material_id' => $material->id,
            'quantity'    => 10,
            'entry_date'  => '2026-10-09',
        ]);
        $resStockIn->assertSessionHasErrors(['material_id']);

        // Coba catat stok keluar
        $resStockOut = $this->actingAs($admin)->post('/materials/stock-out', [
            'material_id' => $material->id,
            'quantity'    => 2,
            'exit_date'   => '2026-10-09',
        ]);
        $resStockOut->assertSessionHasErrors(['material_id']);
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
}
