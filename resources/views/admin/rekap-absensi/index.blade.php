@extends('layout.main')

@section('title', 'Rekap Absensi')

@section('content')
    <div class="min-h-screen bg-gray-50 p-4 md:p-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Rekap Absensi</h1>
                <p class="text-gray-600">Kelola dan analisis data kehadiran siswa per kelas</p>
            </div>

            <!-- Filter Section - Full Width -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-6 bg-blue-600 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900">Filter Data</h2>
                </div>

                <form method="GET" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kelas
                            </label>

                            <select name="kelas_id" id="kelasFilter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-medium bg-white">
                                <option value="">— Semua Kelas —</option>
                                @foreach ($kelases as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                            <input type="month" name="bulan" value="{{ $selectedBulan }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-medium bg-white">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Spesifik</label>
                            <input type="date" name="tanggal" value="{{ $selectedTanggal }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-medium bg-white">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors text-sm inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Tampilkan Data
                        </button>

                        @if ($selectedKelas || $selectedTanggal)
                            <a href="{{ route('admin.rekap-absensi.index') }}"
                                class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-colors text-sm inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Main Container -->
            <div class="grid grid-cols-1 gap-6">

                <!-- Main Content -->
                <div>
                    @if (!$selectedKelas && !$selectedTanggal)
                        <!-- Panduan Penggunaan -->
                        <div class="space-y-6">
                            <!-- Welcome Card -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-8">
                                <div class="text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-full mb-4">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Mulai Analisis Data Absensi</h3>
                                    <p class="text-gray-700 text-sm">Gunakan filter di atas untuk melihat data rekap
                                        kehadiran siswa</p>
                                </div>
                            </div>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white rounded-xl border border-gray-200 p-6">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0a1 1 0 10-2 0m2 0a1 1 0 11-2 0m15.081-5.007l-.381-.023a6 6 0 00-11.964 1.738M7 11a6 6 0 1111.964 1.738L7 11" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Pilih Kelas</h4>
                                            <p class="text-sm text-gray-600">Pilih satu atau lebih kelas untuk melihat data
                                                absensinya</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-gray-200 p-6">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Pilih Periode</h4>
                                            <p class="text-sm text-gray-600">Atur bulan atau tanggal spesifik untuk
                                                membatasi data</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-gray-200 p-6">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Terapkan Filter</h4>
                                            <p class="text-sm text-gray-600">Klik "Tampilkan Data" untuk melihat hasilnya
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-gray-200 p-6">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Export Data</h4>
                                            <p class="text-sm text-gray-600">Download laporan dalam format PDF atau Excel
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Data Results -->
                        <div class="space-y-6">
                            <!-- Summary Stats -->
                            @php
                                $totalRecord = $absensiData->count();
                                $totalKelas = $statistik ? count($statistik) : 0;
                                $totalHadir = collect($statistik)->sum('hadir');
                                $totalTidakHadir =
                                    collect($statistik)->sum('tidak_hadir') + collect($statistik)->sum('alpha');
                            @endphp

                            @if ($totalRecord > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div
                                        class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                                    Total Record</p>
                                                <p class="text-2xl font-bold text-gray-900">{{ $totalRecord }}</p>
                                            </div>
                                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                                    Total Kelas</p>
                                                <p class="text-2xl font-bold text-gray-900">{{ $totalKelas }}</p>
                                            </div>
                                            <div
                                                class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0a1 1 0 10-2 0m2 0a1 1 0 11-2 0m15.081-5.007l-.381-.023a6 6 0 00-11.964 1.738M7 11a6 6 0 1111.964 1.738L7 11" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                                    Hadir</p>
                                                <p class="text-2xl font-bold text-green-600">{{ $totalHadir }}</p>
                                            </div>
                                            <div
                                                class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p
                                                    class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                                    Tidak Hadir</p>
                                                <p class="text-2xl font-bold text-red-600">{{ $totalTidakHadir }}</p>
                                            </div>
                                            <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2 2l2 2" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Export Buttons -->
                                <div class="flex gap-3 flex-wrap">
                                    <a href="{{ route('admin.rekap-absensi.export-pdf', ['kelas_id' => $selectedKelas, 'bulan' => $selectedBulan, 'tanggal' => $selectedTanggal]) }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        Export PDF
                                    </a>
                                    <a href="{{ route('admin.rekap-absensi.export', ['kelas_id' => $selectedKelas, 'bulan' => $selectedBulan, 'tanggal' => $selectedTanggal]) }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Export Excel
                                    </a>
                                </div>

                                <!-- Data Sections -->
                                @if (!empty($statistik) && count($statistik) > 0)
                                    <div class="space-y-6">
                                        @foreach ($statistik as $kelasId => $stats)
                                            <div
                                                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                                <!-- Header -->
                                                <div class="bg-white border-b border-gray-200 px-6 py-6">
                                                    <div class="flex items-center justify-between mb-5">
                                                        <div class="flex items-center gap-4">
                                                            <div
                                                                class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                                                <svg class="w-6 h-6 text-blue-600" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.581m0 0H9m0 0h-.581m0 0a1 1 0 10-2 0m2 0a1 1 0 11-2 0m15.081-5.007l-.381-.023a6 6 0 00-11.964 1.738M7 11a6 6 0 1111.964 1.738L7 11" />
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h3 class="text-xl font-bold text-gray-900">
                                                                    {{ $stats['kelas_nama'] }}</h3>
                                                                <p class="text-sm text-gray-600 mt-1">Data Absensi Kelas
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="bg-blue-50 px-5 py-3 rounded-lg border border-blue-200 text-center">
                                                            <p
                                                                class="text-xs text-blue-600 font-semibold uppercase tracking-wider mb-1">
                                                                Total Siswa</p>
                                                            <p class="text-3xl font-bold text-blue-600">
                                                                {{ $stats['total_siswa_unik'] }}</p>
                                                        </div>
                                                    </div>

                                                    <!-- Stats Grid -->
                                                    <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                                                        <div
                                                            class="bg-green-50 rounded-lg p-3 border border-green-200 text-center">
                                                            <p class="text-xs text-gray-700 font-semibold mb-1">Hadir</p>
                                                            <p class="text-xl font-bold text-green-600">
                                                                {{ $stats['hadir'] }}</p>
                                                        </div>
                                                        <div
                                                            class="bg-red-50 rounded-lg p-3 border border-red-200 text-center">
                                                            <p class="text-xs text-gray-700 font-semibold mb-1">Tidak Hadir
                                                            </p>
                                                            <p class="text-xl font-bold text-red-600">
                                                                {{ $stats['tidak_hadir'] }}</p>
                                                        </div>
                                                        <div
                                                            class="bg-yellow-50 rounded-lg p-3 border border-yellow-200 text-center">
                                                            <p class="text-xs text-gray-700 font-semibold mb-1">Izin</p>
                                                            <p class="text-xl font-bold text-yellow-600">
                                                                {{ $stats['izin'] }}</p>
                                                        </div>
                                                        <div
                                                            class="bg-orange-50 rounded-lg p-3 border border-orange-200 text-center">
                                                            <p class="text-xs text-gray-700 font-semibold mb-1">Sakit</p>
                                                            <p class="text-xl font-bold text-orange-600">
                                                                {{ $stats['sakit'] }}</p>
                                                        </div>
                                                        <div
                                                            class="bg-purple-50 rounded-lg p-3 border border-purple-200 text-center">
                                                            <p class="text-xs text-gray-700 font-semibold mb-1">Alpha</p>
                                                            <p class="text-xl font-bold text-purple-600">
                                                                {{ $stats['alpha'] }}</p>
                                                        </div>
                                                        <div
                                                            class="bg-blue-50 rounded-lg p-3 border border-blue-200 text-center">
                                                            <p class="text-xs text-gray-700 font-semibold mb-1">% Hadir</p>
                                                            <p class="text-xl font-bold text-blue-600">
                                                                @php
                                                                    $total =
                                                                        $stats['hadir'] +
                                                                        $stats['tidak_hadir'] +
                                                                        $stats['izin'] +
                                                                        $stats['sakit'] +
                                                                        $stats['alpha'];
                                                                    $percentage =
                                                                        $total > 0
                                                                            ? round(($stats['hadir'] / $total) * 100, 1)
                                                                            : 0;
                                                                @endphp
                                                                {{ $percentage }}%
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tab untuk All Students vs Absent Students -->
                                                <div x-data="{ tab: 'all' }" class="border-b border-gray-200">
                                                    <div class="flex gap-0">
                                                        <button @click="tab = 'all'"
                                                            :class="tab === 'all' ?
                                                                'border-b-2 border-blue-600 text-blue-600 bg-blue-50' :
                                                                'border-b-2 border-transparent text-gray-600 hover:text-gray-800'"
                                                            class="px-6 py-3 font-semibold text-sm transition-colors">
                                                            <svg class="w-4 h-4 inline mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10h.01M12 10h.01M9 10h.01M6 20h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                            </svg>
                                                            Semua Siswa
                                                        </button>
                                                        @if (count($stats['siswa_tidak_hadir']) > 0)
                                                            <button @click="tab = 'absent'"
                                                                :class="tab === 'absent' ?
                                                                    'border-b-2 border-red-600 text-red-600 bg-red-50' :
                                                                    'border-b-2 border-transparent text-gray-600 hover:text-gray-800'"
                                                                class="px-6 py-3 font-semibold text-sm transition-colors">
                                                                <svg class="w-4 h-4 inline mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                Tidak Hadir ({{ count($stats['siswa_tidak_hadir']) }})
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Content - All Students -->
                                                <div x-show="tab === 'all'" class="p-6">
                                                    @php
                                                        // Ambil data absensi untuk kelas ini
                                                        $absensiKelas = $absensiData->filter(
                                                            fn($a) => $a->kelas_id == $kelasId,
                                                        );
                                                        $allSiswa = [];
                                                        foreach ($absensiKelas as $abs) {
                                                            foreach ($abs->detailAbsensi as $detail) {
                                                                if ($detail->siswa) {
                                                                    $allSiswa[$detail->siswa_id] = [
                                                                        'siswa' => $detail->siswa,
                                                                        'status' => $detail->status ?? 'alpha',
                                                                    ];
                                                                }
                                                            }
                                                        }
                                                        ksort($allSiswa);
                                                    @endphp

                                                    @if (count($allSiswa) > 0)
                                                        <div class="overflow-x-auto">
                                                            <table class="w-full text-sm">
                                                                <thead>
                                                                    <tr class="border-b border-gray-200 bg-gray-50">
                                                                        <th
                                                                            class="text-left py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            No</th>
                                                                        <th
                                                                            class="text-left py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            NIS</th>
                                                                        <th
                                                                            class="text-left py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            Nama Siswa</th>
                                                                        <th
                                                                            class="text-center py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-200">
                                                                    @foreach ($allSiswa as $siswaId => $data)
                                                                        <tr class="hover:bg-gray-50 transition-colors">
                                                                            <td
                                                                                class="py-3 px-4 text-gray-900 font-semibold">
                                                                                {{ $loop->iteration }}</td>
                                                                            <td
                                                                                class="py-3 px-4 text-gray-600 font-mono text-xs">
                                                                                {{ $data['siswa']->nis }}</td>
                                                                            <td
                                                                                class="py-3 px-4 text-gray-900 font-medium">
                                                                                {{ $data['siswa']->nama_siswa }}</td>
                                                                            <td class="py-3 px-4 text-center">
                                                                                @php
                                                                                    $statusValue = strtolower(
                                                                                        $data['status'],
                                                                                    );
                                                                                    $statusLabel = match (
                                                                                        $statusValue
                                                                                    ) {
                                                                                        'hadir' => 'Hadir',
                                                                                        'izin' => 'Izin',
                                                                                        'sakit' => 'Sakit',
                                                                                        'alpha' => 'Alpha',
                                                                                        default => 'Alpha',
                                                                                    };
                                                                                    $statusColor = match (
                                                                                        $statusValue
                                                                                    ) {
                                                                                        'hadir'
                                                                                            => 'bg-green-100 text-green-800 border border-green-300',
                                                                                        'izin'
                                                                                            => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                                                                                        'sakit'
                                                                                            => 'bg-orange-100 text-orange-800 border border-orange-300',
                                                                                        'alpha'
                                                                                            => 'bg-red-100 text-red-800 border border-red-300',
                                                                                        default
                                                                                            => 'bg-red-100 text-red-800 border border-red-300',
                                                                                    };
                                                                                @endphp
                                                                                <span
                                                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                                                                    {{ $statusLabel }}
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="text-center py-8">
                                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <p class="text-gray-600 font-medium">Tidak ada data siswa</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Content - Absent Students Only -->
                                                @if (count($stats['siswa_tidak_hadir']) > 0)
                                                    <div x-show="tab === 'absent'" class="p-6">
                                                        <div class="overflow-x-auto">
                                                            <table class="w-full text-sm">
                                                                <thead>
                                                                    <tr class="border-b border-gray-200 bg-gray-50">
                                                                        <th
                                                                            class="text-left py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            No</th>
                                                                        <th
                                                                            class="text-left py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            Nama Siswa</th>
                                                                        <th
                                                                            class="text-left py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            NIS</th>
                                                                        <th
                                                                            class="text-center py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            Izin</th>
                                                                        <th
                                                                            class="text-center py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            Sakit</th>
                                                                        <th
                                                                            class="text-center py-3 px-4 font-semibold text-gray-700 text-xs uppercase tracking-wider">
                                                                            Alpha</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-200">
                                                                    @foreach ($stats['siswa_tidak_hadir'] as $siswaTidakHadir)
                                                                        <tr class="hover:bg-gray-50 transition-colors">
                                                                            <td
                                                                                class="py-3 px-4 text-gray-900 font-semibold">
                                                                                {{ $loop->iteration }}</td>
                                                                            <td
                                                                                class="py-3 px-4 text-gray-900 font-medium">
                                                                                {{ $siswaTidakHadir['nama'] }}</td>
                                                                            <td
                                                                                class="py-3 px-4 text-gray-600 font-mono text-xs">
                                                                                {{ $siswaTidakHadir['nis'] }}</td>
                                                                            <td class="py-3 px-4 text-center">
                                                                                @if ($siswaTidakHadir['izin'] > 0)
                                                                                    <span
                                                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300">{{ $siswaTidakHadir['izin'] }}x</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-gray-400 text-xs">—</span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="py-3 px-4 text-center">
                                                                                @if ($siswaTidakHadir['sakit'] > 0)
                                                                                    <span
                                                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800 border border-orange-300">{{ $siswaTidakHadir['sakit'] }}x</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-gray-400 text-xs">—</span>
                                                                                @endif
                                                                            </td>
                                                                            <td class="py-3 px-4 text-center">
                                                                                @if ($siswaTidakHadir['alpha'] > 0)
                                                                                    <span
                                                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-300">{{ $siswaTidakHadir['alpha'] }}x</span>
                                                                                @else
                                                                                    <span
                                                                                        class="text-gray-400 text-xs">—</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                                        <div
                                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-900 font-semibold text-lg">Tidak Ada Data</p>
                                        <p class="text-gray-600 text-sm mt-1">Silakan coba dengan filter yang berbeda</p>
                                    </div>
                                @endif
                            @else
                                <div class="bg-blue-50 rounded-xl border border-blue-200 p-12 text-center">
                                    <div
                                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-900 font-semibold text-lg">Belum Ada Rekap Absensi</p>
                                    <p class="text-gray-600 text-sm mt-1">Pilih kelas dan periode untuk melihat data rekap
                                        absensi</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            if (form) {
                form.addEventListener('submit', function() {
                    // Form will submit naturally
                });
            }
        });

        // Initialize Select2 untuk dropdown Kelas
        $(document).ready(function() {
            setTimeout(function() {
                try {
                    var $kelasFilter = $('#kelasFilter');

                    // Destroy existing instance if any
                    if ($kelasFilter.data('select2')) {
                        $kelasFilter.select2('destroy');
                    }

                    var optionCount = $kelasFilter.find('option').length;
                    console.log('Total options:', optionCount);

                    if (optionCount > 0) {
                        $kelasFilter.select2({
                            placeholder: '— Pilih Kelas —',
                            allowClear: true,
                            width: 'resolve',
                            minimumResultsForSearch: 0,
                            dropdownParent: $kelasFilter.closest('.relative, .grid, .block') || $('body')
                        });

                        console.log('Select2 initialized successfully');
                    } else {
                        console.warn('No options found in select element');
                    }
                } catch(e) {
                    console.error('Select2 error:', e);
                    console.error('Stack:', e.stack);
                }
            }, 500);
        });
    </script>

    <style>
        /* Select2 Wrapper */
        .select2-container {
            width: 100% !important;
            z-index: 9999 !important;
        }

        /* Single Selection Box */
        .select2-container--default .select2-selection--single {
            height: 44px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            background-color: #fff !important;
            padding: 8px 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151 !important;
            line-height: 28px !important;
            padding: 0 !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 28px !important;
            right: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 50% !important;
            margin-top: -6px !important;
        }

        /* Focus State */
        .select2-container--focus .select2-selection--single {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        /* Dropdown */
        .select2-dropdown {
            border-radius: 0.5rem !important;
            border: 1px solid #e5e7eb !important;
            margin-top: 4px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            z-index: 9999 !important;
        }

        /* Search Input */
        .select2-search__field {
            padding: 8px 12px !important;
            height: 38px !important;
            border-radius: 0.375rem !important;
            font-size: 0.875rem !important;
        }

        /* Results Container */
        .select2-results {
            padding: 4px 0 !important;
        }

        /* Option Item */
        .select2-results__option {
            padding: 10px 12px !important;
            font-size: 0.875rem !important;
            color: #374151 !important;
        }

        /* Option Hover */
        .select2-results__option--highlighted {
            background-color: #3b82f6 !important;
            color: white !important;
        }

        /* Option Selected */
        .select2-results__option--selected {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
        }

        /* No Results Message */
        .select2-results__option--disabled {
            color: #9ca3af !important;
        }
    </style>
@endsection


