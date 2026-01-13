<?php

use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Buat fake request
$request = Illuminate\Http\Request::capture();

// Cek apakah file ada
$filePath = 'import_kelas.xlsx';
if (!file_exists($filePath)) {
    echo "File tidak ditemukan: $filePath\n";
    exit(1);
}

echo "Mulai import dari: $filePath\n";

try {
    $import = new KelasImport();
    Excel::import($import, $filePath);

    echo "\n=== HASIL IMPORT ===\n";
    echo "Success: " . $import->successCount . "\n";
    echo "Failed: " . $import->failureCount . "\n";

    if (!empty($import->failures)) {
        echo "\nFailures details:\n";
        foreach ($import->failures as $failure) {
            echo "- " . json_encode($failure) . "\n";
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
