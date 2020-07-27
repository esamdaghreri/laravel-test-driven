<?php

namespace Tests\Unit;

use App\User;
use App\Book;
use App\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out(){
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkout($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function a_book_can_be_checked_in(){

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        
        $book->checkout($user);

        $book->checkin($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertNotNull(Reservation::first()->checked_in_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }

    /** @test */
    public function a_book_can_be_checked_out_a_book_twice(){

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        
        $book->checkout($user);
        $book->checkin($user);
        $book->checkout($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::findOrFail(2)->user_id);
        $this->assertEquals($book->id, Reservation::findOrFail(2)->book_id);
        $this->assertNull(Reservation::findOrFail(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::findOrFail(2)->checked_out_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::findOrFail(2)->user_id);
        $this->assertEquals($book->id, Reservation::findOrFail(2)->book_id);
        $this->assertNotNull(Reservation::findOrFail(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::findOrFail(2)->checked_in_at);
    }

    /** @test */
    public function if_not_checked_out_exception_is_thrown(){

        $this->expectException(\Exception::class);
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        
        $book->checkin($user);
    }
}
