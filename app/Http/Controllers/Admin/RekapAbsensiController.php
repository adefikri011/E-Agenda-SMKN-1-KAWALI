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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

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
        $query = Absensi::with(['kelas', 'guru', 'mapel', 'jampel', 'detailAbsensi.siswa']);

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

        // Jika tidak ada data absensi, kembalikan array kosong
        if ($absensiData->isEmpty()) {
            return $statistik;
        }

        foreach ($absensiData as $absensi) {
            $kelasId = $absensi->kelas_id;

            // Inisialisasi statistik untuk kelas jika belum ada
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

            // Ambil detail absensi dengan eager load siswa
            $detailAbsensi = $absensi->detailAbsensi;

            if ($detailAbsensi && $detailAbsensi->count() > 0) {
                // Update total siswa unik (ambil nilai tertinggi)
                $statistik[$kelasId]['total_siswa_unik'] = max(
                    $statistik[$kelasId]['total_siswa_unik'],
                    $detailAbsensi->count()
                );

                // Proses setiap detail absensi
                foreach ($detailAbsensi as $detail) {
                    if (!$detail->siswa) {
                        continue; // Skip jika siswa tidak ada
                    }

                    $siswaId = $detail->siswa_id;
                    $status = strtolower($detail->status ?? 'alpha');

                    // Hitung status
                    switch ($status) {
                        case 'hadir':
                            $statistik[$kelasId]['hadir']++;
                            break;
                        case 'izin':
                            $statistik[$kelasId]['izin']++;
                            // Track siswa tidak hadir
                            if (!isset($statistik[$kelasId]['siswa_tidak_hadir'][$siswaId])) {
                                $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId] = [
                                    'nama' => $detail->siswa->nama_siswa ?? 'N/A',
                                    'nis' => $detail->siswa->nis ?? 'N/A',
                                    'izin' => 0,
                                    'sakit' => 0,
                                    'alpha' => 0,
                                ];
                            }
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['izin']++;
                            break;
                        case 'sakit':
                            $statistik[$kelasId]['sakit']++;
                            // Track siswa tidak hadir
                            if (!isset($statistik[$kelasId]['siswa_tidak_hadir'][$siswaId])) {
                                $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId] = [
                                    'nama' => $detail->siswa->nama_siswa ?? 'N/A',
                                    'nis' => $detail->siswa->nis ?? 'N/A',
                                    'izin' => 0,
                                    'sakit' => 0,
                                    'alpha' => 0,
                                ];
                            }
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['sakit']++;
                            break;
                        case 'alpha':
                        default:
                            $statistik[$kelasId]['tidak_hadir']++;
                            // Track siswa tidak hadir
                            if (!isset($statistik[$kelasId]['siswa_tidak_hadir'][$siswaId])) {
                                $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId] = [
                                    'nama' => $detail->siswa->nama_siswa ?? 'N/A',
                                    'nis' => $detail->siswa->nis ?? 'N/A',
                                    'izin' => 0,
                                    'sakit' => 0,
                                    'alpha' => 0,
                                ];
                            }
                            $statistik[$kelasId]['siswa_tidak_hadir'][$siswaId]['alpha']++;
                            break;
                    }
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
        $selectedTanggal = $request->input('tanggal');

        $query = Absensi::with(['siswa', 'guru', 'kelas', 'mapel', 'detailAbsensi']);

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        if ($selectedTanggal) {
            $query->whereDate('tanggal', $selectedTanggal);
        } else {
            $query->whereYear('tanggal', Carbon::parse($selectedBulan)->year)
                  ->whereMonth('tanggal', Carbon::parse($selectedBulan)->month);
        }

        $absensiData = $query->orderBy('tanggal')->get();

        return Excel::download(new \App\Exports\RekapAbsensiExport($absensiData), 'rekap-absensi-' . $selectedBulan . '.xlsx');
    }

    /**
     * Export rekap absensi ke PDF
     */
    public function exportPDF(Request $request)
    {
        $selectedKelas = $request->input('kelas_id');
        $selectedBulan = $request->input('bulan', now()->format('Y-m'));
        $selectedTanggal = $request->input('tanggal');

        $query = Absensi::with(['siswa', 'guru', 'kelas', 'mapel', 'detailAbsensi']);

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        if ($selectedTanggal) {
            $query->whereDate('tanggal', $selectedTanggal);
        } else {
            $query->whereYear('tanggal', Carbon::parse($selectedBulan)->year)
                  ->whereMonth('tanggal', Carbon::parse($selectedBulan)->month);
        }

        $absensiData = $query->orderBy('tanggal')->get();
        $statistik = $this->hitungStatistikPerKelas($absensiData, $selectedKelas);
        $kelas = Kelas::find($selectedKelas);

        $pdf = \PDF::loadView('admin.rekap-absensi.pdf', [
            'absensiData' => $absensiData,
            'statistik' => $statistik,
            'kelas' => $kelas,
            'bulan' => $selectedBulan,
            'tanggal' => $selectedTanggal,
        ]);

        return $pdf->download('rekap-absensi-' . $selectedBulan . '.pdf');
    }
}
