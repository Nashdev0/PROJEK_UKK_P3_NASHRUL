@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                
                @if($role == 'admin')
                    <h2 class="text-primary mb-0">Anda masuk sebagai admin</h2>
                @elseif($role == 'siswa')
                    <h2 class="text-success mb-0">Hai {{ auth()->guard('siswa')->user()->nis }}</h2>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
