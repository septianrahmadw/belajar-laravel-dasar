<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $nextWeek = Carbon::now()->addWeek();

        $prodis = Prodi::all()->keyBy('name');

        $bookings = [
            // Praktikum Pemrograman Web - Lab Komputer A
            [
                'room_id' => 1,
                'booker_name' => 'Rina Susanti',
                'booker_email' => 'rina@student.ac.id',
                'booker_phone' => '081234567890',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Sistem Informasi']->id ?? 1,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Pemrograman Web',
                'semester' => 4,
                'kelas' => 'A',
                'dosen' => 'Dr. Ahmad Fauzi, M.Kom',
                'teknisi' => 'Budi Santoso',
                'date' => $today->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'status' => 'approved',
            ],
            // Praktikum Basis Data - Lab Komputer A
            [
                'room_id' => 1,
                'booker_name' => 'Budi Pratama',
                'booker_email' => 'budi@student.ac.id',
                'booker_phone' => '081234567891',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Ilmu Komputer']->id ?? 2,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Basis Data',
                'semester' => 4,
                'kelas' => 'B',
                'dosen' => 'Prof. Dr. Siti Nurhaliza, M.T',
                'teknisi' => 'Andi Wijaya',
                'date' => $today->format('Y-m-d'),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'status' => 'approved',
            ],
            // Workshop Desain UI/UX - Lab Komputer B
            [
                'room_id' => 2,
                'booker_name' => 'Andi Kurniawan',
                'booker_email' => 'andi@student.ac.id',
                'booker_phone' => '081234567892',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Teknologi Rekayasa Perangkat Lunak']->id ?? 3,
                'purpose' => 'Kuliah',
                'mata_kuliah' => 'Desain UI/UX',
                'semester' => 6,
                'kelas' => 'A',
                'dosen' => 'Dr. Rudi Hartono, M.Ds',
                'teknisi' => null,
                'date' => $today->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '12:00',
                'status' => 'pending',
            ],
            // Praktikum Jaringan Komputer - Lab Jaringan
            [
                'room_id' => 3,
                'booker_name' => 'Maya Lestari',
                'booker_email' => 'maya@student.ac.id',
                'booker_phone' => '081234567893',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Teknik Informatika']->id ?? 4,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Jaringan Komputer',
                'semester' => 4,
                'kelas' => 'C',
                'dosen' => 'Dr. Eng. Darmawan Setiawan, M.T',
                'teknisi' => 'Rudi Hermawan',
                'date' => $today->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '12:00',
                'status' => 'approved',
            ],
            // Tugas Kelompok Cloud Computing - Lab Server
            [
                'room_id' => 4,
                'booker_name' => 'Dimas Aditya',
                'booker_email' => 'dimas@student.ac.id',
                'booker_phone' => '081234567894',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Ilmu Komputer']->id ?? 2,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Cloud Computing',
                'semester' => 6,
                'kelas' => 'A',
                'dosen' => 'Prof. Dr. Budi Rahardjo, M.T',
                'teknisi' => 'Hendra Kurniawan',
                'date' => $today->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'status' => 'pending',
            ],
            // Ujian Praktikum Algoritma - Lab Komputer A (besok)
            [
                'room_id' => 1,
                'booker_name' => 'Fajar Nugroho',
                'booker_email' => 'fajar@student.ac.id',
                'booker_phone' => '081234567895',
                'jurusan' => 'Teknik',
                'prodi_id' => $prodis['Teknik Informatika']->id ?? 5,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Algoritma dan Pemrograman',
                'semester' => 2,
                'kelas' => 'B',
                'dosen' => 'Dr. Eko Prasetyo, M.Kom',
                'teknisi' => 'Budi Santoso',
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '11:00',
                'status' => 'approved',
            ],
            // Proyek Akhir Animasi 3D - Lab Komputer B (besok)
            [
                'room_id' => 2,
                'booker_name' => 'Sari Dewi',
                'booker_email' => 'sari@student.ac.id',
                'booker_phone' => '081234567896',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Teknologi Rekayasa Perangkat Lunak']->id ?? 3,
                'purpose' => 'Kuliah',
                'mata_kuliah' => 'Animasi 3D',
                'semester' => 6,
                'kelas' => 'A',
                'dosen' => 'Dr. Rudi Hartono, M.Ds',
                'teknisi' => null,
                'date' => $tomorrow->format('Y-m-d'),
                'start_time' => '13:00',
                'end_time' => '16:00',
                'status' => 'pending',
            ],
            // Meeting Tim Project - Ruang Diskusi
            [
                'room_id' => 6,
                'booker_name' => 'Septian Rahmad W',
                'booker_email' => 'septian@example.com',
                'booker_phone' => '081234567800',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Sistem Informasi']->id ?? 1,
                'purpose' => 'Kuliah',
                'mata_kuliah' => 'Proyek Akhir',
                'semester' => 8,
                'kelas' => 'A',
                'dosen' => 'Dr. Ahmad Fauzi, M.Kom',
                'teknisi' => null,
                'date' => $today->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '11:00',
                'status' => 'approved',
            ],
            // Praktikum Nutrisi Ternak - Lab Peternakan
            [
                'room_id' => 8,
                'booker_name' => 'Rizki Pratama',
                'booker_email' => 'rizki@student.ac.id',
                'booker_phone' => '081234567897',
                'jurusan' => 'Peternakan',
                'prodi_id' => $prodis['Ilmu Nutrisi dan Teknologi Pakan']->id ?? 6,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Nutrisi Ternak',
                'semester' => 4,
                'kelas' => 'A',
                'dosen' => 'Dr. Ir. Suharsono, M.P',
                'teknisi' => 'Agus Setiawan',
                'date' => $today->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'status' => 'approved',
            ],
            // Kuliah Agroteknologi - Lab Pertanian
            [
                'room_id' => 7,
                'booker_name' => 'Dewi Kartika',
                'booker_email' => 'dewi@student.ac.id',
                'booker_phone' => '081234567898',
                'jurusan' => 'Budidaya Tanaman Pangan',
                'prodi_id' => $prodis['Agroteknologi']->id ?? 7,
                'purpose' => 'Kuliah',
                'mata_kuliah' => 'Agroteknologi',
                'semester' => 2,
                'kelas' => 'B',
                'dosen' => 'Prof. Dr. Ir. Bambang Susanto, M.P',
                'teknisi' => null,
                'date' => $today->format('Y-m-d'),
                'start_time' => '13:00',
                'end_time' => '15:00',
                'status' => 'approved',
            ],
            // Praktikum Pemrograman Mobile - Lab Komputer A ( minggu depan)
            [
                'room_id' => 1,
                'booker_name' => 'Angga Prasetyo',
                'booker_email' => 'angga@student.ac.id',
                'booker_phone' => '081234567899',
                'jurusan' => 'Teknologi Informasi',
                'prodi_id' => $prodis['Teknik Informatika']->id ?? 4,
                'purpose' => 'Praktikum',
                'mata_kuliah' => 'Pemrograman Mobile',
                'semester' => 4,
                'kelas' => 'A',
                'dosen' => 'Dr. Ahmad Fauzi, M.Kom',
                'teknisi' => 'Budi Santoso',
                'date' => $nextWeek->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '10:00',
                'status' => 'pending',
            ],
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}