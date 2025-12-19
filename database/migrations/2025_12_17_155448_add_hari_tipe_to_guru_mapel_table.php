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
            if (!Schema::hasColumn('guru_mapel', 'hari_tipe')) {
                $table->string('hari_tipe')->nullable()->after('mapel_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru_mapel', function (Blueprint $table) {
            if (Schema::hasColumn('guru_mapel', 'hari_tipe')) {
                $table->dropColumn('hari_tipe');
            }
        });
    }
};
