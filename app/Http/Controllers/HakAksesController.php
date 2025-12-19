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

        // 4. Hitung Total Jurusan (dari kolom 'kelompok' di tabel mata_pelajaran)
        $totalJurusan = MataPelajaran::distinct('kelompok')->count('kelompok');

        // 5. Hitung Total Mata Pelajaran
        $totalMapel = MataPelajaran::count();

        // 6. Hitung Total Agenda
        $totalAgenda = Agenda::count();

        // Kirim semua data ke view admin.dashboard
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalJurusan',
            'totalMapel',
            'totalAgenda'
        ));
    }

    // ... method lainnya (guru, walikelas, dll)

    function guru()
    {
        return view('guru.dashboard');
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
        return view('sekretaris.dashboard');
    }
}
