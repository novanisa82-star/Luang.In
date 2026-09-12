<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\AdminPt\DashboardController as AdminPtDashboardController;
use App\Http\Controllers\AdminPt\LowonganController;
use App\Http\Controllers\AdminPt\PelamarController;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\LaporanController as SuperadminLaporanController;
use App\Http\Controllers\Superadmin\KelolaAkunController as SuperadminKelolaAkunController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Pendaftaran Mitra Perusahaan (Admin PT)
Route::get('/register/pt', [AuthController::class, 'showRegisterPtForm'])->name('register.pt');
Route::post('/register/pt', [AuthController::class, 'registerPt'])->name('register.pt.process');

// Rute Dashboard Admin & Perusahaan (Diproteksi Middleware admin.auth)
Route::middleware(['admin.auth'])->group(function () {
    // Dashboard (Dipisahkan berdasarkan Role Pengguna)
    Route::get('/admin/dashboard', function () {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'superadmin') {
            return app(SuperadminDashboardController::class)->index();
        }
        return app(AdminPtDashboardController::class)->index();
    })->name('admin_pt.dashboard');
    
    // Rute Kelola Lowongan Perusahaan & Pelamar (KHUSUS Admin PT)
    Route::middleware(['admin_pt.only'])->name('admin_pt.')->group(function () {
        Route::get('/admin/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
        Route::get('/admin/lowongan/tambah', [LowonganController::class, 'create'])->name('lowongan.create');
        Route::post('/admin/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');
        Route::get('/admin/lowongan/{id}', [LowonganController::class, 'show'])->name('lowongan.show');
        Route::get('/admin/lowongan/{id}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
        Route::put('/admin/lowongan/{id}', [LowonganController::class, 'update'])->name('lowongan.update');
        Route::delete('/admin/lowongan/{id}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');

        // Rute Manajemen Pelamar & Riwayat Masuk (Admin PT)
        Route::get('/admin/pelamar', [PelamarController::class, 'index'])->name('pelamar.index');
        Route::get('/admin/riwayat', [PelamarController::class, 'riwayat'])->name('riwayat.index');
        Route::patch('/admin/pelamar/{id}/status', [PelamarController::class, 'updateStatus'])->name('pelamar.update_status');
    });

    // Rute Khusus Superadmin (Verifikasi PT, Moderasi Lowongan, Kelola Laporan & Akun PT)
    Route::middleware(['superadmin.only'])->group(function () {
        // Moderasi & Verifikasi
        Route::post('/admin/pt/{id}/verifikasi', [SuperadminDashboardController::class, 'prosesVerifikasiPT'])->name('superadmin.pt.verif');
        Route::patch('/admin/pekerjaan/{id}/moderasi', [SuperadminDashboardController::class, 'prosesModerasiPekerjaan'])->name('superadmin.pekerjaan.moderasi');

        // Kelola Laporan & Pengaduan Superadmin
        Route::get('/admin/superadmin/laporan', [SuperadminLaporanController::class, 'index'])->name('superadmin.laporan.index');
        Route::post('/admin/superadmin/laporan', [SuperadminLaporanController::class, 'store'])->name('superadmin.laporan.store');
        Route::patch('/admin/superadmin/laporan/{id}/status', [SuperadminLaporanController::class, 'updateStatus'])->name('superadmin.laporan.update_status');
        Route::delete('/admin/superadmin/laporan/{id}', [SuperadminLaporanController::class, 'destroy'])->name('superadmin.laporan.destroy');
        Route::get('/admin/superadmin/laporan/cetak', [SuperadminLaporanController::class, 'cetak'])->name('superadmin.laporan.cetak');

        // Kelola Akun Mitra PT & Suspend / Ngedownin Akun Bermasalah
        Route::get('/admin/superadmin/akun', [SuperadminKelolaAkunController::class, 'index'])->name('superadmin.akun.index');
        Route::patch('/admin/superadmin/akun/{id}/suspend', [SuperadminKelolaAkunController::class, 'suspendPT'])->name('superadmin.akun.suspend');
        Route::patch('/admin/superadmin/akun/{id}/unsuspend', [SuperadminKelolaAkunController::class, 'unsuspendPT'])->name('superadmin.akun.unsuspend');
        Route::patch('/admin/superadmin/akun/{id}/status-verifikasi', [SuperadminKelolaAkunController::class, 'updateStatusVerifikasi'])->name('superadmin.akun.update_status');
        Route::delete('/admin/superadmin/akun/{id}', [SuperadminKelolaAkunController::class, 'destroy'])->name('superadmin.akun.destroy');
    });
});