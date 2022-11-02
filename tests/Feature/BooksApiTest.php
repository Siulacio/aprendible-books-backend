<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_all_books(): void
    {
        $book = Book::factory(4)->create();

        $response = $this->getJson(route('books.index'));

        $response
            ->assertJsonFragment(['title' => $book[0]->title])
            ->assertJsonFragment(['title' => $book[1]->title])
            ->assertJsonFragment(['title' => $book[2]->title])
            ->assertJsonFragment(['title' => $book[3]->title]);
    }

    /** @test */
    public function it_can_get_one_book(): void
    {
        $book = Book::factory()->create();

        $this
            ->getJson(route('books.show', $book))
            ->assertJsonFragment(['title' => $book->title]);
    }

    /** @test */
    public function it_can_create_a_book(): void
    {
        $this
            ->postJson(route('books.store'), [])
            ->assertJsonValidationErrorFor('title');

        $this
            ->postJson(route('books.store'), [
                'title' => 'My new book',
            ])
            ->assertJsonFragment([
                'title' => 'My new book',
            ]);

        $this->assertDatabaseHas('books', [
           'title' => 'My new book'
        ]);
    }

    /** @test */
    public function it_can_update_a_book(): void
    {
        $book = Book::factory()->create();

        $this
            ->patchJson(route('books.update', $book), [])
            ->assertJsonValidationErrorFor('title');

        $this
            ->patchJson(route('books.update', $book), [
               'title' => 'Edited book',
            ])
            ->assertJsonFragment([
                'title' => 'Edited book',
            ]);

        $this->assertDatabaseHas('books', [
           'title' => 'Edited book',
        ]);
    }

    /** @test  */
    public function it_can_delete_a_book(): void
    {
        $book = Book::factory()->create();

        $this
            ->deleteJson(route('books.destroy', $book))
            ->assertNoContent();

        $this->assertDatabaseCount('books', 0);
    }
}
