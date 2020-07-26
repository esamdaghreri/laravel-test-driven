<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;

class AuthorsController extends Controller
{
    public function store(){
        $author = Author::create($this->validateRequest());
        return redirect('/');
    }

    protected function validateRequest(){
        return request()->validate([
            'name' => 'required|string|min:2',
            'date_of_birth' => 'required|date'
        ]);
    }
}