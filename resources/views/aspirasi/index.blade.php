@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary">Riwayat Laporan Saya</h5>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-sm btn-primary">+ Buat Laporan Baru</a>
    </div>
    
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aspirasis as $index => $aspirasi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $aspirasi->kategori->ket_kategori ?? '-' }}</td>
                            <td>{{ $aspirasi->lokasi }}</td>
                            <td>{{ $aspirasi->ket }}</td>
                            <td>
                                @if($aspirasi->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($aspirasi->status == 'Proses')
                                    <span class="badge bg-primary">Diproses</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat laporan yang Anda buat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
