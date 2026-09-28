@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Edit Kategori</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="ket_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="ket_kategori" name="ket_kategori" value="{{ $kategori->ket_kategori }}" required autofocus>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
