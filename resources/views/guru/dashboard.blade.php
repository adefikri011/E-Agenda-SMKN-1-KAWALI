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

        .tab-content {
            transition: all 0.3s ease;
        }

        .tab-button.active {
            @apply bg-white text-blue-600 shadow-sm;
        }

        .tab-button:not(.active) {
            @apply text-gray-600 hover:bg-gray-50 hover:text-gray-800;
        }
    </style>

    <div class="space-y-6">
        <!-- HEADER -->
        <div class="bg-white rounded-lg shadow p-6 animate-fade-up">
            <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, <span
                    class="text-blue-600">{{ $user->name ?? ($guru->nama ?? 'Guru') }}</span></h1>
            <p class="text-gray-500 mt-2">{{ now()->translatedFormat('l, d F Y') }} • Ringkasan kegiatan dan statistik hari
                ini</p>
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
                                <p class="text-4xl font-bold text-gray-800 mt-2">{{ $kelasCount ?? 0 }}</p>
                            </div>
                            <div class="text-4xl">📚</div>
                        </div>
                    </div>

                    <div class="card-hover p-6 bg-white rounded-lg shadow border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Mata Pelajaran</p>
                                <p class="text-4xl font-bold text-gray-800 mt-2">{{ $mapelCount ?? 0 }}</p>
                            </div>
                            <div class="text-4xl">📖</div>
                        </div>
                    </div>

                    <div class="card-hover p-6 bg-white rounded-lg shadow border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Siswa Diampu</p>
                                <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalSiswa ?? 0 }}</p>
                            </div>
                            <div class="text-4xl">👥</div>
                        </div>
                    </div>
                </div>

                <!-- KEHADIRAN CHART -->
                <div class="card-hover bg-white rounded-lg shadow p-6 animate-fade-up">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Kehadiran Hari Ini</h3>

                    @php
                        $totalRec = array_sum($presensiData ?? []);
                    @endphp

                    @if ($totalRec > 0)
                        <!-- Statistik Kehadiran -->
                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $percentHadir = round((($presensiData['hadir'] ?? 0) / $totalRec) * 100, 1);
                            @endphp
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
                                <div class="text-gray-600 font-medium text-sm">Total Rekaman</div>
                                <div class="text-3xl font-bold text-blue-600 mt-2">{{ $totalRec }}</div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
                                <div class="text-gray-600 font-medium text-sm">Persentase Hadir</div>
                                <div class="text-3xl font-bold text-green-600 mt-2">{{ $percentHadir }}%</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="text-4xl mb-3">🤷</div>
                            <p class="text-gray-500 font-medium">Data Kehadiran Kosong</p>
                            <p class="text-gray-400 text-sm mt-1">Belum ada rekap absensi untuk hari ini.</p>
                        </div>
                    @endif
                </div>

                <!-- AGENDA HARI INI -->
                <div class="card-hover bg-white rounded-lg shadow p-6 animate-fade-up">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📅 Agenda Terbaru</h3>
                    @if (empty($agendaHariIni) || $agendaHariIni->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada agenda</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach ($agendaHariIni as $agenda)
                                <a href="{{ url('/agenda/' . $agenda->id) }}"
                                    class="block card-hover border-l-4 border-blue-300 bg-gray-50 rounded-lg p-4 hover:bg-blue-50 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-800 text-base">{{ $agenda->mata_pelajaran }}
                                            </p>
                                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                                <p><strong>Kelas:</strong> {{ $agenda->kelas?->nama_kelas ?? 'N/A' }}</p>
                                                <p><strong>Tanggal:</strong>
                                                    {{ $agenda->tanggal ? \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d M Y') : 'N/A' }}
                                                </p>
                                                @if ($agenda->jampel)
                                                    <p><strong>Jam:</strong> {{ $agenda->jampel->jam_mulai }} -
                                                        {{ $agenda->jampel->jam_selesai }}</p>
                                                @endif
                                                <p><strong>Materi:</strong> {{ Str::limit($agenda->materi ?? '-', 100) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <span
                                                class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                                                📌 Sudah Ditanda Tangani
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- SIDEBAR -->
            <aside class="space-y-6 animate-slide-in">
                <!-- DAFTAR KEHADIRAN HARI INI -->
                @php
                    // Hitung total siswa yang tidak hadir
                    $totalIzin = $daftarKehadiranHariIni['izin']->count();
                    $totalSakit = $daftarKehadiranHariIni['sakit']->count();
                    $totalAlpha = $daftarKehadiranHariIni['alpha']->count();
                    $totalTidakHadir = $totalIzin + $totalSakit + $totalAlpha;
                @endphp

                @if ($totalTidakHadir > 0)
                <div class="card-hover bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Daftar Kehadiran Hari Ini</h3>

                    @if (false)
                        <div class="text-center py-8">
                            <div class="text-5xl mb-3">✅</div>
                            <p class="text-gray-600 font-medium">Semua siswa hadir!</p>
                            <p class="text-gray-400 text-sm mt-1">Tidak ada siswa yang izin, sakit, atau alpha hari ini</p>
                        </div>
                    @else
                        <!-- Tab Navigasi -->
                        <div class="flex space-x-2 mb-4 bg-gray-100 p-2 rounded-lg">
                            <button onclick="showTab('izin')" id="tab-izin"
                                class="tab-button flex-1 py-2 px-3 text-xs font-medium rounded transition-colors bg-white text-blue-600 shadow-sm hover:shadow-md">
                                📄 Izin <span class="font-bold">({{ $totalIzin }})</span>
                            </button>
                            <button onclick="showTab('sakit')" id="tab-sakit"
                                class="tab-button flex-1 py-2 px-3 text-xs font-medium rounded transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                🤒 Sakit <span class="font-bold">({{ $totalSakit }})</span>
                            </button>
                            <button onclick="showTab('alpha')" id="tab-alpha"
                                class="tab-button flex-1 py-2 px-3 text-xs font-medium rounded transition-colors text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                                ❌ Alpha <span class="font-bold">({{ $totalAlpha }})</span>
                            </button>
                        </div>

                        <!-- Konten Tab -->
                        <div class="max-h-96 overflow-y-auto">
                            <!-- Tab Izin -->
                            <div id="content-izin" class="tab-content">
                                @if ($totalIzin > 0)
                                    <ul class="space-y-2">
                                        @foreach ($daftarKehadiranHariIni['izin'] as $detail)
                                            <li
                                                class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200 hover:shadow-sm transition-shadow">
                                                <div>
                                                    <p class="font-medium text-sm text-gray-800">
                                                        {{ $detail->siswa->nama ?? 'Nama tidak tersedia' }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ optional(optional($detail->absensi)->kelas)->nama_kelas ??
                                                            (optional(optional($detail->absensi)->kelas)->nama ?? 'Kelas tidak tersedia') }}
                                                    </p>
                                                </div>
                                                <span class="text-lg">📄</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 text-sm text-center py-6">Tidak ada siswa yang izin</p>
                                @endif
                            </div>

                            <!-- Tab Sakit -->
                            <div id="content-sakit" class="tab-content hidden">
                                @if ($totalSakit > 0)
                                    <ul class="space-y-2">
                                        @foreach ($daftarKehadiranHariIni['sakit'] as $detail)
                                            <li
                                                class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200 hover:shadow-sm transition-shadow">
                                                <div>
                                                    <p class="font-medium text-sm text-gray-800">
                                                        {{ $detail->siswa->nama ?? 'Nama tidak tersedia' }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ optional(optional($detail->absensi)->kelas)->nama_kelas ??
                                                            (optional(optional($detail->absensi)->kelas)->nama ?? 'Kelas tidak tersedia') }}
                                                    </p>
                                                </div>
                                                <span class="text-lg">🤒</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 text-sm text-center py-6">Tidak ada siswa yang sakit</p>
                                @endif
                            </div>

                            <!-- Tab Alpha -->
                            <div id="content-alpha" class="tab-content hidden">
                                @if ($totalAlpha > 0)
                                    <ul class="space-y-2">
                                        @foreach ($daftarKehadiranHariIni['alpha'] as $detail)
                                            <li
                                                class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200 hover:shadow-sm transition-shadow">
                                                <div>
                                                    <p class="font-medium text-sm text-gray-800">
                                                        {{ $detail->siswa->nama ?? 'Nama tidak tersedia' }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ optional(optional($detail->absensi)->kelas)->nama_kelas ??
                                                            (optional(optional($detail->absensi)->kelas)->nama ?? 'Kelas tidak tersedia') }}
                                                    </p>
                                                </div>
                                                <span class="text-lg">❌</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500 text-sm text-center py-6">Tidak ada siswa yang alpha</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                @endif
            </aside>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (!empty($presensiData) && array_sum($presensiData) > 0)
                const canvas = document.getElementById('chartPresensi');
                if (canvas) {
                    const presensi = {!! json_encode($presensiData) !!};
                    const labels = ['Hadir', 'Izin', 'Sakit', 'Alpha'];
                    const data = labels.map(l => presensi[l.toLowerCase()] ?? 0);

                    const ctx = canvas.getContext('2d');
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
                            aspectRatio: 1.5,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            size: 12,
                                            weight: 'bold'
                                        },
                                        usePointStyle: true
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        });

        // JavaScript untuk Tab Kehadiran
        function showTab(tabName) {
            // Sembunyikan semua konten tab
            const allContents = document.querySelectorAll('.tab-content');
            allContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Hapus kelas aktif dari semua tombol tab
            const allButtons = document.querySelectorAll('.tab-button');
            allButtons.forEach(button => {
                button.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                button.classList.add('text-gray-600');
            });

            // Tampilkan konten tab yang dipilih
            const selectedContent = document.getElementById('content-' + tabName);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // Aktifkan tombol tab yang dipilih
            const activeButton = document.getElementById('tab-' + tabName);
            if (activeButton) {
                activeButton.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                activeButton.classList.remove('text-gray-600');
            }
        }
    </script>
@endsection