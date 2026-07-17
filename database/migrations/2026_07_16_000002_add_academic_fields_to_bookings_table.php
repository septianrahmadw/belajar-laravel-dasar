<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('jurusan')->after('booker_phone');
            $table->foreignId('prodi_id')->nullable()->after('jurusan')->constrained('prodis')->nullOnDelete();
            $table->string('mata_kuliah')->after('prodi_id');
            $table->integer('semester')->after('mata_kuliah');
            $table->string('kelas')->after('semester');
            $table->string('dosen')->after('kelas');
            $table->string('teknisi')->nullable()->after('dosen');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn(['jurusan', 'prodi_id', 'mata_kuliah', 'semester', 'kelas', 'dosen', 'teknisi']);
        });
    }
};
