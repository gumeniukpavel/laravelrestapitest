<?php

namespace Tests\Feature\API;

use App\Book;
use App\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function testBookAreCreatedCorrectly()
    {
        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'name' => 'First Book',
            'category_id' => 1
        ];

        $this->json('POST', 'api/book/add', $payload)
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

    public function testBookAreCreatedFailedDontCreatedCategory()
    {
        $payload = [
            'name' => 'First Book',
            'category_id' => 1
        ];

        $this->json('POST', 'api/book/add', $payload)
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

    public function testBookAreCreatedFailedNotValidatedName()
    {
        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'name' => true,
            'category_id' => 1
        ];

        $this->json('POST', 'api/book/add', $payload)
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

    public function testBookAreCreatedFailedNotValidatedCategoryId()
    {
        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'name' => 'First Book',
            'category_id' => 'test'
        ];

        $this->json('POST', 'api/book/add', $payload)
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

    public function testBookAreCreatedFailedMissingCategoryId()
    {
        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'name' => 'First Book',
        ];

        $this->json('POST', 'api/book/add', $payload)
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

    public function testBookAreCreatedFailedMissingName()
    {
        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        $payload = [
            'category_id' => 1,
        ];

        $this->json('POST', 'api/book/add', $payload)
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

    public function testBooksAreListedCorrectly()
    {
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

        $response = $this->json('GET', 'api/books/list', [])
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

    public function testBookAreShowedCorrectly()
    {
        factory(Category::class)->create([
            'name' => 'First Category',
        ]);

        factory(Book::class)->create([
            'name' => 'First Book',
            'category_id' => 1
        ]);

        $response = $this->json('GET', 'api/book/1', [])
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

    public function testBookAreShowedFailedNotFound()
    {
        $response = $this->json('GET', 'api/book/1', [])
            ->assertStatus(404)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }
}
