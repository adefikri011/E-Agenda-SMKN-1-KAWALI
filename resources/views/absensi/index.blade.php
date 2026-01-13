@extends('layout.main')

@section('title', 'Manajemen Absensi')

@php
    // Get data from controller
    $startDate = request('start_date')
        ? \Carbon\Carbon::parse(request('start_date'))
        : \Carbon\Carbon::now()->startOfMonth();
    $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : \Carbon\Carbon::now();
    $activeTab = request('tab', 'dashboard');
@endphp

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Presensi</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Kelola data kehadiran siswa dengan mudah</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <!-- Navigation Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="flex space-x-1 p-1">
                <button onclick="switchTab('dashboard')"
                    class="tab-btn dashboard-tab flex-1 py-3 px-4 rounded-lg font-medium text-base transition-colors {{ $activeTab === 'dashboard' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Dashboard
                </button>
                <button onclick="switchTab('history')"
                    class="tab-btn history-tab flex-1 py-3 px-4 rounded-lg font-medium text-base transition-colors {{ $activeTab === 'history' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Riwayat Presensi
                </button>
            </div>
        </div>

        <!-- ============ DASHBOARD TAB ============ -->
        <div id="dashboard-tab-content" class="{{ $activeTab !== 'dashboard' ? 'hidden' : '' }}">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Jadwal Saya -->
                <a href="{{ route('guru.jadwal-saya') }}" class="group block">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Jadwal Saya</h3>
                        <p class="text-base text-gray-600">Input presensi dari jadwal mengajar</p>
                    </div>
                </a>

                <!-- Riwayat -->
                <button onclick="switchTab('history')" class="group block text-left">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Riwayat Presensi</h3>
                        <p class="text-base text-gray-600">Analisis data kehadiran siswa</p>
                    </div>
                </button>
            </div>

            <!-- Dashboard Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Catatan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="dashboardTotalAbsensi">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Kehadiran</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="dashboardRataKehadiran">0%</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Ketidakhadiran</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="dashboardTidakHadir">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Siswa</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="dashboardSiswaUnik">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIWAYAT TAB ============ -->
        <div id="history-tab-content" class="{{ $activeTab !== 'history' ? 'hidden' : '' }}">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Riwayat Presensi</h2>
                <p class="mt-2 text-base text-gray-600">Lihat dan analisis data kehadiran siswa dalam periode waktu tertentu</p>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Filter Data</h3>
                </div>

                <form method="GET" action="{{ route('absensi.index') }}" class="space-y-6">
                    <input type="hidden" name="tab" value="history">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        <!-- Tanggal Mulai -->
                        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <label class="block text-base font-semibold text-gray-700 mb-3">Dari Tanggal</label>
                            <input type="date" name="start_date"
                                value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <label class="block text-base font-semibold text-gray-700 mb-3">Sampai Tanggal</label>
                            <input type="date" name="end_date"
                                value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                        </div>

                        <!-- Kelas -->
                        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <label class="block text-base font-semibold text-gray-700 mb-3">Kelas</label>
                            <select name="kelas_id"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                                <option value="">-- Semua Kelas --</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <label class="block text-base font-semibold text-gray-700 mb-3">Mata Pelajaran</label>
                            <select name="mapel_id"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                                <option value="">-- Semua Mapel --</option>
                                @foreach ($mapel as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('mapel_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors text-base">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Catatan</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="totalAbsensi">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Kehadiran</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="rataKehadiran">0%</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Ketidakhadiran</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="totalTidakHadir">0</p>
                        </div>
                       <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Jumlah Siswa</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="totalSiswaUnik">0</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Detail Presensi</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Tanggal</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Kelas</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Mata Pelajaran</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Nama Siswa</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    NIS</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTableBody" class="divide-y divide-gray-200">
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-base font-medium text-gray-700 mb-2">Pilih filter dan klik Tampilkan untuk melihat data</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                    <p class="text-base text-gray-600">Total: <span id="totalRows" class="font-semibold">0</span> catatan</p>
                    <p class="text-base text-gray-600">Periode: <span id="periodInfo" class="font-semibold">-</span></p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
@endsection

<script>
    // ============ TAB SWITCHER ============
    function switchTab(tabName) {
        // Hide all tabs
        document.getElementById('dashboard-tab-content').classList.add('hidden');
        document.getElementById('history-tab-content').classList.add('hidden');
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('text-gray-600');
        });

        // Show selected tab
        document.getElementById(tabName + '-tab-content').classList.remove('hidden');

        // Add active class to selected tab button
        document.querySelector('.' + tabName + '-tab').classList.add('bg-blue-600', 'text-white');
        document.querySelector('.' + tabName + '-tab').classList.remove('text-gray-600');

        // If history tab, load data
        if (tabName === 'history') {
            setTimeout(() => loadAbsensiHistory(), 100);
        }

        // If dashboard tab, load dashboard stats
        if (tabName === 'dashboard') {
            setTimeout(() => loadDashboardStats(), 100);
        }

        // Update URL
        const newUrl = window.location.pathname + '?tab=' + tabName;
        window.history.replaceState({
            path: newUrl
        }, '', newUrl);
    }

    // ============ LOAD DASHBOARD STATS ============
    function loadDashboardStats() {
        const currentMonth = new Date();
        const startDate = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 1).toISOString().split('T')[0];
        const endDate = currentMonth.toISOString().split('T')[0];

        const params = new URLSearchParams({
            start_date: startDate,
            end_date: endDate
        });

        fetch(`/api/absensi/history?${params}`)
            .then(res => res.json())
            .then(data => {
                updateDashboardStatistics(data);
            })
            .catch(err => {
                console.error('Error loading dashboard stats:', err);
            });
    }

    // Update dashboard statistics
    function updateDashboardStatistics(data) {
        if (!data || data.length === 0) {
            document.getElementById('dashboardTotalAbsensi').textContent = '0';
            document.getElementById('dashboardRataKehadiran').textContent = '0%';
            document.getElementById('dashboardTidakHadir').textContent = '0';
            document.getElementById('dashboardSiswaUnik').textContent = '0';
            return;
        }

        const total = data.length;
        const hadir = data.filter(d => d.status === 'hadir').length;
        const tidakHadir = total - hadir;
        const siswaUnik = new Set(data.map(d => d.siswa_id)).size;
        const rataKehadiran = Math.round((hadir / total) * 100);

        document.getElementById('dashboardTotalAbsensi').textContent = total;
        document.getElementById('dashboardRataKehadiran').textContent = rataKehadiran + '%';
        document.getElementById('dashboardTidakHadir').textContent = tidakHadir;
        document.getElementById('dashboardSiswaUnik').textContent = siswaUnik;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const currentTab = "{{ $activeTab }}";
        if (currentTab === 'history') {
            loadAbsensiHistory();
        } else if (currentTab === 'dashboard') {
            loadDashboardStats();
        }
    });

    // Status badge color mapping
    const statusColors = {
        'hadir': {
            bg: 'bg-green-100',
            text: 'text-green-800',
            label: 'Hadir'
        },
        'sakit': {
            bg: 'bg-yellow-100',
            text: 'text-yellow-800',
            label: 'Sakit'
        },
        'izin': {
            bg: 'bg-blue-100',
            text: 'text-blue-800',
            label: 'Izin'
        },
        'alpha': {
            bg: 'bg-red-100',
            text: 'text-red-800',
            label: 'Alpa'
        }
    };

    // Load history absensi
    function loadAbsensiHistory() {
        const startDateInput = document.querySelector('input[name="start_date"]');
        const endDateInput = document.querySelector('input[name="end_date"]');
        const kelasSelect = document.querySelector('select[name="kelas_id"]');
        const mapelSelect = document.querySelector('select[name="mapel_id"]');

        if (!startDateInput || !endDateInput) {
            return;
        }

        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        const kelasId = kelasSelect ? kelasSelect.value : '';
        const mapelId = mapelSelect ? mapelSelect.value : '';

        if (!startDate || !endDate) {
            return;
        }

        // Build query string
        const params = new URLSearchParams({
            start_date: startDate,
            end_date: endDate,
            ...(kelasId && {
                kelas_id: kelasId
            }),
            ...(mapelId && {
                mapel_id: mapelId
            })
        });

        fetch(`/api/absensi/history?${params}`)
            .then(res => res.json())
            .then(data => {
                renderAbsensiData(data);
                updateStatistics(data);
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Gagal memuat data absensi');
            });
    }

    // Render absensi data ke table
    function renderAbsensiData(data) {
        const tbody = document.getElementById('absensiTableBody');
        const totalRowsSpan = document.getElementById('totalRows');
        const startDate = document.querySelector('input[name="start_date"]').value;
        const endDate = document.querySelector('input[name="end_date"]').value;

        if (!data || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-base font-medium text-gray-700 mb-2">Tidak ada data presensi untuk periode ini</p>
                    </td>
                </tr>
            `;
            totalRowsSpan.textContent = '0';
            document.getElementById('periodInfo').textContent = formatDateRange(startDate, endDate);
            return;
        }

        tbody.innerHTML = data.map(item => `
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">${formatDate(item.tanggal)}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.kelas?.nama_kelas || '-'}</td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.mapel?.nama || '-'}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">${item.siswa?.nama_siswa || '-'}</td>
                <td class="px-6 py-4 text-sm text-center text-gray-600">${item.siswa?.nis || '-'}</td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${statusColors[item.status].bg} ${statusColors[item.status].text}">
                        ${statusColors[item.status].label}
                    </span>
                </td>
            </tr>
        `).join('');

        totalRowsSpan.textContent = data.length;
        document.getElementById('periodInfo').textContent = formatDateRange(startDate, endDate);
    }

    // Update statistics
    function updateStatistics(data) {
        if (!data || data.length === 0) {
            document.getElementById('totalAbsensi').textContent = '0';
            document.getElementById('rataKehadiran').textContent = '0%';
            document.getElementById('totalTidakHadir').textContent = '0';
            document.getElementById('totalSiswaUnik').textContent = '0';
            return;
        }

        const total = data.length;
        const hadir = data.filter(d => d.status === 'hadir').length;
        const tidakHadir = total - hadir;
        const siswaUnik = new Set(data.map(d => d.siswa_id)).size;
        const rataKehadiran = Math.round((hadir / total) * 100);

        document.getElementById('totalAbsensi').textContent = total;
        document.getElementById('rataKehadiran').textContent = rataKehadiran + '%';
        document.getElementById('totalTidakHadir').textContent = tidakHadir;
        document.getElementById('totalSiswaUnik').textContent = siswaUnik;
    }

    // Format date helper
    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        };
        return date.toLocaleDateString('id-ID', options);
    }

    // Format date range
    function formatDateRange(startDate, endDate) {
        return `${formatDate(startDate)} - ${formatDate(endDate)}`;
    }

    // Handle form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        loadAbsensiHistory();
    });

    // Auto load on date change
    document.querySelector('input[name="start_date"]').addEventListener('change', loadAbsensiHistory);
    document.querySelector('input[name="end_date"]').addEventListener('change', loadAbsensiHistory);
    document.querySelector('select[name="kelas_id"]').addEventListener('change', loadAbsensiHistory);
    document.querySelector('select[name="mapel_id"]').addEventListener('change', loadAbsensiHistory);
</script>
