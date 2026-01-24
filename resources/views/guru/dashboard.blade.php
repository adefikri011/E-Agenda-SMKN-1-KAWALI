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
                <p class="text-lg text-gray-600 ml-4">Selamat Datang, <span
                        class="font-semibold text-blue-600">{{ $user->name ?? ($guru->nama ?? 'Guru') }}</span></p>
                <p class="text-base text-gray-500 ml-4">{{ now()->translatedFormat('l, d F Y') }} • Ringkasan kegiatan dan
                    statistik hari ini</p>
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
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
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
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
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
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KEGIATAN SEBELUM KBM -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Kegiatan Sebelum KBM - Hari {{ $todayHari ?? 'Ini' }}</h3>
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5h.01v.01H12v-.01z" />
                            </svg>
                        </div>
                    </div>

                    @if ($kegiatanSebelumKBMHariIni->isEmpty())
                        <div class="text-center py-12 bg-amber-50 rounded-xl border border-amber-100">
                            <div class="w-20 h-20 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700 mb-2">Belum Ada Kegiatan Sebelum KBM</p>
                            <p class="text-base text-gray-500">Tidak ada kegiatan yang ditentukan untuk hari {{ $todayHari ?? 'ini' }}</p>
                        </div>
                    @else
                        <div class="space-y-5">
                            @foreach ($kegiatanSebelumKBMHariIni as $item)
                                <div class="border border-amber-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-amber-50">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                                                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-3">{{ $item['jurusan_name'] }}</h4>
                                            <ul class="space-y-2">
                                                @foreach ($item['kegiatans'] as $kegiatan)
                                                    <li class="flex items-start gap-2">
                                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-amber-300 flex-shrink-0 mt-0.5">
                                                            <svg class="h-3 w-3 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                        <span class="text-base text-gray-700">{{ $kegiatan }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- KEHADIRAN CHART PER MAPEL -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Rekap Presensi Hari Ini</h3>
                        <div class="flex items-center gap-3">
                            @if ($rekapPresensiPerMapel->count() > 3)
                                <button onclick="openRekap()" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                                    Lihat Semua
                                </button>
                            @endif
                            <div
                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if ($rekapPresensiPerMapel->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700 mb-2">Belum Ada Data Presensi</p>
                            <p class="text-base text-gray-500">Anda belum melakukan input presensi untuk kelas manapun hari
                                ini.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($rekapPresensiPerMapel->take(3) as $item)
                                <div
                                    class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-white">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-2">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900">{{ $item['mapel'] }}</h4>
                                            <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                                                <span
                                                    class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-medium">{{ $item['kelas'] }}</span>
                                                <span>•</span>
                                                <span>{{ $item['jam'] }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-blue-600">
                                                {{ $item['stats']['persentase'] }}%</div>
                                            <div class="text-xs text-gray-500 uppercase tracking-wide">Kehadiran</div>
                                        </div>
                                    </div>

                                    <!-- Progress & Stats Grid -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Progress Bar -->
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-xs font-semibold text-gray-600">
                                                <span>Kehadiran Siswa</span>
                                                <span>{{ $item['stats']['hadir'] }} / {{ $item['stats']['total'] }}
                                                    Siswa</span>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                                <div class="bg-blue-500 h-3 rounded-full"
                                                    style="width: {{ $item['stats']['persentase'] }}%;"></div>
                                            </div>
                                        </div>

                                        <!-- Breakdown Status -->
                                        <div class="grid grid-cols-4 gap-2 text-center">
                                            <div class="bg-green-50 rounded p-2 border border-green-100">
                                                <div class="text-xs text-green-600 font-medium">Hadir</div>
                                                <div class="font-bold text-green-800">{{ $item['stats']['hadir'] }}</div>
                                            </div>
                                            <div class="bg-yellow-50 rounded p-2 border border-yellow-100">
                                                <div class="text-xs text-yellow-600 font-medium">Izin</div>
                                                <div class="font-bold text-yellow-800">{{ $item['stats']['izin'] }}</div>
                                            </div>
                                            <div class="bg-blue-50 rounded p-2 border border-blue-100">
                                                <div class="text-xs text-blue-600 font-medium">Sakit</div>
                                                <div class="font-bold text-blue-800">{{ $item['stats']['sakit'] }}</div>
                                            </div>
                                            <div class="bg-red-50 rounded p-2 border border-red-100">
                                                <div class="text-xs text-red-600 font-medium">Alpha</div>
                                                <div class="font-bold text-red-800">{{ $item['stats']['alpha'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if ($rekapPresensiPerMapel->count() > 3)
                                <div class="text-center pt-4">
                                    <p class="text-sm text-gray-500">
                                        Menampilkan 3 dari {{ $rekapPresensiPerMapel->count() }} data
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- AGENDA HARI INI -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Agenda Terbaru</h3>
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    @if (empty($agendaTerbaru) || $agendaTerbaru->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700 mb-2">Belum ada agenda</p>
                            <p class="text-base text-gray-500">Tambahkan agenda baru untuk melihat di sini</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($agendaTerbaru as $agenda)
                                <div
                                    class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 hover:bg-blue-50 transition-all">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900 text-lg mb-3">
                                                {{ $agenda->mata_pelajaran }}</p>
                                            <div class="space-y-2 text-base text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    <span><strong>Kelas:</strong>
                                                        {{ $agenda->kelas?->nama_kelas ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span><strong>Tanggal:</strong>
                                                        {{ $agenda->tanggal ? \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d M Y') : 'N/A' }}
                                                    </span>
                                                </div>
                                                @if ($agenda->jampel)
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span><strong>Jam:</strong> {{ $agenda->jampel->jam_mulai }} -
                                                            {{ $agenda->jampel->jam_selesai }}</span>
                                                    </div>
                                                @endif
                                                <div class="flex items-start gap-2">
                                                    <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span><strong>Materi:</strong>
                                                        {{ Str::limit($agenda->materi ?? '-', 100) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <span
                                                class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
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
                        'alpha' => 0,
                    ];
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Visualisasi Presensi</h3>
                        <span class="text-sm font-semibold bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Hari
                            Ini</span>
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
                                    [
                                        'label' => 'Hadir',
                                        'value' => $chartData['hadir'],
                                        'color' => 'bg-green-500',
                                        'light' => 'bg-green-50',
                                        'text' => 'text-green-700',
                                    ],
                                    [
                                        'label' => 'Izin',
                                        'value' => $chartData['izin'],
                                        'color' => 'bg-yellow-500',
                                        'light' => 'bg-yellow-50',
                                        'text' => 'text-yellow-700',
                                    ],
                                    [
                                        'label' => 'Sakit',
                                        'value' => $chartData['sakit'],
                                        'color' => 'bg-blue-500',
                                        'light' => 'bg-blue-50',
                                        'text' => 'text-blue-700',
                                    ],
                                    [
                                        'label' => 'Alpha',
                                        'value' => $chartData['alpha'],
                                        'color' => 'bg-red-500',
                                        'light' => 'bg-red-50',
                                        'text' => 'text-red-700',
                                    ],
                                ];
                            @endphp

                            @foreach ($items as $item)
                                @php
                                    $percentage = ($item['value'] / $total) * 100;
                                @endphp
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-gray-700">{{ $item['label'] }}</span>
                                        <span class="text-sm font-bold {{ $item['text'] }}">{{ $item['value'] }}
                                            ({{ round($percentage) }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="{{ $item['color'] }} h-2.5 rounded-full transition-all duration-500"
                                            style="width: {{ $percentage }}%;"></div>
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

    <!-- MODAL: LIHAT SEMUA REKAP PRESENSI -->
    <div id="rekapModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-8 py-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Semua Rekap Presensi</h2>
                        <p class="text-sm text-gray-500 mt-1">Total: {{ $rekapPresensiPerMapel->count() }} data presensi</p>
                    </div>
                    <button onclick="closeRekap()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-8 space-y-6">
                    @forelse ($rekapPresensiPerMapel as $item)
                        <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow bg-white">
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-2">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $item['mapel'] }}</h4>
                                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                                        <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-medium">{{ $item['kelas'] }}</span>
                                        <span>•</span>
                                        <span>{{ $item['jam'] }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600">{{ $item['stats']['persentase'] }}%</div>
                                    <div class="text-xs text-gray-500 uppercase tracking-wide">Kehadiran</div>
                                </div>
                            </div>

                            <!-- Progress & Stats Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Progress Bar -->
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-semibold text-gray-600">
                                        <span>Kehadiran Siswa</span>
                                        <span>{{ $item['stats']['hadir'] }} / {{ $item['stats']['total'] }} Siswa</span>
                                    </div>
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $item['stats']['persentase'] }}%;"></div>
                                    </div>
                                </div>

                                <!-- Breakdown Status -->
                                <div class="grid grid-cols-4 gap-2 text-center">
                                    <div class="bg-green-50 rounded p-2 border border-green-100">
                                        <div class="text-xs text-green-600 font-medium">Hadir</div>
                                        <div class="font-bold text-green-800">{{ $item['stats']['hadir'] }}</div>
                                    </div>
                                    <div class="bg-yellow-50 rounded p-2 border border-yellow-100">
                                        <div class="text-xs text-yellow-600 font-medium">Izin</div>
                                        <div class="font-bold text-yellow-800">{{ $item['stats']['izin'] }}</div>
                                    </div>
                                    <div class="bg-blue-50 rounded p-2 border border-blue-100">
                                        <div class="text-xs text-blue-600 font-medium">Sakit</div>
                                        <div class="font-bold text-blue-800">{{ $item['stats']['sakit'] }}</div>
                                    </div>
                                    <div class="bg-red-50 rounded p-2 border border-red-100">
                                        <div class="text-xs text-red-600 font-medium">Alpha</div>
                                        <div class="font-bold text-red-800">{{ $item['stats']['alpha'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500">Tidak ada data presensi</p>
                        </div>
                    @endforelse
                </div>

                <!-- Modal Footer -->
                <div class="sticky bottom-0 bg-white border-t border-gray-200 px-8 py-4 flex justify-end">
                    <button onclick="closeRekap()" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Modal -->
    <script>
        function openRekap() {
            document.getElementById('rekapModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRekap() {
            document.getElementById('rekapModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal ketika klik di luar
        document.getElementById('rekapModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeRekap();
            }
        });

        // Close modal dengan ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRekap();
            }
        });
    </script>

@endsection
