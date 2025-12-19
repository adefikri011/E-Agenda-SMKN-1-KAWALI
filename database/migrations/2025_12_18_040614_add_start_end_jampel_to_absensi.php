<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('start_jampel_id')
                ->after('mapel_id')
                ->constrained('jam_pelajaran');

            $table->foreignId('end_jampel_id')
                ->after('start_jampel_id')
                ->constrained('jam_pelajaran');
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['start_jampel_id']);
            $table->dropForeign(['end_jampel_id']);
            $table->dropColumn(['start_jampel_id', 'end_jampel_id']);
        });
    }

};
