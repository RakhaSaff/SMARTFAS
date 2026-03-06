<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Halaman Utama (Hero)
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Auth Routes (Login & Register)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route Laporan (sementara tanpa controller)
Route::get('/laporan/create', fn() => view('laporan.create'))->name('laporan.create');

// Dashboard setelah login (protected)
Route::get('/dashboard', fn() => view('dashboard.index'))->middleware('auth')->name('dashboard');