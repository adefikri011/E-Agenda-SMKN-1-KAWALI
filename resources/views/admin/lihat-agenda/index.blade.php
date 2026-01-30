@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Agenda Guru</h1>
                <p class="text-gray-600 text-sm">
                    @if(!$selectedTanggalAwal && !$selectedTanggalAkhir)
                        Menampilkan semua agenda
                    @else
                        @if($selectedTanggalAwal && $selectedTanggalAkhir)
                            Periode {{ \Carbon\Carbon::parse($selectedTanggalAwal)->isoFormat('D MMM') }} - {{ \Carbon\Carbon::parse($selectedTanggalAkhir)->isoFormat('D MMM YYYY') }}
                        @elseif($selectedTanggalAwal)
                            Mulai {{ \Carbon\Carbon::parse($selectedTanggalAwal)->isoFormat('D MMMM YYYY') }}
                        @endif
                    @endif
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                @if($selectedTanggalAwal || $selectedTanggalAkhir || $selectedKelas || $selectedStatus)
                    <a href="{{ route('admin.lihat-agenda.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filter
                    </a>
                @endif

                <button id="filterToggle" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700 text-sm font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>

                <form action="{{ route('admin.lihat-agenda.export') }}" method="GET" class="inline">
                    @foreach($request->except('export') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 text-white text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Total Agenda</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $totalAgenda }}</p>
                    </div>
                    <div class="text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Hari Ini</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $totalHariIni }}</p>
                    </div>
                    <div class="text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Minggu Ini</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $totalMingguIni }}</p>
                    </div>
                    <div class="text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1">Ditampilkan</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $agendas->total() }}</p>
                    </div>
                    <div class="text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg border border-gray-200 mb-6 overflow-hidden transition-all duration-300" id="filterForm" style="display: {{ ($selectedKelas || $selectedGuru || $selectedMapel || $selectedTanggalAwal || $selectedTanggalAkhir) ? 'block' : 'none' }};">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="font-medium text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter Agenda
            </h3>
            <button id="closeFilterBtn" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="GET" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Kelas Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                    <select name="kelas_id" id="kelasSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kelas</option>
                        @foreach($kelases as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Awal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_awal" value="{{ $selectedTanggalAwal }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Status TTD Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status TTD</label>
                    <select name="status_ttd" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua</option>
                        <option value="sudah" {{ $selectedStatus == 'sudah' ? 'selected' : '' }}>Sudah</option>
                        <option value="belum" {{ $selectedStatus == 'belum' ? 'selected' : '' }}>Belum</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.lihat-agenda.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-medium">
                    Reset
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 text-white text-sm font-medium flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Agenda Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        @if($agendas->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($agendas as $kelasGroup)
                    <!-- Kelas Header (Collapsible) -->
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <button type="button" class="kelas-toggle w-full px-6 py-4 flex items-center justify-between hover:bg-blue-50 transition-colors" data-kelas="{{ $kelasGroup->kelas_id }}">
                            <div class="flex items-center gap-4 flex-1 text-left">
                                <svg class="kelas-icon w-5 h-5 text-blue-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $kelasGroup->kelas_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $kelasGroup->total }} agenda hari ini</p>
                                </div>
                            </div>
                        </button>
                    </div>

                    <!-- Agenda Details (Collapsible Content) -->
                    <div class="kelas-content hidden" data-kelas="{{ $kelasGroup->kelas_id }}">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-t border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mapel</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($kelasGroup->agendas as $agenda)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <!-- Date Column -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    <div class="font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($agenda->tanggal)->isoFormat('DD/MM/YYYY') }}
                                                    </div>
                                                    <div class="text-gray-500 text-xs">
                                                        {{ \Carbon\Carbon::parse($agenda->tanggal)->isoFormat('dddd') }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Teacher Column -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $agenda->user->guru->nama ?? $agenda->user->name ?? '-' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $agenda->user->guru->nip ?? '' }}
                                                </div>
                                            </td>

                                            <!-- Subject Column -->
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                @php
                                                    $mapelsToShow = [];
                                                    if(isset($agenda->mapels) && is_object($agenda->mapels) && method_exists($agenda->mapels, 'count') && $agenda->mapels->count() > 0) {
                                                        $mapelsToShow = $agenda->mapels;
                                                    } elseif($agenda->mapel) {
                                                        $mapelsToShow = [$agenda->mapel];
                                                    }
                                                @endphp
                                                @if(count($mapelsToShow) > 0)
                                                    <div class="flex flex-col gap-1">
                                                        @foreach($mapelsToShow as $mapel)
                                                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                                {{ $mapel->nama ?? 'Mapel' }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-gray-400 text-xs">-</span>
                                                @endif
                                            </td>

                                            <!-- Time Column -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if($agenda->startJampel && $agenda->endJampel)
                                                        {{ \Carbon\Carbon::parse($agenda->startJampel->jam_mulai)->format('H:i') }} -
                                                        {{ \Carbon\Carbon::parse($agenda->endJampel->jam_selesai)->format('H:i') }}
                                                    @elseif($agenda->startJampel)
                                                        {{ \Carbon\Carbon::parse($agenda->startJampel->jam_mulai)->format('H:i') }}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Material Column -->
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $agenda->materi ?? $agenda->kegiatan ?? '' }}">
                                                    {{ Str::limit($agenda->materi ?? $agenda->kegiatan ?? '', 60) }}
                                                </div>
                                            </td>

                                            <!-- Status Column -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'draft' => 'bg-gray-100 text-gray-800',
                                                        'submitted' => 'bg-yellow-100 text-yellow-800',
                                                        'approved' => 'bg-green-100 text-green-800'
                                                    ];
                                                    $statusLabels = [
                                                        'draft' => 'Draft',
                                                        'submitted' => 'Menunggu',
                                                        'approved' => 'Disetujui'
                                                    ];
                                                    $currentStatus = $agenda->status ?? 'draft';
                                                    $statusColor = $statusColors[$currentStatus] ?? 'bg-gray-100 text-gray-800';
                                                    $statusLabel = $statusLabels[$currentStatus] ?? ucfirst($currentStatus);
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>

                                            <!-- Actions Column -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.lihat-agenda.show', $agenda->id) }}"
                                                   class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium">{{ $agendas->firstItem() }}</span> -
                        <span class="font-medium">{{ $agendas->lastItem() }}</span> dari
                        <span class="font-medium">{{ $agendas->total() }}</span> kelas
                    </div>
                    <div>
                        {{ $agendas->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada agenda</h3>
                <p class="mt-2 text-sm text-gray-500">
                    @if($selectedKelas || $selectedGuru || $selectedMapel || $selectedTanggalAwal || $selectedTanggalAkhir)
                        Tidak ada agenda yang sesuai dengan filter yang dipilih.
                    @else
                        Belum ada agenda yang dibuat untuk hari ini.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        height: auto !important;
        padding: 0.5rem 0.75rem !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding: 0 !important;
        line-height: 1.5 !important;
        color: #111827 !important;
    }

    .select2-dropdown {
        border-color: #d1d5db !important;
        border-radius: 0.5rem !important;
        margin-top: 0.25rem !important;
        max-height: 300px !important;
        z-index: 9999 !important; /* Pastikan dropdown muncul di atas elemen lain */
    }

    .select2-results__options {
        max-height: 250px !important;
    }

    .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: #dbeafe !important;
        color: #1e40af !important;
    }

    .select2-results__option--selected {
        background-color: #3b82f6 !important;
        color: white !important;
    }

    .select2-search__field {
        border-color: #d1d5db !important;
        padding: 0.5rem 0.75rem !important;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Inisialisasi Select2 pada elemen dengan class .select2 (sesuaikan dengan HTML)
        $('.select2').select2({
            dropdownParent: $('#filterForm'), // Agar dropdown tidak terpotong oleh overflow hidden
            theme: 'default',
            width: '100%'
        });

        const filterForm = document.getElementById('filterForm');
        const filterToggle = document.getElementById('filterToggle');
        const closeFilterBtn = document.getElementById('closeFilterBtn');

        // Fungsi untuk mengubah teks tombol dan visibilitas form
        function setFilterState(isOpen) {
            if (isOpen) {
                filterForm.style.display = 'block';
                // Ubah menjadi "Tutup Filter"
                filterToggle.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Tutup Filter</span>
                `;
            } else {
                filterForm.style.display = 'none';
                // Ubah kembali menjadi "Filter"
                filterToggle.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                `;
            }
        }

        // Event Listener untuk tombol Filter
        if (filterToggle) {
            filterToggle.addEventListener('click', function(e) {
                e.preventDefault();
                // Cek apakah form sedang tersembunyi atau tidak
                const isHidden = window.getComputedStyle(filterForm).display === 'none';
                setFilterState(isHidden);
            });
        }

        // Event Listener untuk tombol Close (X)
        if (closeFilterBtn) {
            closeFilterBtn.addEventListener('click', function(e) {
                e.preventDefault();
                setFilterState(false);
            });
        }

        // Cek status awal dari PHP (untuk sinkronisasi teks tombol saat load pertama)
        const isVisible = window.getComputedStyle(filterForm).display !== 'none';
        setFilterState(isVisible);

        // Kelas Toggle Functionality
        document.querySelectorAll('.kelas-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const kelasId = this.getAttribute('data-kelas');
                const content = document.querySelector(`.kelas-content[data-kelas="${kelasId}"]`);
                const icon = this.querySelector('.kelas-icon');

                // Toggle content visibility
                content.classList.toggle('hidden');

                // Rotate icon
                if (content.classList.contains('hidden')) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    });

    function applyQuickPeriod(select) {
        const value = select.value;
        if (!value) return;

        const today = new Date();
        let startDate = '';
        let endDate = '';

        switch(value) {
            case 'today':
                startDate = today.toISOString().split('T')[0];
                endDate = startDate;
                break;
            case 'week':
                const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
                const lastDay = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                startDate = firstDay.toISOString().split('T')[0];
                endDate = lastDay.toISOString().split('T')[0];
                break;
            case 'month':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
                break;
            case 'last_week':
                const lastWeek = new Date(today.setDate(today.getDate() - 7));
                const lastWeekFirst = new Date(lastWeek.setDate(lastWeek.getDate() - lastWeek.getDay()));
                const lastWeekLast = new Date(lastWeek.setDate(lastWeek.getDate() - lastWeek.getDay() + 6));
                startDate = lastWeekFirst.toISOString().split('T')[0];
                endDate = lastWeekLast.toISOString().split('T')[0];
                break;
            case 'last_month':
                startDate = new Date(today.getFullYear(), today.getMonth() - 1, 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), today.getMonth(), 0).toISOString().split('T')[0];
                break;
        }

        // Set date inputs
        document.querySelector('input[name="tanggal_awal"]').value = startDate;
        document.querySelector('input[name="tanggal_akhir"]').value = endDate;

        // Submit form
        select.form.submit();
    }
</script>
@endsection
