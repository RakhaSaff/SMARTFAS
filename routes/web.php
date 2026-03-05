<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Halaman Utama (Hero)
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Route untuk tombol "LAPORKAN KERUSAKAN" (fix error route laporan.create)
Route::get('/laporan/create', fn() => view('laporan.create'))
    ->name('laporan.create');

// Route sementara login & register (fix error route login)
Route::get('/login', fn() => view('auth.login'))->name('login');   // nanti ganti dengan Breeze
Route::get('/register', fn() => view('auth.register'))->name('register');

// Dashboard setelah login (bisa diubah nanti)
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');