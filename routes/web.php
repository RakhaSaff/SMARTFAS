<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Halaman Utama (Hero)
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Route untuk tombol "LAPORKAN KERUSAKAN" (fix error route laporan.create)
Route::get('/laporan/create', fn() => view('laporan.create'))
    ->name('laporan.create');

// Halaman Login & Register (GET)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Proses autentikasi (POST)
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard setelah login (bisa diubah nanti)
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');



Route::get('/register', function () {
    return view('auth.register');
})->name('register');
