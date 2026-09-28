<?php

use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// SISWA
Route::get('/login', [AuthController::class, 'showLoginFormSiswa'])->name('login');
Route::post('/login', [AuthController::class, 'loginSiswa'])->name('login.post');

// ATMIN
Route::get('/login_admin', [AuthController::class, 'showLoginFormAdmin'])->name('login.admin');
Route::post('/login_admin', [AuthController::class, 'loginAdmin'])->name('login.admin.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterSiswaForm'])->name('register.siswa');
Route::post('/register', [AuthController::class, 'registerSiswa'])->name('register.siswa.post');

// DASHBOARD
Route::get('/dashboard', function () {
    if (Auth::guard('admin')->check()) {
        return view('dashboard', ['role' => 'admin']);
    } elseif (Auth::guard('siswa')->check()) {
        return view('dashboard', ['role' => 'siswa']);
    }
    return redirect('/login');
});

// MIDLEWARE SISWA
Route::middleware(['auth:siswa'])->group(function () {
    Route::resource('aspirasi', AspirasiController::class)->only(['index', 'create', 'store']);
});

use App\Http\Controllers\KategoriController;

// MIDLEWARE ATMIN
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // Pengaduan
    Route::get('/aspirasi', [AdminController::class, 'index'])->name('aspirasi.index');
    Route::get('/aspirasi/{id}/edit', [AdminController::class, 'edit'])->name('aspirasi.edit');
    Route::put('/aspirasi/{id}', [AdminController::class, 'update'])->name('aspirasi.update');
    
    // Kategori
    Route::resource('kategori', KategoriController::class)->except(['show']);
});