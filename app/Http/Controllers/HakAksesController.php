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
        $kelasData = Kelas::with('walikelas:id,name')->orderBy('created_at', 'desc')->limit(5)->get();

        // 14. Guru Mapel Terbaru
        $guruMapelTerbaru = GuruMapel::with(['guru:id,nama', 'kelas:id,nama_kelas', 'mapel:id,nama'])
            ->orderBy('created_at', 'desc')->limit(5)->get();

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
            'guruMapelTerbaru'
        ));
    }


    function guru()
    {
        $user = Auth::user();

        $guru = Guru::where('users_id', $user->id)->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Profil guru tidak ditemukan.');
        }

        $kelasCount = GuruMapel::where('guru_id', $guru->id)->distinct('kelas_id')->count();
        $mapelCount = GuruMapel::where('guru_id', $guru->id)->distinct('mapel_id')->count();

        $today = now()->format('Y-m-d');

        // Agenda table stores the creator in `users_id`, not `guru_id`
        $agendaHariIni = Agenda::where('users_id', $guru->users_id)
            ->whereDate('tanggal', $today)
            ->orderBy('jampel_id')
            ->get();

        $recentAgendas = Agenda::where('users_id', $guru->users_id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        $kelasIds = GuruMapel::where('guru_id', $guru->id)->pluck('kelas_id')->unique()->toArray();

        $presensiHadir = DetailAbsensi::whereHas('absensi', function ($q) use ($today, $kelasIds) {
            $q->whereDate('tanggal', $today)->whereIn('kelas_id', $kelasIds);
        })->where('status', 'hadir')->count();

        $presensiIzin = DetailAbsensi::whereHas('absensi', function ($q) use ($today, $kelasIds) {
            $q->whereDate('tanggal', $today)->whereIn('kelas_id', $kelasIds);
        })->where('status', 'izin')->count();

        $presensiSakit = DetailAbsensi::whereHas('absensi', function ($q) use ($today, $kelasIds) {
            $q->whereDate('tanggal', $today)->whereIn('kelas_id', $kelasIds);
        })->where('status', 'sakit')->count();

        $presensiAlpha = DetailAbsensi::whereHas('absensi', function ($q) use ($today, $kelasIds) {
            $q->whereDate('tanggal', $today)->whereIn('kelas_id', $kelasIds);
        })->where('status', 'alpha')->count();

        $presensiData = [
            'hadir' => $presensiHadir,
            'izin' => $presensiIzin,
            'sakit' => $presensiSakit,
            'alpha' => $presensiAlpha,
        ];

        $totalSiswa = 0;
        if (!empty($kelasIds)) {
            $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();
        }

        // Fetch activity history: recent agendas created by this guru + recent absences recorded
        // Ensures data isolation per guru (only show their own activities)
        $activities = [];

        // Recent agendas created by this guru (last 10)
        $recentAgendaActivities = Agenda::where('users_id', $guru->users_id)
            ->with('kelas')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($agenda) {
                return [
                    'type' => 'agenda',
                    'title' => 'Agenda: ' . $agenda->mata_pelajaran,
                    'description' => 'Kelas ' . ($agenda->kelas->nama ?? 'N/A'),
                    'timestamp' => $agenda->created_at,
                ];
            });

        // Recent absences recorded for this guru's classes (last 10)
        $recentAbsensiActivities = Absensi::whereIn('kelas_id', $kelasIds)
            ->with('kelas')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($absensi) {
                $tanggalFormatted = is_string($absensi->tanggal)
                    ? \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y')
                    : $absensi->tanggal->format('d M Y');
                return [
                    'type' => 'absensi',
                    'title' => 'Absensi Kelas ' . ($absensi->kelas->nama ?? 'N/A'),
                    'description' => 'Tanggal: ' . $tanggalFormatted,
                    'timestamp' => $absensi->created_at,
                ];
            });

        // Merge and sort by timestamp (newest first)
        $activities = collect($recentAgendaActivities)
            ->merge($recentAbsensiActivities)
            ->sortByDesc('timestamp')
            ->take(10);

        return view('guru.dashboard', compact(
            'user', 'guru', 'kelasCount', 'mapelCount', 'agendaHariIni', 'recentAgendas', 'presensiData', 'totalSiswa', 'activities'
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
            ->with(['startJampel', 'endJampel', 'guru.user'])
            ->orderBy('jampel_id')
            ->get();

        // Get mata pelajaran taught in this kelas (via GuruMapel)
        $guruMapelToday = GuruMapel::where('kelas_id', $kelas->id)
            ->with(['guru.user', 'mapel'])
            ->get();

        $jumlahMapel = $guruMapelToday->count();

        // Get kegiatan sebelum KBM based on kelas's jurusan
        $hari = now()->translatedFormat('l');
        $kegiatanPreKBM = \App\Models\KegiatanSebelumKBM::where('hari', $hari)
            ->where(function ($query) use ($kelas) {
                $query->whereNull('jurusan_id')
                    ->orWhere('jurusan_id', $kelas->jurusan_id);
            })
            ->first();

        return view('sekretaris.dashboard', compact(
            'user',
            'kelas',
            'jumlahSiswa',
            'jumlahMapel',
            'agendaHariIni',
            'guruMapelToday',
            'kegiatanPreKBM'
        ));
    }
}
