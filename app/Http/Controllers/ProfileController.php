<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profile
     */
    public function show()
    {
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update data profile user
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        $user->update($validated);
        // Force touch updated_at timestamp
        $user->touch();

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Tampilkan halaman ganti password
     */
    public function changePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Update password user
     */
    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Password lama tidak sesuai');
                    }
                },
            ],
            'new_password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
            'new_password.min' => 'Password minimal 8 karakter',
            'new_password.mixed_case' => 'Password harus mengandung huruf besar dan kecil',
            'new_password.numbers' => 'Password harus mengandung angka',
            'new_password.symbols' => 'Password harus mengandung simbol (!@#$%^&*)',
        ]);

        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diubah!');
    }
}
