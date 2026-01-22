<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini jika belum ada
use App\Exports\AgendaExport; // Tambahkan ini jika belum ada

class LihatAgendaController extends Controller
{
    /**
     * Display a listing of all agendas for admin overview
     */
    public function index(Request $request)
    {
        // Ambil semua data untuk filter dropdown
        $kelases = Kelas::orderBy('nama_kelas')->get();
        $gurus = Guru::with('user')->orderBy('nama')->get();
        // Untuk mapel, ambil dari mata_pelajaran atau dari guru_mapel
        $mapels = MataPelajaran::orderBy('nama')->get();

        // Filter inputs
        $selectedKelas = $request->input('kelas_id');
        $selectedGuru = $request->input('guru_id'); // ini adalah users_id
        $selectedMapel = $request->input('mapel_id');
        $selectedTanggalAwal = $request->input('tanggal_awal');
        $selectedTanggalAkhir = $request->input('tanggal_akhir');
        $selectedStatus = $request->input('status'); // draft, submitted, approved

        // Base query dengan eager loading untuk mengoptimalkan kinerja
        $query = Agenda::with([
            'kelas',
            'user.guru', // Relasi user -> guru
            'startJampel',
            'endJampel'
        ]);

        // DEFAULT: Jika tidak ada filter tanggal, tampilkan agenda hari ini
        if (!$selectedTanggalAwal && !$selectedTanggalAkhir) {
            $today = Carbon::today();
            $query->whereDate('tanggal', $today);
        }

        // Terapkan filter
        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        if ($selectedGuru) {
            $query->where('users_id', $selectedGuru);
        }

        if ($selectedMapel) {
            $query->where('mapel_id', $selectedMapel);
        }

        if ($selectedTanggalAwal) {
            $query->whereDate('tanggal', '>=', $selectedTanggalAwal);
        }

        if ($selectedTanggalAkhir) {
            $query->whereDate('tanggal', '<=', $selectedTanggalAkhir);
        }

        if ($selectedStatus) {
            $query->where('status', $selectedStatus);
        }

        // Get data dan sort dengan pagination
        $agendas = $query->orderBy('tanggal', 'asc')
                         ->orderBy('start_jampel_id', 'asc')
                         ->paginate(15)
                         ->appends($request->query());

        // Hitung statistik dengan query yang lebih efisien
        $totalAgenda = Agenda::count();
        $today = Carbon::today();
        $totalHariIni = Agenda::whereDate('tanggal', $today)->count();

        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $totalMingguIni = Agenda::whereBetween('tanggal', [$weekStart, $weekEnd])->count();

        // Tambahkan status breakdown untuk filter
        $statusOptions = [
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'approved' => 'Approved'
        ];

        return view('admin.lihat-agenda.index', compact(
            'agendas',
            'kelases',
            'gurus',
            'mapels',
            'selectedKelas',
            'selectedGuru',
            'selectedMapel',
            'selectedTanggalAwal',
            'selectedTanggalAkhir',
            'selectedStatus',
            'totalAgenda',
            'totalHariIni',
            'totalMingguIni',
            'statusOptions'
        ));
    }

    /**
     * Show detail agenda
     */
    public function show($id)
    {
        // Tambahkan relasi yang mungkin diperlukan di view detail
        $agenda = Agenda::with([
            'kelas',
            'user.guru',
            'startJampel',
            'endJampel',
            'mapel'
        ])->findOrFail($id);

        return view('admin.lihat-agenda.show', compact('agenda'));
    }

    /**
     * Export agendas to Excel
     */
    public function exportExcel(Request $request)
    {
        // Base query dengan eager loading
        $query = Agenda::with([
            'kelas',
            'user.guru',
            'startJampel',
            'endJampel',
            'mapel'
        ]);

        // Terapkan filter yang sama dengan method index
        if ($request->input('kelas_id')) {
            $query->where('kelas_id', $request->input('kelas_id'));
        }

        if ($request->input('guru_id')) {
            $query->where('users_id', $request->input('guru_id'));
        }

        if ($request->input('mapel_id')) {
            $query->where('mapel_id', $request->input('mapel_id'));
        }

        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->input('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->input('tanggal_awal'));
        }

        if ($request->input('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->input('tanggal_akhir'));
        }

        $agendas = $query->orderBy('tanggal')->get();

        // Gunakan nama file yang lebih deskriptif
        $filename = 'agenda-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new AgendaExport($agendas), $filename);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistik()
    {
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        // Menggunakan satu query untuk mendapatkan semua statistik
        $stats = [
            'total' => Agenda::count(),
            'hari_ini' => Agenda::whereDate('tanggal', $today)->count(),
            'minggu_ini' => Agenda::whereBetween('tanggal', [$weekStart, $weekEnd])->count(),
            'bulan_ini' => Agenda::whereBetween('tanggal', [$monthStart, $monthEnd])->count(),
            'belum_ditandatangani' => Agenda::where('sudah_ttd', false)->count(),
            'sudah_ditandatangani' => Agenda::where('sudah_ttd', true)->count(),
        ];

        return response()->json($stats);
    }
}
