<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class LamaranController extends Controller
{
    public function index(Request $request)
    {
        $lamaran = Application::with(['pekerjaan.user'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(function ($item) {
                $pekerjaan = $item->pekerjaan;

                return [
                    'id' => $item->id,
                    'posisi' => $pekerjaan?->judul ?? 'Pekerjaan',
                    'perusahaan' => $pekerjaan?->user?->name
                        ?? 'Perusahaan',
                    'status' => $item->status,
                    'informasi' => match ($item->status) {
                        'diterima' => 'Lamaran berhasil diterima',
                        'ditolak' => 'Lamaran belum diterima',
                        default => 'Menunggu konfirmasi perusahaan',
                    },
                    'upah' => $this->parseUpah($pekerjaan?->upah),
                    'tanggal' => $item->created_at?->toISOString(),
                ];
            });

        return response()->json([
            'message' => 'Riwayat lamaran berhasil diambil',
            'data' => $lamaran,
        ]);
    }

    private function parseUpah($upah): ?int
    {
        if ($upah === null || $upah === '') {
            return null;
        }

        $angka = preg_replace('/[^0-9]/', '', (string) $upah);

        return $angka !== '' ? (int) $angka : null;
    }
}