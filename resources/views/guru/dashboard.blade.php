@extends('layout.main')

@section('title', 'Dashboard Guru')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Guru</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Selamat Datang, <span class="font-semibold text-blue-600">{{ $user->name ?? ($guru->nama ?? 'Guru') }}</span></p>
                <p class="text-base text-gray-500 ml-4">{{ now()->translatedFormat('l, d F Y') }} • Ringkasan kegiatan dan statistik hari ini</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ now()->format('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Main Content - Takes More Space -->
            <div class="xl:col-span-2 space-y-8">
                <!-- STAT CARDS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-600">KELAS</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $kelasCount ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-600">MATA PELAJARAN</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $mapelCount ?? 0 }}</p>
                            </div>
                           <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-600">SISWA DIAMPU</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSiswa ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KEHADIRAN CHART -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Kehadiran Hari Ini</h3>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>

                    @php
                        $totalRec = array_sum($presensiData ?? []);
                    @endphp

                    @if ($totalRec > 0)
                        <!-- Statistik Kehadiran -->
                        <div class="grid grid-cols-2 gap-6">
                            @php
                                $percentHadir = round((($presensiData['hadir'] ?? 0) / $totalRec) * 100, 1);
                            @endphp
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                <div class="text-base font-medium text-gray-600 mb-2">Total Rekaman</div>
                                <div class="text-3xl font-bold text-blue-600">{{ $totalRec }}</div>
                            </div>
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                <div class="text-base font-medium text-gray-600 mb-2">Persentase Hadir</div>
                                <div class="text-3xl font-bold text-green-600">{{ $percentHadir }}%</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700 mb-2">Data Kehadiran Kosong</p>
                            <p class="text-base text-gray-500">Belum ada rekap presensi untuk hari ini.</p>
                        </div>
                    @endif
                </div>

                <!-- AGENDA HARI INI -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Agenda Terbaru</h3>
                       <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    @if (empty($agendaHariIni) || $agendaHariIni->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700 mb-2">Belum ada agenda</p>
                            <p class="text-base text-gray-500">Tambahkan agenda baru untuk melihat di sini</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($agendaHariIni as $agenda)
                                <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 hover:bg-blue-50 transition-all">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900 text-lg mb-3">{{ $agenda->mata_pelajaran }}</p>
                                            <div class="space-y-2 text-base text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    <span><strong>Kelas:</strong> {{ $agenda->kelas?->nama_kelas ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span><strong>Tanggal:</strong>
                                                        {{ $agenda->tanggal ? \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d M Y') : 'N/A' }}
                                                    </span>
                                                </div>
                                                @if ($agenda->jampel)
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span><strong>Jam:</strong> {{ $agenda->jampel->jam_mulai }} - {{ $agenda->jampel->jam_selesai }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex items-start gap-2">
                                                    <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span><strong>Materi:</strong> {{ Str::limit($agenda->materi ?? '-', 100) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                                Sudah Ditanda Tangani
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- SIDEBAR -->
            <aside class="space-y-8">
                <!-- Logic Data Sidebar -->
                @php
                    // Menggunakan data presensi yang sudah ada untuk grafik
                    // Jika $presensiData kosong, set default 0 agar grafik tidak error
                    $chartData = $presensiData ?? [
                        'hadir' => 0,
                        'izin' => 0,
                        'sakit' => 0,
                        'alpha' => 0
                    ];
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Visualisasi Presensi</h3>
                        <span class="text-sm font-semibold bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Hari Ini</span>
                    </div>

                    @php
                        $total = array_sum($chartData);
                    @endphp

                    @if ($total == 0)
                        <!-- Kosong State -->
                        <div class="flex flex-col items-center justify-center py-12">
                            <span class="text-4xl mb-3">📊</span>
                            <p class="text-base text-gray-600 font-medium">Belum ada data presensi</p>
                            <p class="text-sm text-gray-400 mt-1">Data akan muncul saat ada rekam presensi</p>
                        </div>
                    @else
                        <!-- Progress Bars -->
                        <div class="space-y-4">
                            @php
                                $items = [
                                    ['label' => 'Hadir', 'value' => $chartData['hadir'], 'color' => 'bg-green-500', 'light' => 'bg-green-50', 'text' => 'text-green-700'],
                                    ['label' => 'Izin', 'value' => $chartData['izin'], 'color' => 'bg-yellow-500', 'light' => 'bg-yellow-50', 'text' => 'text-yellow-700'],
                                    ['label' => 'Sakit', 'value' => $chartData['sakit'], 'color' => 'bg-blue-500', 'light' => 'bg-blue-50', 'text' => 'text-blue-700'],
                                    ['label' => 'Alpha', 'value' => $chartData['alpha'], 'color' => 'bg-red-500', 'light' => 'bg-red-50', 'text' => 'text-red-700']
                                ];
                            @endphp

                            @foreach ($items as $item)
                                @php
                                    $percentage = ($item['value'] / $total) * 100;
                                @endphp
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-gray-700">{{ $item['label'] }}</span>
                                        <span class="text-sm font-bold {{ $item['text'] }}">{{ $item['value'] }} ({{ round($percentage) }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="{{ $item['color'] }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Total Stats -->
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3 bg-blue-50 rounded-lg">
                                        <p class="text-xs text-gray-600 font-medium">Total Rekaman</p>
                                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $total }}</p>
                                    </div>
                                    @php
                                        $persenHadir = $total > 0 ? round(($chartData['hadir'] / $total) * 100, 1) : 0;
                                    @endphp
                                    <div class="p-3 bg-green-50 rounded-lg">
                                        <p class="text-xs text-gray-600 font-medium">% Hadir</p>
                                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $persenHadir }}%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </aside>
        </div>
    </div>

@endsection
