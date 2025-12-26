<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Guru;
use App\Models\User;
use App\Models\Kelas;
use App\Models\DetailAbsensi;
use App\Models\KegiatanSebelumKBM;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index() {
        // Ambil agenda hari ini saja (max 3) untuk landing page
        $agendas = Agenda::with(['kelas', 'jampel', 'startJampel', 'endJampel'])
            ->whereDate('tanggal', today())
            ->orderBy('tanggal', 'asc')
            ->limit(3)
            ->get();

        // Ambil kegiatan pre-KBM hari ini untuk bagian Sekretaris
        $hariIni = now()->translatedFormat('l'); // Misal: 'Senin', 'Selasa', dll
        // Map English day names to Indonesian
        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $hariIndonesia = $hariMap[now()->format('l')] ?? 'Senin';

        // Determine jurusan for current user if available
        $jurusanId = null;
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->getKelasAttribute()) {
                $jurusanId = $user->getKelasAttribute()->jurusan_id ?? null;
            } elseif ($user->kelasAsWali) {
                $jurusanId = $user->kelasAsWali->jurusan_id ?? null;
            }
        }

        // For Monday (Senin) we show the general activities (same for all jurusan)
        if ($hariIndonesia === 'Senin') {
            $kegiatanPreKBM = KegiatanSebelumKBM::where('hari', $hariIndonesia)
                ->limit(3)
                ->get();
        } else {
            // Prefer jurusan-specific activities, fallback to general (jurusan_id = null), then recent
            if ($jurusanId) {
                $kegiatanPreKBM = KegiatanSebelumKBM::where('hari', $hariIndonesia)
                    ->where('jurusan_id', $jurusanId)
                    ->limit(3)
                    ->get();

                if ($kegiatanPreKBM->isEmpty()) {
                    $kegiatanPreKBM = KegiatanSebelumKBM::where('hari', $hariIndonesia)
                        ->whereNull('jurusan_id')
                        ->limit(3)
                        ->get();
                }
            } else {
                $kegiatanPreKBM = KegiatanSebelumKBM::where('hari', $hariIndonesia)
                    ->whereNull('jurusan_id')
                    ->limit(3)
                    ->get();
            }

            if (empty($kegiatanPreKBM) || $kegiatanPreKBM->isEmpty()) {
                $kegiatanPreKBM = KegiatanSebelumKBM::orderBy('created_at', 'desc')->limit(3)->get();
            }
        }

        // Determine selected jurusan for display (if any)
        $selectedJurusan = null;
        if (isset($jurusanId) && $jurusanId) {
            $selectedJurusan = Jurusan::find($jurusanId);
        }

        // If not set and first kegiatan has jurusan_id, use that
        if (!$selectedJurusan && isset($kegiatanPreKBM) && $kegiatanPreKBM->isNotEmpty()) {
            $first = $kegiatanPreKBM->first();
            if (!empty($first->jurusan_id)) {
                $selectedJurusan = Jurusan::find($first->jurusan_id);
            }
        }

        // Data untuk Dashboard Admin
        $adminStats = [
            'guru_aktif' => Guru::count(),
            'siswa_aktif' => User::where('role', 'siswa')->count(),
            'kelas_aktif' => Kelas::count(),
            'kehadiran' => $this->hitungPersentaseKehadiran(),
        ];

        return view('landing_page.index', compact('agendas', 'adminStats', 'kegiatanPreKBM', 'selectedJurusan'));
    }

    private function hitungPersentaseKehadiran()
    {
        // Hitung persentase kehadiran dari data absensi
        $totalAbsensi = DetailAbsensi::count();

        if ($totalAbsensi == 0) {
            return 0;
        }

        $hadir = DetailAbsensi::where('status', 'hadir')->count();
        $persentase = round(($hadir / $totalAbsensi) * 100);

        return min($persentase, 100); // Pastikan tidak lebih dari 100%
    }
}


