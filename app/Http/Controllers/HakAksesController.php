<?php

namespace App\Http\Controllers;

use App\Models\DetailAbsensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Agenda;
use App\Models\Absensi;
use App\Models\GuruMapel;
use Illuminate\Support\Facades\DB;


class HakAksesController extends Controller
{
    function admin()
    {
        // 1. Hitung Total Siswa
        $totalSiswa = Siswa::count();

        // 2. Hitung Total Guru
        $totalGuru = Guru::count();

        // 3. Hitung Total Kelas
        $totalKelas = Kelas::count();

        // 4. Hitung Total Jurusan (dari Jurusan model)
        $totalJurusan = \App\Models\Jurusan::count();

        // 5. Hitung Total Mata Pelajaran
        $totalMapel = MataPelajaran::count();

        // 6. Hitung Total Agenda
        $totalAgenda = Agenda::count();

        // 7. Hitung Absensi Hari Ini
        $today = now()->format('Y-m-d');
        $absensiHariIni = DetailAbsensi::whereHas('absensi', function ($query) use ($today) {
            $query->whereDate('tanggal', $today);
        })->count();

        $kehadiranHariIni = DetailAbsensi::whereHas('absensi', function ($query) use ($today) {
            $query->whereDate('tanggal', $today);
        })->where('status', 'hadir')->count();

        // 8. Hitung Agenda Hari Ini
        $agendaHariIni = Agenda::whereDate('tanggal', $today)->count();

        // 9. Hitung Agenda Sudah Ditandatangani (Selesai)
        $agendaSelesai = Agenda::where('sudah_ttd', true)->count();

        // 10. Hitung Agenda Belum Ditandatangani (Dalam Proses)
        $agendaDalamProses = Agenda::where('sudah_ttd', false)->count();

        // 11. Persentase Kehadiran
        $persentaseKehadiran = $absensiHariIni > 0 ? round(($kehadiranHariIni / $absensiHariIni) * 100, 1) : 0;

        // 12. Detail Absensi Hari Ini (breakdown)
        $detailAbsensiHariIni = [
            'hadir' => DetailAbsensi::whereHas('absensi', function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            })->where('status', 'hadir')->count(),
            'izin' => DetailAbsensi::whereHas('absensi', function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            })->where('status', 'izin')->count(),
            'sakit' => DetailAbsensi::whereHas('absensi', function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            })->where('status', 'sakit')->count(),
            'alpha' => DetailAbsensi::whereHas('absensi', function ($query) use ($today) {
                $query->whereDate('tanggal', $today);
            })->where('status', 'alpha')->count(),
        ];

        // 13. Kelas dengan wali kelas (terbaru)
        $kelasData = Kelas::with('walikelas:id,name')->orderBy('created_at', 'desc')->limit(3)->get();

        // 14. Guru Mapel Terbaru
        $guruMapelTerbaru = GuruMapel::with(['guru:id,nama', 'kelas:id,nama_kelas', 'mapel:id,nama'])
            ->orderBy('created_at', 'desc')->limit(3)->get();

        // 15. Data Absensi Mingguan (7 hari terakhir)
        $absensiMingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->format('D');

            $hadir = DetailAbsensi::whereHas('absensi', function ($query) use ($date) {
                $query->whereDate('tanggal', $date);
            })->where('status', 'hadir')->count();

            $izin = DetailAbsensi::whereHas('absensi', function ($query) use ($date) {
                $query->whereDate('tanggal', $date);
            })->where('status', 'izin')->count();

            $sakit = DetailAbsensi::whereHas('absensi', function ($query) use ($date) {
                $query->whereDate('tanggal', $date);
            })->where('status', 'sakit')->count();

            $absensiMingguan[$dayName] = [
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit
            ];
        }

        // 16. Data Agenda Bulanan (30 hari terakhir)
        $agendaBulanan = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayLabel = now()->subDays($i)->format('d M');

            $count = Agenda::whereDate('tanggal', $date)->count();
            $agendaBulanan[$dayLabel] = $count;
        }

        // Kirim semua data ke view admin.dashboard
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalJurusan',
            'totalMapel',
            'totalAgenda',
            'absensiHariIni',
            'kehadiranHariIni',
            'agendaHariIni',
            'agendaSelesai',
            'agendaDalamProses',
            'persentaseKehadiran',
            'detailAbsensiHariIni',
            'kelasData',
            'guruMapelTerbaru',
            'absensiMingguan',
            'agendaBulanan'
        ));
    }

    public function guru()
    {
        $user = Auth::user();
        $guru = Guru::where('users_id', $user->id)->first();

    if (!$guru) {
        return redirect()->back()->with('error', 'Profil guru tidak ditemukan.');
    }

    $kelasCount = GuruMapel::where('guru_id', $guru->id)->select('kelas_id')->distinct()->count();
    $mapelCount = GuruMapel::where('guru_id', $guru->id)->select('mapel_id')->distinct()->count();

    $today = now()->format('Y-m-d');
    $kelasIds = GuruMapel::where('guru_id', $guru->id)->pluck('kelas_id')->unique()->toArray();
    $mapelIds = GuruMapel::where('guru_id', $guru->id)->pluck('mapel_id')->unique()->toArray();

    // --- 1. DAFTAR SISWA TIDAK HADIR (Global untuk sidebar/notifikasi) ---
    $daftarKehadiranHariIni = collect();
    if (!empty($kelasIds)) {
        $daftarKehadiranHariIni = DetailAbsensi::with(['siswa', 'absensi.kelas'])
            ->whereHas('absensi', function ($query) use ($today, $kelasIds) {
                $query->whereDate('tanggal', $today)
                    ->whereIn('kelas_id', $kelasIds);
            })
            ->whereIn('status', ['izin', 'sakit', 'alpha'])
            ->get()
            ->groupBy('status');
    }

    $daftarKehadiranHariIni = collect([
        'izin' => $daftarKehadiranHariIni->get('izin', collect()),
        'sakit' => $daftarKehadiranHariIni->get('sakit', collect()),
        'alpha' => $daftarKehadiranHariIni->get('alpha', collect()),
    ]);

    // --- 2. REKAP PRESENSI PER MAPEL (FILTER: HANYA ABSENSI KELAS GURU INI) ---
    // Ambil data absensi hari ini untuk kelas yang diampu guru (ini adalah source utama)
    // Filter: hanya kelas yang diampu + mapel yang guru ajarkan
    $rekapPresensiPerMapel = Absensi::whereDate('tanggal', $today)
        ->whereIn('kelas_id', $kelasIds)
        ->whereIn('mapel_id', $mapelIds)
        ->get()
        ->groupBy(function ($item) {
            return $item->kelas_id . '_' . $item->mapel_id;
        })
        ->map(function ($group) {
            // Ambil absensi pertama dari group untuk info kelas, mapel, jampel
            $absensi = $group->first();

            // Aggregate detail_absensi dari semua absensi dalam group
            $allDetails = collect();
            $group->each(function ($abs) use (&$allDetails) {
                $allDetails = $allDetails->concat($abs->detailAbsensi);
            });

            if ($allDetails->isEmpty()) {
                return null; // Skip jika tidak ada detail absensi
            }

            // Hitung status
            $hadir = $allDetails->where('status', 'hadir')->count();
            $izin = $allDetails->where('status', 'izin')->count();
            $sakit = $allDetails->where('status', 'sakit')->count();
            $alpha = $allDetails->where('status', 'alpha')->count();
            $total = $allDetails->count();

            // Hitung Persentase Kehadiran
            $persentase = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

            return [
                'mapel' => $absensi->mapel ? $absensi->mapel->nama : 'Umum',
                'kelas' => $absensi->kelas->nama_kelas,
                'jam' => $absensi->jampel ? ($absensi->jampel->jam_mulai . ' - ' . $absensi->jampel->jam_selesai) : '-',
                'stats' => [
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alpha' => $alpha,
                    'total' => $total,
                    'persentase' => $persentase
                ]
            ];
        })
        ->filter() // Hapus null entries
        ->values(); // Reset keys

    // --- 3. AGENDA TERBARU (List bawah) ---
    $agendaTerbaru = Agenda::where(function ($query) use ($user, $kelasIds) {
            // SECURITY: Hanya agenda dari guru ini dan hanya untuk kelas yang diampu
            $query->where('users_id', $user->id)
                ->whereIn('kelas_id', $kelasIds);
        })
        ->with(['jampel', 'kelas'])
        ->orderBy('tanggal', 'desc')
        ->orderBy('jampel_id', 'desc')
        ->limit(3)
        ->get();

    // --- 4. TOTAL SISWA ---
    $totalSiswa = 0;
    if (!empty($kelasIds)) {
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();
    }

    // --- 5. AGREGASI PRESENSI UNTUK SIDEBAR (Visualisasi Presensi) ---
    // Ambil agregasi dari data per mapel yang sudah computed di $rekapPresensiPerMapel
    $presensiData = [
        'hadir' => $rekapPresensiPerMapel->sum(function($item) { return $item['stats']['hadir']; }),
        'izin' => $rekapPresensiPerMapel->sum(function($item) { return $item['stats']['izin']; }),
        'sakit' => $rekapPresensiPerMapel->sum(function($item) { return $item['stats']['sakit']; }),
        'alpha' => $rekapPresensiPerMapel->sum(function($item) { return $item['stats']['alpha']; }),
    ];

    return view('guru.dashboard', compact(
        'user',
        'guru',
        'kelasCount',
        'mapelCount',
        'agendaTerbaru',
        'totalSiswa',
        'daftarKehadiranHariIni',
        'rekapPresensiPerMapel',
        'presensiData' // Data untuk sidebar visualisasi presensi
    ));
}

    function walikelas()
    {
        $user = Auth::user();

        $kelas = Kelas::where('wali_kelas_id', $user->id)->first();

        // Jika tidak ada kelas yang diampu, tampilkan pesan error
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan sebagai wali kelas.');
        }

        // 3. Mendapatkan jumlah siswa di kelas tersebut
        $jumlahSiswa = $kelas->siswa()->count();

        // 4. Mendapatkan jumlah mata pelajaran di kelas tersebut
        $jumlahMapel = $kelas->mataPelajaran()->count();


        $today = now()->format('Y-m-d');

        $kehadiranHadir = DetailAbsensi::whereHas('absensi', function ($query) use ($kelas, $today) {
            $query->where('kelas_id', $kelas->id)
                ->whereDate('tanggal', $today);
        })->where('status', 'hadir')
            ->count();

        $kehadiranIzin = DetailAbsensi::whereHas('absensi', function ($query) use ($kelas, $today) {
            $query->where('kelas_id', $kelas->id)
                ->whereDate('tanggal', $today);
        })->where('status', 'izin')
            ->count();

        $kehadiranSakit = DetailAbsensi::whereHas('absensi', function ($query) use ($kelas, $today) {
            $query->where('kelas_id', $kelas->id)
                ->whereDate('tanggal', $today);
        })->where('status', 'sakit')
            ->count();

        $kehadiranAlpha = DetailAbsensi::whereHas('absensi', function ($query) use ($kelas, $today) {
            $query->where('kelas_id', $kelas->id)
                ->whereDate('tanggal', $today);
        })->where('status', 'alpha')
            ->count();

        // 6. Menghitung jumlah siswa yang tidak hadir
        $siswaTidakHadir = $kehadiranIzin + $kehadiranSakit + $kehadiranAlpha;

        // 7. Kirim SEMUA data ke view
        return view('walikelas.dashboard', compact(
            'user',
            'kelas',
            'jumlahSiswa',
            'jumlahMapel',
            'kehadiranHadir', // Menggunakan nama variabel yang lebih jelas
            'kehadiranIzin',
            'kehadiranSakit',
            'kehadiranAlpha',
            'siswaTidakHadir'
        ));

    }

    function sekretaris()
    {
        $user = Auth::user();

        // Get sekretaris's kelas (if assigned as wali kelas via siswa)
        $siswa = Siswa::where('users_id', $user->id)->first();
        $kelas = $siswa ? $siswa->kelas : null;

        if (!$kelas) {
            // Return empty view if no kelas assigned
            return view('sekretaris.dashboard', [
                'user' => $user,
                'kelas' => null,
                'jurusan' => null,
                'jumlahSiswa' => 0,
                'agendaHariIni' => [],
                'guruMapelToday' => [],
                'kegiatanPreKBM' => null,
            ]);
        }

        // Get number of siswa in kelas
        $jumlahSiswa = $kelas->siswa()->count();

        // Get today's agendas for this kelas
        $today = now()->format('Y-m-d');
        $agendaHariIni = Agenda::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $today)
            ->with(['startJampel', 'endJampel', 'user.guru'])
            ->orderBy('jampel_id')
            ->get();

        // Separate first agenda and rest for modal
        $agendaPertama = $agendaHariIni->first();
        $agendaLainnya = $agendaHariIni->skip(1)->all();

        // Get mata pelajaran taught in this kelas (via GuruMapel)
        $guruMapelToday = GuruMapel::where('kelas_id', $kelas->id)
            ->with(['guru.user', 'mapel'])
            ->get();

        $jumlahMapel = $guruMapelToday->count();

        // Get kegiatan sebelum KBM based on kelas's jurusan
        $englishDay = now()->format('l');
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Senin',
            'Sunday' => 'Senin',
        ];
        $hari = $dayMap[$englishDay] ?? 'Senin';

        $kegiatanPreKBM = \App\Models\KegiatanSebelumKBM::where('hari', $hari)
            ->where(function ($query) use ($kelas) {
                $query->whereNull('jurusan_id')
                    ->orWhere('jurusan_id', $kelas->jurusan_id);
            })
            ->first();

        // Get jurusan data
        $jurusan = $kelas->jurusan ?? null;

        return view('sekretaris.dashboard', compact(
            'user',
            'kelas',
            'jurusan',
            'jumlahSiswa',
            'jumlahMapel',
            'agendaHariIni',
            'agendaPertama',
            'agendaLainnya',
            'guruMapelToday',
            'kegiatanPreKBM'
        ));
    }
}
