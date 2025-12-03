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

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan sesuai role → /dashboard-ROLE
            return redirect('/dashboard-' . Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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
