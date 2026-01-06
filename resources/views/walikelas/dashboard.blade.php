@extends('layout.main')

@section('title', 'Dashboard Wali Kelas')

@section('content')

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Wali Kelas</h1>
        <p class="text-gray-600 mt-2">{{ $kelas->nama_kelas }} • {{ $user->name }}</p>
    </div>

    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Siswa -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <p class="text-gray-600 text-sm font-medium">Total Siswa</p>
            <p class="text-4xl font-bold text-gray-900 mt-3">{{ $jumlahSiswa }}</p>
            <p class="text-gray-500 text-xs mt-2">Terdaftar di kelas</p>
        </div>

        <!-- Hadir -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <p class="text-gray-600 text-sm font-medium">Hadir Hari Ini</p>
            <p class="text-4xl font-bold text-green-600 mt-3">{{ $kehadiranHadir }}</p>
            <p class="text-gray-500 text-xs mt-2">Siswa hadir</p>
        </div>

        <!-- Izin -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <p class="text-gray-600 text-sm font-medium">Izin</p>
            <p class="text-4xl font-bold text-blue-600 mt-3">{{ $kehadiranIzin }}</p>
            <p class="text-gray-500 text-xs mt-2">Dengan izin</p>
        </div>

        <!-- Tidak Hadir -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <p class="text-gray-600 text-sm font-medium">Sakit & Alpha</p>
            <p class="text-4xl font-bold text-orange-600 mt-3">{{ $kehadiranSakit + $kehadiranAlpha }}</p>
            <p class="text-gray-500 text-xs mt-2">Sakit: {{ $kehadiranSakit }}, Alpha: {{ $kehadiranAlpha }}</p>
        </div>
    </div>

    <!-- CHART & INFO -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- CHART -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-6">Rekapitulasi Kehadiran</h2>
            <div style="height: 300px;">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>

        <!-- INFO CARD -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan</h2>

            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <span class="text-gray-600">Mata Pelajaran</span>
                    <span class="text-lg font-semibold text-gray-900">{{ $jumlahMapel }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <span class="text-gray-600">Persentase Hadir</span>
                    <span class="text-lg font-semibold text-green-600">{{ $jumlahSiswa > 0 ? round(($kehadiranHadir / $jumlahSiswa) * 100) : 0 }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Tidak Hadir</span>
                    <span class="text-lg font-semibold text-orange-600">{{ $siswaTidakHadir }}</span>
                </div>
            </div>

            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-xs text-gray-600 font-medium">Status Hari Ini</p>
                <p class="text-sm text-gray-900 font-semibold mt-2">{{ now()->format('d F Y') }}</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
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
                        borderRadius: 6,
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
                            grid: { color: 'rgba(0, 0, 0, 0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    </script>

@endsection
