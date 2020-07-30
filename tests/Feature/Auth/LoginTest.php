<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', '/auth/login')
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'test@test.test',
            'password' => bcrypt('test123'),
        ]);

        $payload = ['email' => 'test@test.test', 'password' => 'test123'];

        $this->json('POST', '/auth/login', $payload)
            ->assertStatus(200)
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
}
