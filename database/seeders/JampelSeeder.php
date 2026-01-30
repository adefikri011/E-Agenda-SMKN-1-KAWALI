<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jampel;
use Illuminate\Support\Facades\Schema;

class JampelSeeder extends Seeder
{
    public function run(): void
    {
        // 🔓 Matikan FK sementara
        Schema::disableForeignKeyConstraints();
        Jampel::truncate();
        // 🔒 Hidupkan lagi FK
        Schema::enableForeignKeyConstraints();

        $jampelData = [
            // SENIN (berdasarkan gambar)
            ['jam_ke' => 1, 'nama_jam' => 'Upacara', 'rentang_waktu' => '06:30 - 07:15', 'jam_mulai' => '06:30', 'jam_selesai' => '07:15', 'hari_tipe' => 'senin'],
            ['jam_ke' => 2, 'nama_jam' => 'Jam 2', 'rentang_waktu' => '07:15 - 07:55', 'jam_mulai' => '07:15', 'jam_selesai' => '07:55', 'hari_tipe' => 'senin'],
            ['jam_ke' => 3, 'nama_jam' => 'Jam 3', 'rentang_waktu' => '07:55 - 08:35', 'jam_mulai' => '07:55', 'jam_selesai' => '08:35', 'hari_tipe' => 'senin'],
            ['jam_ke' => 4, 'nama_jam' => 'Jam 4', 'rentang_waktu' => '08:35 - 09:15', 'jam_mulai' => '08:35', 'jam_selesai' => '09:15', 'hari_tipe' => 'senin'],
            ['jam_ke' => 5, 'nama_jam' => 'Jam 5', 'rentang_waktu' => '09:15 - 09:55', 'jam_mulai' => '09:15', 'jam_selesai' => '09:55', 'hari_tipe' => 'senin'],
            ['jam_ke' => 6, 'nama_jam' => 'Jam 6', 'rentang_waktu' => '09:55 - 10:35', 'jam_mulai' => '09:55', 'jam_selesai' => '10:35', 'hari_tipe' => 'senin'],
            ['jam_ke' => 7, 'nama_jam' => 'Jam 7', 'rentang_waktu' => '10:35 - 11:15', 'jam_mulai' => '10:35', 'jam_selesai' => '11:15', 'hari_tipe' => 'senin'],
            ['jam_ke' => 8, 'nama_jam' => 'MBG', 'rentang_waktu' => '11:15 - 12:45', 'jam_mulai' => '11:15', 'jam_selesai' => '12:45', 'hari_tipe' => 'senin'],
            ['jam_ke' => 9, 'nama_jam' => 'Jam 9', 'rentang_waktu' => '12:45 - 13:20', 'jam_mulai' => '12:45', 'jam_selesai' => '13:20', 'hari_tipe' => 'senin'],
            ['jam_ke' => 10, 'nama_jam' => 'Jam 10', 'rentang_waktu' => '13:20 - 14:00', 'jam_mulai' => '13:20', 'jam_selesai' => '14:00', 'hari_tipe' => 'senin'],
            ['jam_ke' => 11, 'nama_jam' => 'Jam 11', 'rentang_waktu' => '14:00 - 15:05', 'jam_mulai' => '14:00', 'jam_selesai' => '15:05', 'hari_tipe' => 'senin'],
            ['jam_ke' => 12, 'nama_jam' => 'Jam 12', 'rentang_waktu' => '15:05 - 16:00', 'jam_mulai' => '15:05', 'jam_selesai' => '16:00', 'hari_tipe' => 'senin'],

            // SELASA-RABU-KAMIS (berdasarkan gambar)
            ['jam_ke' => 1, 'nama_jam' => 'Pembiasaan Positif', 'rentang_waktu' => '06:30 - 07:00', 'jam_mulai' => '06:30', 'jam_selesai' => '07:00', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 2, 'nama_jam' => 'Jam 2', 'rentang_waktu' => '07:00 - 07:40', 'jam_mulai' => '07:00', 'jam_selesai' => '07:40', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 3, 'nama_jam' => 'Jam 3', 'rentang_waktu' => '07:40 - 08:20', 'jam_mulai' => '07:40', 'jam_selesai' => '08:20', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 4, 'nama_jam' => 'Jam 4', 'rentang_waktu' => '08:20 - 09:00', 'jam_mulai' => '08:20', 'jam_selesai' => '09:00', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 5, 'nama_jam' => 'Jam 5', 'rentang_waktu' => '09:00 - 09:40', 'jam_mulai' => '09:00', 'jam_selesai' => '09:40', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 6, 'nama_jam' => 'Jam 6', 'rentang_waktu' => '09:40 - 10:20', 'jam_mulai' => '09:40', 'jam_selesai' => '10:20', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 7, 'nama_jam' => 'Jam 7', 'rentang_waktu' => '10:20 - 11:00', 'jam_mulai' => '10:20', 'jam_selesai' => '11:00', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 8, 'nama_jam' => 'Jam 8', 'rentang_waktu' => '11:00 - 11:40', 'jam_mulai' => '11:00', 'jam_selesai' => '11:40', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 9, 'nama_jam' => 'Jam 9', 'rentang_waktu' => '11:40 - 12:20', 'jam_mulai' => '11:40', 'jam_selesai' => '12:20', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 10, 'nama_jam' => 'Jam 10', 'rentang_waktu' => '12:20 - 13:00', 'jam_mulai' => '12:20', 'jam_selesai' => '13:00', 'hari_tipe' => 'selasa_rabu_kamis'],
            ['jam_ke' => 11, 'nama_jam' => 'Jam 11', 'rentang_waktu' => '13:00 - 13:40', 'jam_mulai' => '13:00', 'jam_selesai' => '13:40', 'hari_tipe' => 'selasa_rabu_kamis'],

            // JUMAT (berdasarkan gambar)
            ['jam_ke' => 1, 'nama_jam' => 'Kegiatan Keagamaan', 'rentang_waktu' => '06:30 - 07:00', 'jam_mulai' => '06:30', 'jam_selesai' => '07:00', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 2, 'nama_jam' => 'Jam 2', 'rentang_waktu' => '07:00 - 07:40', 'jam_mulai' => '07:00', 'jam_selesai' => '07:40', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 3, 'nama_jam' => 'Jam 3', 'rentang_waktu' => '07:40 - 08:20', 'jam_mulai' => '07:40', 'jam_selesai' => '08:20', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 4, 'nama_jam' => 'Jam 4', 'rentang_waktu' => '08:20 - 09:00', 'jam_mulai' => '08:20', 'jam_selesai' => '09:00', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 5, 'nama_jam' => 'Jam 5', 'rentang_waktu' => '09:00 - 09:40', 'jam_mulai' => '09:00', 'jam_selesai' => '09:40', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 6, 'nama_jam' => 'Jam 6', 'rentang_waktu' => '09:40 - 10:20', 'jam_mulai' => '09:40', 'jam_selesai' => '10:20', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 7, 'nama_jam' => 'Jam 7', 'rentang_waktu' => '10:20 - 11:00', 'jam_mulai' => '10:20', 'jam_selesai' => '11:00', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 8, 'nama_jam' => 'Jam 8', 'rentang_waktu' => '11:00 - 11:40', 'jam_mulai' => '11:00', 'jam_selesai' => '11:40', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 9, 'nama_jam' => 'Jam 9', 'rentang_waktu' => '11:40 - 12:20', 'jam_mulai' => '11:40', 'jam_selesai' => '12:20', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 10, 'nama_jam' => 'Jam 10', 'rentang_waktu' => '12:20 - 13:00', 'jam_mulai' => '12:20', 'jam_selesai' => '13:00', 'hari_tipe' => 'jumat'],
            ['jam_ke' => 11, 'nama_jam' => 'Jam 11', 'rentang_waktu' => '13:00 - 13:40', 'jam_mulai' => '13:00', 'jam_selesai' => '13:40', 'hari_tipe' => 'jumat'],
        ];

        foreach ($jampelData as $jampel) {
            Jampel::create($jampel);
        }
    }
}
