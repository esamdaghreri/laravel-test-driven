<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_name_is_required_to_create_an_author(){
        Author::firstOrCreate([
            'name' => 'Esam Daghreri'
        ]);

        $this->assertCount(1, Author::all());
    }
}
