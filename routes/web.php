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

// Prefix admin + middleware khusus
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest (belum login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);

        Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);
    });

    // Authenticated (sudah login admin)
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Nanti tambah route lain: laporan, users, settings, dll
    });
});

// Route preview dashboard admin (hanya untuk development)
Route::get('/admin/preview-dashboard', function () {
    $stats = [
        'total_laporan' => 245,
        'pending'       => 87,
        'selesai'       => 158,
    ];

    return view('admin.dashboard', [
        'stats'      => $stats,
        'admin_name' => 'Hilal (Mode Preview)',
        'jabatan'    => 'Pengembang Sistem',
    ]);
})->name('admin.preview-dashboard');
