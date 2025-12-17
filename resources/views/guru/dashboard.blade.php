@extends('layout.main')

@section('title', 'Dashboard Guru')

@section('content')

 <!-- HEADER -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold">Selamat Datang, <span class="text-blue-500">Guru Satu!</span></h1>
            <p class="text-gray-600 mt-1">Dashboard Sistem Agenda Sekolah</p>
        </div>

        <!-- TOP STAT CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kelas -->
            <div class="p-5 bg-white rounded-xl shadow-md border">
                <p class="text-gray-500 text-sm">Kelas</p>
                <h2 class="text-4xl font-bold text-blue-600 mt-1">3</h2>
            </div>

            <!-- Jurusan -->
            <div class="p-5 bg-white rounded-xl shadow-md border">
                <p class="text-gray-500 text-sm">Jurusan</p>
                <h2 class="text-4xl font-bold text-green-600 mt-1">1</h2>
            </div>

            <!-- Mapel -->
            <div class="p-5 bg-white rounded-xl shadow-md border">
                <p class="text-gray-500 text-sm">Mapel</p>
                <h2 class="text-4xl font-bold text-yellow-600 mt-1">1</h2>
            </div>
        </div>

        <!-- LAPORAN KEGIATAN SECTION -->
        <div class="bg-white rounded-xl shadow-md p-6 mt-8">
            <h2 class="text-xl font-bold mb-4">Lapor Kegiatan Sebelum KBM</h2>

            <div class="border-l-4 border-yellow-500 pl-4 py-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Kegiatan Senam Pagi</h3>
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium mr-3">
                        <i class="far fa-clock mr-1"></i> Kamis, 07:00 - 07:15
                    </div>
                </div>
                <p class="text-gray-600 mt-2">Kegiatan senam pagi untuk menjaga kesehatan dan kebahagiaan siswa, dipimpin oleh guru olahraga.</p>
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

