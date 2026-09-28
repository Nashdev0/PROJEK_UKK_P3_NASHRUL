@extends('layouts.app')

@section('content')
<h2>Umpan Balik Aspirasi</h2>

<form action="{{ route('admin.aspirasi.update', $aspirasi->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>NIS: {{ $aspirasi->siswa->nis }}</label>
    </div>
    <div class="mb-3">
        <label>Kategori: {{ $aspirasi->kategori->ket_kategori }}</label>
    </div>
    <div class="mb-3">
        <label>Lokasi: {{ $aspirasi->lokasi }}</label>
    </div>
    <div class="mb-3">
        <label>Keterangan: {{ $aspirasi->ket }}</label>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
            <option value="Menunggu" {{ $aspirasi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="Proses" {{ $aspirasi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
            <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="feedback" class="form-label">Feedback</label>
        <textarea class="form-control" id="feedback" name="feedback" rows="3">{{ $aspirasi->feedback }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection