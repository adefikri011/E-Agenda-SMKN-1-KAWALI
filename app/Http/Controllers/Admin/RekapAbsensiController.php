<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\DetailAbsensi;
use App\Models\Siswa;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    /**
     * Display a listing of absence recaps for all classes.
     */
    public function index(Request $request)
    {
        $kelases = Kelas::orderBy('nama_kelas')->get();

        // Filter berdasarkan input
        $selectedKelas = $request->input('kelas_id');
        $selectedBulan = $request->input('bulan', now()->format('Y-m'));
        $selectedTanggal = $request->input('tanggal');

        // Base query untuk absensi
        $query = Absensi::with(['siswa', 'guru', 'kelas', 'mapel', 'jampel', 'detailAbsensi']);

        // Filter by kelas jika dipilih
        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        // Filter by tanggal jika dipilih
        if ($selectedTanggal) {
            $query->whereDate('tanggal', $selectedTanggal);
        } else {
            // Default: tampilkan bulan yang dipilih
            $query->whereYear('tanggal', Carbon::parse($selectedBulan)->year)
                  ->whereMonth('tanggal', Carbon::parse($selectedBulan)->month);
        }

        $absensiData = $query->orderBy('tanggal', 'desc')
                              ->orderBy('kelas_id')
                              ->get();

        // Hitung statistik per kelas
        $statistik = $this->hitungStatistikPerKelas($absensiData, $selectedKelas);

        return view('admin.rekap-absensi.index', [
            'kelases' => $kelases,
            'absensiData' => $absensiData,
            'statistik' => $statistik,
            'selectedKelas' => $selectedKelas,
            'selectedBulan' => $selectedBulan,
            'selectedTanggal' => $selectedTanggal,
        ]);
    }

    /**
     * Calculate statistics per class
     */
    private function hitungStatistikPerKelas($absensiData, $selectedKelas = null)
    {
        $statistik = [];

        foreach ($absensiData as $absensi) {
            $kelasId = $absensi->kelas_id;

            if (!isset($statistik[$kelasId])) {
                $statistik[$kelasId] = [
                    'kelas_nama' => $absensi->kelas->nama_kelas,
                    'total_siswa_unik' => 0,
                    'hadir' => 0,
                    'tidak_hadir' => 0,
                    'izin' => 0,
                    'sakit' => 0,
                    'alpha' => 0,
                    'total_absensi_record' => 0,
                    'siswa_tidak_hadir' => []
                ];
            }

            $statistik[$kelasId]['total_absensi_record']++;

            // Hitung dari detail_absensi
            if ($absensi->detailAbsensi) {
                foreach ($absensi->detailAbsensi as $detail) {
                    $siswaId = $detail->siswa_id;

                    // Track siswa yang tidak hadir
                    if ($detail->keterangan !== 'Hadir') {
                        if (!isset($statistik[$kelasId]['siswa_tidak_hadir'][$siswaId])) {
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId] = [
                                'nama' => $detail->siswa->nama_siswa ?? 'N/A',
                                'nis' => $detail->siswa->nis ?? 'N/A',
                                'izin' => 0,
                                'sakit' => 0,
                                'alpha' => 0,
                            ];
                        }
                    }

                    // Count status
                    switch ($detail->keterangan) {
                        case 'Hadir':
                            $statistik[$kelasId]['hadir']++;
                            break;
                        case 'Tidak Hadir':
                            $statistik[$kelasId]['tidak_hadir']++;
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['alpha']++;
                            break;
                        case 'Izin':
                            $statistik[$kelasId]['izin']++;
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['izin']++;
                            break;
                        case 'Sakit':
                            $statistik[$kelasId]['sakit']++;
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['sakit']++;
                            break;
                        case 'Alpha':
                            $statistik[$kelasId]['alpha']++;
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['alpha']++;
                            break;
                    }
                }

                // Count total unique siswa
                if ($absensi->detailAbsensi->count() > 0) {
                    $statistik[$kelasId]['total_siswa_unik'] = max(
                        $statistik[$kelasId]['total_siswa_unik'],
                        $absensi->detailAbsensi->count()
                    );
                }
            }
        }

        return $statistik;
    }

    /**
     * Show detail absensi untuk satu kelas pada tanggal tertentu
     */
    public function detail(Request $request)
    {
        $kelas = Kelas::findOrFail($request->input('kelas_id'));
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));

        $absensi = Absensi::where('kelas_id', $kelas->id)
                          ->whereDate('tanggal', $tanggal)
                          ->with(['detailAbsensi', 'guru', 'mapel', 'jampel'])
                          ->get();

        return view('admin.rekap-absensi.detail', [
            'kelas' => $kelas,
            'tanggal' => $tanggal,
            'absensi' => $absensi,
        ]);
    }

    /**
     * Export rekap absensi ke Excel
     */
    public function exportExcel(Request $request)
    {
        $selectedKelas = $request->input('kelas_id');
        $selectedBulan = $request->input('bulan', now()->format('Y-m'));

        $query = Absensi::with(['siswa', 'guru', 'kelas', 'mapel', 'detailAbsensi']);

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        $query->whereYear('tanggal', Carbon::parse($selectedBulan)->year)
              ->whereMonth('tanggal', Carbon::parse($selectedBulan)->month);

        $absensiData = $query->orderBy('tanggal')->get();

        return Excel::download(new \App\Exports\RekapAbsensiExport($absensiData), 'rekap-absensi-' . $selectedBulan . '.xlsx');
    }
}
