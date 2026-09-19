<?php

namespace App\Http\Controllers\AdminPt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Pekerjaan;
use App\Models\Rating;

class RatingController extends Controller
{
    /**
     * Menampilkan daftar rating & ulasan PER LOWONGAN milik PT yang login.
     */
    public function index(Request $request)
    {
        $this->ensureRatingsTableReady();

        $adminId = Auth::id();

        // Ambil semua lowongan milik PT ini beserta ratingnya
        $lowongans = Pekerjaan::where('user_id', $adminId)
            ->with(['ratings' => function ($q) {
                $q->latest();
            }, 'ratings.reviewer', 'ratings.application'])
            ->latest()
            ->get();

        // Filter lowongan yang dipilih jika ada
        $selectedLowonganId = $request->query('pekerjaan_id');
        $selectedLowongan = null;
        if ($selectedLowonganId) {
            $selectedLowongan = $lowongans->firstWhere('id', $selectedLowonganId);
        }

        // Query ulasan individual via relasi pekerjaan milik PT ini
        $query = Rating::whereHas('pekerjaan', function ($q) use ($adminId) {
            $q->where('user_id', $adminId);
        })->with(['reviewer', 'pekerjaan', 'application']);

        if ($selectedLowongan) {
            $query->where('pekerjaan_id', $selectedLowongan->id);
        }

        if ($request->filled('bintang') && in_array($request->bintang, [1, 2, 3, 4, 5])) {
            $query->where('bintang', $request->bintang);
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('komentar', 'like', "%{$search}%")
                  ->orWhereHas('reviewer', function ($rq) use ($search) {
                      $rq->where('name', 'like', "%{$search}%");
                  })->orWhereHas('pekerjaan', function ($pq) use ($search) {
                      $pq->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $ratings = $query->latest()->paginate(10)->withQueryString();

        // Rekapitulasi rating per lowongan
        $lowonganRatingSummaries = $lowongans->map(function ($loker) {
            $count = $loker->ratings->count();
            $avg = $count > 0 ? round($loker->ratings->avg('bintang'), 1) : 0;
            return [
                'lowongan' => $loker,
                'avg' => $avg,
                'count' => $count,
            ];
        });

        return view('admin_pt.rating.index', compact(
            'lowongans',
            'selectedLowongan',
            'ratings',
            'lowonganRatingSummaries'
        ));
    }

    /**
     * Pastikan tabel ratings dan seluruh kolom yang dibutuhkan dibuat secara aman tanpa posisi 'after'.
     */
    private function ensureRatingsTableReady()
    {
        if (!Schema::hasTable('ratings')) {
            Schema::create('ratings', function ($table) {
                $table->id();
                $table->unsignedBigInteger('application_id')->nullable();
                $table->unsignedBigInteger('pekerjaan_id')->nullable();
                $table->unsignedBigInteger('reviewer_id')->nullable();
                $table->unsignedBigInteger('pt_user_id')->nullable();
                $table->tinyInteger('bintang')->unsigned()->default(5);
                $table->text('komentar')->nullable();
                $table->timestamps();
            });
            return;
        }

        Schema::table('ratings', function ($table) {
            if (!Schema::hasColumn('ratings', 'application_id')) {
                $table->unsignedBigInteger('application_id')->nullable();
            }
            if (!Schema::hasColumn('ratings', 'pekerjaan_id')) {
                $table->unsignedBigInteger('pekerjaan_id')->nullable();
            }
            if (!Schema::hasColumn('ratings', 'reviewer_id')) {
                $table->unsignedBigInteger('reviewer_id')->nullable();
            }
            if (!Schema::hasColumn('ratings', 'pt_user_id')) {
                $table->unsignedBigInteger('pt_user_id')->nullable();
            }
            if (!Schema::hasColumn('ratings', 'bintang')) {
                $table->tinyInteger('bintang')->unsigned()->default(5);
            }
            if (!Schema::hasColumn('ratings', 'komentar')) {
                $table->text('komentar')->nullable();
            }
        });
    }
}
