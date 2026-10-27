<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use Illuminate\Http\JsonResponse;

class PekerjaanController extends Controller
{
    public function index(): JsonResponse
    {
        $pekerjaans = Pekerjaan::with('user')
            ->where('status_moderasi', 'disetujui')
            ->where('status_loker', 'aktif')
            ->latest()
            ->get()
            ->map(function ($pekerjaan) {
                return [
                    'id' => $pekerjaan->id,
                    'user_id' => $pekerjaan->user_id,
                    'judul' => $pekerjaan->judul,
                    'deskripsi' => $pekerjaan->deskripsi,
                    'latitude' => $pekerjaan->latitude,
                    'longitude' => $pekerjaan->longitude,
                    'upah' => $pekerjaan->upah,
                    'durasi' => $pekerjaan->durasi,
                    'status_moderasi' => $pekerjaan->status_moderasi,
                    'status_loker' => $pekerjaan->status_loker,
                    'created_at' => $pekerjaan->created_at,
                    'updated_at' => $pekerjaan->updated_at,
                    'nama_pt' => $pekerjaan->user?->name,
                    'rating' => null,
                    'total_rating' => 0,
                ];
            });

        return response()->json([
            'message' => 'Daftar lowongan berhasil diambil.',
            'data' => $pekerjaans,
        ]);
    }
}