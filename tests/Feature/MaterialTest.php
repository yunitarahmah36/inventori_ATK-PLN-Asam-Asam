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
            'username' => strtolower($role),
            'email'    => strtolower($role) . '@pln.com',
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
            $response->assertSee('Kelola data material ATK PLN Asam-Asam');
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
        $response->assertSee('Silakan tambahkan material baru atau import data melalui Excel.');
    }

    public function test_materials_page_displays_material_data(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 70gr',
            'entry_date'      => now(),
            'quantity'        => 120,
            'unit'            => 'Rim',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/materials');
        $response->assertStatus(200);
        $response->assertSee('MAT001');
        $response->assertSee('Kertas HVS A4 70gr');
        $response->assertSee('120');
        $response->assertSee('Rim');
    }

    public function test_search_filters_material_by_number_and_name(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => now(),
            'quantity'        => 50,
            'unit'            => 'Rim',
            'created_by'      => $admin->id,
        ]);
        Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Pulpen Pilot',
            'entry_date'      => now(),
            'quantity'        => 20,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        // Cari berdasarkan nama
        $resName = $this->actingAs($admin)->get('/materials?search=Pulpen');
        $resName->assertSee('Pulpen Pilot');
        $resName->assertDontSee('Kertas HVS A4');

        // Cari berdasarkan nomor
        $resNumber = $this->actingAs($admin)->get('/materials?search=MAT001');
        $resNumber->assertSee('Kertas HVS A4');
        $resNumber->assertDontSee('Pulpen Pilot');
    }

    public function test_date_filter_filters_by_entry_date(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Material Lama',
            'entry_date'      => '2026-01-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);
        Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Material Baru',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/materials?start_date=2026-09-01&end_date=2026-10-31');
        $response->assertSee('Material Baru');
        $response->assertDontSee('Material Lama');
    }

    public function test_store_creates_new_material_and_stock_movement(): void
    {
        $umum = $this->createUser('Umum');

        $response = $this->actingAs($umum)->post('/materials', [
            'material_number' => 'MAT010',
            'name'            => 'Spidol Snowman',
            'entry_date'      => '2026-10-06',
            'quantity'        => 25,
            'unit'            => 'Pcs',
            'description'     => 'Spidol papan tulis',
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success', 'Material berhasil ditambahkan.');

        $this->assertDatabaseHas('materials', [
            'material_number' => 'MAT010',
            'name'            => 'Spidol Snowman',
            'quantity'        => 25,
            'unit'            => 'Pcs',
            'created_by'      => $umum->id,
        ]);

        // Periksa pencatatan riwayat stok
        $this->assertDatabaseHas('stock_movements', [
            'user_id'         => $umum->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => 25,
            'quantity_change' => 25,
        ]);
    }

    public function test_store_validates_required_and_unique_fields(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Existing Material',
            'entry_date'      => now(),
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT001', // duplikat
            'name'            => '',       // kosong
            'entry_date'      => '',
            'quantity'        => -5,       // negatif
            'unit'            => '',
        ]);

        $response->assertSessionHasErrors(['material_number', 'name', 'entry_date', 'quantity', 'unit']);
    }

    public function test_update_modifies_material_and_logs_movement(): void
    {
        $keuangan = $this->createUser('Keuangan');
        $material = Material::create([
            'material_number' => 'MAT005',
            'name'            => 'Buku Tulis',
            'entry_date'      => '2026-10-01',
            'quantity'        => 30,
            'unit'            => 'Buah',
            'created_by'      => $keuangan->id,
        ]);

        $response = $this->actingAs($keuangan)->put("/materials/{$material->id}", [
            'material_number' => 'MAT005',
            'name'            => 'Buku Tulis Bergaris',
            'entry_date'      => '2026-10-02',
            'quantity'        => 50,
            'unit'            => 'Buah',
            'description'     => 'Revisi stok',
        ]);

        $response->assertRedirect('/materials');
        $response->assertSessionHas('success', 'Material berhasil diperbarui.');

        $this->assertDatabaseHas('materials', [
            'id'       => $material->id,
            'name'     => 'Buku Tulis Bergaris',
            'quantity' => 50,
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'user_id'         => $keuangan->id,
            'activity'        => 'Edit',
            'quantity_before' => 30,
            'quantity_after'  => 50,
            'quantity_change' => 20,
        ]);
    }

    public function test_destroy_deletes_material(): void
    {
        $admin = $this->createUser('Admin');
        $material = Material::create([
            'material_number' => 'MAT009',
            'name'            => 'Barang Dihapus',
            'entry_date'      => now(),
            'quantity'        => 5,
            'unit'            => 'Pcs',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->delete("/materials/{$material->id}");
        $response->assertRedirect('/materials');
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('materials', [
            'id' => $material->id,
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'user_id'         => $admin->id,
            'activity'        => 'Hapus',
            'quantity_before' => 5,
            'quantity_after'  => 0,
            'quantity_change' => -5,
        ]);
    }

    public function test_export_downloads_excel_file(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 Test Export',
            'entry_date'      => '2026-10-06',
            'quantity'        => 100,
            'unit'            => 'Rim',
            'created_by'      => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get('/materials/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
