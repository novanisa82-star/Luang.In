<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\AdminWebController;
use App\Http\Controllers\AdminPt\LowonganController; // Pastikan namespace controller lowongan Anda sudah benar

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard Admin & Perusahaan (Diproteksi Middleware admin.auth)
Route::middleware(['admin.auth'])->name('admin_pt.')->group(function () {
    Route::get('/admin/dashboard', [AdminWebController::class, 'superadminDashboard'])->name('dashboard');
    
    // Tambahan rute untuk Kelola Lowongan
        Route::get('/admin/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/admin/lowongan/tambah', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/admin/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');

    Route::post('/admin/pt/{id}/verifikasi', [AdminWebController::class, 'prosesVerifikasiPT'])->name('superadmin.pt.verif');
    Route::patch('/admin/pekerjaan/{id}/moderasi', [AdminWebController::class, 'prosesModerasiPekerjaan'])->name('superadmin.pekerjaan.moderasi');
});