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
        Schema::table('kegiatan_sebelum_kbm', function (Blueprint $table) {
            // Modify enum column to include Sabtu and Minggu
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatan_sebelum_kbm', function (Blueprint $table) {
            // Revert to original enum
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])->change();
        });
    }
};
