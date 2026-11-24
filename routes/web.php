<?php

use Illuminate\Support\Facades\Route;

Route::get('/camera', function () {
    return view('camera.index');
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\FrameController;

// Halaman Utama (Bisa diakses bebas, ada tombol Login di pojok kanan)
//Route::get('/', function () {
  //  return view('user.dashboard');
//})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Khusus User yang Sudah Login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/photo/download/{id}', [PhotoController::class, 'download'])->name('photo.download');
});

// Route Khusus Admin (Dilindungi EnsureAdmin)

Route::middleware(['auth', EnsureAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
    $totalFrame = \App\Models\Frame::count();
    $totalFilter = \App\Models\Filter::count();
    $totalPengguna = \App\Models\User::count();

    return view('admin.dashboard', compact(
        'totalFrame',
        'totalFilter',
        'totalPengguna'
    ));
})->name('dashboard');

    // Kelola Filter
    Route::resource('filters', FilterController::class);

    // Kelola Frame
Route::resource('frames', FrameController::class);
});

// Route Khusus Admin (Dilindungi EnsureAdmin)
/*Route::middleware(['auth', EnsureAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});*/

 // ===============================
// BAGIAN USER (FRONTEND)
// ===============================

// Halaman pertama: landing lotus
Route::view('/', 'user.landing-whimsybooth')->name('landing.whimsybooth');

// Home
Route::get('/home', function () {
    return view('user.home');
})->name('home');

// Download
Route::get('/download', function () {
    return view('user.download');
})->name('download');