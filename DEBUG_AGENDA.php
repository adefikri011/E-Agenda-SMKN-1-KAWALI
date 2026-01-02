<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Get the app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check the logged in user
$userId = auth()->id() ?? 1; // Default to user 1 for testing

echo "=== DEBUG AGENDA ===\n";
echo "User ID: " . $userId . "\n\n";

// Query 1: Agenda created by user
$agendaByUser = Agenda::where('users_id', $userId)
    ->with(['jampel', 'kelas'])
    ->orderBy('tanggal', 'desc')
    ->limit(5)
    ->get();

echo "Agenda created by user (users_id = $userId):\n";
echo "Count: " . $agendaByUser->count() . "\n";
foreach($agendaByUser as $a) {
    echo "  - ID: {$a->id}, Tanggal: {$a->tanggal}, Mata Pelajaran: {$a->mata_pelajaran}, Kelas ID: {$a->kelas_id}\n";
}

echo "\n";

// Query 2: Agenda signed by user
$agendaSigned = Agenda::where('ditandatangani_oleh', $userId)
    ->with(['jampel', 'kelas'])
    ->orderBy('tanggal', 'desc')
    ->limit(5)
    ->get();

echo "Agenda signed by user (ditandatangani_oleh = $userId):\n";
echo "Count: " . $agendaSigned->count() . "\n";
foreach($agendaSigned as $a) {
    echo "  - ID: {$a->id}, Tanggal: {$a->tanggal}, Mata Pelajaran: {$a->mata_pelajaran}, Kelas ID: {$a->kelas_id}\n";
}

echo "\n";

// Query 3: All agendas
$allAgendas = Agenda::orderBy('tanggal', 'desc')->limit(10)->get();
echo "All agendas (top 10):\n";
echo "Count: " . $allAgendas->count() . "\n";
foreach($allAgendas as $a) {
    echo "  - ID: {$a->id}, users_id: {$a->users_id}, ditandatangani_oleh: {$a->ditandatangani_oleh}, Tanggal: {$a->tanggal}, Mata Pelajaran: {$a->mata_pelajaran}\n";
}

echo "\n=== END DEBUG ===\n";
