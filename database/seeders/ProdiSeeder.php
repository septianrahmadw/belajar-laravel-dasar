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
            ['name' => 'Agroteknologi', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],
            ['name' => 'Agroekoteknologi', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],
            ['name' => 'Ilmu Tanah', 'jurusan' => 'Budidaya Tanaman Pangan', 'is_active' => true],

            // Budidaya Tanaman Perkebunan
            ['name' => 'Kultivasi Tanaman Perkebunan', 'jurusan' => 'Budidaya Tanaman Perkebunan', 'is_active' => true],
            ['name' => 'Teknologi Industri Pertanian', 'jurusan' => 'Budidaya Tanaman Perkebunan', 'is_active' => true],

            // Teknologi Pertanian
            ['name' => 'Teknologi Pangan', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Teknik Pertanian', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],
            ['name' => 'Agroindustri', 'jurusan' => 'Teknologi Pertanian', 'is_active' => true],

            // Peternakan
            ['name' => 'Peternakan', 'jurusan' => 'Peternakan', 'is_active' => true],
            ['name' => 'Produksi Ternak', 'jurusan' => 'Peternakan', 'is_active' => true],
            ['name' => 'Ilmu Nutrisi dan Teknologi Pakan', 'jurusan' => 'Peternakan', 'is_active' => true],

            // Ekonomi dan Bisnis
            ['name' => 'Ekonomi Pembangunan', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Manajemen', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],
            ['name' => 'Akuntansi', 'jurusan' => 'Ekonomi dan Bisnis', 'is_active' => true],

            // Teknik
            ['name' => 'Teknik Informatika', 'jurusan' => 'Teknik', 'is_active' => true],
            ['name' => 'Teknik Elektro', 'jurusan' => 'Teknik', 'is_active' => true],
            ['name' => 'Teknik Mesin', 'jurusan' => 'Teknik', 'is_active' => true],

            // Perikanan dan Kelautan
            ['name' => 'Ilmu Kelautan', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],
            ['name' => 'Perikanan', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],
            ['name' => 'Akuakultur', 'jurusan' => 'Perikanan dan Kelautan', 'is_active' => true],

            // Teknologi Informasi
            ['name' => 'Sistem Informasi', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Teknik Informatika', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Ilmu Komputer', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
            ['name' => 'Teknologi Rekayasa Perangkat Lunak', 'jurusan' => 'Teknologi Informasi', 'is_active' => true],
        ];

        foreach ($prodis as $prodiData) {
            Prodi::create($prodiData);
        }
    }
}