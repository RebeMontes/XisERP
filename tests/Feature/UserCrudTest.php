<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::firstOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'Administrador XIS',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'admin@erp.com',
            'password' => 'admin123456',
        ]);

        $this->token = $loginResponse->json('data.access_token');
    }

    public function test_can_list_users(): void
    {
        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'meta' => ['total', 'current_page', 'per_page'],
            ]);
    }

    public function test_can_create_user(): void
    {
        $email = 'nuevo_' . time() . '@erp.com';

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->postJson('/api/users', [
                'name' => 'Carlos Técnico',
                'email' => $email,
                'password' => 'clave123',
                'role' => 'technician',
                'is_active' => true,
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Carlos Técnico',
                    'email' => $email,
                    'role' => 'technician',
                    'is_active' => true,
                ],
            ]);
    }

    public function test_can_update_user(): void
    {
        $user = User::create([
            'name' => 'Usuario Temporal',
            'email' => 'temp_' . time() . '@erp.com',
            'password' => Hash::make('clave123'),
            'role' => 'technician',
            'is_active' => true,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->putJson("/api/users/{$user->id}", [
                'name' => 'Usuario Modificado',
                'email' => $user->email,
                'role' => 'admin',
                'is_active' => false,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'name' => 'Usuario Modificado',
                    'role' => 'admin',
                    'is_active' => false,
                ],
            ]);
    }

    public function test_can_toggle_user_status(): void
    {
        $user = User::create([
            'name' => 'Usuario Toggle',
            'email' => 'toggle_' . time() . '@erp.com',
            'password' => Hash::make('clave123'),
            'role' => 'technician',
            'is_active' => true,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->patchJson("/api/users/{$user->id}/toggle-status");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'is_active' => false,
                ],
            ]);
    }

    public function test_cannot_toggle_own_status(): void
    {
        $currentUser = auth('api')->setToken($this->token)->user();

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->patchJson("/api/users/{$currentUser->id}/toggle-status");

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'No puede desactivar su propia cuenta de usuario mientras tiene la sesión activa.',
            ]);
    }

    public function test_users_are_ordered_alphabetically_by_default(): void
    {
        User::create([
            'name' => 'Zara López',
            'email' => 'zara_' . time() . '@erp.com',
            'password' => Hash::make('clave123'),
            'role' => 'technician',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Ana Morales',
            'email' => 'ana_' . time() . '@erp.com',
            'password' => Hash::make('clave123'),
            'role' => 'technician',
            'is_active' => true,
        ]);

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->getJson('/api/users');

        $response->assertStatus(200);
        $names = collect($response->json('data'))->pluck('name')->values()->all();
        $sortedNames = $names;
        sort($sortedNames, SORT_NATURAL | SORT_FLAG_CASE);
        $this->assertEquals($sortedNames, $names);
    }
}
