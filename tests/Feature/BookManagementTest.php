<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_added_to_the_library()
    {
        // Show errors in detail
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'This is an amazing book',
            'author' => 'Esam Daghreri'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());

    }

    /** @test */
    public function a_title_and_author_are_required(){

        $response = $this->post('/books', [
            'title' => '',
            'author' => ''
        ]);       

        $response->assertSessionHasErrors(['title', 'author']);
    }

    /** @test */
    public function a_book_can_updated(){
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'This is amazing book',
            'author' => 'Esam Daghreri'
        ]);

        $book = Book::first();

        $response = $this->put($book->path() , [
            'title' => 'New title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted(){

        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'This is amazing book',
            'author' => 'Esam Daghreri'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}