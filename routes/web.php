<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AdminWebController;
use App\Http\Controllers\AdminPt\LowonganController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard Admin & Perusahaan (Diproteksi Middleware admin.auth)
Route::middleware(['admin.auth'])->group(function () {
    // Dashboard (Admin PT & Superadmin)
    Route::get('/admin/dashboard', [AdminWebController::class, 'superadminDashboard'])->name('admin_pt.dashboard');
    
    // Rute Kelola Lowongan Perusahaan (Admin PT)
    Route::name('admin_pt.')->group(function () {
        Route::get('/admin/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/admin/lowongan/tambah', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/admin/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
    });

    // Rute Khusus Superadmin (Verifikasi PT & Moderasi Lowongan)
    Route::post('/admin/pt/{id}/verifikasi', [AdminWebController::class, 'prosesVerifikasiPT'])->name('superadmin.pt.verif');
    Route::patch('/admin/pekerjaan/{id}/moderasi', [AdminWebController::class, 'prosesModerasiPekerjaan'])->name('superadmin.pekerjaan.moderasi');
});