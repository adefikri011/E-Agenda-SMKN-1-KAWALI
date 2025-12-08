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
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('users_id')->constrained('users');
            $table->date('tanggal');
            $table->text('isi_agenda');
            $table->string('tanda_tangan')->nullable();
            $table->boolean('sudah_ttd')->default(false);
            $table->timestamp('waktu_ttd')->nullable();
            $table->foreignId('ditandatangani_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
};
