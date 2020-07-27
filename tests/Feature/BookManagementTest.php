<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;
use App\Author;

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

        $response = $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());

    }

    /** @test */
    public function an_author_is_required(){

        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));       

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_updated(){
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->put($book->path() , [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted(){

        // $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added(){
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());


        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data(){
        return [
            'title' => 'This is an amazing book',
            'author_id' => 'Esam Daghreri'
        ];
    }
}