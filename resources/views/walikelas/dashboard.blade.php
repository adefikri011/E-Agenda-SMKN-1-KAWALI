@extends('layout.main')

@section('title', 'Dashboard Wali Kelas')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Wali Kelas</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">{{ $kelas->nama_kelas }} • {{ $user->name }}</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <!-- STATS GRID -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Siswa -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base font-medium text-gray-600">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $jumlahSiswa }}</p>
                        <p class="text-sm text-gray-500 mt-2">Terdaftar di kelas</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Hadir -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base font-medium text-gray-600">Hadir Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-600 mt-2">{{ $kehadiranHadir }}</p>
                        <p class="text-sm text-gray-500 mt-2">Siswa hadir</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Izin -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base font-medium text-gray-600">Izin</p>
                        <p class="text-3xl font-bold text-gray-600 mt-2">{{ $kehadiranIzin }}</p>
                        <p class="text-sm text-gray-500 mt-2">Dengan izin</p>
                    </div>
                     <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tidak Hadir -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-base font-medium text-gray-600">Sakit & Alpha</p>
                        <p class="text-3xl font-bold text-gray-600 mt-2">{{ $kehadiranSakit + $kehadiranAlpha }}</p>
                        <p class="text-sm text-gray-500 mt-2">Sakit: {{ $kehadiranSakit }}, Alpha: {{ $kehadiranAlpha }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART & INFO -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- CHART -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Rekapitulasi Kehadiran</h2>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
                <div style="height: 320px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <!-- INFO CARD -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Ringkasan</h2>
                     <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-700">Mata Pelajaran</span>
                            <span class="text-lg font-bold text-gray-900">{{ $jumlahMapel }}</span>
                        </div>
                    </div>
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-700">Persentase Hadir</span>
                            <span class="text-lg font-bold text-gray-600">{{ $jumlahSiswa > 0 ? round(($kehadiranHadir / $jumlahSiswa) * 100) : 0 }}%</span>
                        </div>
                    </div>
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-700">Tidak Hadir</span>
                            <span class="text-lg font-bold text-gray-600">{{ $siswaTidakHadir }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm font-semibold text-blue-700 mb-2">Status Hari Ini</p>
                    <p class="text-lg font-bold text-blue-900">{{ now()->format('d F Y') }}</p>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('attendanceChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
                        datasets: [{
                            label: 'Jumlah Siswa',
                            data: [{{ $kehadiranHadir }}, {{ $kehadiranIzin }}, {{ $kehadiranSakit }}, {{ $kehadiranAlpha }}],
                            backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                            borderRadius: 8,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' },
                                ticks: {
                                    font: { size: 12 }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: { size: 12 }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
