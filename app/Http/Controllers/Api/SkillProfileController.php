<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SkillProfile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SkillProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $profile = SkillProfile::where('user_id', $user->id)->first();

        return response()->json([
            'message' => 'Data profil keahlian berhasil diambil.',
            'profile' => $profile,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'whatsapp' => ['required', 'string', 'max:20'],
            'domisili' => ['nullable', 'string', 'max:255'],
            'primary_role' => ['required', 'string', 'max:255'],
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['required', 'string', 'max:100'],
            'experience' => [
                'required',
                'in:Non Pengalaman,< 1 Tahun,1 - 2 Tahun,2 - 4 Tahun,> 4 Tahun',
            ],
        ], [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'primary_role.required' => 'Pekerjaan utama wajib diisi.',
            'skills.required' => 'Tambahkan minimal satu keahlian.',
            'skills.min' => 'Tambahkan minimal satu keahlian.',
            'experience.required' => 'Pengalaman kerja wajib dipilih.',
        ]);

        $user = $request->user();

        $profile = SkillProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'whatsapp' => $data['whatsapp'],
                'domisili' => $data['domisili'] ?? null,
                'primary_role' => $data['primary_role'],
                'skills' => $data['skills'],
                'experience' => $data['experience'],
            ]
        );

        return response()->json([
            'message' => 'Profil keahlian berhasil disimpan.',
            'profile' => $profile,
        ]);
    }
}