<?php
/**
 * Test script untuk memverifikasi guru dapat login dan akses create agenda
 *
 * Instruksi:
 * 1. Login dengan guru user (misal user doni)
 * 2. Klik "Input Agenda"
 * 3. Buka browser F12 → Console tab
 * 4. Pilih kelas dari dropdown
 * 5. Lihat response di Network tab untuk /agenda/get-mapel-by-kelas/
 * 6. Check apakah mata pelajaran muncul dan guru_id terisi
 */

// Data guru-mapel yang tersedia di database:
$guruMapel = [
    [
        'guru_nama' => 'doni',
        'guru_id' => 1,
        'kelas_nama' => 'X AK 1',
        'mapel_nama' => 'Matematika',
        'status' => '✓ Seharusnya berfungsi'
    ],
    [
        'guru_nama' => 'Haland',
        'guru_id' => 2,
        'kelas_nama' => 'X TKJ 10',
        'mapel_nama' => 'Bahasa Inggris',
        'status' => '✓ Seharusnya berfungsi'
    ],
    [
        'guru_nama' => 'hasan',
        'guru_id' => 3,
        'kelas_nama' => 'XII DPIB 1',
        'mapel_nama' => 'Matematika',
        'status' => '✓ Seharusnya berfungsi'
    ],
    [
        'guru_nama' => 'asep kuda',
        'guru_id' => 4,
        'kelas_nama' => 'XII DPIB 1',
        'mapel_nama' => 'Bahasa Inggris',
        'status' => '✓ Seharusnya berfungsi'
    ],
    [
        'guru_nama' => 'Haland',
        'guru_id' => 2,
        'kelas_nama' => 'XII AK 2',
        'mapel_nama' => 'bahasa arab',
        'status' => '✓ Seharusnya berfungsi'
    ],
    [
        'guru_nama' => 'hasan',
        'guru_id' => 3,
        'kelas_nama' => 'XII AK 2',
        'mapel_nama' => 'Bahasa Inggris',
        'status' => '✓ Seharusnya berfungsi'
    ]
];

echo "=== TEST GURU MAPEL FRONTEND ===\n\n";

echo "Kombinasi Guru-Kelas-Mata Pelajaran yang Valid:\n";
echo str_repeat("-", 80) . "\n";
printf("%-15s | %-20s | %-20s | %s\n", "GURU", "KELAS", "MAPEL", "STATUS");
echo str_repeat("-", 80) . "\n";

foreach ($guruMapel as $gm) {
    printf("%-15s | %-20s | %-20s | %s\n",
        $gm['guru_nama'],
        $gm['kelas_nama'],
        $gm['mapel_nama'],
        $gm['status']
    );
}

echo "\n\n=== LANGKAH DEBUGGING ===\n";
echo "1. Login dengan guru (misal: doni)\n";
echo "2. Buka halaman Input Agenda\n";
echo "3. Pilih kelas dari dropdown (harus dari list: X AK 1, X TKJ 10, XII DPIB 1, XII AK 2)\n";
echo "4. Buka F12 → Network tab\n";
echo "5. Pilih mata pelajaran → cek response dari API /agenda/get-mapel-by-kelas/\n";
echo "6. Verifikasi:\n";
echo "   - Apakah mata pelajaran muncul?\n";
echo "   - Apakah guru nama tampil di dropdown?\n";
echo "   - Apakah guru_id terisi otomatis?\n";
echo "7. Isi form lengkap dan submit\n";
echo "8. Check storage/logs/laravel.log untuk error detail\n";
echo "\n";
echo "Jika masih error:\n";
echo "- Check browser console (F12 → Console) untuk JavaScript error\n";
echo "- Check Network tab untuk HTTP error responses\n";
echo "- Report error code dan message yang muncul\n";
?>
