<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;

class AuthController extends Controller
{
    // ==========================================
    // LOGIN SISWA
    // ==========================================
    public function showLoginFormSiswa()
    {
        if (Auth::guard('web')->check() || Auth::guard('siswa')->check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function loginSiswa(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('siswa')->attempt(['nis' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['username' => 'NIS atau Password Siswa salah!']);
    }

    // ==========================================
    // LOGIN ADMIN
    // ==========================================
    public function showLoginFormAdmin()
    {
        if (Auth::guard('web')->check() || Auth::guard('siswa')->check()) {
            return redirect('/dashboard');
        }
        return view('auth.login_admin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['name' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau Password Admin salah!']);
    }

    // ==========================================
    // LOGOUT (UNTUK KEDUANYA)
    // ==========================================
    public function logout(Request $request)
    {
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // ==========================================
    // REGISTER SISWA
    // ==========================================
    public function showRegisterSiswaForm()
    {
        if (Auth::guard('web')->check() || Auth::guard('siswa')->check()) {
            return redirect('/dashboard');
        }
        return view('auth.register_siswa');
    }

    public function registerSiswa(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:10|unique:siswa,nis',
            'kelas' => 'required|string|max:10',
            'password' => 'required|string|min:6',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
        ]);

        // Langsung login-kan siswa yang baru mendaftar
        Auth::guard('siswa')->login($siswa);

        return redirect('/dashboard');
    }
}
