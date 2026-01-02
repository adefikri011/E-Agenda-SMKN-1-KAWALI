<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\User;

// Cek guru dan GuruMapel
echo "=== GURU ===\n";
$gurus = Guru::all();
foreach ($gurus as $g) {
    echo "ID: {$g->id}, Nama: {$g->nama}, Users ID: {$g->users_id}\n";
}

echo "\n=== USERS ===\n";
$users = User::all();
foreach ($users as $u) {
    echo "ID: {$u->id}, Nama: {$u->name}, Role: {$u->role}\n";
}

echo "\n=== GURU_MAPEL (pertama 10) ===\n";
$guruMapels = GuruMapel::with(['guru', 'kelas', 'mapel'])->limit(10)->get();
foreach ($guruMapels as $gm) {
    echo "ID: {$gm->id}, Guru: {$gm->guru->nama}, Kelas: {$gm->kelas->nama_kelas}, Mapel: {$gm->mapel->nama}\n";
}

echo "\n=== Jumlah GuruMapel ===\n";
echo "Total: " . GuruMapel::count() . "\n";

echo "\n=== Check Kombinasi Guru-Kelas-Mapel ===\n";
if ($gurus->count() > 0) {
    $guru = $gurus->first();
    $gmCount = GuruMapel::where('guru_id', $guru->id)->count();
    echo "Guru '{$guru->nama}' (ID: {$guru->id}) mengajar di: {$gmCount} kombinasi kelas-mapel\n";

    if ($gmCount > 0) {
        $gm = GuruMapel::where('guru_id', $guru->id)->first();
        echo "  - Contoh: Kelas {$gm->kelas->nama_kelas}, Mapel {$gm->mapel->nama}\n";
    }
}


