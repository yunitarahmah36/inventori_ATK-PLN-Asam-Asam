<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name'     => 'Admin User',
            'username' => 'admin_' . uniqid(),
            'email'    => 'admin_' . uniqid() . '@pln.co.id',
            'password' => Hash::make('password123'),
            'role'     => 'Admin',
        ], $attributes));
    }

    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get(route('profile.show'));
        $response->assertRedirect(route('login'));
    }

    public function test_profile_page_can_be_viewed_by_authenticated_user_without_activity_tab(): void
    {
        $user = $this->createUser([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response = $this->actingAs($user)->get(route('profile.show'));

        $response->assertStatus(200);
        $response->assertSee('Profil Pengguna');
        $response->assertSee('Informasi Akun');
        $response->assertSee('Keamanan & Sandi', false);
        // Pastikan fitur Aktivitas Terakhir tidak ada
        $response->assertDontSee('tab-activity-btn');
        $response->assertDontSee('pane-activity');
        $response->assertDontSee('Aktivitas Mutasi Stok Terakhir');
    }

    public function test_user_can_update_profile_name(): void
    {
        $user = $this->createUser([
            'name' => 'Original Name',
        ]);

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Updated Name',
        ]);

        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_user_can_update_password_with_valid_current_password(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('old-password-123'),
        ]);

        $response = $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'old-password-123',
            'new_password' => 'new-secure-password-456',
            'new_password_confirmation' => 'new-secure-password-456',
        ]);

        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('new-secure-password-456', $user->password));
    }

    public function test_user_cannot_update_password_with_wrong_current_password(): void
    {
        $user = $this->createUser([
            'password' => Hash::make('correct-password-123'),
        ]);

        $response = $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'wrong-password-999',
            'new_password' => 'new-secure-password-456',
            'new_password_confirmation' => 'new-secure-password-456',
        ]);

        $response->assertSessionHasErrors('current_password');
        $user->refresh();
        $this->assertTrue(Hash::check('correct-password-123', $user->password));
    }
}
