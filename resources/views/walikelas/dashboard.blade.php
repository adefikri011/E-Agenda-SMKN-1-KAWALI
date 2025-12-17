@extends('layout.main')

@section('title', 'Dashboard Wali Kelas')

@section('content')
 <!-- HEADER -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h1 class="text-2xl font-bold">Selamat Datang, <span class="text-blue-500">{{ $user->name }}!</span></h1>
    <p class="text-gray-600 mt-1">Dashboard Sistem Agenda Sekolah - Wali Kelas {{ $kelas->nama_kelas }}</p>
</div>

<!-- TOP STAT CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Jumlah Siswa -->
    <div class="p-5 bg-white rounded-xl shadow-md border hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jumlah Siswa</p>
                <h2 class="text-4xl font-bold text-blue-600 mt-1">{{ $jumlahSiswa }}</h2>
            </div>
            <div class="bg-blue-100 p-3 rounded-lg">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Kehadiran Hari Ini -->
    <div class="p-5 bg-white rounded-xl shadow-md border hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Kehadiran Hari Ini</p>
                <h2 class="text-4xl font-bold text-green-600 mt-1">{{ $kehadiranHariIni }}</h2>
                <p class="text-xs text-gray-500 mt-1">{{ round(($kehadiranHariIni / $jumlahSiswa) * 100) }}% hadir</p>
            </div>
            <div class="bg-green-100 p-3 rounded-lg">
                <i class="fas fa-user-check text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Siswa Tidak Hadir -->
    <div class="p-5 bg-white rounded-xl shadow-md border hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Siswa Tidak Hadir</p>
                <h2 class="text-4xl font-bold text-yellow-600 mt-1">{{ $siswaTidakHadir }}</h2>
                <p class="text-xs text-gray-500 mt-1">{{ $kehadiranIzin }} izin, {{ $kehadiranSakit }} sakit, {{ $kehadiranAlpha }} alpha</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded-lg">
                <i class="fas fa-user-times text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Jumlah Mapel -->
    <div class="p-5 bg-white rounded-xl shadow-md border hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Jumlah Mapel</p>
                <h2 class="text-4xl font-bold text-purple-600 mt-1">{{ $jumlahMapel }}</h2>
            </div>
            <div class="bg-purple-100 p-3 rounded-lg">
                <i class="fas fa-book text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- INFORMASI PENTING & JADWAL -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- SISWA PERHATIAN KHUSUS -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
            Siswa Perlu Perhatian Khusus
        </h2>
        <div class="space-y-3">
            @if($siswaTidakHadir > 0)
                <div class="flex items-center p-3 bg-red-50 rounded-lg">
                    <div class="bg-red-100 p-2 rounded-full mr-3">
                        <i class="fas fa-user-slash text-red-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-red-800">{{ $siswaTidakHadir }} siswa tidak hadir hari ini</p>
                        <p class="text-sm text-red-600">Perlu follow-up segera</p>
                    </div>
                </div>
            @endif

            @if($kehadiranAlpha > 0)
                <div class="flex items-center p-3 bg-orange-50 rounded-lg">
                    <div class="bg-orange-100 p-2 rounded-full mr-3">
                        <i class="fas fa-user-clock text-orange-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-orange-800">{{ $kehadiranAlpha }} siswa alpha</p>
                        <p class="text-sm text-orange-600">Perlu konfirmasi kepada orang tua</p>
                    </div>
                </div>
            @endif

            @if($jumlahSiswa == 0)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="bg-gray-100 p-2 rounded-full mr-3">
                        <i class="fas fa-info-circle text-gray-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Belum ada siswa terdaftar</p>
                        <p class="text-sm text-gray-600">Hubungi admin untuk menambahkan siswa</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- JADWAL HARI INI -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center">
            <i class="fas fa-calendar-day text-blue-500 mr-2"></i>
            Jadwal Pelajaran Hari Ini
        </h2>
        <div class="space-y-2">
            <!-- Contoh jadwal, sesuaikan dengan data dinamis -->
            <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                    07:00 - 08:30
                </div>
                <div>
                    <p class="font-semibold">Matematika</p>
                    <p class="text-sm text-gray-600">Pak Ahmad</p>
                </div>
            </div>
            <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                    08:30 - 10:00
                </div>
                <div>
                    <p class="font-semibold">Bahasa Indonesia</p>
                    <p class="text-sm text-gray-600">Bu Siti</p>
                </div>
            </div>
            <div class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                    10:15 - 11:45
                </div>
                <div>
                    <p class="font-semibold">IPA</p>
                    <p class="text-sm text-gray-600">Pak Budi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LAPORAN KEGIATAN SECTION -->
<div class="bg-white rounded-xl shadow-md p-6 mt-6">
    <h2 class="text-xl font-bold mb-4 flex items-center">
        <i class="fas fa-clipboard-list text-green-500 mr-2"></i>
        Laporan Kegiatan Kelas
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="border-l-4 border-yellow-500 pl-4 py-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Jadwal Piket Kelas</h3>
            <div class="flex items-center mb-3">
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                    <i class="far fa-clock mr-1"></i> Kamis, 07:00 - 07:15
                </div>
            </div>
            <p class="text-gray-600 mt-2">Kelompok 1 (Ahmad, Budi, Citra) bertugas membersihkan kelas dan menyiapkan pembelajaran.</p>
        </div>

        <div class="border-l-4 border-blue-500 pl-4 py-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Rapat Wali Kelas</h3>
            <div class="flex items-center mb-3">
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                    <i class="far fa-clock mr-1"></i> Jumat, 13:00 - 14:30
                </div>
            </div>
            <p class="text-gray-600 mt-2">Pembahasan evaluasi tengah semester dan persiapan kegiatan OSIS.</p>
        </div>
    </div>

    <!-- GRAFIK KEHADIRAN -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-chart-bar text-purple-500 mr-2"></i>
            Statistik Kehadiran Siswa
        </h3>
        <div class="bg-gray-50 p-4 rounded-lg">
            <canvas id="chartPresensi" height="100"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartPresensi').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
                datasets: [{
                    data: [{{ $kehadiranHariIni }}, {{ $kehadiranIzin }}, {{ $kehadiranSakit }}, {{ $kehadiranAlpha }}],
                    backgroundColor: ['#22c55e', '#eab308', '#3b82f6', '#ef4444'],
                    borderWidth: 0,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = {{ $jumlahSiswa }};
                                const value = context.raw;
                                const percentage = Math.round((value / total) * 100);
                                return `${context.label}: ${value} siswa (${percentage}%)`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
