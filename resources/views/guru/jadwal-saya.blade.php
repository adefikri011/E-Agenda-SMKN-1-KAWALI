@extends('layout.main')

@section('title', 'Jadwal Mengajar Saya')

@section('content')
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Jadwal Mengajar Saya</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Daftar kelas dan mata pelajaran yang Anda ajar</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <!-- Informasi Sistem - Card Modern -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pengaturan Jadwal</h3>
                        <p class="mt-1 text-base text-gray-600">Jadwal diatur oleh administrator. Hubungi admin untuk perubahan jadwal mengajar.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Jadwal</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="totalJadwal">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Presensi Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="presensiHariIni">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Belum Presensi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="belumPresensi">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="totalSiswa">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Buat Agenda -->
            <a href="{{ route('agenda.index') }}" class="group block">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buat Agenda</h3>
                    <p class="text-base text-gray-600">Buat agenda pembelajaran untuk kelas</p>
                </div>
            </a>

            <!-- Lihat Riwayat -->
            <a href="{{ route('absensi.index') }}" class="group block">
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
                    <p class="text-base text-gray-600">Lihat riwayat presensi siswa</p>
                </div>
            </a>
        </div>

        <!-- Loading State - Modern -->
        <div id="loadingState" class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-12">
                    <div class="flex flex-col items-center justify-center">
                        <div class="relative">
                            <div class="w-12 h-12 border-2 border-gray-200 border-t-blue-600 rounded-full animate-spin"></div>
                        </div>
                        <p class="mt-6 text-gray-700 font-medium">Memuat jadwal mengajar...</p>
                        <p class="mt-1 text-sm text-gray-500">Sedang mengambil data</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Container -->
        <div id="scheduleCards" class="space-y-6 mb-8"></div>

        <!-- Empty State - Modern -->
        <div id="emptyState" class="hidden mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-12">
                    <div class="text-center">
                        <div class="mx-auto w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Jadwal Mengajar</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Anda belum memiliki jadwal mengajar yang ditetapkan.</p>
                        <button onclick="location.reload()" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Refresh Halaman
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error State - Modern -->
        <div id="errorState" class="hidden mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-12">
                    <div class="text-center">
                        <div class="mx-auto w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2" id="errorTitle">Terjadi Kesalahan</h3>
                        <p class="text-gray-600 mb-6" id="errorMessage"></p>
                        <button onclick="location.reload()" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Coba Lagi
                        </button>
                    </div>
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

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    loadSchedules();

    function loadSchedules() {
        console.log('Loading schedules...');

        fetch('/api/my-schedules', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(schedules => {
            console.log('Schedules loaded:', schedules);
            hideAllStates();

            if (!schedules || schedules.length === 0) {
                showEmptyState();
                return;
            }

            renderSchedules(schedules);
            updateStatistics(schedules);
        })
        .catch(error => {
            console.error('Error loading schedules:', error);
            hideAllStates();
            showErrorState(error.message);
        });
    }

    function hideAllStates() {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('emptyState').classList.add('hidden');
        document.getElementById('errorState').classList.add('hidden');
        document.getElementById('scheduleCards').classList.add('hidden');
    }

    function showEmptyState() {
        document.getElementById('emptyState').classList.remove('hidden');
    }

    function showErrorState(message) {
        document.getElementById('errorState').classList.remove('hidden');
        document.getElementById('errorMessage').textContent = message || 'Terjadi kesalahan saat memuat data. Silakan coba lagi.';
    }

    function updateStatistics(schedules) {
        // Update statistics
        document.getElementById('totalJadwal').textContent = schedules.length;

        const presensiHariIni = schedules.filter(s => s.has_absensi_today).length;
        document.getElementById('presensiHariIni').textContent = presensiHariIni;

        const belumPresensi = schedules.length - presensiHariIni;
        document.getElementById('belumPresensi').textContent = belumPresensi;

        const totalSiswa = schedules.reduce((sum, s) => sum + (s.total_siswa || 0), 0);
        document.getElementById('totalSiswa').textContent = totalSiswa;
    }

    function renderSchedules(schedules) {
        const container = document.getElementById('scheduleCards');
        container.innerHTML = '';
        container.classList.remove('hidden');

        // Group by hari jika diperlukan
        schedules.forEach(schedule => {
            const card = createScheduleCard(schedule);
            container.appendChild(card);
        });
    }

    function createScheduleCard(schedule) {
        const card = document.createElement('div');
        card.className = 'bg-white rounded-xl shadow-sm border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-200 animate-fadeIn';

        // Format jadwal info
        const jadwalInfo = schedule.jampel_name
            ? `<div class="flex items-center text-sm text-gray-600 mt-2">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                ${schedule.jampel_name}
            </div>`
            : '';

        // Determine status and create appropriate content
        let statusContent = '';
        if (schedule.has_absensi_today) {
            const persentaseHadir = schedule.total_siswa > 0
                ? Math.round((schedule.siswa_hadir / schedule.total_siswa) * 100)
                : 0;

            statusContent = `
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-gray-900">Presensi Hari Ini</h4>
                        <span class="inline-flex items-center text-xs text-green-700 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Telah Diisi
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-xl font-bold text-gray-900">${schedule.siswa_hadir}</div>
                                <div class="text-xs text-gray-600 mt-1">Hadir</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-xl font-bold text-gray-900">${schedule.siswa_tidak_hadir}</div>
                                <div class="text-xs text-gray-600 mt-1">Tidak Hadir</div>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <div class="text-xl font-bold text-gray-900">${persentaseHadir}%</div>
                                <div class="text-xs text-gray-600 mt-1">Rasio</div>
                            </div>
                        </div>

                        <div class="relative pt-1">
                            <div class="flex mb-1 items-center justify-between">
                                <div class="text-xs text-gray-600 font-medium">
                                    Tingkat Kehadiran
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold text-gray-900">
                                        ${persentaseHadir}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-100">
                                <div style="width:${persentaseHadir}%" class="bg-green-600"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="/absensi/${schedule.absensi_id}" class="text-center px-4 py-2.5 bg-gray-100 text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                Lihat Presensi
                            </a>
                            <a href="{{ route('agenda.create') }}?schedule_id=${schedule.id}" class="text-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Buat Agenda
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            statusContent = `
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-gray-900">Presensi Hari Ini</h4>
                        <span class="inline-flex items-center text-xs text-yellow-700 font-medium">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Belum Diisi
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <p class="text-sm text-gray-600">Belum ada data presensi untuk hari ini</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="/absensi/create?kelas_id=${schedule.kelas_id}&mapel_id=${schedule.mapel_id}&jampel_id=${schedule.start_jampel_id}&tanggal=${getTodayDate()}&pertemuan=1" class="text-center px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Input Presensi
                            </a>
                            <a href="{{ route('agenda.create') }}?schedule_id=${schedule.id}" class="text-center px-4 py-2.5 bg-gray-100 text-gray-900 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                Buat Agenda
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        card.innerHTML = `
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-start gap-6">
                    <!-- Left Column - Schedule Info -->
                    <div class="flex-1">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Kelas</div>
                                <h3 class="text-2xl font-bold text-gray-900">${schedule.kelas_name}</h3>
                                <div class="text-lg text-gray-700 mt-1">${schedule.mapel_name}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 font-medium">ID: ${schedule.id}</div>
                            </div>
                        </div>

                        ${jadwalInfo}
                    </div>

                    <!-- Right Column - Actions & Status -->
                    <div class="w-full md:w-72">
                        ${statusContent}
                    </div>
                </div>
            </div>
        `;

        return card;
    }

    // Helper function untuk format tanggal YYYY-MM-DD
    function getTodayDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Auto-refresh every 5 minutes
    setInterval(() => {
        console.log('Auto-refreshing schedules...');
        loadSchedules();
    }, 5 * 60 * 1000);
});
</script>
@endpush
