<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/kontak', 'kontak')->name('kontak');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/cara-kerja', 'cara-kerja')->name('cara-kerja');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
});
