<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Penting untuk Hashing Password

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin (Sesuai Soal: Password harus di-hash)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@lks.com',
            'password' => Hash::make('password123'), // Hashing Bcrypt
        ]);

        // 2. Buat Data Dummy Events (Sesuai data JSON kemarin)
        Event::create([
            'event_name' => 'Rapat Pleno Triwulan',
            'event_date' => '2024-03-15',
            'organizer' => 'BPH Inti',
            'description' => 'Evaluasi kinerja pengurus periode awal.',
        ]);

        Event::create([
            'event_name' => 'Class Meeting Semester Genap',
            'event_date' => '2024-06-10',
            'organizer' => 'Sekbid 4 (Olahraga)',
            'description' => 'Lomba futsal dan basket antar kelas.',
        ]);

        Event::create([
            'event_name' => 'Bakti Sosial Ramadhan',
            'event_date' => '2024-04-05',
            'organizer' => 'Sekbid 1 (Agama)',
            'description' => 'Pembagian takjil dan santunan.',
        ]);
    }
}