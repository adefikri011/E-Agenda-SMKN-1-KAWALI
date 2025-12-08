@extends('layout.main')

@section('title', 'Dashboard Guru')

@section('content')

    <!-- HEADER -->
    <div class="bg-base-100 rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold">Selamat Datang, <span class="text-blue-500">Guru!</span></h1>
        <p class="text-gray-600 mt-1">Dashboard Presensi Siswa</p>
    </div>

    <!-- TOP STAT CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Siswa -->
        <div class="p-5 bg-base-100 rounded-xl shadow-md border">
            <p class="text-gray-500 text-sm">Total Siswa</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-1">120</h2>
        </div>

        <!-- Hadir -->
        <div class="p-5 bg-base-100 rounded-xl shadow-md border">
            <p class="text-gray-500 text-sm">Hadir</p>
            <h2 class="text-4xl font-bold text-green-600 mt-1">113</h2>
        </div>

        <!-- Izin -->
        <div class="p-5 bg-base-100 rounded-xl shadow-md border">
            <p class="text-gray-500 text-sm">Izin</p>
            <h2 class="text-4xl font-bold text-yellow-600 mt-1">5</h2>
        </div>

        <!-- Alpha -->
        <div class="p-5 bg-base-100 rounded-xl shadow-md border">
            <p class="text-gray-500 text-sm">Alpha</p>
            <h2 class="text-4xl font-bold text-red-600 mt-1">2</h2>
        </div>
    </div>

    <!-- MID SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

        <!-- REKAP PRESENSI HARI INI (GRAFIK) -->
        <div class="bg-base-100 rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Rekap Presensi Hari Ini</h2>

            <div class="w-full h-64">
                <canvas id="chartPresensi"></canvas>
            </div>

            <div class="mt-6 text-center">
                <div class="text-3xl font-bold text-blue-600">94%</div>
                <p class="text-gray-600">Persentase Kehadiran</p>
            </div>
        </div>

        <!-- REKAP DETAIL -->
        <div class="bg-base-100 rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Ringkasan Presensi</h2>

            <ul class="space-y-3">
                <li class="flex justify-between">
                    <span class="font-medium">Total Siswa</span>
                    <span>120</span>
                </li>
                <li class="flex justify-between">
                    <span class="font-medium text-green-600">Hadir</span>
                    <span>113</span>
                </li>
                <li class="flex justify-between">
                    <span class="font-medium text-yellow-600">Izin</span>
                    <span>5</span>
                </li>
                <li class="flex justify-between">
                    <span class="font-medium text-red-600">Alpha</span>
                    <span>2</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- TABLE SECTION -->
    <div class="bg-base-100 rounded-xl shadow-md p-6 mt-8">

        <h2 class="text-xl font-bold mb-4">Daftar Presensi Siswa</h2>

        <div class="overflow-x-auto">
            <table class="table w-full border">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Andi Saputra</td>
                        <td>XI RPL 1</td>
                        <td>
                            <span class="px-3 py-1 rounded-lg bg-green-500 text-white text-sm">Hadir</span>
                        </td>
                    </tr>

                    <tr>
                        <td>Rani Putri</td>
                        <td>XI RPL 1</td>
                        <td>
                            <span class="px-3 py-1 rounded-lg bg-yellow-500 text-white text-sm">Izin</span>
                        </td>
                    </tr>

                    <tr>
                        <td>Budi Hartono</td>
                        <td>XI RPL 1</td>
                        <td>
                            <span class="px-3 py-1 rounded-lg bg-red-500 text-white text-sm">Alpha</span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('chartPresensi').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                data: [113, 5, 0, 2],
                backgroundColor: ['#22c55e', '#eab308', '#3b82f6', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            plugins: { legend: { display: false }},
            scales: { y: { beginAtZero: true }}
        }
    });
</script>
@endsection
