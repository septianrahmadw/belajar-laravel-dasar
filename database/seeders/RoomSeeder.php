<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Lab Komputer A',
                'code' => 'LAB-A',
                'location' => 'Gedung Teknologi Lantai 2',
                'capacity' => 40,
                'description' => 'Laboratorium komputer utama dengan perangkat lengkap untuk praktikum pemrograman, jaringan, dan basis data. Dilengkapi dengan projector dan sound system.',
                'facilities' => ['40 PC Windows', 'Projector', 'Sound System', 'AC', 'Whiteboard', 'Internet 100Mbps'],
                'is_active' => true,
            ],
            [
                'name' => 'Lab Komputer B',
                'code' => 'LAB-B',
                'location' => 'Gedung Teknologi Lantai 2',
                'capacity' => 35,
                'description' => 'Laboratorium khusus untuk praktikum desain grafis dan multimedia. Setiap PC dilengkapi dengan GPU dedicated dan monitor calibrated.',
                'facilities' => ['35 PC + GPU', 'Monitor Calibrated', 'Scanner', 'Printer', 'AC', 'Drawing Tablet'],
                'is_active' => true,
            ],
            [
                'name' => 'Lab Jaringan',
                'code' => 'LAB-NET',
                'location' => 'Gedung Teknologi Lantai 3',
                'capacity' => 25,
                'description' => 'Laboratorium khusus jaringan komputer dengan perangkat Cisco, MikroTik, dan server rack. Cocok untuk praktikum CCNA dan administrasi jaringan.',
                'facilities' => ['25 PC', 'Cisco Router', 'MikroTik', 'Server Rack', 'UPS', 'Cable Tester'],
                'is_active' => true,
            ],
            [
                'name' => 'Lab Server',
                'code' => 'LAB-SRV',
                'location' => 'Gedung Teknologi Lantai 3',
                'capacity' => 20,
                'description' => 'Laboratorium server dan cloud computing. Dilengkapi dengan server fisik untuk virtualisasi dan akses ke platform cloud.',
                'facilities' => ['20 PC', 'Physical Server', 'VMware', 'Cloud Access', 'UPS', 'Cooling System'],
                'is_active' => true,
            ],
            [
                'name' => 'Lab IoT & Robotics',
                'code' => 'LAB-IoT',
                'location' => 'Gedung Teknologi Lantai 4',
                'capacity' => 15,
                'description' => 'Laboratorium Internet of Things dan Robotika. Tersedia Arduino, Raspberry Pi, sensor, dan perangkat embedded system lainnya.',
                'facilities' => ['15 PC', 'Arduino Kit', 'Raspberry Pi', '3D Printer', 'Oscilloscope', 'Solder Station'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Diskusi',
                'code' => 'DC-01',
                'location' => 'Gedung Teknologi Lantai 1',
                'capacity' => 10,
                'description' => 'Ruang diskusi dan meeting kecil untuk kelompok. Dilengkapi TV 55 inch dan whiteboard untuk presentasi.',
                'facilities' => ['TV 55"', 'Whiteboard', 'AC', 'WiFi', 'Power Outlet', 'Webcam'],
                'is_active' => true,
            ],
            [
                'name' => 'Lab Pertanian',
                'code' => 'LAB-AGRI',
                'location' => 'Gedung Pertanian Lantai 1',
                'capacity' => 30,
                'description' => 'Laboratorium untuk praktikum budidaya tanaman dan analisis soil. Dilengkapi mikroskop dan alat uji tanah.',
                'facilities' => ['30 PC', 'Mikroskop', 'Soil Tester', 'Microscope Camera', 'AC', 'Projector'],
                'is_active' => true,
            ],
            [
                'name' => 'Lab Peternakan',
                'code' => 'LAB-TERN',
                'location' => 'Gedung Peternakan Lantai 2',
                'capacity' => 25,
                'description' => 'Laboratorium untuk praktikum nutrisi ternak dan reproduksi hewan. Dilengkapi perangkat analisis nutrisi.',
                'facilities' => ['25 PC', 'Feed Analyzer', 'Microscope', 'Centrifuge', 'AC', 'Whiteboard'],
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }
    }
}