<?php

namespace App\Http\Controllers\AdminPt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerjaan;
use App\Models\Application;
use App\Models\Laporan;
use App\Models\Rating;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Metrik Ringkasan Khusus PT Login
        $lowonganAktifCount = Pekerjaan::where('user_id', $user->id)
            ->where('status_loker', 'aktif')
            ->count();

        $pelamarMasukCount = Application::whereHas('pekerjaan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        $kandidatDiterimaCount = Application::whereHas('pekerjaan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'diterima')->count();

        $recentPekerjaan = Pekerjaan::where('user_id', $user->id)->latest()->take(5)->get();

        // Rating rata-rata yang diterima PT ini dari pelamar
        $ratingRataRata = null;
        $totalRating = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('ratings') &&
            \Illuminate\Support\Facades\Schema::hasColumn('ratings', 'pt_user_id')) {
            $totalRating = Rating::where('pt_user_id', $user->id)->count();
            $ratingRataRata = $totalRating > 0
                ? round(Rating::where('pt_user_id', $user->id)->avg('bintang'), 1)
                : null;
        }

        // Deteksi Peringatan Pengaduan Aktif dari Superadmin terhadap PT ini
        $activeWarnings = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('laporans')) {
            $activeWarnings = Laporan::where(function ($q) use ($user) {
                $q->where('terlapor_id', $user->id)
                  ->orWhereHas('pekerjaan', function ($pq) use ($user) {
                      $pq->where('user_id', $user->id);
                  });
            })
            ->whereIn('status', ['menunggu', 'proses'])
            ->with(['pekerjaan'])
            ->latest()
            ->get();
        }

        return view('admin_pt.dashboard', compact(
            'lowonganAktifCount',
            'pelamarMasukCount',
            'kandidatDiterimaCount',
            'recentPekerjaan',
            'ratingRataRata',
            'totalRating',
            'activeWarnings'
        ));
    }
}

