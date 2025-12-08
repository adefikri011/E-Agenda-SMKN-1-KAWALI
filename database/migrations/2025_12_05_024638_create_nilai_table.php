<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->foreignId('guru_id')->constrained('users');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->enum('jenis', ['tugas', 'ulangan', 'uts', 'uas']);
            $table->integer('nilai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
