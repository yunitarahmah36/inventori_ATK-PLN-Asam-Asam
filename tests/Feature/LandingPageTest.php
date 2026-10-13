<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    private function createTestUser(): User
    {
        return User::create([
            'name'     => 'Petugas Gudang',
            'username' => 'petugas_' . uniqid(),
            'email'    => 'petugas_' . uniqid() . '@pln.com',
            'password' => Hash::make('password123'),
            'role'     => 'Admin',
        ]);
    }

    public function test_landing_page_can_be_accessed_without_login(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Catat Pengambilan Barang');
        $response->assertSee('PT PLN INDONESIA POWER UBP ASAM ASAM');
        $response->assertSee('Login Admin');
    }

    public function test_pengambilan_barang_form_redirects_to_landing_anchor(): void
    {
        $response = $this->get('/pengambilan-barang');

        $response->assertRedirect(route('landing') . '#form-pengambilan');
    }

    public function test_public_user_can_record_stock_taking_successfully(): void
    {
        // Seed default user for foreign key fallback
        $this->createTestUser();

        $material = Material::create([
            'material_number' => 'MAT-TEST-001',
            'name'            => 'Kabel NYM 3x2.5mm',
            'quantity'        => 50,
            'unit'            => 'Meter',
            'description'     => 'Kabel instalasi standar',
        ]);

        $payload = [
            'nama_pengambil' => 'Rudi Hartono',
            'divisi'         => 'Pemeliharaan Listrik',
            'material_id'    => $material->id,
            'quantity'       => 15,
            'description'    => 'Penggantian kabel panel gardu B',
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        $response->assertRedirect(route('landing') . '#form-pengambilan');
        $response->assertSessionHas('success_pengambilan');
        $response->assertSessionHas('receipt_data');

        // Verifikasi stok berkurang secara otomatis
        $material->refresh();
        $this->assertEquals(35, $material->quantity);

        // Verifikasi tersimpan di riwayat stock movements
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $material->id,
            'material_name'   => 'Kabel NYM 3x2.5mm',
            'activity'        => 'Keluar',
            'quantity_before' => 50,
            'quantity_after'  => 35,
            'quantity_change' => -15,
            'recipient'       => 'Rudi Hartono (Pemeliharaan Listrik)',
        ]);
    }

    public function test_public_user_cannot_take_more_than_available_stock(): void
    {
        $this->createTestUser();

        $material = Material::create([
            'material_number' => 'MAT-TEST-002',
            'name'            => 'Lampu LED Panel 18W',
            'quantity'        => 5,
            'unit'            => 'Pcs',
            'description'     => 'Lampu hemat energi',
        ]);

        $payload = [
            'nama_pengambil' => 'Budi Setiawan',
            'divisi'         => 'Operasi',
            'material_id'    => $material->id,
            'quantity'       => 10, // Melebihi stok (5)
            'description'    => 'Pemasangan gedung kontrol',
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        $response->assertSessionHasErrors('quantity');

        // Stok tidak berubah
        $material->refresh();
        $this->assertEquals(5, $material->quantity);

        // Tidak ada pergerakan stok dicatat
        $this->assertDatabaseMissing('stock_movements', [
            'material_id' => $material->id,
        ]);
    }

    public function test_dashboard_still_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
