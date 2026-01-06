<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\DetailAbsensi;
use App\Models\MataPelajaran;
use App\Models\GuruMapel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class RekapController extends Controller
{
    // Rekap untuk wali kelas - hanya data kelas mereka
    public function index(Request $request)
    {
        // Get kelas yang di-walikelas-kan oleh user ini
        $kelas = Kelas::where('wali_kelas_id', Auth::id())->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda bukan wali kelas atau belum ditugaskan');
        }

        // Get semua siswa di kelas ini
        $allSiswa = Siswa::where('kelas_id', $kelas->id)
            ->orderBy('nama_siswa')
            ->get();

        // Get mapel list untuk filter dropdown
        $mapelIds = GuruMapel::where('kelas_id', $kelas->id)->pluck('mapel_id')->unique()->toArray();
        if (empty($mapelIds)) {
            $mapelIds = Absensi::where('kelas_id', $kelas->id)->pluck('mapel_id')->unique()->toArray();
        }
        $allMapels = MataPelajaran::whereIn('id', $mapelIds)->get();

        // Get selected mapel dari request (opsional, untuk filter tampilan)
        $selectedMapelId = $request->get('mapel_id');

        // Filter siswa berdasarkan mapel yang dipilih
        $siswa = $allSiswa;
        if ($selectedMapelId) {
            // Ambil siswa yang punya absensi (dari detail_absensi) atau nilai di mapel ini
            $absensiSiswaIds = DetailAbsensi::whereHas('absensi', function($q) use ($kelas, $selectedMapelId) {
                $q->where('kelas_id', $kelas->id)->where('mapel_id', $selectedMapelId);
            })->pluck('siswa_id')->unique();

            $nilaiSiswaIds = Nilai::where('kelas_id', $kelas->id)
                ->where('mapel_id', $selectedMapelId)
                ->pluck('siswa_id')
                ->unique();

            $siswaWithData = $absensiSiswaIds->merge($nilaiSiswaIds)->unique();

            $siswa = $allSiswa->whereIn('id', $siswaWithData->values()->all());
        }

        // Get data absensi dan nilai untuk siswa di kelas ini
        $absensiData = $this->getAbsensiData($siswa, $selectedMapelId);
        $nilaiData = $this->getNilaiData($siswa, $selectedMapelId);

        // Prepare summary data
        $summaryData = $this->prepareSummaryData($siswa, $absensiData, $nilaiData);

        return view('walikelas.rekap.index', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'absensiData' => $absensiData,
            'nilaiData' => $nilaiData,
            'summaryData' => $summaryData,
            'mapels' => $allMapels,
            'totalSiswa' => count($siswa),
            'mapelOptions' => $allMapels,
            'selectedMapelId' => $selectedMapelId,
        ]);
    }

    /**
     * Get date range berdasarkan periode filter
     */
    private function getDateRangeFromPeriode($periode, $startDate = null, $endDate = null)
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();

        switch ($periode) {
            case 'today':
                return [
                    'start' => $today,
                    'end' => $today->copy()->endOfDay()
                ];
            
            case 'thisWeek':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek()
                ];
            
            case 'lastWeek':
                return [
                    'start' => $now->copy()->subWeek()->startOfWeek(),
                    'end' => $now->copy()->subWeek()->endOfWeek()
                ];
            
            case 'thisMonth':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
            
            case 'lastMonth':
                return [
                    'start' => $now->copy()->subMonth()->startOfMonth(),
                    'end' => $now->copy()->subMonth()->endOfMonth()
                ];
            
            case 'last3Months':
                return [
                    'start' => $now->copy()->subMonths(3)->startOfMonth(),
                    'end' => $now->copy()->endOfMonth()
                ];
            
            case 'semester':
                // Semester saat ini - Jan-Jun atau Jul-Des
                $month = $now->month;
                if ($month <= 6) {
                    return [
                        'start' => $now->copy()->month(1)->startOfMonth(),
                        'end' => $now->copy()->month(6)->endOfMonth()
                    ];
                } else {
                    return [
                        'start' => $now->copy()->month(7)->startOfMonth(),
                        'end' => $now->copy()->month(12)->endOfMonth()
                    ];
                }
            
            case 'lastSemester':
                // Semester sebelumnya
                $month = $now->month;
                if ($month <= 6) {
                    return [
                        'start' => $now->copy()->year($now->year - 1)->month(7)->startOfMonth(),
                        'end' => $now->copy()->year($now->year - 1)->month(12)->endOfMonth()
                    ];
                } else {
                    return [
                        'start' => $now->copy()->month(1)->startOfMonth(),
                        'end' => $now->copy()->month(6)->endOfMonth()
                    ];
                }
            
            case 'custom':
                if ($startDate && $endDate) {
                    return [
                        'start' => Carbon::parse($startDate)->startOfDay(),
                        'end' => Carbon::parse($endDate)->endOfDay()
                    ];
                }
                // Fallback to all if custom but dates not provided
                return ['start' => null, 'end' => null];
            
            case 'all':
            default:
                return ['start' => null, 'end' => null];
        }
    }

    // Get data absensi untuk siswa-siswa
    private function getAbsensiData($siswa, $mapelId = null)
    {
        $absensiData = [];

        foreach ($siswa as $s) {
            // Absensi tidak punya kolom siswa_id, gunakan relasi detail_absensi
            $query = Absensi::whereHas('detailAbsensi', function($q) use ($s) {
                $q->where('siswa_id', $s->id);
            })->with(['detailAbsensi']);

            // Filter by mapel jika dipilih
            if ($mapelId) {
                $query->where('mapel_id', $mapelId);
            }

            $absensi = $query->get();

            // Count attendance status
            $totalPertemuan = 0;
            $hadir = 0;
            $sakit = 0;
            $izin = 0;
            $alpa = 0;

            foreach ($absensi as $abs) {
                // Ambil detail absensi hanya untuk siswa ini
                $detail = $abs->detailAbsensi->firstWhere('siswa_id', $s->id);
                if ($detail) {
                    $totalPertemuan++;
                    $status = strtolower(trim($detail->status));

                    switch ($status) {
                        case 'hadir':
                        case 'h':
                            $hadir++;
                            break;
                        case 'sakit':
                        case 's':
                            $sakit++;
                            break;
                        case 'izin':
                        case 'i':
                            $izin++;
                            break;
                        case 'alpa':
                        case 'alpha':
                        case 'a':
                            $alpa++;
                            break;
                        default:
                            // unknown status - ignore
                            break;
                    }
                }
            }

            $persentase = $totalPertemuan > 0
                ? round(($hadir / $totalPertemuan) * 100)
                : 0;

            $absensiData[$s->id] = [
                'nama' => $s->nama_siswa,
                'nis' => $s->nis,
                'kelas' => $s->kelas->nama_kelas,
                'totalPertemuan' => $totalPertemuan,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'alpa' => $alpa,
                'persentase' => $persentase
            ];
        }

        return $absensiData;
    }

    // Get data nilai untuk siswa-siswa
    private function getNilaiData($siswa, $mapelId = null)
    {
        $nilaiData = [];

        foreach ($siswa as $s) {
            $query = Nilai::where('siswa_id', $s->id)
                ->with(['guru', 'mapel']);

            // Filter by mapel jika dipilih
            if ($mapelId) {
                $query->where('mapel_id', $mapelId);
            }

            $nilai = $query->get();

            // Hitung statistik nilai lengkap termasuk per-jenis (tugas/ulangan/uts/uas)
            $totalTugas = $nilai->count();

            // Siapkan counter per jenis supaya tugas harian tetap muncul walau 0
            $jenisCounts = [
                'tugas' => 0,
                'ulangan' => 0,
                'uts' => 0,
                'uas' => 0,
            ];

            $nilaiValues = [];
            foreach ($nilai as $n) {
                $nilaiValues[] = (float) $n->nilai;
                $jenis = strtolower($n->jenis ?? 'tugas');
                if (array_key_exists($jenis, $jenisCounts)) {
                    $jenisCounts[$jenis]++;
                }
            }

            $nilaiTotal = array_sum($nilaiValues);

            if ($totalTugas > 0) {
                $nilaiTertinggi = max($nilaiValues);
                $nilaiTerendah = min($nilaiValues);
                $nilaiRataRata = round($nilaiTotal / $totalTugas, 1);
            } else {
                $nilaiTertinggi = 0;
                $nilaiTerendah = 0;
                $nilaiRataRata = 0;
            }

            // Jika hanya 0 atau 1 nilai, tampilkan nilai terendah sebagai 0
            // (lebih informatif daripada menampilkan angka tunggal sebagai 'terendah')
            if ($totalTugas <= 1) {
                $nilaiTerendah = 0;
            }

            $nilaiData[$s->id] = [
                'nama' => $s->nama_siswa,
                'nis' => $s->nis,
                'kelas' => $s->kelas->nama_kelas,
                'totalTugas' => $totalTugas,
                'nilaiRataRata' => $nilaiRataRata,
                'nilaiTertinggi' => $nilaiTertinggi,
                'nilaiTerendah' => $nilaiTerendah,
                'jenisCounts' => $jenisCounts,
                'tugasBelumDinilai' => 0 // Optional: implement jika ada tugas yang belum dinilai
            ];
        }

        return $nilaiData;
    }

    // Prepare summary data untuk statistics
    private function prepareSummaryData($siswa, $absensiData, $nilaiData)
    {
        $totalPertemuan = 0;
        $totalHadir = 0;
        $totalPossible = 0;
        $totalNilai = 0;
        $totalGrades = 0;
        $totalTugas = 0;

        // Calculate dari absensi data
        foreach ($absensiData as $data) {
            $totalHadir += $data['hadir'];
            $totalPossible += $data['totalPertemuan'];
        }

        // Get unique meetings count
        $totalPertemuan = $totalPossible > 0 ? count(array_unique(array_map(function($s) {
            return $s['totalPertemuan'];
        }, $absensiData))) : 0;

        // Lebih akurat: ambil dari database
        $totalPertemuan = Absensi::whereHas('siswa', function($query) use ($siswa) {
            $query->whereIn('siswa.id', $siswa->pluck('id'));
        })->count();

        // Calculate dari nilai data
        foreach ($nilaiData as $data) {
            $totalNilai += ($data['nilaiRataRata'] * $data['totalTugas']);
            $totalGrades += $data['totalTugas'];
            $totalTugas += $data['totalTugas'];
        }

        $avgKehadiran = $totalPossible > 0
            ? round(($totalHadir / $totalPossible) * 100)
            : 0;

        $avgNilai = $totalGrades > 0
            ? round($totalNilai / $totalGrades)
            : 0;

        return [
            'totalPertemuan' => $totalPertemuan,
            'avgKehadiran' => $avgKehadiran,
            'avgNilai' => $avgNilai,
            'totalTugas' => $totalTugas
        ];
    }

    // API: Get data untuk JavaScript
    public function getRekapData()
    {
        $kelas = Kelas::where('wali_kelas_id', Auth::id())->first();

        if (!$kelas) {
            return response()->json(['error' => 'Bukan wali kelas'], 403);
        }
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        $absensiData = $this->getAbsensiData($siswa);
        $nilaiData = $this->getNilaiData($siswa);
        $summaryData = $this->prepareSummaryData($siswa, $absensiData, $nilaiData);

        // also return mapel list
        $mapelIds = GuruMapel::where('kelas_id', $kelas->id)->pluck('mapel_id')->unique()->toArray();
        if (empty($mapelIds)) {
            $mapelIds = Absensi::where('kelas_id', $kelas->id)->pluck('mapel_id')->unique()->toArray();
        }
        $mapels = MataPelajaran::whereIn('id', $mapelIds)->get();

        return response()->json([
            'kelas' => $kelas->nama_kelas,
            'absensi' => $absensiData,
            'nilai' => $nilaiData,
            'summary' => $summaryData,
            'mapels' => $mapels
        ]);
    }

    // Download endpoint: csv, excel, pdf
    public function download($format)
    {
        $kelas = Kelas::where('wali_kelas_id', Auth::id())->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Bukan wali kelas');
        }

        $siswa = Siswa::where('kelas_id', $kelas->id)->orderBy('nama_siswa')->get();

        $absensiData = $this->getAbsensiData($siswa);
        $nilaiData = $this->getNilaiData($siswa);

        // Build rows
        $rows = [];
        foreach ($siswa as $s) {
            $a = $absensiData[$s->id] ?? null;
            $n = $nilaiData[$s->id] ?? null;

            $rows[] = [
                $s->nis,
                $s->nama_siswa,
                $s->kelas->nama_kelas ?? '',
                $a['totalPertemuan'] ?? 0,
                $a['hadir'] ?? 0,
                $a['sakit'] ?? 0,
                $a['izin'] ?? 0,
                $a['alpa'] ?? 0,
                ($a['persentase'] ?? 0) . '%',
                $n['totalTugas'] ?? 0,
                // breakdown per jenis
                $n['jenisCounts']['tugas'] ?? 0,
                $n['jenisCounts']['ulangan'] ?? 0,
                $n['jenisCounts']['uts'] ?? 0,
                $n['jenisCounts']['uas'] ?? 0,
                $n['nilaiRataRata'] ?? 0,
                $n['nilaiTertinggi'] ?? 0,
                $n['nilaiTerendah'] ?? 0,
            ];
        }

        $filenameBase = 'rekap_' . preg_replace('/[^A-Za-z0-9\-]/', '_', strtolower($kelas->nama_kelas));

        switch (strtolower($format)) {
            case 'csv':
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"{$filenameBase}.csv\"",
                ];

                $callback = function () use ($rows) {
                    $out = fopen('php://output', 'w');
                    fputcsv($out, [
                        'NIS', 'Nama', 'Kelas', 'Total Pertemuan', 'Hadir', 'Sakit', 'Izin', 'Alpa', 'Persentase (%)',
                        'Total Tugas', 'Count Tugas', 'Count Ulangan', 'Count UTS', 'Count UAS', 'Rata-rata', 'Tertinggi', 'Terendah'
                    ]);

                    foreach ($rows as $row) {
                        // remove percent sign from persentase column for CSV numeric clarity
                        $r = $row;
                        if (is_string($r[8])) {
                            $r[8] = rtrim($r[8], '%');
                        }
                        fputcsv($out, $r);
                    }

                    fclose($out);
                };

                return response()->streamDownload($callback, "{$filenameBase}.csv", $headers);

            case 'excel':
                return Excel::download(new RekapExport($rows), "{$filenameBase}.xlsx");

            case 'pdf':
                $pdf = Pdf::loadView('walikelas.rekap.pdf', ['rows' => $rows, 'kelas' => $kelas->nama_kelas]);
                return $pdf->download("{$filenameBase}.pdf");

            default:
                return redirect()->back()->with('error', 'Format tidak didukung');
        }
    }
}

