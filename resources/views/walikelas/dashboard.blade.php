@extends('layout.main')

@section('title', 'Dashboard Wali Kelas')

@section('content')
 <!-- HEADER -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold">Selamat Datang, <span class="text-blue-500">{{ $user->name }}</span>!</h1>
            <p class="text-gray-600 mt-1">Dashboard Wali Kelas {{ $kelas->nama_kelas }}</p>
        </div>

        <!-- TOP STAT CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Jumlah Siswa -->
            <div class="p-5 bg-white rounded-xl shadow-md border">
                <p class="text-gray-500 text-sm">Jumlah Siswa</p>
                <h2 class="text-4xl font-bold text-blue-600 mt-1">{{ $jumlahSiswa }}</h2>
            </div>

            <!-- Kehadiran Hari Ini -->
            <div class="p-5 bg-white rounded-xl shadow-md border">
                <p class="text-gray-500 text-sm">Kehadiran Hari Ini</p>
                <h2 class="text-4xl font-bold text-green-600 mt-1">{{ $kehadiranHadir }}</h2>
            </div>

            <!-- Siswa Tidak Hadir -->
            <div class="p-5 bg-white rounded-xl shadow-md border">
                <p class="text-gray-500 text-sm">Siswa Tidak Hadir</p>
                <h2 class="text-4xl font-bold text-yellow-600 mt-1">{{ $siswaTidakHadir }}</h2>
            </div>
        </div>

        <!-- LAPORAN KEGIATAN SECTION -->
        <div class="bg-white rounded-xl shadow-md p-6 mt-8">
            <h2 class="text-xl font-bold mb-4">Laporan Kegiatan Kelas</h2>

            <div class="border-l-4 border-yellow-500 pl-4 py-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Jadwal Piket Kelas</h3>
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                        <i class="far fa-clock mr-1"></i> Kamis, 07:00 - 07:15
                    </div>
                </div>
                <p class="text-gray-600 mt-2">Kelompok 1 (Ahmad, Budi, Citra) bertugas membersihkan kelas dan menyiapkan pembelajaran.</p>
            </div>

            <div class="border-l-4 border-blue-500 pl-4 py-2 mt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Rapat Wali Kelas</h3>
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                        <i class="far fa-clock mr-1"></i> Jumat, 13:00 - 14:30
                    </div>
                </div>
                <p class="text-gray-600 mt-2">Pembahasan evaluasi tengah semester dan persiapan kegiatan OSIS.</p>
            </div>

            <!-- GRAFIK KEHADIRAN -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Kehadiran Siswa</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <canvas id="chartPresensi" height="100"></canvas>
                </div>
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
                // DATA DIAMBIL DARI CONTROLLER
                data: [{{ $kehadiranHadir }}, {{ $kehadiranIzin }}, {{ $kehadiranSakit }}, {{ $kehadiranAlpha }}],
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
