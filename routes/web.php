<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);

    Route::resource('nasabah',
       NasabahController::class);
;
});
