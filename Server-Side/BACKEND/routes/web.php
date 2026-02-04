<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// 1. Jalur KHUSUS TAMU (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login'); // Halaman Login
    Route::post('/login', [AuthController::class, 'authenticate']);       // Proses Login
});

// 2. Jalur KHUSUS MEMBER (Sudah Login / Dashboard)
// 'auth' ibarat satpam, kalau belum login akan ditendang balik.
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Nanti kita tambah fitur delete di sini
    Route::delete('/events/{id}', [DashboardController::class, 'destroy'])->name('events.destroy');
});