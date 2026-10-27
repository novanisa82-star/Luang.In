<?php

namespace App\Http\Controllers\AdminPt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    public function index()
    {
        // Mengambil data lowongan berdasarkan perusahaan yang sedang login
        $lowongans = Pekerjaan::where('user_id', Auth::id())->latest()->paginate(10);
        
        return view('admin_pt.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        return view('admin_pt.lowongan.create');
    }

    public function store(Request $request)
    {
        // Bersihkan input upah jika diformat (misal: "Rp 150.000" menjadi 150000)
        if ($request->filled('upah')) {
            $cleanedUpah = preg_replace('/[^0-9]/', '', (string)$request->upah);
            $request->merge(['upah' => $cleanedUpah ?: 0]);
        }

        // Validasi data input lowongan baru
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'upah' => 'required|numeric',
            'durasi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $deskripsiLengkap = $request->deskripsi ?? '-';
        if ($request->filled('lokasi')) {
            $deskripsiLengkap .= "\n\nLokasi: " . $request->lokasi;
        }
        if ($request->filled('skills')) {
            $skills = is_array($request->skills) ? implode(', ', $request->skills) : $request->skills;
            $deskripsiLengkap .= "\nSkill yang dibutuhkan: " . $skills;
        }

        $isDraft = $request->input('action') === 'draft';

        Pekerjaan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $deskripsiLengkap,
            'latitude' => $request->latitude ?? -6.200000,
            'longitude' => $request->longitude ?? 106.816666,
            'upah' => $request->upah,
            'durasi' => $request->durasi,
            'status_moderasi' => $isDraft ? 'menunggu' : 'menunggu',
            'status_loker' => $isDraft ? 'ditutup' : 'aktif',
        ]);

        $pesan = $isDraft ? 'Lowongan berhasil disimpan sebagai draf.' : 'Lowongan berhasil ditayangkan dan menunggu verifikasi.';
        return redirect()->route('admin_pt.lowongan.index')->with('success', $pesan);
    }

    public function show($id)
    {
        $lowongan = Pekerjaan::where('user_id', Auth::id())->with('applications.user')->findOrFail($id);
        return view('admin_pt.lowongan.show', compact('lowongan'));
    }

    public function edit($id)
    {
        $lowongan = Pekerjaan::where('user_id', Auth::id())->findOrFail($id);
        
        // Ekstrak lokasi & skills dari deskripsi jika ada
        $deskripsiTeks = $lowongan->deskripsi ?? '';
        $lokasi = '';
        $skills = '';

        if (preg_match('/Lokasi:\s*(.*?)(\n|$)/i', $deskripsiTeks, $matches)) {
            $lokasi = trim($matches[1]);
        }
        if (preg_match('/Skill yang dibutuhkan:\s*(.*?)(\n|$)/i', $deskripsiTeks, $matches)) {
            $skills = trim($matches[1]);
        }

        // Hapus teks lokasi dan skill dari deskripsi agar textarea bersih
        $deskripsiBersih = preg_replace('/(\n\n)?Lokasi:\s*(.*?)(\n|$)/i', '', $deskripsiTeks);
        $deskripsiBersih = preg_replace('/(\n\n)?Skill yang dibutuhkan:\s*(.*?)(\n|$)/i', '', $deskripsiBersih);
        $deskripsiBersih = trim($deskripsiBersih);

        return view('admin_pt.lowongan.edit', compact('lowongan', 'lokasi', 'skills', 'deskripsiBersih'));
    }

    public function update(Request $request, $id)
    {
        // Bersihkan input upah jika diformat
        if ($request->filled('upah')) {
            $cleanedUpah = preg_replace('/[^0-9]/', '', (string)$request->upah);
            $request->merge(['upah' => $cleanedUpah ?: 0]);
        }

        // Validasi data input lowongan yang diperbarui
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'upah' => 'required|numeric',
            'durasi' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:255',
            'status_loker' => 'nullable|in:aktif,ditutup',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $lowongan = Pekerjaan::where('user_id', Auth::id())->findOrFail($id);

        $deskripsiLengkap = $request->deskripsi ?? '-';
        if ($request->filled('lokasi')) {
            $deskripsiLengkap .= "\n\nLokasi: " . $request->lokasi;
        }
        if ($request->filled('skills')) {
            $skills = is_array($request->skills) ? implode(', ', $request->skills) : $request->skills;
            $deskripsiLengkap .= "\nSkill yang dibutuhkan: " . $skills;
        }

        $lowongan->update([
            'judul' => $request->judul,
            'deskripsi' => $deskripsiLengkap,
            'latitude' => $request->latitude ?? $lowongan->latitude ?? -6.200000,
            'longitude' => $request->longitude ?? $lowongan->longitude ?? 106.816666,
            'upah' => $request->upah,
            'durasi' => $request->durasi,
            'status_loker' => $request->input('status_loker', $lowongan->status_loker ?? 'aktif'),
        ]);

        return redirect()->route('admin_pt.lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lowongan = Pekerjaan::where('user_id', Auth::id())->findOrFail($id);
        $lowongan->delete();

        return redirect()->route('admin_pt.lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}