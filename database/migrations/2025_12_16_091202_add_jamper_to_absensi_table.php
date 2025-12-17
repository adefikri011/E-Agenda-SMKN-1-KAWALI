<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('jampel_id')->after('mapel_id')->constrained('jam_pelajaran');
            $table->integer('pertemuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['jampel_id']);
            $table->dropColumn(['jampel_id', 'pertemuan']);
        });
    }
};
