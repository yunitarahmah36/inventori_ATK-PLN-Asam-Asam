<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StockOutTest extends TestCase
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

    public function test_stock_out_requires_authentication(): void
    {
        $material = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
            'description'     => 'Stok ATK',
        ]);

        $response = $this->post(route('materials.stock-out', $material->id), [
            'quantity'    => 5,
            'exit_date'   => '2026-10-09',
            'description' => 'Keperluan rapat',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_stock_out_button_and_modal_rendered_on_materials_index(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Rim',
            'description'     => 'Stok ATK',
        ]);

        $response = $this->actingAs($user)->get(route('materials.index'));

        $response->assertStatus(200);
        $response->assertSee('btn-open-stock-out-modal');
        $response->assertSee('Stok Keluar');
        $response->assertSee('stockOutModal');
        $response->assertSee('Catat Stok Keluar');
        $response->assertSee('Simpan Stok Keluar');
    }

    public function test_stock_out_successfully_reduces_quantity_and_creates_stock_movement(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT100',
            'name'            => 'Spidol Boardmarker Hitam',
            'entry_date'      => '2026-10-01',
            'quantity'        => 25,
            'unit'            => 'Pcs',
            'description'     => 'Stok operasional',
        ]);

        $response = $this->actingAs($user)->post(route('materials.stock-out', $material->id), [
            'quantity'    => 7,
            'exit_date'   => '2026-10-09',
            'description' => 'Digunakan untuk pelatihan K3',
        ]);

        $response->assertRedirect(route('materials.index'));
        $response->assertSessionHas('success');

        // Pastikan stok berkurang
        $material->refresh();
        $this->assertEquals(18, $material->quantity);

        // Pastikan tercatat di StockMovement
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'material_name'   => 'Spidol Boardmarker Hitam',
            'material_number' => 'MAT100',
            'user_id'         => $user->id,
            'activity'        => 'Keluar',
            'quantity_before' => 25,
            'quantity_after'  => 18,
            'quantity_change' => -7,
            'description'     => 'Digunakan untuk pelatihan K3',
        ]);
    }

    public function test_stock_out_validation_fails_if_quantity_is_zero_or_negative(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT101',
            'name'            => 'Buku Ekspedisi',
            'entry_date'      => '2026-10-01',
            'quantity'        => 10,
            'unit'            => 'Buku',
            'description'     => 'Stok administrasi',
        ]);

        // Uji kuantitas 0
        $responseZero = $this->actingAs($user)->post(route('materials.stock-out', $material->id), [
            'quantity'    => 0,
            'exit_date'   => '2026-10-09',
            'description' => 'Test 0',
        ]);
        $responseZero->assertSessionHasErrors(['quantity']);

        // Uji kuantitas negatif
        $responseNeg = $this->actingAs($user)->post(route('materials.stock-out', $material->id), [
            'quantity'    => -5,
            'exit_date'   => '2026-10-09',
            'description' => 'Test negatif',
        ]);
        $responseNeg->assertSessionHasErrors(['quantity']);

        // Stok tidak berubah
        $material->refresh();
        $this->assertEquals(10, $material->quantity);
    }

    public function test_stock_out_validation_fails_if_quantity_exceeds_available_stock(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT102',
            'name'            => 'Tinta Printer Epson Black',
            'entry_date'      => '2026-10-01',
            'quantity'        => 8,
            'unit'            => 'Botol',
            'description'     => 'Stok tinta',
        ]);

        // Coba keluarkan 9 botol padahal stok hanya 8
        $response = $this->actingAs($user)->post(route('materials.stock-out', $material->id), [
            'quantity'    => 9,
            'exit_date'   => '2026-10-09',
            'description' => 'Keperluan cetak laporan tahunan',
        ]);

        $response->assertSessionHasErrors(['quantity']);

        // Pastikan stok tidak menjadi negatif dan tetap 8
        $material->refresh();
        $this->assertEquals(8, $material->quantity);

        // Pastikan tidak ada movement tercatat
        $this->assertDatabaseMissing('stock_movements', [
            'material_id' => $material->id,
            'activity'    => 'Keluar',
        ]);
    }

    public function test_stock_out_validation_requires_date_and_description(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT103',
            'name'            => 'Map Snelhechter',
            'entry_date'      => '2026-10-01',
            'quantity'        => 30,
            'unit'            => 'Pcs',
        ]);

        $response = $this->actingAs($user)->post(route('materials.stock-out', $material->id), [
            'quantity'    => 5,
            'exit_date'   => '',
            'description' => '',
        ]);

        $response->assertSessionHasErrors(['exit_date', 'description']);

        $material->refresh();
        $this->assertEquals(30, $material->quantity);
    }

    public function test_stock_out_can_deplete_stock_to_zero_without_negative(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT104',
            'name'            => 'Baterai AA',
            'entry_date'      => '2026-10-01',
            'quantity'        => 12,
            'unit'            => 'Pack',
        ]);

        // Keluarkan seluruh stok (12)
        $response = $this->actingAs($user)->post(route('materials.stock-out', $material->id), [
            'quantity'    => 12,
            'exit_date'   => '2026-10-09',
            'description' => 'Penggantian baterai seluruh mouse unit',
        ]);

        $response->assertRedirect(route('materials.index'));

        $material->refresh();
        $this->assertEquals(0, $material->quantity);

        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'activity'        => 'Keluar',
            'quantity_before' => 12,
            'quantity_after'  => 0,
            'quantity_change' => -12,
        ]);
    }

    public function test_material_edit_form_does_not_modify_stock(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT105',
            'name'            => 'Gunting Kertas Sedang',
            'entry_date'      => '2026-10-01',
            'quantity'        => 15,
            'unit'            => 'Pcs',
            'description'     => 'Keterangan awal',
        ]);

        // Akses halaman edit
        $responseEdit = $this->actingAs($user)->get(route('materials.edit', $material->id));
        $responseEdit->assertStatus(200);
        $responseEdit->assertSee('readonly');

        // Coba submit update dengan manipulasi quantity di payload
        $responseUpdate = $this->actingAs($user)->put(route('materials.update', $material->id), [
            'material_number' => 'MAT105',
            'name'            => 'Gunting Kertas Sedang Updated',
            'entry_date'      => '2026-10-01',
            'quantity'        => 999, // payload manipulasi tidak boleh mengubah stok
            'unit'            => 'Pcs',
            'description'     => 'Keterangan baru',
        ]);

        $responseUpdate->assertRedirect(route('materials.index'));

        $material->refresh();
        $this->assertEquals('Gunting Kertas Sedang Updated', $material->name);
        $this->assertEquals(15, $material->quantity); // Tetap 15!
    }

    public function test_stock_out_index_page_rendered_with_kpi_and_table(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT201',
            'name'            => 'Pulpen Standard Hitam',
            'entry_date'      => '2026-10-01',
            'quantity'        => 50,
            'unit'            => 'Pcs',
        ]);

        StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => $user->id,
            'activity'        => 'Keluar',
            'quantity_before' => 50,
            'quantity_after'  => 45,
            'quantity_change' => -5,
            'recipient'       => 'Divisi HRD',
            'description'     => 'Keperluan orientasi',
            'created_at'      => now(),
        ]);

        $response = $this->actingAs($user)->get(route('materials.stock-out.index'));

        $response->assertStatus(200);
        $response->assertSee('Stok Keluar');
        $response->assertSee('Total Transaksi Keluar');
        $response->assertSee('Total Item Dikeluarkan');
        $response->assertSee('Pulpen Standard Hitam');
        $response->assertSee('MAT201');
        $response->assertSee('Divisi HRD');
        $response->assertSee('Keperluan orientasi');
    }

    public function test_stock_out_store_via_stock_out_controller(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT202',
            'name'            => 'Kertas Buffalo Kuning',
            'entry_date'      => '2026-10-01',
            'quantity'        => 30,
            'unit'            => 'Rim',
        ]);

        $response = $this->actingAs($user)->post(route('materials.stock-out.store'), [
            'material_id' => $material->id,
            'quantity'    => 10,
            'exit_date'   => '2026-10-09',
            'recipient'   => 'Seksi Pemeliharaan',
            'description' => 'Untuk cover laporan',
        ]);

        $response->assertRedirect(route('materials.stock-out.index'));
        $response->assertSessionHas('success');

        $material->refresh();
        $this->assertEquals(20, $material->quantity);

        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'material_number' => 'MAT202',
            'activity'        => 'Keluar',
            'quantity_before' => 30,
            'quantity_after'  => 20,
            'quantity_change' => -10,
            'recipient'       => 'Seksi Pemeliharaan',
            'description'     => 'Untuk cover laporan',
        ]);
    }

    public function test_stock_out_store_fails_if_quantity_exceeds_stock(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT203',
            'name'            => 'Stapler Besar',
            'entry_date'      => '2026-10-01',
            'quantity'        => 3,
            'unit'            => 'Pcs',
        ]);

        $response = $this->actingAs($user)->post(route('materials.stock-out.store'), [
            'material_id' => $material->id,
            'quantity'    => 5,
            'exit_date'   => '2026-10-09',
            'recipient'   => 'Gudang',
        ]);

        $response->assertSessionHasErrors(['quantity']);

        $material->refresh();
        $this->assertEquals(3, $material->quantity);
    }

    public function test_stock_out_update_recalculates_stock_correctly(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT204',
            'name'            => 'Lakban Hitam',
            'entry_date'      => '2026-10-01',
            'quantity'        => 20, // setelah keluar 10, stok awal 30
            'unit'            => 'Roll',
        ]);

        $movement = StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => $user->id,
            'activity'        => 'Keluar',
            'quantity_before' => 30,
            'quantity_after'  => 20,
            'quantity_change' => -10,
            'recipient'       => 'Unit Boiler',
            'description'     => 'Packing alat',
            'created_at'      => now(),
        ]);

        // Ubah dari keluar 10 menjadi keluar 15 (tersedia 20 + 10 = 30; sisa baru = 30 - 15 = 15)
        $response = $this->actingAs($user)->put(route('materials.stock-out.update', $movement->id), [
            'quantity'    => 15,
            'exit_date'   => '2026-10-09',
            'recipient'   => 'Unit Boiler & Turbin',
            'description' => 'Packing alat tambahan',
        ]);

        $response->assertRedirect(route('materials.stock-out.index'));
        $response->assertSessionHas('success');

        $material->refresh();
        $this->assertEquals(15, $material->quantity);

        $movement->refresh();
        $this->assertEquals(-15, $movement->quantity_change);
        $this->assertEquals(30, $movement->quantity_before);
        $this->assertEquals(15, $movement->quantity_after);
        $this->assertEquals('Unit Boiler & Turbin', $movement->recipient);
    }

    public function test_stock_out_update_fails_if_new_quantity_exceeds_available_stock(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT205',
            'name'            => 'Penghapus Papan Tulis',
            'entry_date'      => '2026-10-01',
            'quantity'        => 5,
            'unit'            => 'Pcs',
        ]);

        $movement = StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => $user->id,
            'activity'        => 'Keluar',
            'quantity_before' => 7,
            'quantity_after'  => 5,
            'quantity_change' => -2, // stok total tersedia adalah 5 + 2 = 7
            'recipient'       => 'Rapat',
            'created_at'      => now(),
        ]);

        // Coba minta keluar 10 padahal maksimal tersedia hanya 7
        $response = $this->actingAs($user)->put(route('materials.stock-out.update', $movement->id), [
            'quantity'    => 10,
            'exit_date'   => '2026-10-09',
            'recipient'   => 'Rapat',
        ]);

        $response->assertSessionHasErrors(['quantity']);

        $material->refresh();
        $this->assertEquals(5, $material->quantity);
    }

    public function test_stock_out_destroy_restores_material_stock(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT206',
            'name'            => 'Amplop Coklat Folio',
            'entry_date'      => '2026-10-01',
            'quantity'        => 25,
            'unit'            => 'Lembar',
        ]);

        $movement = StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => $user->id,
            'activity'        => 'Keluar',
            'quantity_before' => 35,
            'quantity_after'  => 25,
            'quantity_change' => -10,
            'recipient'       => 'Bagian Umum',
            'created_at'      => now(),
        ]);

        $response = $this->actingAs($user)->delete(route('materials.stock-out.destroy', $movement->id));

        $response->assertRedirect(route('materials.stock-out.index'));
        $response->assertSessionHas('success');

        // Pastikan stok dikembalikan (25 + 10 = 35)
        $material->refresh();
        $this->assertEquals(35, $material->quantity);

        // Pastikan record pergerakan stok dihapus
        $this->assertDatabaseMissing('stock_movements', [
            'id' => $movement->id,
        ]);
    }

    public function test_stock_out_export_excel(): void
    {
        $user = $this->createUser('Admin');

        $response = $this->actingAs($user)->get(route('materials.stock-out.export'));

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains(
                (string) $response->headers->get('content-disposition'),
                'laporan-stok-keluar-atk.xlsx'
            )
        );
    }
}
