<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Application;
use App\Models\Rating;

class RatingController extends Controller
{
    /**
     * Tampilkan form rating untuk pelamar yang sudah diterima.
     * Route: GET /rating/{application_id}
     */
    public function show($applicationId)
    {
        $this->ensureRatingsTableReady();

        $user = Auth::user();

        // Cari lamaran: harus milik user yang login dan statusnya diterima
        $application = Application::where('id', $applicationId)
            ->where('user_id', $user->id)
            ->where('status', 'diterima')
            ->with(['pekerjaan', 'pekerjaan.user'])
            ->firstOrFail();

        // Cek apakah sudah pernah dinilai
        $sudahDinilai = Rating::where('application_id', $applicationId)
            ->where('reviewer_id', $user->id)
            ->exists();

        return view('user.rating.form', compact('application', 'sudahDinilai'));
    }

    /**
     * Simpan rating dari pelamar.
     * Route: POST /rating/{application_id}
     */
    public function store(Request $request, $applicationId)
    {
        $this->ensureRatingsTableReady();

        $user = Auth::user();

        // Validasi: lamaran harus milik user login dan statusnya diterima
        $application = Application::where('id', $applicationId)
            ->where('user_id', $user->id)
            ->where('status', 'diterima')
            ->with('pekerjaan')
            ->firstOrFail();

        // Cegah double rating
        if (Rating::where('application_id', $applicationId)->where('reviewer_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk pekerjaan ini.');
        }

        $request->validate([
            'bintang'  => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        Rating::create([
            'application_id' => $applicationId,
            'pekerjaan_id'   => $application->pekerjaan_id,
            'reviewer_id'    => $user->id,
            'pt_user_id'     => $application->pekerjaan->user_id,
            'bintang'        => $request->bintang,
            'komentar'       => $request->komentar,
        ]);

        return redirect()->route('user.rating.show', $applicationId)
            ->with('success', 'Terima kasih! Rating Anda berhasil disimpan.');
    }

    /**
     * Pastikan tabel ratings memiliki semua kolom yang dibutuhkan tanpa klausa 'after'.
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
