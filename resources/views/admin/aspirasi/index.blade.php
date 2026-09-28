@extends('layouts.app')

@section('content')
<h2>Daftar Aspirasi</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>NIS</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($aspirasis as $aspirasi)
        <tr>
            <td>{{ $aspirasi->id }}</td>
            <td>{{ $aspirasi->siswa->nis }}</td>
            <td>{{ $aspirasi->kategori->ket_kategori }}</td>
            <td>{{ $aspirasi->lokasi }}</td>
            <td>
                <span class="badge bg-{{ $aspirasi->status == 'Selesai' ? 'success' : ($aspirasi->status == 'Proses' ? 'warning' : 'secondary') }}">
                    {{ $aspirasi->status }}
                </span>
            </td>
            <td>
                <a href="{{ route('admin.aspirasi.edit', $aspirasi->id) }}" class="btn btn-sm btn-primary">Umpan Balik</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection