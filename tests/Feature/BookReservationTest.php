<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_added_to_the_library()
    {
        // Show errors in detail
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'This is an amazing book',
            'author' => 'Esam Daghreri'
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
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

        $response = $this->put('/books/'.$book->id , [
            'title' => 'New title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }
}