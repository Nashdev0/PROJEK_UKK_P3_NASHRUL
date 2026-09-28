<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::where('siswa_id', auth()->guard('siswa')->id())
                             ->orderBy('created_at', 'desc')
                             ->get(); 
        return view('aspirasi.index', compact('aspirasis'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('aspirasi.create', compact('kategoris'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi' => 'required|string|max:50',
            'ket' => 'required|string',
        ]);

        Aspirasi::create([
            'siswa_id' => auth()->guard('siswa')->id(), 
            'kategori_id' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('aspirasi.index')->with('success', 'Aspirasi berhasil dikirim!');
    }

}