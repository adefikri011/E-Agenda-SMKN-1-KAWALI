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
        Schema::table('agenda', function (Blueprint $table) {
            // Tambahkan kolom start_jampel_id dan end_jampel_id
            $table->foreignId('start_jampel_id')->nullable()->after('tanggal')->constrained('jam_pelajaran');
            $table->foreignId('end_jampel_id')->nullable()->after('start_jampel_id')->constrained('jam_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->dropForeignIdFor('start_jampel_id');
            $table->dropForeignIdFor('end_jampel_id');
            $table->dropColumn(['start_jampel_id', 'end_jampel_id']);
        });
    }
};
