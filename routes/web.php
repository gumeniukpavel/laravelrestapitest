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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LoginController@logout');
});

Route::prefix('api')->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/books/list', 'API\BookController@index');
        Route::get('/book/{bookId}', 'API\BookController@show');
        Route::post('/book/add', 'API\BookController@store');
    });
});
