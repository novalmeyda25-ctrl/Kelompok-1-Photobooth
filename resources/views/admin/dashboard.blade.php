<<<<<<< HEAD
=======

@extends('admin.layouts.app')
@section('title', 'Dashboard Admin - WhimsyBooth')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang di panel admin WhimsyBooth!')
@section('content')

    <!-- STATISTIK -->
    <section class="stats">

        <div class="stat-card">
            <p>Total Frame</p>
            <h2>{{ $totalFrame }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Filter</p>
            <h2>{{ $totalFilter }}</h2>
        </div>

        <div class="stat-card">
            <p>Total Pengguna</p>
            <h2>{{ $totalPengguna }}</h2>
        </div>

    </section>

    <!-- SELAMAT DATANG -->
    <section class="content">

        <h2>Selamat Datang!</h2>

        <p>
            Kelola frame, filter, dan data pengguna
            photobooth melalui halaman dashboard ini.
        </p>

    </section>

@endsection
>>>>>>> 2177ae3e84c3c0045a5e7ae1e78f7208a445f39e
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Whimsybooth</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-900 min-h-screen p-8 text-white">

    <div class="max-w-3xl mx-auto bg-slate-800 rounded-3xl p-8 flex justify-between items-center border border-slate-700 shadow-lg">
        <div>
            <span class="text-xs bg-purple-500/20 text-purple-300 px-3 py-1 rounded-full font-semibold">⚡ ADMIN PANEL</span>
            <h1 class="text-xl font-bold mt-3">Halo, Admin {{ auth()->user()->name }}</h1>
            <p class="text-xs text-slate-400 mt-1">Halaman kontrol pengelola sistem Whimsybooth.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-300 rounded-xl text-xs font-semibold hover:bg-red-500/30 transition">
                Logout
            </button>
        </form>
    </div>

</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 2177ae3e84c3c0045a5e7ae1e78f7208a445f39e
