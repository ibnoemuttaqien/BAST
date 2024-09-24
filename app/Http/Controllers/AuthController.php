<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan pengguna ke dashboard berdasarkan peran
            $role = Auth::user()->role;

            switch ($role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'owner':
                    return redirect()->intended('/owner/dashboard');
                case 'karyawan':
                    return redirect()->intended('/karyawan/dashboard');
                default:
                    return redirect('/');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    // Menangani proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
