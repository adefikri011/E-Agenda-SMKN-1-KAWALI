<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jampel;

class AddJampelSeeder extends Seeder
{
    public function run()
    {
        $toAdd = [
            ['hari'=>'senin','jam_ke'=>4,'nama'=>'Jam 4','mulai'=>'08:35','selesai'=>'09:15','rentang'=>'08:35-09:15'],
            ['hari'=>'senin','jam_ke'=>5,'nama'=>'Jam 5','mulai'=>'09:30','selesai'=>'10:10','rentang'=>'09:30-10:10'],
            ['hari'=>'senin','jam_ke'=>6,'nama'=>'Jam 6','mulai'=>'10:10','selesai'=>'10:50','rentang'=>'10:10-10:50'],
            ['hari'=>'senin','jam_ke'=>7,'nama'=>'Jam 7','mulai'=>'10:50','selesai'=>'11:30','rentang'=>'10:50-11:30'],
            ['hari'=>'senin','jam_ke'=>8,'nama'=>'Jam 8','mulai'=>'12:45','selesai'=>'13:20','rentang'=>'12:45-13:20'],
            ['hari'=>'senin','jam_ke'=>9,'nama'=>'Jam 9','mulai'=>'13:20','selesai'=>'14:00','rentang'=>'13:20-14:00'],
            ['hari'=>'senin','jam_ke'=>10,'nama'=>'Jam 10','mulai'=>'14:00','selesai'=>'14:40','rentang'=>'14:00-14:40'],
            ['hari'=>'senin','jam_ke'=>11,'nama'=>'Jam 11','mulai'=>'14:40','selesai'=>'15:20','rentang'=>'14:40-15:20'],

            ['hari'=>'selasa_rabu_kamis','jam_ke'=>5,'nama'=>'Jam 5','mulai'=>'09:15','selesai'=>'09:55','rentang'=>'09:15-09:55'],
            ['hari'=>'selasa_rabu_kamis','jam_ke'=>6,'nama'=>'Jam 6','mulai'=>'09:55','selesai'=>'10:35','rentang'=>'09:55-10:35'],
            ['hari'=>'selasa_rabu_kamis','jam_ke'=>7,'nama'=>'Jam 7','mulai'=>'10:35','selesai'=>'11:15','rentang'=>'10:35-11:15'],
            ['hari'=>'selasa_rabu_kamis','jam_ke'=>8,'nama'=>'Jam 8','mulai'=>'11:15','selesai'=>'11:45','rentang'=>'11:15-11:45'],
            ['hari'=>'selasa_rabu_kamis','jam_ke'=>9,'nama'=>'Jam 9','mulai'=>'12:45','selesai'=>'13:20','rentang'=>'12:45-13:20'],
            ['hari'=>'selasa_rabu_kamis','jam_ke'=>10,'nama'=>'Jam 10','mulai'=>'13:20','selesai'=>'14:00','rentang'=>'13:20-14:00'],
            ['hari'=>'selasa_rabu_kamis','jam_ke'=>11,'nama'=>'Jam 11','mulai'=>'14:00','selesai'=>'14:40','rentang'=>'14:00-14:40'],

            ['hari'=>'jumat','jam_ke'=>5,'nama'=>'Jam 5','mulai'=>'09:15','selesai'=>'09:55','rentang'=>'09:15-09:55'],
            ['hari'=>'jumat','jam_ke'=>6,'nama'=>'Jam 6','mulai'=>'09:55','selesai'=>'10:35','rentang'=>'09:55-10:35'],
            ['hari'=>'jumat','jam_ke'=>7,'nama'=>'Jam 7','mulai'=>'10:35','selesai'=>'11:15','rentang'=>'10:35-11:15'],
            ['hari'=>'jumat','jam_ke'=>8,'nama'=>'Jam 8','mulai'=>'11:15','selesai'=>'11:45','rentang'=>'11:15-11:45'],
            ['hari'=>'jumat','jam_ke'=>9,'nama'=>'Jam 9','mulai'=>'12:45','selesai'=>'13:20','rentang'=>'12:45-13:20'],
            ['hari'=>'jumat','jam_ke'=>10,'nama'=>'Jam 10','mulai'=>'13:20','selesai'=>'14:00','rentang'=>'13:20-14:00'],
        ];

        foreach ($toAdd as $t) {
            $exists = Jampel::where('hari_tipe', $t['hari'])->where('jam_ke', $t['jam_ke'])->first();
            if (!$exists) {
                Jampel::create([
                    'nama_jam' => $t['nama'],
                    'rentang_waktu' => $t['rentang'],
                    'jam_ke' => $t['jam_ke'],
                    'hari_tipe' => $t['hari'],
                    'jam_mulai' => $t['mulai'],
                    'jam_selesai' => $t['selesai'],
                ]);
            }
        }
    }
}
