<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;

// ── Halaman Utama ──
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/panduan', fn() => view('panduan'))->name('panduan');

// ── Auth Routes ──
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ── Route Laporan ──
Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/laporan/{id}/success', [LaporanController::class, 'success'])->name('laporan.success');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// ── Dashboard user (protected) ──
Route::get('/dashboard', fn() => view('dashboard.index'))->middleware('auth')->name('dashboard');

// ── Admin Routes ──
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
        Route::get('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);
    });

    // Auth admin
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });
});

// ── Preview admin (development only) ──
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