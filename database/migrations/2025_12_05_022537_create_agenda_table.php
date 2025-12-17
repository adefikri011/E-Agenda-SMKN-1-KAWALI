<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('jampel_id')->constrained('jam_pelajaran');
            $table->date('tanggal');
            $table->string('mata_pelajaran');
            $table->text('materi');
            $table->text('kegiatan');
            $table->text('catatan')->nullable();
            $table->longText('tanda_tangan')->nullable();  // Changed to longText untuk data URL
            $table->boolean('sudah_ttd')->default(true);  // Default true karena sudah ada TTD saat create
            $table->foreignId('ditandatangani_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
};
