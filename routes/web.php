<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LaporanController;

// ── Halaman Utama ──
Route::get('/', [DashboardController::class, 'index'])->name('home')->middleware('auth');
Route::get('/panduan', fn() => view('panduan'))->name('panduan');

// ── Auth Routes ──
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ── Route Laporan ──
Route::get('/laporan/saya', [LaporanController::class, 'laporanSaya'])->name('laporan.saya')->middleware('auth');
Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
Route::get('/laporan/{id}/success', [LaporanController::class, 'success'])->name('laporan.success');
Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit')->middleware('auth');
Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update')->middleware('auth');
Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy')->middleware('auth');
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

        // Laporan Masuk
        Route::get('/laporan-masuk', [App\Http\Controllers\Admin\LaporanMasukController::class, 'index'])->name('laporan-masuk.index');
        Route::get('/laporan-masuk/{id}', [App\Http\Controllers\Admin\LaporanMasukController::class, 'show'])->name('laporan-masuk.show');
        Route::put('/laporan-masuk/{id}', [App\Http\Controllers\Admin\LaporanMasukController::class, 'update'])->name('laporan-masuk.update');
        Route::patch('/laporan-masuk/{id}/verifikasi', [App\Http\Controllers\Admin\LaporanMasukController::class, 'verifikasi'])->name('laporan-masuk.verifikasi');

        // Perlu Diverifikasi
        Route::get('/perlu-verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'index'])->name('perlu-verifikasi');
        Route::patch('/perlu-verifikasi/{id}/proses', [App\Http\Controllers\Admin\VerifikasiController::class, 'proses'])->name('perlu-verifikasi.proses');

        // Manajemen Perbaikan
        Route::get('/manajemen-perbaikan', [App\Http\Controllers\Admin\ManajemenPerbaikanController::class, 'index'])->name('manajemen-perbaikan');
        Route::patch('/manajemen-perbaikan/{id}/selesai', [App\Http\Controllers\Admin\ManajemenPerbaikanController::class, 'selesai'])->name('manajemen-perbaikan.selesai');
        Route::post('/manajemen-perbaikan/{id}/perbaikan', [App\Http\Controllers\Admin\ManajemenPerbaikanController::class, 'storePerbaikan'])->name('manajemen-perbaikan.perbaikan');

        // Rekapan
        Route::get('/rekapan', [App\Http\Controllers\Admin\RekapanController::class, 'index'])->name('rekapan');
        Route::delete('/rekapan/hapus-otomatis', [App\Http\Controllers\Admin\RekapanController::class, 'hapusOtomatis'])->name('rekapan.hapus-otomatis');
        Route::delete('/rekapan/{id}/hapus', [App\Http\Controllers\Admin\RekapanController::class, 'hapus'])->name('rekapan.hapus');
    });
});

// ── Preview admin (development only) ──
Route::get('/admin/preview-dashboard', function () {
    return view('admin.dashboard', [
        'totalLaporan'         => 245,
        'perluVerifikasi'      => 87,
        'sudahVerifikasi'      => 100,
        'selesai'              => 58,
        'laporanTerbaru'       => collect([]),
        'chartVerifikasi'      => [10,15,20,8,12,18,22,15,10,14,18,20],
        'chartBelumVerifikasi' => [5,8,12,4,6,9,11,7,5,7,9,10],
        'dominanLabels'        => ['AC', 'Proyektor', 'Kursi', 'Lampu', 'Komputer'],
        'dominanData'          => [32, 25, 18, 15, 10],
        'tahun'                => now()->year,
    ]);
})->name('admin.preview-dashboard');