<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/books', 'BooksController@store')->name('books.store');
Route::put('/books/{book}-{slut}', 'BooksController@update')->name('books.update');
Route::delete('/books/{book}-{slut}', 'BooksController@destroy')->name('books.delete');

