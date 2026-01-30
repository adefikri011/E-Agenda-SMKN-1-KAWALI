<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AgendaaExport;

class LihatAgendaController extends Controller
{
    /**
     * Display a listing of all agendas for admin overview
     */
    public function index(Request $request)
    {
        // Get dropdown data without cache for now (for debugging)
        $kelases = Kelas::orderBy('nama_kelas')->get();
        $gurus = Guru::with('user')->orderBy('nama')->get();
        $mapels = MataPelajaran::orderBy('nama')->get();

        // Filter inputs
        $filters = [
            'kelas_id' => $request->input('kelas_id'),
            'guru_id' => $request->input('guru_id'),
            'mapel_id' => $request->input('mapel_id'),
            'status_ttd' => $request->input('status_ttd'),
            'tanggal_awal' => $request->input('tanggal_awal'),
            'tanggal_akhir' => $request->input('tanggal_akhir')
        ];

        // Base query with optimized eager loading
        $query = Agenda::with([
            'kelas' => function ($q) {
                $q->select('id', 'nama_kelas');
            },
            'user.guru' => function ($q) {
                $q->select('users_id', 'nama', 'nip');
            },
            'startJampel' => function ($q) {
                $q->select('id', 'jam_mulai');
            },
            'endJampel' => function ($q) {
                $q->select('id', 'jam_selesai');
            },
            'mapel' => function ($q) {
                $q->select('id', 'nama');
            }
        ]);

        // Apply filters dynamically
        $this->applyFilters($query, $filters);

        // Default: If no date filter, show only today's agendas
        if (!$filters['tanggal_awal'] && !$filters['tanggal_akhir']) {
            $query->whereDate('tanggal', Carbon::today());
        }

        // Get paginated results with optimized sorting
        $agendas = $query->orderBy('tanggal', 'desc')
                         ->orderBy('start_jampel_id', 'asc')
                         ->paginate(20)
                         ->withQueryString();

        // Group agendas by date, class, and time slot to avoid duplicates
        $groupedAgendas = collect($agendas->items())
            ->groupBy(function ($item) {
                return $item->tanggal . '_' . $item->kelas_id . '_' . $item->start_jampel_id . '_' . $item->end_jampel_id;
            })
            ->map(function ($group) {
                $first = $group->first();

                // Collect all mapels and filter out null/empty ones
                $mapels = $group->filter(function($item) {
                    return $item->mapel && $item->mapel->id;
                })->pluck('mapel')->unique(function($item) {
                    return $item->id;
                })->values();

                $agendaObj = new \stdClass();
                $agendaObj->id = $first->id;
                $agendaObj->tanggal = $first->tanggal;
                $agendaObj->kelas_id = $first->kelas_id;
                $agendaObj->kelas = $first->kelas;
                $agendaObj->users_id = $first->users_id;
                $agendaObj->user = $first->user;
                $agendaObj->start_jampel_id = $first->start_jampel_id;
                $agendaObj->startJampel = $first->startJampel;
                $agendaObj->end_jampel_id = $first->end_jampel_id;
                $agendaObj->endJampel = $first->endJampel;
                $agendaObj->mapels = $mapels;
                $agendaObj->mapel = $first->mapel;
                $agendaObj->status = $first->status;
                $agendaObj->kegiatan = $first->kegiatan;
                $agendaObj->materi = $group->filter(function($item) {
                    return $item->materi;
                })->pluck('materi')->unique()->implode(' | ');

                return $agendaObj;
            })
            ->values();

        // Group by kelas for display
        $agendaByKelas = collect($groupedAgendas)
            ->groupBy('kelas_id')
            ->map(function ($kelasAgendas, $kelasId) {
                return (object)[
                    'kelas_id' => $kelasId,
                    'kelas_name' => $kelasAgendas->first()->kelas->nama_kelas ?? 'Kelas Tidak Diketahui',
                    'kelas' => $kelasAgendas->first()->kelas,
                    'agendas' => $kelasAgendas,
                    'total' => $kelasAgendas->count(),
                ];
            })
            ->values();

        // Create a custom paginator with grouped data
        $agendas->setCollection($agendaByKelas);

        // Calculate statistics with optimized queries
        $statistics = $this->getStatistics($filters);

        // Status options for filter
        $statusOptions = [
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'approved' => 'Disetujui'
        ];

        return view('admin.lihat-agenda.index', array_merge(
            [
                'agendas' => $agendas,
                'kelases' => $kelases,
                'gurus' => $gurus,
                'mapels' => $mapels,
                'statusOptions' => $statusOptions,
                'request' => $request,
                'selectedKelas' => $filters['kelas_id'],
                'selectedGuru' => $filters['guru_id'],
                'selectedMapel' => $filters['mapel_id'],
                'selectedStatus' => $filters['status_ttd'],
                'selectedTanggalAwal' => $filters['tanggal_awal'],
                'selectedTanggalAkhir' => $filters['tanggal_akhir']
            ],
            $statistics
        ));
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, $filters)
    {
        foreach ($filters as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'kelas_id':
                        $query->where('kelas_id', $value);
                        break;
                    case 'guru_id':
                        $query->where('users_id', $value);
                        break;
                    case 'mapel_id':
                        $query->where('mapel_id', $value);
                        break;
                    case 'status_ttd':
                        $query->where('status_ttd', $value);
                        break;
                    case 'tanggal_awal':
                        $query->whereDate('tanggal', '>=', $value);
                        break;
                    case 'tanggal_akhir':
                        $query->whereDate('tanggal', '<=', $value);
                        break;
                }
            }
        }
    }

    /**
     * Get statistics with optimized queries
     */
    private function getStatistics($filters)
    {
        $now = Carbon::now();

        // Base queries for each statistic
        $totalQuery = Agenda::query();
        $todayQuery = Agenda::whereDate('tanggal', $now->toDateString());
        $weekQuery = Agenda::whereBetween('tanggal', [
            $now->startOfWeek()->toDateString(),
            $now->endOfWeek()->toDateString()
        ]);

        // Apply same filters to statistics queries
        foreach ([$totalQuery, $todayQuery, $weekQuery] as $query) {
            $this->applyFilters($query, $filters);
        }

        return [
            'totalAgenda' => $totalQuery->count(),
            'totalHariIni' => $todayQuery->count(),
            'totalMingguIni' => $weekQuery->count()
        ];
    }

    /**
     * Show detail agenda
     */
    public function show($id)
    {
        $agenda = Agenda::with([
            'kelas',
            'user.guru',
            'startJampel',
            'endJampel',
            'mapel',
            'detailAbsensi.siswa'
        ])->findOrFail($id);

        // Sort detail absensi by siswa nama
        $agenda->detailAbsensi = $agenda->detailAbsensi->sortBy(function ($item) {
            return $item->siswa?->nama ?? '';
        })->values();

        return view('admin.lihat-agenda.show', compact('agenda'));
    }

    /**
     * Export agendas to Excel
     */
    public function exportExcel(Request $request)
    {
        $query = Agenda::with([
            'kelas',
            'user.guru',
            'startJampel',
            'endJampel',
            'mapel'
        ]);

        $this->applyFilters($query, $request->all());

        $agendas = $query->orderBy('tanggal', 'asc')
                        ->orderBy('start_jampel_id', 'asc')
                        ->get();

        // Generate filename based on filters
        $filename = 'agenda-export-' . now()->format('Y-m-d-H-i');
        if ($request->kelas_id) {
            $filename .= '-kelas-' . $request->kelas_id;
        }
        if ($request->tanggal_awal) {
            $filename .= '-mulai-' . $request->tanggal_awal;
        }
        $filename .= '.xlsx';

        return Excel::download(new AgendaaExport($agendas), $filename);
    }

    /**
     * Get statistics for dashboard (AJAX)
     */
    public function getStatistik(Request $request)
    {
        $filters = $request->only(['kelas_id', 'guru_id', 'mapel_id', 'status']);

        $now = Carbon::now();
        $lastWeek = Carbon::now()->subWeek();
        $lastMonth = Carbon::now()->subMonth();

        $queries = [
            'total' => Agenda::query(),
            'hari_ini' => Agenda::whereDate('tanggal', $now->toDateString()),
            'minggu_ini' => Agenda::whereBetween('tanggal', [
                $now->startOfWeek()->toDateString(),
                $now->endOfWeek()->toDateString()
            ]),
            'bulan_ini' => Agenda::whereBetween('tanggal', [
                $now->startOfMonth()->toDateString(),
                $now->endOfMonth()->toDateString()
            ]),
            'minggu_lalu' => Agenda::whereBetween('tanggal', [
                $lastWeek->startOfWeek()->toDateString(),
                $lastWeek->endOfWeek()->toDateString()
            ]),
            'status_draft' => Agenda::where('status', 'draft'),
            'status_submitted' => Agenda::where('status', 'submitted'),
            'status_approved' => Agenda::where('status', 'approved')
        ];

        // Apply filters to all queries
        foreach ($queries as $query) {
            $this->applyFilters($query, $filters);
        }

        $stats = [];
        foreach ($queries as $key => $query) {
            $stats[$key] = $query->count();
        }

        return response()->json($stats);
    }

    /**
     * Quick filter by period
     */
    public function quickFilter(Request $request)
    {
        $period = $request->period;

        $dates = $this->getPeriodDates($period);

        return redirect()->route('admin.lihat-agenda.index', [
            'tanggal_awal' => $dates['start'],
            'tanggal_akhir' => $dates['end']
        ]);
    }

    /**
     * Get dates for quick periods
     */
    private function getPeriodDates($period)
    {
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                return [
                    'start' => $now->toDateString(),
                    'end' => $now->toDateString()
                ];
            case 'week':
                return [
                    'start' => $now->startOfWeek()->toDateString(),
                    'end' => $now->endOfWeek()->toDateString()
                ];
            case 'month':
                return [
                    'start' => $now->startOfMonth()->toDateString(),
                    'end' => $now->endOfMonth()->toDateString()
                ];
            case 'last_week':
                $lastWeek = $now->copy()->subWeek();
                return [
                    'start' => $lastWeek->startOfWeek()->toDateString(),
                    'end' => $lastWeek->endOfWeek()->toDateString()
                ];
            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                return [
                    'start' => $lastMonth->startOfMonth()->toDateString(),
                    'end' => $lastMonth->endOfMonth()->toDateString()
                ];
            default:
                return ['start' => null, 'end' => null];
        }
    }
}
