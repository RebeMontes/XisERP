<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@erp.com',
            'password' => 'admin123456',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'is_active',
                    ],
                ],
            ]);

        $this->assertEquals('admin', $response->json('data.user.role'));
        $this->assertNotEmpty($response->json('data.access_token'));
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@erp.com',
            'password' => 'wrongpassword123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Credenciales inválidas. Verifique su correo o contraseña.',
            ]);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $inactiveUser = User::updateOrCreate(
            ['email' => 'inactivo@erp.com'],
            [
                'name' => 'Usuario Inactivo',
                'password' => Hash::make('password123'),
                'role' => 'technician',
                'is_active' => false,
            ]
        );

        $response = $this->postJson('/api/auth/login', [
            'email' => 'inactivo@erp.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Su cuenta se encuentra inactiva o suspendida. Comuníquese con el administrador del sistema.',
            ]);
    }

    public function test_authenticated_user_can_get_profile(): void
    {
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'admin@erp.com',
            'password' => 'admin123456',
        ]);

        $token = $loginResponse->json('data.access_token');

        $profileResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/auth/me');

        $profileResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'email' => 'admin@erp.com',
                        'role' => 'admin',
                    ],
                ],
            ]);
    }

    public function test_unauthenticated_request_to_protected_route_fails(): void
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401);
    }

    public function test_user_can_refresh_token(): void
    {
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'admin@erp.com',
            'password' => 'admin123456',
        ]);

        $token = $loginResponse->json('data.access_token');

        $refreshResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/refresh');

        $refreshResponse->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                ],
            ]);
    }

    public function test_user_can_logout(): void
    {
        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'admin@erp.com',
            'password' => 'admin123456',
        ]);

        $token = $loginResponse->json('data.access_token');

        $logoutResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Sesión cerrada exitosamente.',
            ]);
    }
}
