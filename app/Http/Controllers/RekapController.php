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

class RekapController extends Controller
{
    // Rekap untuk wali kelas - hanya data kelas mereka
    public function index()
    {
        // Get kelas yang di-walikelas-kan oleh user ini
        $kelas = Kelas::where('wali_kelas_id', Auth::id())->first();

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda bukan wali kelas atau belum ditugaskan');
        }

        // Get semua siswa di kelas ini
        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->orderBy('nama_siswa')
            ->get();

        // Get mapel list for this class (from guru_mapel or from absensi records)
        $mapelIds = GuruMapel::where('kelas_id', $kelas->id)->pluck('mapel_id')->unique()->toArray();
        if (empty($mapelIds)) {
            $mapelIds = Absensi::where('kelas_id', $kelas->id)->pluck('mapel_id')->unique()->toArray();
        }
        $mapels = MataPelajaran::whereIn('id', $mapelIds)->get();

        // Get data absensi untuk siswa-siswa di kelas ini
        $absensiData = $this->getAbsensiData($siswa);

        // Get data nilai untuk siswa-siswa di kelas ini
        $nilaiData = $this->getNilaiData($siswa);

        // Prepare summary data
        $summaryData = $this->prepareSummaryData($siswa, $absensiData, $nilaiData);

        return view('walikelas.rekap.index', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'absensiData' => $absensiData,
            'nilaiData' => $nilaiData,
            'summaryData' => $summaryData,
            'mapels' => $mapels,
            'totalSiswa' => count($siswa),
        ]);
    }

    // Get data absensi untuk siswa-siswa
    private function getAbsensiData($siswa)
    {
        $absensiData = [];

        foreach ($siswa as $s) {
            // Absensi tidak punya kolom siswa_id, gunakan relasi detail_absensi
            $absensi = Absensi::whereHas('detailAbsensi', function($q) use ($s) {
                $q->where('siswa_id', $s->id);
            })->with(['detailAbsensi'])->get();

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
    private function getNilaiData($siswa)
    {
        $nilaiData = [];

        foreach ($siswa as $s) {
            $nilai = Nilai::where('siswa_id', $s->id)
                ->with(['guru', 'mapel'])
                ->get();

            $totalTugas = $nilai->count();
            $nilaiTotal = 0;
            $nilaiTertinggi = 0;
            $nilaiTerendah = 100;

            foreach ($nilai as $n) {
                $nilaiTotal += $n->nilai;

                if ($n->nilai > $nilaiTertinggi) {
                    $nilaiTertinggi = $n->nilai;
                }

                if ($n->nilai < $nilaiTerendah) {
                    $nilaiTerendah = $n->nilai;
                }
            }

            $nilaiRataRata = $totalTugas > 0
                ? round($nilaiTotal / $totalTugas)
                : 0;

            // Reset terendah jika tidak ada nilai
            if ($totalTugas === 0) {
                $nilaiTertinggi = 0;
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
                        'Total Tugas', 'Rata-rata', 'Tertinggi', 'Terendah'
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

