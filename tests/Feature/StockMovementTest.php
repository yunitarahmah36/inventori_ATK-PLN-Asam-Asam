<?php

namespace Tests\Feature;

use App\Models\Material;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StockMovementTest extends TestCase
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

    public function test_stock_movement_export_pdf_requires_authentication(): void
    {
        $response = $this->get(route('stock-movements.export-pdf'));
        $response->assertRedirect('/login');
    }

    public function test_stock_movement_export_pdf_downloads_with_standardized_filename(): void
    {
        $user = $this->createUser('Admin');

        $material = Material::create([
            'material_number' => 'MAT001',
            'name'            => 'Kertas HVS',
            'quantity'        => 10,
            'unit'            => 'Rim',
        ]);

        StockMovement::create([
            'material_id'     => $material->id,
            'material_name'   => $material->name,
            'material_number' => $material->material_number,
            'user_id'         => $user->id,
            'activity'        => 'Tambah',
            'quantity_before' => 0,
            'quantity_after'  => 10,
            'quantity_change' => 10,
            'description'     => 'Stok Awal',
        ]);

        $response = $this->actingAs($user)->get(route('stock-movements.export-pdf'));

        $response->assertStatus(200);
        $this->assertMatchesRegularExpression(
            '/Riwayat_Stok_PLN_\d{8}_\d{6}\.pdf/',
            (string) $response->headers->get('content-disposition')
        );
    }
}
