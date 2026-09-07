<?php

namespace App\Http\Controllers\AdminPt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pekerjaan; // Sesuaikan dengan nama model pekerjaan/lowongan Anda
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
        // Validasi dan proses simpan data lowongan baru di sini
        $request->validate([
            'judul' => 'required|string|max:255',
            'upah' => 'required|numeric',
            'durasi' => 'required|string',
        ]);

        Pekerjaan::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'upah' => $request->upah,
            'durasi' => $request->durasi,
            'status' => 'Aktif',
        ]);

        return redirect()->route('admin_pt.lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }
}