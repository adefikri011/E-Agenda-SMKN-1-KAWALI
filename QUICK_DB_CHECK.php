<?php
/**
 * Quick Database Check Script
 * Run: php artisan tinker
 * Then paste these commands:
 */

echo "=== QUICK DEBUG COMMANDS ===\n\n";

echo "1. Check Guru User Relationship:\n";
echo "   \$user = App\\Models\\User::find(7); // User ID dari guru yang login\n";
echo "   \$user->guru; // Seharusnya return guru record\n";
echo "   \$user->guru->id; // Seharusnya return guru ID (misal: 3)\n\n";

echo "2. Check GuruMapel for Specific Guru:\n";
echo "   \$guru = App\\Models\\Guru::find(3); // guru ID for 'hasan'\n";
echo "   \$guru->mapels()->where('kelas_id', 15)->get(); // Check kelas 15 (XII AK 2)\n";
echo "   // Seharusnya return 1 record (Bahasa Inggris)\n\n";

echo "3. Check All GuruMapel Relationships:\n";
echo "   App\\Models\\GuruMapel::where('guru_id', 3)->get();\n";
echo "   // Seharusnya return 2 records untuk guru hasan\n\n";

echo "4. Simulate API Response:\n";
echo "   \$kelas_id = 15; // XII AK 2\n";
echo "   \$guru_id = 3; // hasan\n";
echo "   \$guruMapels = App\\Models\\GuruMapel::where('guru_id', \$guru_id)\n";
echo "     ->where('kelas_id', \$kelas_id)\n";
echo "     ->with(['mapel', 'guru'])\n";
echo "     ->get();\n";
echo "   \$guruMapels->count(); // Should be 1\n";
echo "   \$guruMapels[0]->mapel->nama; // Should be 'Bahasa Inggris'\n";
echo "   \$guruMapels[0]->guru->nama; // Should be 'hasan'\n\n";

echo "=== EXPECTED DATA ===\n\n";
echo "Guru: hasan (ID: 3)\n";
echo "- Kelas XII DPIB 1: Matematika\n";
echo "- Kelas XII AK 2: Bahasa Inggris\n\n";

echo "When guru hasan selects kelas XII AK 2:\n";
echo "API should return:\n";
echo "[\n";
echo "  {\n";
echo "    \"id\": 2,\n";
echo "    \"nama\": \"Bahasa Inggris\",\n";
echo "    \"gurus\": [\n";
echo "      { \"guru_id\": 3, \"guru_nama\": \"hasan\" }\n";
echo "    ]\n";
echo "  }\n";
echo "]\n";
?>
