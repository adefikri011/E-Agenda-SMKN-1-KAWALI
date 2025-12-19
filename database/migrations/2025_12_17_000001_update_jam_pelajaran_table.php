<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jam_pelajaran', function (Blueprint $table) {
            // Tambah kolom baru untuk struktur yang lebih rapi
            $table->integer('jam_ke')->nullable()->after('nama_jam');
            $table->string('hari_tipe')->nullable()->after('jam_ke'); // 'senin', 'selasa_rabu_kamis', 'jumat'
            $table->time('jam_mulai')->nullable()->after('rentang_waktu');
            $table->time('jam_selesai')->nullable()->after('jam_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jam_pelajaran', function (Blueprint $table) {
            $table->dropColumn(['jam_ke', 'hari_tipe', 'jam_mulai', 'jam_selesai']);
        });
    }
};
