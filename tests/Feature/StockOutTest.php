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
}
