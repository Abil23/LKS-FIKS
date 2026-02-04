<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // Panggil Model Event

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data event dari database
        $events = Event::all(); 

        // Kirim data ke tampilan dashboard
        return view('dashboard.index', compact('events'));
    }

    // Nanti kita isi fungsi hapus di sini
    // Hapus Data Event
    public function destroy($id)
    {
        // 1. Cari data berdasarkan ID
        $event = Event::findOrFail($id);

        // 2. Hapus data
        $event->delete();

        // 3. Kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Data berhasil dihapus!');
    }
}

