<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengaduan Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; width: 260px; background-color: #343a40; }
        .sidebar a { color: #adb5bd; border-radius: 5px; padding: 10px 15px; display: block; text-decoration: none; margin-bottom: 5px; }
        .sidebar a:hover { color: #fff; background-color: #495057; }
        .sidebar a.active { color: #fff; background-color: #0d6efd; font-weight: bold; }
        .main-content { min-height: 100vh; width: 100%; }
    </style>
</head>
<body class="bg-light">

@if(Auth::guard('admin')->check() || Auth::guard('siswa')->check())
    <div class="d-flex">
        <div class="sidebar p-3 d-flex flex-column shadow">
            <h4 class="text-white text-center mb-4 mt-2">Pengaduan</h4>
            <hr class="text-secondary">
            
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>
                
                @if(Auth::guard('admin')->check())
                    <li class="nav-item">
                        <a href="{{ route('admin.aspirasi.index') }}" class="{{ request()->is('admin/aspirasi*') ? 'active' : '' }}">
                            Data Pengaduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.kategori.index') }}" class="{{ request()->is('admin/kategori*') ? 'active' : '' }}">
                            Data Kategori
                        </a>
                    </li>
                
                @elseif(Auth::guard('siswa')->check())
                    <li class="nav-item">
                        <a href="{{ route('aspirasi.create') }}" class="{{ request()->is('aspirasi/create') ? 'active' : '' }}">
                            Kirim Pengaduan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('aspirasi.index') }}" class="{{ request()->is('aspirasi') ? 'active' : '' }}">
                            Riwayat Laporan
                        </a>
                    </li>
                @endif
            </ul>

            <hr class="text-secondary">
            <div class="text-center text-white mb-2">
                <small>Halo, <b>{{ Auth::guard('admin')->check() ? 'Admin' : 'Siswa' }}</b></small>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>

        <div class="main-content p-4">
            @yield('content')
        </div>
    </div>
@else
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">Pengaduan Sekolah</a>
        </div>
    </nav>
    <div class="container mt-5">
        @yield('content')
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>