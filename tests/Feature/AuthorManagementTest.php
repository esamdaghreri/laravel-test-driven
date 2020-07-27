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

        $this->post('/authors', $this->data());

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->date_of_birth);
        $this->assertEquals('1995/04/22', $author->first()->date_of_birth->format('Y/m/d'));
    }

    /** @test */
    public function a_name_is_required(){
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_date_of_birth_is_required(){
        $response = $this->post('/authors', array_merge($this->data(), ['date_of_birth' => '']));
        $response->assertSessionHasErrors('date_of_birth');
    }

    private function data(){
        return [
            'name' => 'Esam Daghreri',
            'date_of_birth' => '04/22/1995'
        ];
    }

   }
