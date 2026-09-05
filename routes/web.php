<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\HadiahController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PencairanController;
use App\Http\Controllers\ProfileController;

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
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/photo', [ProfileController::class, 'photo'])->name('profile.photo');
    Route::post('/profile/photo/delete', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');

    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('sampah', SampahController::class)->except(['show']);
    Route::resource('setoran', SetoranController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('hadiah', HadiahController::class)->except(['show']);

    Route::get('/redeem', [RedeemController::class, 'index'])->name('redeem.index');
    Route::post('/redeem', [RedeemController::class, 'store'])->name('redeem.store');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');

    Route::get('/scan', [ScannerController::class, 'index'])->name('scanner.index');
    Route::post('/scan/analyze', [ScannerController::class, 'analyze'])->name('scanner.analyze');
    Route::post('/scan/store', [ScannerController::class, 'store'])->name('scanner.store');

    // Bank Sampah Digital
    Route::get('/tabungan', [PencairanController::class, 'index'])->name('tabungan.index');
    Route::post('/tabungan', [PencairanController::class, 'store'])->name('tabungan.store');
    Route::get('/pencairan', [PencairanController::class, 'adminIndex'])->name('pencairan.index');
    Route::post('/pencairan/{pencairan}/approve', [PencairanController::class, 'approve'])->name('pencairan.approve');
    Route::post('/pencairan/{pencairan}/reject', [PencairanController::class, 'reject'])->name('pencairan.reject');
});
