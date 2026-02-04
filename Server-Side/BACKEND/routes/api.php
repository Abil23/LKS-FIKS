<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Event; // Jangan lupa panggil Model Event

// Membuat endpoint API yang bisa diakses publik
Route::get('/events', function () {
    // Ambil semua data event dan kembalikan dalam bentuk JSON
    return Event::all();
});