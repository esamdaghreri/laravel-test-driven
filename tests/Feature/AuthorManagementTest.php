<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created(){
        $this->withoutExceptionHandling();

        $this->post('/author', [
            'name' => 'Esam Daghreri',
            'date_of_birth' => '04/22/1995'
        ]);

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->date_of_birth);
        $this->assertEquals('1995/04/22', $author->first()->date_of_birth->format('Y/m/d'));
    }
}
