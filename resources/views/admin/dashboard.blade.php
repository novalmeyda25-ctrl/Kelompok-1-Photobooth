
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
