<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodis = [
            // Budidaya Tanaman Pangan
            ['name' => 'Hortikultura', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],
            ['name' => 'Teknologi Perbenihan', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],
            ['name' => 'Teknologi Produksi Tanaman Pangan', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],
            ['name' => 'Teknologi Produksi Tanaman Hortikultura', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],
            ['name' => 'Ketahanan Pangan', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],

            // Budidaya Tanaman Perkebunan
            ['name' => 'Produksi Tanaman Perkebunan', 'jurusan' => 'Budidaya Tanaman Perkebunan', 'is_active' => true],
            ['name' => 'Produksi dan Manajemen Industri Perkebunan', 'jurusan' => 'Budidaya Tanaman Perkebunan', 'is_active' => true],
            ['name' => 'Pengelolaan Perkebunan Kopi', 'jurusan' => 'Budidaya Tanaman Perkebunan', 'is_active' => true],
            ['name' => 'Teknologi Produksi Tanaman Perkebunan', 'jurusan' => 'Budidaya Tanaman Perkebunan', 'is_active' => true],

            // Teknologi Pertanian
            ['name' => 'Teknologi Pangan', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Pengembangan Produk Agroindustri', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Kimia Terapan', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Mekanisasi Pertanian', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Teknologi Pangan Halal', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Gizi Klinis', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],

            // Peternakan
            ['name' => 'Agribisnis Peternakan', 'jurusan' => 'Peternakan', 'is_active' => true],
            ['name' => 'Teknologi Produksi Ternak', 'jurusan' => 'Peternakan', 'is_active' => true],
            ['name' => 'Teknologi Pakan Ternak', 'jurusan' => 'Peternakan', 'is_active' => true],

            // Ekonomi dan Bisnis
            ['name' => 'Perjalanan Wisata', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Agribisnis Pangan', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Pengelolaan Agribisnis', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Akuntansi Perpajakan', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Akuntansi Bisnis Digital', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Pengelolaan Perhotelan', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Pengelolaan Konvensi dan Acara', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Produksi Media', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Bisnis Digital', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Manajemen Inovasi Agribisnis', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],

            // Teknik
            ['name' => 'Teknologi Rekayasa Kimia Industri', 'jurusan' => 'Teknik', 'is_active' => true],
            ['name' => 'Teknik Sumberdaya Lahan dan Lingkungan', 'jurusan' => 'Teknik', 'is_active' => true],
            ['name' => 'Teknologi Rekayasa Kontruksi Jalan dan Jembatan', 'jurusan' => 'Teknik', 'is_active' => true],
            ['name' => 'Teknologi Rekayasa Otomotif', 'jurusan' => 'Teknik', 'is_active' => true],

            // Perikanan dan Kelautan
            ['name' => 'Perikanan Tangkap', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],
            ['name' => 'Teknologi Pembenihan Ikan', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],
            ['name' => 'Budidaya Perikanan', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],
            ['name' => 'Teknologi Akuakultur', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],
            ['name' => 'Teknologi Cerdas Penangkapan Ikan', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],

            // Teknologi Informasi
            ['name' => 'Teknologi Rekayasa Internet', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Teknologi Rekayasa Perangkat Lunak', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Manajemen Informatika', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Teknologi Rekayasa Elektronika', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Sains Data Terapan', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
        ];

        foreach ($prodis as $prodiData) {
            Prodi::create($prodiData);
        }
    }
}