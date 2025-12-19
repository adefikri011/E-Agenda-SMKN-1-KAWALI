<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Deteksi apakah permintaan dilakukan via AJAX / fetch
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan sesuai role → /dashboard-ROLE
            $redirectUrl = '/dashboard-' . Auth::user()->role;

            if ($isAjax) {
                return response()->json(['success' => true, 'redirect' => $redirectUrl], 200);
            }

            return redirect($redirectUrl);
        }

        // Gagal autentikasi
        $errorMessage = 'Email atau Password yang anda masukan salah.';

        if ($isAjax) {
            return response()->json(['success' => false, 'errors' => ['email' => $errorMessage]], 422);
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        // Log out user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate token
        $request->session()->regenerateToken();

        // Redirect kembali ke halaman login
        return redirect('/')->with('success', 'Anda berhasil logout.');
    }

}
