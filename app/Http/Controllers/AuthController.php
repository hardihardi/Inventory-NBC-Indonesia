<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->remember)) {
        $request->session()->regenerate();
        \App\Models\ActivityLog::log('Login', 'Berhasil masuk ke sistem');
        return redirect()->intended('dashboard');
    }

    \App\Models\ActivityLog::log('Login Gagal', "Percobaan login gagal untuk email: {$request->email}");

    return back()->withErrors([
        'email' => 'Email atau password yang dimasukkan salah.',
    ])->onlyInput('email');
}
    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}