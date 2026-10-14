<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('SISTEM PERSEDIAAN ATK');
        $response->assertSee('Catat Pengambilan');
    }

    public function test_logout_redirects_to_landing_page(): void
    {
        $user = \App\Models\User::create([
            'name'     => 'Petugas',
            'username' => 'petugas',
            'email'    => 'petugas@pln.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role'     => 'Admin',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('landing'));
        $this->assertGuest();
    }
}
