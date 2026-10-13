<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LowStockAlertTest extends TestCase
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

    /**
     * Ketentuan 1: Semua material yang sudah terdaftar menggunakan batas minimum stok default 15 unit
     * tanpa perlu mengatur satu per satu.
     */
    public function test_all_materials_have_default_min_stock_of_15_units(): void
    {
        $admin = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4',
            'unit'            => 'Rim',
            'quantity'        => 50,
            'created_by'      => $admin->id,
        ]);

        $this->assertEquals(15, $material->min_stock);
        $this->assertEquals(15, $material->effective_min_stock);
        $this->assertDatabaseHas('materials', [
            'id'        => $material->id,
            'min_stock' => 15,
        ]);
    }

    /**
     * Ketentuan 2: Jika stok material <= 15 unit, tampilkan status Stok Menipis.
     * Jika stok > 15 unit, tampilkan status Stok Aman.
     */
    public function test_displays_stok_menipis_when_quantity_less_than_or_equal_to_limit_and_stok_aman_when_greater(): void
    {
        $admin = $this->createUser('Admin');

        // Material stok menipis (quantity <= 15)
        $lowMat = Material::create([
            'material_number' => 'MAT-LOW',
            'name'            => 'Tinta Printer Hitam',
            'unit'            => 'Botol',
            'quantity'        => 15, // tepat 15 unit
            'created_by'      => $admin->id,
        ]);

        // Material stok aman (quantity > 15)
        $safeMat = Material::create([
            'material_number' => 'MAT-SAFE',
            'name'            => 'Map Folder Folio',
            'unit'            => 'Pack',
            'quantity'        => 16, // > 15 unit
            'created_by'      => $admin->id,
        ]);

        $this->assertTrue($lowMat->isLowStock());
        $this->assertEquals('Stok Menipis', $lowMat->stock_status);

        $this->assertFalse($safeMat->isLowStock());
        $this->assertEquals('Stok Aman', $safeMat->stock_status);

        // Akses halaman data material
        $response = $this->actingAs($admin)->get('/materials');
        $response->assertStatus(200);
        $response->assertSee('Stok Menipis');
        $response->assertSee('Stok Aman');
        $response->assertSee('15 Botol');
        $response->assertSee('15 Pack');
    }

    /**
     * Ketentuan 3 & 4: Tambahkan fitur Atur Batas Stok agar admin dapat mengubah batas minimum
     * setiap material secara individual sesuai kebutuhan dan disimpan di database.
     */
    public function test_admin_can_update_min_stock_individually_and_persists_in_database(): void
    {
        $admin = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT-CUSTOM',
            'name'            => 'Kabel LAN Cat6',
            'unit'            => 'Roll',
            'quantity'        => 25,
            'created_by'      => $admin->id,
        ]);

        // Awalnya quantity 25 > 15 (Aman)
        $this->assertFalse($material->isLowStock());

        // Ubah batas minimum menjadi 30 unit melalui endpoint updateMinStock
        $response = $this->actingAs($admin)->put("/materials/{$material->id}/min-stock", [
            'min_stock' => 30,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('materials', [
            'id'        => $material->id,
            'min_stock' => 30,
        ]);

        // Muat ulang dari database
        $material->refresh();
        $this->assertEquals(30, $material->min_stock);

        // Sekarang quantity 25 <= 30 (Menipis)
        $this->assertTrue($material->isLowStock());
        $this->assertEquals('Stok Menipis', $material->stock_status);
    }

    /**
     * Ketentuan 5: Material yang batasnya sudah diubah harus mengikuti nilai terbaru, bukan kembali ke 15 unit.
     */
    public function test_material_with_custom_limit_retains_newest_value_after_page_reload(): void
    {
        $admin = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT-PERSIST',
            'name'            => 'Buku Ekspedisi Besar',
            'unit'            => 'Buku',
            'quantity'        => 8,
            'min_stock'       => 5, // diubah menjadi 5 unit
            'created_by'      => $admin->id,
        ]);

        // Kuantitas 8 > batas khusus 5 => Stok Aman (bukan menipis)
        $this->assertEquals(5, $material->effective_min_stock);
        $this->assertFalse($material->isLowStock());
        $this->assertEquals('Stok Aman', $material->stock_status);

        // Akses halaman data material, pastikan nilai 5 Buku tetap tampil
        $response = $this->actingAs($admin)->get('/materials');
        $response->assertStatus(200);
        $response->assertSee('5 Buku');
        $response->assertDontSee('15 Buku');
    }

    /**
     * Ketentuan 6: Jangan mengubah form tambah material yang sudah ada, struktur input Nomor Material,
     * Nama Material, dan Satuan.
     */
    public function test_create_material_form_structure_remains_unchanged_and_defaults_to_15(): void
    {
        $admin = $this->createUser('Admin');

        // Form create tetap hanya memiliki input No Material, Nama Material, Satuan
        $response = $this->actingAs($admin)->get('/materials/create');
        $response->assertStatus(200);
        $response->assertSee('No. Material');
        $response->assertSee('Nama Material');
        $response->assertSee('Satuan');

        // Pendaftaran material baru tanpa min_stock otomatis mendapatkan 15 unit
        $postResponse = $this->actingAs($admin)->post('/materials', [
            'material_number' => 'MAT-NEW',
            'name'            => 'Penghapus Papan Tulis',
            'unit'            => 'Pcs',
        ]);

        $postResponse->assertRedirect('/materials');
        $this->assertDatabaseHas('materials', [
            'material_number' => 'MAT-NEW',
            'min_stock'       => 15,
        ]);
    }

    /**
     * Ketentuan 7: Pastikan material dengan stok menipis tetap muncul pada peringatan dashboard
     * dan dapat diprioritaskan dalam daftar material berdasarkan kondisi stoknya.
     */
    public function test_low_stock_materials_appear_on_dashboard_alert_and_can_be_prioritized(): void
    {
        $admin = $this->createUser('Admin');

        // Material A: Stok 18, batas 20 (Menipis karena <= batas kustom 20)
        $matA = Material::create([
            'material_number' => 'MAT-A',
            'name'            => 'Baterai AA',
            'unit'            => 'Pack',
            'quantity'        => 18,
            'min_stock'       => 20,
            'entry_date'      => now(),
            'created_by'      => $admin->id,
        ]);

        // Material B: Stok 50, batas 15 (Aman)
        $matB = Material::create([
            'material_number' => 'MAT-B',
            'name'            => 'Gunting Kertas',
            'unit'            => 'Pcs',
            'quantity'        => 50,
            'min_stock'       => 15,
            'entry_date'      => now(),
            'created_by'      => $admin->id,
        ]);

        // Cek Dashboard: Harus muncul peringatan stok menipis untuk 1 material (MAT-A)
        $dashResponse = $this->actingAs($admin)->get('/dashboard');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Peringatan: Terdapat 1 Jenis Material dengan Stok Menipis!');
        $dashResponse->assertSee('MAT-A');

        // Cek Data Material dengan filter prioritas sort=low_stock:
        // MAT-A yang menipis harus berada di paling atas
        $sortResponse = $this->actingAs($admin)->get('/materials?sort=low_stock');
        $sortResponse->assertStatus(200);
        $sortedItems = $sortResponse->viewData('materials');
        $this->assertEquals($matA->id, $sortedItems->first()->id);
    }
}
