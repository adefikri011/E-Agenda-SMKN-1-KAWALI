@extends('layout.main')

@section('title', 'Jadwal Mengajar Saya')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header yang bersih dan minimalis -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <span class="font-medium">Jadwal Mengajar</span>
                        <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Guru</span>
                    </div>
                    <h1 class="text-3xl font-light text-gray-900 tracking-tight">Jadwal Mengajar</h1>
                    <p class="mt-2 text-gray-600">Daftar kelas dan mata pelajaran yang Anda ajar</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-500">
                        {{ date('d F Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Informasi Sistem - Card Minimalis -->
        <div class="mb-10">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-base font-medium text-gray-900">Pengaturan Jadwal</h3>
                        <p class="mt-1 text-sm text-gray-600">Jadwal diatur oleh administrator. Hubungi admin untuk perubahan jadwal mengajar.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State - Minimalis -->
        <div id="loadingState" class="mb-10">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="p-12">
                    <div class="flex flex-col items-center justify-center">
                        <div class="relative">
                            <div class="w-12 h-12 border-2 border-gray-200 border-t-blue-600 rounded-full animate-spin"></div>
                        </div>
                        <p class="mt-6 text-gray-700">Memuat jadwal mengajar...</p>
                        <p class="mt-1 text-sm text-gray-500">Sedang mengambil data</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Container -->
        <div id="scheduleCards" class="space-y-6 mb-10"></div>

        <!-- Empty State - Minimalis -->
        <div id="emptyState" class="hidden mb-10">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="p-12">
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-light text-gray-900 mb-2">Belum Ada Jadwal Mengajar</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Anda belum memiliki jadwal mengajar yang ditetapkan.</p>
                        <button onclick="location.reload()" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200">
                            Refresh Halaman
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="hidden mb-10">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="p-12">
                    <div class="text-center">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-light text-gray-900 mb-2" id="errorTitle">Terjadi Kesalahan</h3>
                        <p class="text-gray-600 mb-6" id="errorMessage"></p>
                        <button onclick="location.reload()" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-200">
                            Coba Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex justify-center">
                <a href="{{ route('agenda.index') }}" class="px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Input Agenda Pembelajaran
                </a>
            </div>
        </div>
    </div>
</div>

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
        card.className = 'bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors duration-200';

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
                        <h4 class="text-sm font-medium text-gray-900">Absensi Hari Ini</h4>
                        <span class="inline-flex items-center text-xs text-green-700">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Telah Diisi
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center p-3">
                                <div class="text-xl font-light text-gray-900">${schedule.siswa_hadir}</div>
                                <div class="text-xs text-gray-600 mt-1">Hadir</div>
                            </div>
                            <div class="text-center p-3">
                                <div class="text-xl font-light text-gray-900">${schedule.siswa_tidak_hadir}</div>
                                <div class="text-xs text-gray-600 mt-1">Tidak Hadir</div>
                            </div>
                            <div class="text-center p-3">
                                <div class="text-xl font-light text-gray-900">${persentaseHadir}%</div>
                                <div class="text-xs text-gray-600 mt-1">Rasio</div>
                            </div>
                        </div>

                        <div class="relative pt-1">
                            <div class="flex mb-1 items-center justify-between">
                                <div class="text-xs text-gray-600">
                                    Tingkat Kehadiran
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-medium text-gray-600">
                                        ${persentaseHadir}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-1 mb-4 text-xs flex rounded bg-gray-100">
                                <div style="width:${persentaseHadir}%" class="bg-green-600"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="/absensi/${schedule.absensi_id}" class="text-center px-4 py-2 bg-gray-100 text-gray-900 text-sm font-medium rounded hover:bg-gray-200 transition-colors duration-200">
                                Lihat Absensi
                            </a>
                            <a href="{{ route('agenda.index') }}" class="text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors duration-200">
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
                        <h4 class="text-sm font-medium text-gray-900">Absensi Hari Ini</h4>
                        <span class="inline-flex items-center text-xs text-gray-700">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Belum Diisi
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="text-center p-4">
                            <p class="text-sm text-gray-600">Belum ada data absensi untuk hari ini</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="/absensi/create?kelas_id=${schedule.kelas_id}&mapel_id=${schedule.mapel_id}&jampel_id=${schedule.start_jampel_id}&tanggal=${getTodayDate()}&pertemuan=1" class="text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors duration-200">
                                Input Absensi
                            </a>
                            <a href="{{ route('agenda.index') }}" class="text-center px-4 py-2 bg-gray-100 text-gray-900 text-sm font-medium rounded hover:bg-gray-200 transition-colors duration-200">
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
                                <h3 class="text-xl font-light text-gray-900">${schedule.kelas_name}</h3>
                                <div class="text-base text-gray-700 mt-1">${schedule.mapel_name}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-500">ID: ${schedule.id}</div>
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
@endsection 
