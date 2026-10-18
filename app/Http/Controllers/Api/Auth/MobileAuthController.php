<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SkillProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class MobileAuthController extends Controller
{
    public function register(Request $request)
    {
        return response()->json([
            'message' => 'Gunakan formulir Skill Profile untuk menyelesaikan registrasi.',
        ], 409);
    }

    public function completeRegistration(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],

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
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'primary_role.required' => 'Pekerjaan utama wajib diisi.',
            'skills.required' => 'Tambahkan minimal satu keahlian.',
            'skills.min' => 'Tambahkan minimal satu keahlian.',
            'experience.required' => 'Pengalaman kerja wajib dipilih.',
        ]);

        $result = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'whatsapp' => $data['whatsapp'],
                'domisili' => $data['domisili'] ?? null,
                'role' => 'user',
            ]);

            $profile = SkillProfile::create([
                'user_id' => $user->id,
                'whatsapp' => $data['whatsapp'],
                'domisili' => $data['domisili'] ?? null,
                'primary_role' => $data['primary_role'],
                'skills' => $data['skills'],
                'experience' => $data['experience'],
            ]);

            return [
                'user' => $user,
                'profile' => $profile,
            ];
        });

        $token = $result['user']
            ->createToken('luangin-mobile')
            ->plainTextToken;

        return response()->json([
            'message' => 'Registrasi dan profil keahlian berhasil disimpan.',
            'user' => $result['user'],
            'profile' => $result['profile'],
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak benar.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (
            !$user ||
            !Hash::check($data['password'], $user->password) ||
            $user->role !== 'user'
        ) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $token = $user->createToken('luangin-mobile')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}