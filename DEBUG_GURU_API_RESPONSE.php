<?php
/**
 * DEBUGGING SCRIPT - Guru API Response
 *
 * USER INSTRUCTION:
 * 1. Buka browser, bersihkan cache (Ctrl+Shift+Delete)
 * 2. Login sebagai guru (misal: doni)
 * 3. Buka halaman "Input Agenda"
 * 4. Buka F12 → Console tab
 * 5. Pilih Kelas dari dropdown (misal: X AK 1 untuk guru doni)
 * 6. Lihat log di Console:
 *    - "Mapels received from API:" - ini adalah response API
 *    - Check: apakah ada mapel? apakah ada gurus data?
 * 7. Lihat di Network tab → /agenda/get-mapel-by-kelas/
 *    - Check response JSON - format harus seperti:
 *      [
 *        {
 *          "id": 2,
 *          "nama": "Bahasa Inggris",
 *          "gurus": [
 *            { "guru_id": 3, "guru_nama": "hasan" }
 *          ]
 *        }
 *      ]
 * 8. Server log check:
 *    - Run: Get-Content storage/logs/laravel.log | Select-Object -Last 50
 *    - Look for "GuruMapel results for guru" - apakah count > 0?
 *
 * EXPECTED BEHAVIOR:
 *
 * === UNTUK GURU ===
 * 1. Pilih kelas → API fetch mata pelajaran yang dia ajar di kelas itu
 * 2. Mata pelajaran muncul dengan nama guru di parenthesis
 * 3. Pilih mata pelajaran → guru_nama auto-fill di "Pengampu Mata Pelajaran"
 * 4. guru_id tersimpan hidden input
 *
 * === UNTUK SISWA ===
 * 1. Pilih kelas → API fetch semua mata pelajaran di kelas itu
 * 2. Setiap mata pelajaran tampil dengan semua guru yang mengajar
 * 3. Pilih mata pelajaran → jika 1 guru, auto-fill; jika >1, tampil modal pilih guru
 */

echo "=== DEBUGGING CHECKLIST ===\n\n";
echo "STEP 1: Check Server Logs\n";
echo "- Run: Get-Content storage/logs/laravel.log | Select-Object -Last 50\n";
echo "- Look for \"GuruMapel results for guru\"\n";
echo "- Verify count > 0 dan raw_data shows kelas dan mapel\n\n";

echo "STEP 2: Check API Response (F12 → Network)\n";
echo "- Click /agenda/get-mapel-by-kelas/{kelasId}\n";
echo "- Response tab - harus ada gurus array dengan guru_id dan guru_nama\n\n";

echo "STEP 3: Check Browser Console (F12 → Console)\n";
echo "- Pilih kelas → lihat \"Mapels received from API\"\n";
echo "- Verify struktur:\n";
echo "  - mapels.length > 0\n";
echo "  - mapels[0].gurus adalah array\n";
echo "  - mapels[0].gurus[0].guru_nama ada nilai (bukan undefined)\n\n";

echo "STEP 4: Test Selection\n";
echo "- Pilih mata pelajaran dari dropdown\n";
echo "- Check console: \"Mapel selected:\" log harus tampil\n";
echo "- Verify gurus array populated\n";
echo "- Lihat \"Pengampu Mata Pelajaran\" box\n";
echo "- Seharusnya tampil nama guru (bukan undefined)\n\n";

echo "JIKA MASIH UNDEFINED:\n";
echo "- Check di Network tab: response API struktur gurus array-nya\n";
echo "- Lihat storage/logs/laravel.log - apakah GuruMapel query return data?\n";
echo "- Possible issue: Guru tidak punya data di GuruMapel tabel untuk kelas itu\n";
?>
