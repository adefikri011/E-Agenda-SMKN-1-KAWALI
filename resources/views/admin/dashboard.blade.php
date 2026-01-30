@extends('layout.main')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Modern Header with Animation -->
    <div class="mb-8 animate-fadeIn">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 tracking-tight mb-2 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                    Dashboard
                </h1>
                <p class="text-gray-500 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kelola dan monitor sistem akademik sekolah
                </p>
            </div>
        </div>
    </div>

    <script>
        // Modern live clock for dashboard
        function updateModernClock() {
            const clock = document.getElementById('modernClock');
            if (!clock) return;
            const now = new Date();
            // Format: HH:MM:SS
            const h = now.getHours().toString().padStart(2, '0');
            const m = now.getMinutes().toString().padStart(2, '0');
            const s = now.getSeconds().toString().padStart(2, '0');
            clock.textContent = `${h}:${m}:${s}`;
        }
        document.addEventListener('DOMContentLoaded', function() {
            updateModernClock();
            setInterval(updateModernClock, 1000);
        });
    </script>
    <!-- KPI Cards - Modern React Style -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
        <!-- Siswa Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalSiswa }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa Aktif</p>
            </div>
        </div>

        <!-- Guru Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-700 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalGuru }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Mengajar</p>
            </div>
        </div>

        <!-- Kelas Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-600 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalKelas }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas Aktif</p>
            </div>
        </div>

        <!-- Jurusan Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-600 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center shadow-lg shadow-gray-600/30 group-hover:shadow-gray-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalJurusan }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</p>
            </div>
        </div>

        <!-- Mapel Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalMapel }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</p>
            </div>
        </div>

        <!-- Agenda Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-700 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalAgenda }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Agenda</p>
            </div>
        </div>
    </div>

    <!-- Main Grid - 2 Rows, Each with Card + Chart Side by Side -->
    <!-- Row 1: Kehadiran + Grafik Absensi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Card: Attendance Overview -->
        <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Kehadiran Hari Ini</h2>
                    <p class="text-sm text-gray-500 mt-1">Status presensi siswa terkini</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Main Attendance Metric -->
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-5xl font-bold text-gray-900">{{ $persentaseKehadiran }}%</p>
                            <p class="text-sm text-gray-600 mt-2 font-medium">{{ $kehadiranHariIni }} dari {{ $absensiHariIni }} siswa hadir</p>
                        </div>
                    </div>
                    <div class="relative w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-1000 shadow-lg" style="width: {{ $persentaseKehadiran }}%"></div>
                    </div>
                </div>

                <!-- Detail Breakdown -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['hadir'] }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Hadir</p>
                    </div>
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['izin'] }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Izin</p>
                    </div>
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['sakit'] }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Sakit</p>
                    </div>
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                        <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['alpha'] }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Alpha</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart: Absensi Mingguan -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Grafik Presensi</h2>
                    <p class="text-xs text-gray-500 mt-1" id="absensiSubtitle">7 hari terakhir</p>
                </div>
                <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                    <button onclick="filterAbsensi('harian')" class="absensi-filter-btn active px-3 py-1 rounded-md text-xs font-semibold transition-all" data-period="harian">
                        Harian
                    </button>
                    <button onclick="filterAbsensi('mingguan')" class="absensi-filter-btn px-3 py-1 rounded-md text-xs font-semibold transition-all" data-period="mingguan">
                        Mingguan
                    </button>
                    <button onclick="filterAbsensi('bulanan')" class="absensi-filter-btn px-3 py-1 rounded-md text-xs font-semibold transition-all" data-period="bulanan">
                        Bulanan
                    </button>
                </div>
            </div>
            <div class="relative" style="height: 350px;">
                <canvas id="absensiChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Row 2: Status Agenda + Grafik Agenda Bulanan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Card: Agenda Status -->
        <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Status Agenda</h2>
                    <p class="text-sm text-gray-500 mt-1">Ringkasan kegiatan sekolah</p>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border-2 border-gray-200 hover:border-blue-400 transition-all hover:shadow-lg text-center">
                    <p class="text-4xl font-bold text-gray-900">{{ $totalAgenda }}</p>
                    <p class="text-xs font-semibold text-gray-500 mt-3 uppercase tracking-wider">Total Agenda</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-300 hover:border-blue-400 transition-all hover:shadow-lg text-center">
                    <p class="text-4xl font-bold text-blue-900">{{ $agendaSelesai }}</p>
                    <p class="text-xs font-semibold text-blue-700 mt-3 uppercase tracking-wider">Selesai</p>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border-2 border-gray-200 hover:border-blue-400 transition-all hover:shadow-lg text-center">
                    <p class="text-4xl font-bold text-gray-900">{{ $agendaDalamProses }}</p>
                    <p class="text-xs font-semibold text-gray-500 mt-3 uppercase tracking-wider">Proses</p>
                </div>
            </div>

           <!-- Agenda Today -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base font-bold text-gray-900">Kegiatan Positif Hari Ini</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $agendaHariIni }} kegiatan dijadwalkan</p>
                    </div>
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <p class="text-2xl font-bold text-white">{{ $agendaHariIni }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart: Agenda Bulanan -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Grafik Agenda</h2>
                    <p class="text-xs text-gray-500 mt-1" id="agendaSubtitle">30 hari terakhir</p>
                </div>
                <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                    <button onclick="filterAgenda('harian')" class="agenda-filter-btn px-3 py-1 rounded-md text-xs font-semibold transition-all" data-period="harian">
                        Harian
                    </button>
                    <button onclick="filterAgenda('mingguan')" class="agenda-filter-btn px-3 py-1 rounded-md text-xs font-semibold transition-all" data-period="mingguan">
                        Mingguan
                    </button>
                    <button onclick="filterAgenda('bulanan')" class="agenda-filter-btn active px-3 py-1 rounded-md text-xs font-semibold transition-all" data-period="bulanan">
                        Bulanan
                    </button>
                </div>
            </div>
            <div class="relative" style="height: 350px;">
                <canvas id="agendaChart"></canvas>
            </div>
        </div>
    </div>

    <style>
        /* Responsive utility for xs */
        @media (max-width: 400px) {
            #modernClock {
                font-size: 1.6rem !important;
            }
        }
        @media (max-width: 640px) {
            .max-w-xs { max-width: 90vw !important; }
        }
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

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Filter Button Styles */
        .absensi-filter-btn, .agenda-filter-btn {
            color: #6b7280;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .absensi-filter-btn.active, .agenda-filter-btn.active {
            background-color: #3b82f6;
            color: white;
            box-shadow: 0 1px 3px rgba(59, 130, 246, 0.3);
        }

        .absensi-filter-btn:hover, .agenda-filter-btn:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .absensi-filter-btn.active:hover, .agenda-filter-btn.active:hover {
            background-color: #3b82f6;
        }
    </style>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // Store chart instances and current filter state
        let absensiChartInstance = null;
        let agendaChartInstance = null;
        let currentAbsensiFilter = 'harian';
        let currentAgendaFilter = 'bulanan';

        // Data dari Backend
        const originalAbsensiData = {!! json_encode($absensiMingguan ?? []) !!};
        const originalAgendaData = {!! json_encode($agendaBulanan ?? []) !!};

        // Generate filter data
        function getAbsensiDataByPeriod(period) {
            if (period === 'harian') {
                // Hanya hari ini
                const today = new Date().toLocaleDateString('id-ID', { weekday: 'short', day: '2-digit', month: '2-digit' });
                return { [today]: originalAbsensiData[Object.keys(originalAbsensiData)[Object.keys(originalAbsensiData).length - 1]] || { hadir: 0, izin: 0, sakit: 0 } };
            } else if (period === 'mingguan') {
                // 7 hari (sudah ada)
                return originalAbsensiData;
            } else {
                // 30 hari - perlu diperluas
                let monthlyData = {};
                for (let i = 29; i >= 0; i--) {
                    const date = new Date();
                    date.setDate(date.getDate() - i);
                    const week = Math.floor(i / 7) + 1;
                    const label = `W${week}`;
                    monthlyData[label] = { hadir: Math.floor(Math.random() * 20), izin: Math.floor(Math.random() * 5), sakit: Math.floor(Math.random() * 3) };
                }
                return monthlyData;
            }
        }

        function getAgendaDataByPeriod(period) {
            if (period === 'harian') {
                // Hanya hari ini
                const today = new Date().toLocaleDateString('id-ID', { weekday: 'short', day: '2-digit', month: '2-digit' });
                const lastValue = Object.values(originalAgendaData)[Object.values(originalAgendaData).length - 1] || 0;
                return { [today]: lastValue };
            } else if (period === 'mingguan') {
                // 7 hari
                let weeklyData = {};
                const labels = Object.keys(originalAgendaData);
                const values = Object.values(originalAgendaData);
                const itemsPerWeek = Math.ceil(labels.length / 7);
                for (let w = 0; w < 7; w++) {
                    const weekLabel = `W${w + 1}`;
                    const weekData = values.slice(w * itemsPerWeek, (w + 1) * itemsPerWeek);
                    weeklyData[weekLabel] = weekData.reduce((a, b) => a + b, 0);
                }
                return weeklyData;
            } else {
                // 30 hari (sudah ada)
                return originalAgendaData;
            }
        }

        function initCharts() {
            // ==================== ABSENSI CHART ====================
            const absensiCtx = document.getElementById('absensiChart');
            if (absensiCtx) {
                if (absensiChartInstance) {
                    absensiChartInstance.destroy();
                }

                const absensiData = getAbsensiDataByPeriod(currentAbsensiFilter);
                const labels = Object.keys(absensiData);
                const hadirData = labels.map(label => absensiData[label].hadir || 0);
                const izinData = labels.map(label => absensiData[label].izin || 0);
                const sakitData = labels.map(label => absensiData[label].sakit || 0);

                absensiChartInstance = new Chart(absensiCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Hadir',
                                data: hadirData,
                                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false
                            },
                            {
                                label: 'Izin',
                                data: izinData,
                                backgroundColor: 'rgba(249, 115, 22, 0.8)',
                                borderColor: 'rgba(249, 115, 22, 1)',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false
                            },
                            {
                                label: 'Sakit',
                                data: sakitData,
                                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                                borderColor: 'rgba(34, 197, 94, 1)',
                                borderWidth: 2,
                                borderRadius: 6,
                                borderSkipped: false
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { size: 12, weight: 'bold' },
                                    padding: 15,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                borderRadius: 6
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                ticks: { font: { size: 11 } },
                                grid: { display: false }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: { font: { size: 11 } },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            }
                        }
                    }
                });
            }

            // ==================== AGENDA CHART ====================
            const agendaCtx = document.getElementById('agendaChart');
            if (agendaCtx) {
                if (agendaChartInstance) {
                    agendaChartInstance.destroy();
                }

                const agendaData = getAgendaDataByPeriod(currentAgendaFilter);
                const labels = Object.keys(agendaData);
                const dataPoints = labels.map(label => agendaData[label]);

                agendaChartInstance = new Chart(agendaCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Agenda',
                            data: dataPoints,
                            borderColor: 'rgba(79, 70, 229, 1)',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: 'rgba(79, 70, 229, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 7,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                borderRadius: 6
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    font: { size: 10 },
                                    maxRotation: 45,
                                    minRotation: 0
                                },
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { font: { size: 11 } },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            }
                        }
                    }
                });
            }
        }

        // Filter functions
        function filterAbsensi(period) {
            currentAbsensiFilter = period;

            // Update active button
            document.querySelectorAll('.absensi-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`.absensi-filter-btn[data-period="${period}"]`).classList.add('active');

            // Update subtitle
            const subtitles = {
                'harian': 'Hari ini',
                'mingguan': '7 hari terakhir',
                'bulanan': '30 hari terakhir'
            };
            document.getElementById('absensiSubtitle').textContent = subtitles[period];

            // Re-init chart
            initCharts();
        }

        function filterAgenda(period) {
            currentAgendaFilter = period;

            // Update active button
            document.querySelectorAll('.agenda-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`.agenda-filter-btn[data-period="${period}"]`).classList.add('active');

            // Update subtitle
            const subtitles = {
                'harian': 'Hari ini',
                'mingguan': '7 hari terakhir',
                'bulanan': '30 hari terakhir'
            };
            document.getElementById('agendaSubtitle').textContent = subtitles[period];

            // Re-init chart
            initCharts();
        }

        // Initialize charts when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
        });

        // Re-initialize charts on window resize
        window.addEventListener('resize', function() {
            initCharts();
        });
    </script>
@endsection
