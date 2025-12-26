<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kegiatan_sebelum_kbm', function (Blueprint $table) {
            if (!Schema::hasColumn('kegiatan_sebelum_kbm', 'jurusan_id')) {
                $table->unsignedBigInteger('jurusan_id')->nullable()->after('kegiatan');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kegiatan_sebelum_kbm', function (Blueprint $table) {
            if (Schema::hasColumn('kegiatan_sebelum_kbm', 'jurusan_id')) {
                $table->dropColumn('jurusan_id');
            }
        });
    }
};
