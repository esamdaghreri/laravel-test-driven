<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name', 'date_of_birth'
    ];

    protected $dates = ['date_of_birth'];
}
