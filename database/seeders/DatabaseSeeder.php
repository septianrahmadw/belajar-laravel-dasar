<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@labbooking.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Septian Rahmad W',
            'email' => 'septian@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Operator Lab',
            'email' => 'operator@labbooking.com',
            'role' => 'operator',
        ]);

        $rooms = [
            [
                'name' => 'Lab Komputer A',
                'code' => 'LAB-A',
                'location' => 'Gedung Teknologi Lantai 2',
                'capacity' => 40,
                'description' => 'Laboratorium komputer utama dengan perangkat lengkap untuk praktikum pemrograman, jaringan, dan basis data. Dilengkapi dengan projector dan sound system.',
                'facilities' => ['40 PC Windows', 'Projector', 'Sound System', 'AC', 'Whiteboard', 'Internet 100Mbps'],
            ],
            [
                'name' => 'Lab Komputer B',
                'code' => 'LAB-B',
                'location' => 'Gedung Teknologi Lantai 2',
                'capacity' => 35,
                'description' => 'Laboratorium khusus untuk praktikum desain grafis dan multimedia. Setiap PC dilengkapi dengan GPU dedicated dan monitor calibrated.',
                'facilities' => ['35 PC + GPU', 'Monitor Calibrated', 'Scanner', 'Printer', 'AC', 'Drawing Tablet'],
            ],
            [
                'name' => 'Lab Jaringan',
                'code' => 'LAB-NET',
                'location' => 'Gedung Teknologi Lantai 3',
                'capacity' => 25,
                'description' => 'Laboratorium khusus jaringan komputer dengan perangkat Cisco, MikroTik, dan server rack. Cocok untuk praktikum CCNA dan administrasi jaringan.',
                'facilities' => ['25 PC', 'Cisco Router', 'MikroTik', 'Server Rack', 'UPS', 'Cable Tester'],
            ],
            [
                'name' => 'Lab Server',
                'code' => 'LAB-SRV',
                'location' => 'Gedung Teknologi Lantai 3',
                'capacity' => 20,
                'description' => 'Laboratorium server dan cloud computing. Dilengkapi dengan server fisik untuk virtualisasi dan akses ke platform cloud.',
                'facilities' => ['20 PC', 'Physical Server', 'VMware', 'Cloud Access', 'UPS', 'Cooling System'],
            ],
            [
                'name' => 'Lab IoT & Robotics',
                'code' => 'LAB-IoT',
                'location' => 'Gedung Teknologi Lantai 4',
                'capacity' => 15,
                'description' => 'Laboratorium Internet of Things dan Robotika. Tersedia Arduino, Raspberry Pi, sensor, dan perangkat embedded system lainnya.',
                'facilities' => ['15 PC', 'Arduino Kit', 'Raspberry Pi', '3D Printer', 'Oscilloscope', 'Solder Station'],
            ],
            [
                'name' => 'Ruang Diskusi',
                'code' => 'DC-01',
                'location' => 'Gedung Teknologi Lantai 1',
                'capacity' => 10,
                'description' => 'Ruang diskusi dan meeting kecil untuk kelompok. Dilengkapi TV 55 inch dan whiteboard untuk presentasi.',
                'facilities' => ['TV 55"', 'Whiteboard', 'AC', 'WiFi', 'Power Outlet', 'Webcam'],
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }

        $today = Carbon::today();
        $bookings = [
            ['room_id' => 1, 'booker_name' => 'Rina Susanti', 'booker_email' => 'rina@student.ac.id', 'booker_phone' => '081234567890', 'booker_nim' => '2024001', 'purpose' => 'Praktikum Pemrograman Web', 'date' => $today->format('Y-m-d'), 'start_time' => '08:00', 'end_time' => '10:00', 'status' => 'approved'],
            ['room_id' => 1, 'booker_name' => 'Budi Pratama', 'booker_email' => 'budi@student.ac.id', 'booker_phone' => '081234567891', 'booker_nim' => '2024002', 'purpose' => 'Praktikum Basis Data', 'date' => $today->format('Y-m-d'), 'start_time' => '13:00', 'end_time' => '15:00', 'status' => 'approved'],
            ['room_id' => 2, 'booker_name' => 'Andi Kurniawan', 'booker_email' => 'andi@student.ac.id', 'booker_phone' => '081234567892', 'booker_nim' => '2024003', 'purpose' => 'Workshop Desain UI/UX', 'date' => $today->format('Y-m-d'), 'start_time' => '09:00', 'end_time' => '12:00', 'status' => 'pending'],
            ['room_id' => 3, 'booker_name' => 'Maya Lestari', 'booker_email' => 'maya@student.ac.id', 'booker_phone' => '081234567893', 'booker_nim' => '2024004', 'purpose' => 'Praktikum Jaringan Komputer', 'date' => $today->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '12:00', 'status' => 'approved'],
            ['room_id' => 4, 'booker_name' => 'Dimas Aditya', 'booker_email' => 'dimas@student.ac.id', 'booker_phone' => '081234567894', 'booker_nim' => '2024005', 'purpose' => 'Tugas Kelompok Cloud Computing', 'date' => $today->format('Y-m-d'), 'start_time' => '14:00', 'end_time' => '16:00', 'status' => 'pending'],
            ['room_id' => 1, 'booker_name' => 'Fajar Nugroho', 'booker_email' => 'fajar@student.ac.id', 'booker_phone' => '081234567895', 'booker_nim' => '2024006', 'purpose' => 'Ujian Praktikum Algoritma', 'date' => $today->copy()->addDay()->format('Y-m-d'), 'start_time' => '08:00', 'end_time' => '11:00', 'status' => 'approved'],
            ['room_id' => 2, 'booker_name' => 'Sari Dewi', 'booker_email' => 'sari@student.ac.id', 'booker_phone' => '081234567896', 'booker_nim' => '2024007', 'purpose' => 'Proyek Akhir Animasi 3D', 'date' => $today->copy()->addDay()->format('Y-m-d'), 'start_time' => '13:00', 'end_time' => '16:00', 'status' => 'pending'],
            ['room_id' => 6, 'booker_name' => 'Septian Rahmad W', 'booker_email' => 'septian@example.com', 'booker_phone' => '081234567800', 'purpose' => 'Meeting Tim Project', 'date' => $today->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '11:00', 'status' => 'approved'],
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}
