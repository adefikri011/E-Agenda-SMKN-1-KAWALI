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
        Schema::table('guru_mapel', function (Blueprint $table) {
            if (!Schema::hasColumn('guru_mapel', 'start_jampel_id')) {
                $table->foreignId('start_jampel_id')->nullable()->constrained('jam_pelajaran')->onDelete('set null');
            }
            if (!Schema::hasColumn('guru_mapel', 'end_jampel_id')) {
                $table->foreignId('end_jampel_id')->nullable()->constrained('jam_pelajaran')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru_mapel', function (Blueprint $table) {
            if (Schema::hasColumn('guru_mapel', 'start_jampel_id')) {
                $table->dropForeign(['start_jampel_id']);
                $table->dropColumn('start_jampel_id');
            }
            if (Schema::hasColumn('guru_mapel', 'end_jampel_id')) {
                $table->dropForeign(['end_jampel_id']);
                $table->dropColumn('end_jampel_id');
            }
        });
    }
};
