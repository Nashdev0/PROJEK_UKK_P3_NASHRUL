<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::with(['siswa', 'kategori'])->latest()->get();
        return view('admin.aspirasi.index', compact('aspirasis'));
    }

    public function edit($id)
    {
        $aspirasi = Aspirasi::with(['siswa', 'kategori'])->findOrFail($id);
        return view('admin.aspirasi.edit', compact('aspirasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('admin.aspirasi.index')->with('success', 'Umpan balik berhasil disimpan!');
    }
}