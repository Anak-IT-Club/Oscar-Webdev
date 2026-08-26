<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/kontak', 'kontak')->name('kontak');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/cara-kerja', 'cara-kerja')->name('cara-kerja');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});
