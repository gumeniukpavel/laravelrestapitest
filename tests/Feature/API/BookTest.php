<?php

namespace Tests\Feature\API;

use App\Book;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testBookIsCreatedCorrectly()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'name' => 'First Book',
            'category_id' => 1
        ];

        $this->json('POST', 'api/book/add', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
    }

    public function testBookIsCreatedFailedDontCreatedCategory()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name' => 'First Book',
            'category_id' => 1
        ];

        $this->json('POST', 'api/book/add', $payload, $headers)
            ->assertStatus(500)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
    }

    public function testValidatedNameAndCategoryId()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'name' => true,
            'category_id' => 'test'
        ];

        $this->json('POST', 'api/book/add', $payload, $headers)
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
    }

    public function testRequiresNameAndCategoryId()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $this->json('POST', 'api/book/add', [], $headers)
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
    }

    public function testBookIsShowedCorrectly()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        factory(Book::class)->create([
            'name' => 'First Book',
            'category_id' => 1
        ]);

        $response = $this->json('GET', 'api/book/1', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
    }

    public function testBookIsShowedFailedNotFound()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', 'api/book/1', [], $headers)
            ->assertStatus(404)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }

    public function testBooksAreListedCorrectly()
    {
        $user = factory(User::class)->create(['email' => 'test@test.test']);

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        factory(Book::class)->create([
            'name' => 'First Book',
            'category_id' => 1
        ]);

        factory(Book::class)->create([
            'name' => 'Second Book',
            'category_id' => 1
        ]);

        $response = $this->json('GET', 'api/books/list', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'success',
                'data',
                'message'
            ]);
    }
}
