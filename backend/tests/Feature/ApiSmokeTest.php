<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_endpoint_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/home');
        $response->assertOk()->assertJsonStructure([
            'categories', 'flash_deals', 'recommended', 'trending', 'more_to_love',
        ]);
    }

    public function test_register_login_and_me(): void
    {
        $register = $this->postJson('/api/v1/auth/register', [
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => 'password123',
        ])->assertCreated()->json();

        $this->assertArrayHasKey('token', $register);

        $login = $this->postJson('/api/v1/auth/login', [
            'email'    => 'test@example.com',
            'password' => 'password123',
        ])->assertOk()->json();

        $token = $login['token'];

        $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('email', 'test@example.com');
    }
}
