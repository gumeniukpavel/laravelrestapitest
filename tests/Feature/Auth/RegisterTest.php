<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistersSuccessfully()
    {
        $payload = [
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => 'test123',
            'password_confirmation' => 'test123',
        ];

        $this->json('post', '/auth/register', $payload)
            ->assertStatus(201)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
                'message'
            ]);
    }

    public function testRequiresPasswordEmailAndName()
    {
        $this->json('post', '/auth/register')
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => 'test123',
        ];

        $this->json('post', '/auth/register', $payload)
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }
}
