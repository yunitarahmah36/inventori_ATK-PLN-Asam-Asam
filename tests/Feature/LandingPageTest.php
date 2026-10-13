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

    public function test_public_user_can_record_multiple_materials_stock_taking(): void
    {
        $this->createTestUser();

        $mat1 = Material::create([
            'material_number' => 'MAT-MULTI-001',
            'name'            => 'Kertas HVS A4 80gr',
            'quantity'        => 20,
            'unit'            => 'Rim',
            'description'     => 'Kertas cetak',
        ]);

        $mat2 = Material::create([
            'material_number' => 'MAT-MULTI-002',
            'name'            => 'Spidol Whiteboard Snowman',
            'quantity'        => 50,
            'unit'            => 'Pcs',
            'description'     => 'Spidol hitam',
        ]);

        $payload = [
            'nama_pengambil' => 'Rina Wijaya',
            'divisi'         => 'Administrasi & Keuangan',
            'items'          => [
                [
                    'material_id' => $mat1->id,
                    'quantity'    => 5,
                ],
                [
                    'material_id' => $mat2->id,
                    'quantity'    => 10,
                ],
            ],
            'description'    => 'Kebutuhan rapat koordinasi',
        ];

        $response = $this->post('/pengambilan-barang', $payload);

        $response->assertRedirect(route('landing') . '#form-pengambilan');
        $response->assertSessionHas('success_pengambilan');
        $response->assertSessionHas('receipt_data');

        // Verifikasi stok kedua barang berkurang
        $mat1->refresh();
        $this->assertEquals(15, $mat1->quantity);

        $mat2->refresh();
        $this->assertEquals(40, $mat2->quantity);

        // Verifikasi stock movements tercatat untuk kedua barang
        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $mat1->id,
            'activity'        => 'Keluar',
            'quantity_before' => 20,
            'quantity_after'  => 15,
            'quantity_change' => -5,
            'recipient'       => 'Rina Wijaya (Administrasi & Keuangan)',
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'material_id'     => $mat2->id,
            'activity'        => 'Keluar',
            'quantity_before' => 50,
            'quantity_after'  => 40,
            'quantity_change' => -10,
            'recipient'       => 'Rina Wijaya (Administrasi & Keuangan)',
        ]);
    }

    public function test_only_receipt_is_shown_and_form_is_hidden_when_success_session_exists(): void
    {
        $response = $this->withSession([
            'success_pengambilan' => 'Pengambilan berhasil disimpan!',
            'receipt_data' => [
                'date'            => '13 Oktober 2026, 18:00 WITA',
                'recipient'       => 'Ahmad Fauzi (Operasi)',
                'material_name'   => 'Kabel NYM',
                'material_number' => 'MAT-001',
                'qty_out'         => 2,
                'unit'            => 'Roll',
                'remaining_stock' => 8,
            ],
        ])->get('/');

        $response->assertStatus(200);
        $response->assertSee('BUKTI RESI PENGAMBILAN BARANG');
        $response->assertSee('Catat Pengambilan Baru');
        $response->assertSee('id="formSection" style="display: none;"', false);

        // Dan ketika membuka parameter ?baru=1, resi hilang dan formSection ditampilkan
        $responseBaru = $this->get('/?baru=1');
        $responseBaru->assertDontSee('BUKTI RESI PENGAMBILAN BARANG');
        $responseBaru->assertSee('id="formSection" style=""', false);
    }

    public function test_dashboard_still_requires_authentication(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}
