<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('pages.home');
});

Route::view('/kontak', 'pages.kontak')->name('kontak');
Route::view('/tentang', 'pages.tentang')->name('tentang');
Route::view('/cara-kerja', 'pages.cara-kerja')->name('cara-kerja');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});
