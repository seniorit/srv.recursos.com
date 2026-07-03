<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_user_can_register_login_and_access_profile(): void
    {
        $registerPayload = [
            'username' => 'usuario1',
            'nombre' => 'Usuario Uno',
            'email' => 'usuario1@test.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'rol' => 'Empleado',
        ];

        $registerResponse = $this->postJson('/api/auth/register', $registerPayload);
        $registerResponse->assertStatus(201)
            ->assertJsonPath('data.user.username', 'usuario1')
            ->assertJsonPath('data.user.email', 'usuario1@test.com')
            ->assertJsonStructure([
                'data' => [
                    'user' => ['id', 'username', 'email', 'rol', 'activo'],
                    'token',
                ],
            ]);

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'usuario1@test.com',
            'password' => 'secret123',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonPath('data.user.email', 'usuario1@test.com')
            ->assertJsonStructure([
                'data' => [
                    'user' => ['id', 'username', 'email', 'rol', 'activo'],
                    'token',
                ],
            ]);

        $token = $loginResponse->json('data.token');

        $meResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/me');

        $meResponse->assertStatus(200)
            ->assertJsonPath('data.email', 'usuario1@test.com');

        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('usuarios', ['email' => 'usuario1@test.com']);
    }
}
