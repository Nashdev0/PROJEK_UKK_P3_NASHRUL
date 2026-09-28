@extends('layouts.app')

@section('content')
<h2>Form Aspirasi Siswa</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('aspirasi.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">NIS (Otomatis)</label>
        <input type="text" class="form-control" value="{{ auth()->guard('siswa')->user()->nis }}" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Kelas (Otomatis)</label>
        <input type="text" class="form-control" value="{{ auth()->guard('siswa')->user()->kelas }}" disabled>
    </div>
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select" id="kategori_id" name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->ket_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="lokasi" class="form-label">Lokasi</label>
        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
    </div>
    <div class="mb-3">
        <label for="ket" class="form-label">Keterangan</label>
        <textarea class="form-control" id="ket" name="ket" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Kirim Aspirasi</button>
</form>
@endsection