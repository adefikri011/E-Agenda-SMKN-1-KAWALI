@extends('layout.main')

@section('title', 'Jadwal Mengajar Saya')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">📅 Jadwal Mengajar Saya</h1>
    <p class="text-gray-500 mt-2">Daftar lengkap kelas dan mata pelajaran yang Anda ajar (ditentukan oleh admin)</p>
</div>

<!-- Info Box -->
<div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-6">
    <div class="flex items-start gap-3">
        <div class="text-2xl">ℹ️</div>
        <div>
            <p class="font-semibold text-blue-900">Jadwal Anda Diatur Oleh Admin</p>
            <p class="text-blue-800 text-sm mt-1">Hubungi admin untuk perubahan atau tambahan jadwal mengajar. Gunakan jadwal ini untuk input agenda pembelajaran harian.</p>
        </div>
    </div>
</div>

<!-- Schedule Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="scheduleCards">
    <div class="col-span-full text-center py-12">
        <div class="text-4xl mb-2">⏳</div>
        <p class="text-gray-500">Memuat jadwal...</p>
    </div>
</div>

<!-- Quick Action Button -->
<div class="mt-8 text-center">
    <a href="{{ route('agenda.index') }}" class="inline-block px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all">
        <i class="fas fa-plus mr-2"></i> Input Agenda Pembelajaran
    </a>
</div>

<script>
    // Load guru's schedules on page load
    loadSchedules();

    function loadSchedules() {
        console.log('Loading schedules...');

        fetch('/api/my-schedules', {
            headers: {
                'Accept': 'application/json'
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
                const container = document.getElementById('scheduleCards');
                container.innerHTML = '';

                if (!schedules || schedules.length === 0) {
                    container.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <div class="text-6xl mb-4">📭</div>
                            <p class="text-gray-500 text-lg">Anda belum memiliki jadwal mengajar</p>
                            <p class="text-gray-400 text-sm mt-2">Hubungi admin untuk menambahkan jadwal Anda</p>
                        </div>
                    `;
                    return;
                }

                schedules.forEach(schedule => {
                    const card = document.createElement('div');
                    card.className = 'bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow';

                    const jampelInfo = schedule.jampel_name
                        ? `<p class="text-sm text-orange-600 font-semibold">🕐 ${schedule.jampel_name}</p>`
                        : '';

                    // Status absensi hari ini
                    let absensiStatus = '';
                    if (schedule.has_absensi_today) {
                        const persentaseHadir = schedule.total_siswa > 0
                            ? Math.round((schedule.siswa_hadir / schedule.total_siswa) * 100)
                            : 0;

                        absensiStatus = `
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">📊 Absensi Hari Ini</p>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="bg-green-50 rounded-lg p-2 text-center">
                                        <p class="text-sm font-bold text-green-700">${schedule.siswa_hadir}</p>
                                        <p class="text-xs text-green-600">Hadir</p>
                                    </div>
                                    <div class="bg-yellow-50 rounded-lg p-2 text-center">
                                        <p class="text-sm font-bold text-yellow-700">${schedule.siswa_tidak_hadir}</p>
                                        <p class="text-xs text-yellow-600">Tidak</p>
                                    </div>
                                    <div class="bg-blue-50 rounded-lg p-2 text-center">
                                        <p class="text-sm font-bold text-blue-700">${persentaseHadir}%</p>
                                        <p class="text-xs text-blue-600">Hadir</p>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2 overflow-hidden">
                                    <div class="bg-green-500 h-full" style="width: ${persentaseHadir}%"></div>
                                </div>
                            </div>
                            <div class="pt-3 grid grid-cols-2 gap-2">
                                <a href="/absensi?kelas_id=${schedule.kelas_id}&mapel_id=${schedule.mapel_id}&start_jampel_id=${schedule.start_jampel_id}&end_jampel_id=${schedule.end_jampel_id}&tanggal=${new Date().toISOString().split('T')[0]}&auto_load=1" class="block px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg hover:bg-blue-200 transition-colors text-sm text-center">
                                    📋 Lihat Absensi
                                </a>
                                <a href="{{ route('agenda.index') }}" class="block px-4 py-2 bg-green-100 text-green-700 font-semibold rounded-lg hover:bg-green-200 transition-colors text-sm text-center">
                                    ✏️ Agenda
                                </a>
                            </div>
                        `;
                    } else {
                        // Belum ada absensi hari ini
                        absensiStatus = `
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">📊 Absensi Hari Ini</p>
                                <div class="bg-gray-50 rounded-lg p-3 text-center mb-3">
                                    <p class="text-sm text-gray-600">⏳ Belum ada data absensi</p>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="/absensi?kelas_id=${schedule.kelas_id}&mapel_id=${schedule.mapel_id}&start_jampel_id=${schedule.start_jampel_id}&end_jampel_id=${schedule.end_jampel_id}&tanggal=${getTodayDate()}&auto_load=1" class="block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm text-center">
                                        ➕ Input Absensi
                                    </a>
                                    <a href="{{ route('agenda.index') }}" class="block px-4 py-2 bg-green-100 text-green-700 font-semibold rounded-lg hover:bg-green-200 transition-colors text-sm text-center">
                                        ✏️ Agenda
                                    </a>
                                </div>
                            </div>
                        `;
                    }

                    card.innerHTML = `
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Kelas</p>
                                <p class="text-lg font-bold text-gray-900">${schedule.kelas_name}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Mata Pelajaran</p>
                                <p class="text-base font-semibold text-blue-600">${schedule.mapel_name}</p>
                            </div>
                            ${jampelInfo}
                            ${absensiStatus}
                        </div>
                    `;
                    container.appendChild(card);
                });
            })
            .catch(error => {
                console.error('Error loading schedules:', error);
                const container = document.getElementById('scheduleCards');
                container.innerHTML = `
                    <div class="col-span-full text-center py-12">
                        <div class="text-4xl mb-4">⚠️</div>
                        <p class="text-red-600 font-semibold">Error memuat jadwal</p>
                        <p class="text-gray-500 text-sm mt-2">${error.message}</p>
                        <button onclick="location.reload()" class="mt-4 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                            Coba Lagi
                        </button>
                    </div>
                `;
            });
    }

    // Helper function untuk format tanggal YYYY-MM-DD
    function getTodayDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
</script>

@endsection
