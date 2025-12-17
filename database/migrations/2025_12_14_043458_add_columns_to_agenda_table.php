<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            // Tambahkan kolom untuk mendukung siswa membuat agenda
            $table->enum('pembuat', ['guru', 'siswa'])->default('guru')->after('users_id');
            $table->enum('status_ttd', ['belum', 'sudah'])->default('belum')->after('pembuat');
            $table->foreignId('guru_ttd_id')->nullable()->after('status_ttd')->constrained('users');
            $table->timestamp('waktu_ttd')->nullable()->after('guru_ttd_id');

            // Ubah default value untuk kolom tanda_tangan
            $table->longText('tanda_tangan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->dropColumn(['pembuat', 'status_ttd', 'guru_ttd_id', 'waktu_ttd']);
        });
    }
};
