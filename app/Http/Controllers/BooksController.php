<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BooksController extends Controller
{
    public function store(){
        Book::create($this->validateRequest());
    }

    public function update(Book $book){
        if($book->update($this->validateRequest())) {
            return redirect('/');
        }
    }

    protected function validateRequest(){
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
