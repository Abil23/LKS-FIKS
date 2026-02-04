<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Logika Login (Sesuai Soal: Validasi & Keamanan)
    public function authenticate(Request $request)
    {
        // 1. Validasi Input (Wajib diisi) [cite: 69]
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek Kecocokan Data (Laravel otomatis mengecek hash password) [cite: 68]
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Keamanan: Cegah Session Fixation
            return redirect()->intended('dashboard');
        }

        // 3. Jika Gagal Login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}