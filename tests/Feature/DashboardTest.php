<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role): User
    {
        return User::create([
            'name'     => $role,
            'username' => strtolower($role),
            'email'    => strtolower($role) . '@pln.com',
            'password' => Hash::make(strtolower($role) . '123'),
            'role'     => $role,
        ]);
    }

    public function test_dashboard_requires_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard(): void
    {
        $admin    = $this->createUser('Admin');
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang Kembali, Admin');
        $response->assertSee('Admin'); // role badge
        $response->assertSee('Total Material');
        $response->assertSee('Total Stok');
        $response->assertSee('Material Masuk');
        $response->assertSee('Aktivitas Hari Ini');
    }

    public function test_umum_sees_same_dashboard_as_admin(): void
    {
        $umum     = $this->createUser('Umum');
        $response = $this->actingAs($umum)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang Kembali, Umum');
        $response->assertSee('Umum');
        $response->assertSee('Total Material');
        $response->assertSee('Total Stok');
        $response->assertSee('Material Masuk');
        $response->assertSee('Aktivitas Hari Ini');
    }

    public function test_keuangan_sees_same_dashboard_as_admin(): void
    {
        $keuangan = $this->createUser('Keuangan');
        $response = $this->actingAs($keuangan)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang Kembali, Keuangan');
        $response->assertSee('Keuangan');
        $response->assertSee('Total Material');
        $response->assertSee('Total Stok');
        $response->assertSee('Material Masuk');
        $response->assertSee('Aktivitas Hari Ini');
    }

    public function test_dashboard_shows_real_material_data(): void
    {
        $admin = $this->createUser('Admin');
        Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS A4 Test',
            'entry_date'      => now(),
            'quantity'        => 50,
            'unit'            => 'Rim',
            'created_by'      => $admin->id,
        ]);
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('MAT001');
        $response->assertSee('Kertas HVS A4 Test');
        $response->assertSee('50');
    }

    public function test_dashboard_shows_activity_with_correct_user_name(): void
    {
        $umum = $this->createUser('Umum');
        $mat  = Material::create([
            'material_number' => 'MAT002',
            'name'            => 'Pulpen Test',
            'entry_date'      => now(),
            'quantity'        => 10,
            'unit'            => 'Pcs',
            'created_by'      => $umum->id,
        ]);
        StockMovement::create([
            'material_id'     => $mat->id,
            'user_id'         => $umum->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => 10,
            'quantity_change' => 10,
        ]);

        $response = $this->actingAs($umum)->get('/dashboard');
        $response->assertStatus(200);
        // Nama user harus muncul dari relasi, bukan hardcode
        $response->assertSee('Umum');
        $response->assertSee('Tambah');
    }
}
