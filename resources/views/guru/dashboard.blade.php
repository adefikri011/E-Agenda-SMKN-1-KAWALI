@extends('layout.main')

@section('title', 'Dashboard Guru')

@section('content')

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slide-in {
        animation: slideInLeft 0.6s ease-out;
    }

    .card-hover {
        @apply transition-all duration-300 ease-out;
    }

    .card-hover:hover {
        @apply transform -translate-y-2 shadow-2xl;
    }
</style>

<div class="space-y-6">
    <!-- HEADER -->
    <div class="bg-white rounded-lg shadow p-6 animate-fade-up">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, <span class="text-blue-600">{{ $user->name ?? ($guru->nama ?? 'Guru') }}</span></h1>
        <p class="text-gray-500 mt-2">{{ now()->translatedFormat('l, d F Y') }} • Ringkasan kegiatan dan statistik hari ini</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- MAIN CONTENT -->
        <div class="lg:col-span-2 space-y-6">
            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 animate-fade-up">
                <div class="card-hover p-6 bg-white rounded-lg shadow border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Kelas</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">{{ $kelasCount }}</p>
                        </div>
                        <div class="text-4xl">📚</div>
                    </div>
                </div>

                <div class="card-hover p-6 bg-white rounded-lg shadow border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Mata Pelajaran</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">{{ $mapelCount }}</p>
                        </div>
                        <div class="text-4xl">📖</div>
                    </div>
                </div>

                <div class="card-hover p-6 bg-white rounded-lg shadow border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Siswa Diampu</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalSiswa }}</p>
                        </div>
                        <div class="text-4xl">👥</div>
                    </div>
                </div>
            </div>

            <!-- KEHADIRAN CHART -->
            <div class="card-hover bg-white rounded-lg shadow p-6 animate-fade-up">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Kehadiran Hari Ini</h3>
                <canvas id="chartPresensi" height="100"></canvas>
            </div>

            <!-- AGENDA HARI INI -->
            <div class="card-hover bg-white rounded-lg shadow p-6 animate-fade-up">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📅 Agenda Hari Ini</h3>
                @if ($agendaHariIni->isEmpty())
                    <p class="text-gray-500">Tidak ada agenda untuk hari ini</p>
                @else
                    <div class="space-y-3">
                        @foreach ($agendaHariIni as $agenda)
                            <div class="card-hover border-l-4 border-gray-300 bg-gray-50 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">{{ $agenda->mata_pelajaran }}</p>
                                        <p class="text-sm text-gray-600 mt-1">Kelas: {{ $agenda->kelas->nama ?? ($agenda->kelas_id ?? 'N/A') }}</p>
                                        <p class="text-sm text-gray-600">Materi: {{ Str::limit($agenda->materi, 60) }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-4 text-sm text-gray-600">
                                        <p>{{ optional($agenda->jampel)->jam_mulai ?? '--:--' }} - {{ optional($agenda->jampel)->jam_selesai ?? '--:--' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- SIDEBAR -->
        <aside class="space-y-6 animate-slide-in">
            <!-- RIWAYAT AKTIVITAS -->
            <div class="card-hover bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🕐 Riwayat Aktivitas</h3>
                @if (empty($activities) || $activities->isEmpty())
                    <p class="text-gray-500 text-sm">Belum ada riwayat aktivitas</p>
                @else
                    <ul class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach ($activities as $activity)
                            <li class="card-hover pb-3 border-b last:border-b-0 last:pb-0">
                                <div class="flex items-start gap-2">
                                    @if ($activity['type'] === 'agenda')
                                        <span class="text-lg">📝</span>
                                    @else
                                        <span class="text-lg">✓</span>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-sm text-gray-800 truncate">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $activity['description'] }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $activity['timestamp']->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- RINGKASAN HARI INI -->
            <div class="card-hover bg-white rounded-lg shadow p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">⚡ Ringkasan Hari Ini</h3>
                <div class="space-y-4">
                    <div class="card-hover">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">📅 Agenda</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $agendaHariIni->count() }}</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gray-400" style="width: {{ min($agendaHariIni->count() * 20, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="card-hover">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">✓ Hadir</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $presensiData['hadir'] ?? 0 }}</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gray-400" style="width: {{ min(($presensiData['hadir'] ?? 0) * 10, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="card-hover">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">👥 Total Siswa</span>
                            <span class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gray-400" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const presensi = {!! json_encode($presensiData ?? ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0]) !!};
        const labels = ['Hadir', 'Izin', 'Sakit', 'Alpha'];
        const data = labels.map(l => presensi[l.toLowerCase()] ?? 0);

        const ctx = document.getElementById('chartPresensi').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#16a34a', '#f59e0b', '#3b82f6', '#ef4444'],
                    borderColor: ['#fff', '#fff', '#fff', '#fff'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: { size: 12, weight: 'bold' },
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
@endsection
