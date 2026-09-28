<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;

class AuthController extends Controller
{

    public function showLoginFormSiswa()
    {
        if (Auth::guard('admin')->check() || Auth::guard('siswa')->check()) {
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


    public function showLoginFormAdmin()
    {
        if (Auth::guard('admin')->check() || Auth::guard('siswa')->check()) {
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

        if ($request->username === 'admin' && $request->password === 'admin123') {
            
            $admin = \App\Models\User::firstOrCreate(
                ['name' => 'admin'],
                ['password' => \Illuminate\Support\Facades\Hash::make('admin123'), 'email' => 'admin@admin.com']
            );
            
            Auth::guard('admin')->login($admin);
            
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau Password Admin salah!']);
    }


    public function logout(Request $request)
    {
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


    public function showRegisterSiswaForm()
    {
        if (Auth::guard('admin')->check() || Auth::guard('siswa')->check()) {
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

        Auth::guard('siswa')->login($siswa);

        return redirect('/dashboard');
    }
}
