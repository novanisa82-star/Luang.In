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
        // Validasi data input lowongan baru
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'upah' => 'required|numeric',
            'durasi' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Pekerjaan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi ?? '-',
            'latitude' => $request->latitude ?? -6.200000,
            'longitude' => $request->longitude ?? 106.816666,
            'upah' => $request->upah,
            'durasi' => $request->durasi,
            'status_moderasi' => 'menunggu',
            'status_loker' => 'aktif',
        ]);

        return redirect()->route('admin_pt.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $lowongan = Pekerjaan::where('user_id', Auth::id())->findOrFail($id);
        return view('admin_pt.lowongan.show', compact('lowongan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data input lowongan yang diperbarui
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'upah' => 'required|numeric',
            'durasi' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $lowongan = Pekerjaan::where('user_id', Auth::id())->findOrFail($id);
        $lowongan->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi ?? '-',
            'latitude' => $request->latitude ?? -6.200000,
            'longitude' => $request->longitude ?? 106.816666,
            'upah' => $request->upah,
            'durasi' => $request->durasi,
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