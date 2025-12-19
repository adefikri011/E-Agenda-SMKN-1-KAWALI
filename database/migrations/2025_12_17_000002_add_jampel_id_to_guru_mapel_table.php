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
            if (!Schema::hasColumn('guru_mapel', 'jampel_id')) {
                $table->foreignId('jampel_id')->nullable()->constrained('jam_pelajaran')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru_mapel', function (Blueprint $table) {
            if (Schema::hasColumn('guru_mapel', 'jampel_id')) {
                $table->dropForeign(['jampel_id']);
                $table->dropColumn('jampel_id');
            }
        });
    }
};
