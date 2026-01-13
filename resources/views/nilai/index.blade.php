@extends('layout.main')

@section('title', 'Daftar Nilai')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Daftar Nilai</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Input nilai siswa dan riwayat per hari</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <!-- Navigation Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
            <div class="flex space-x-1 p-1">
                <button onclick="switchTab('today')"
                    class="tab-btn today-tab flex-1 py-3 px-4 rounded-lg font-medium text-base transition-colors bg-blue-600 text-white">
                    Nilai Hari Ini
                </button>
                <button onclick="switchTab('history')"
                    class="tab-btn history-tab flex-1 py-3 px-4 rounded-lg font-medium text-base transition-colors text-gray-600 hover:bg-gray-100">
                    Riwayat Nilai
                </button>
            </div>
        </div>

        @php
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $nilaiByDate = $nilai->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            })->sortByDesc(function($items, $date) {
                return $date;
            });

            $todayNilai = $nilaiByDate->get($today, collect());
            $historyNilai = $nilaiByDate->filter(function($items, $date) use ($today) {
                return $date !== $today;
            });
        @endphp

        <!-- ============ TODAY TAB ============ -->
        <div id="today-tab-content">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Input Nilai Baru -->
                <a href="{{ route('nilai.create') }}" class="group block">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Input Nilai Baru</h3>
                        <p class="text-base text-gray-600">Tambahkan nilai untuk siswa</p>
                    </div>
                </a>

                <!-- Statistik -->
                <button onclick="switchTab('history')" class="group block text-left">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Statistik Nilai</h3>
                        <p class="text-base text-gray-600">Lihat analisis nilai siswa</p>
                    </div>
                </button>
            </div>

            <!-- Dashboard Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Nilai</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $nilai->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Nilai Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $todayNilai->count() }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Rata-rata</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $nilai->count() > 0 ? round($nilai->avg('nilai'), 1) : 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Tertinggi</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ $nilai->count() > 0 ? $nilai->max('nilai') : 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NILAI HARI INI -->
            @if($todayNilai->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Nilai Hari Ini</h2>
                        <p class="text-sm text-gray-600 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Siswa</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Mapel</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Nilai</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($todayNilai as $n)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            @php
                                                $namasiswa = optional($n->siswa)->nama_siswa ?? optional($n->siswa)->nama ?? optional($n->siswa)->name ?? 'Siswa #' . ($n->siswa_id ?? 'N/A');
                                            @endphp
                                            {{ $namasiswa }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->kelas)->nama_kelas ?? optional($n->kelas)->nama ?? optional($n->kelas)->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->mapel)->nama ?? optional($n->mapel)->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') bg-blue-100 text-blue-800
                                                @elseif($n->jenis === 'uts') bg-orange-100 text-orange-800
                                                @elseif($n->jenis === 'uas') bg-red-100 text-red-800
                                                @endif">
                                                @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') Tugas Harian
                                                @elseif($n->jenis === 'uts') UTS
                                                @elseif($n->jenis === 'uas') UAS
                                                @else {{ ucfirst($n->jenis) }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $n->nilai }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $n->keterangan ? Str::limit($n->keterangan, 40) : '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $n->created_at->format('H:i') }}</td>
                                        <td class="px-6 py-4 text-sm flex gap-2">
                                            <a href="{{ route('nilai.edit', $n->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                            <button type="button" onclick="openDeleteModal({{ $n->id }})" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="mx-auto w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Nilai Hari Ini</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Anda belum menginput nilai untuk hari ini. Mulai input nilai sekarang.</p>
                    <a href="{{ route('nilai.create') }}" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Input Nilai Baru
                    </a>
                </div>
            @endif
        </div>

        <!-- ============ HISTORY TAB ============ -->
        <div id="history-tab-content" class="hidden">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Riwayat Nilai</h2>
                <p class="mt-2 text-base text-gray-600">Lihat dan kelola riwayat nilai siswa</p>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Filter Data</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tanggal -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Tanggal</label>
                        <input type="date" id="filter-date" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                    </div>

                    <!-- Kelas -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Kelas</label>
                        <select id="filter-kelas" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                            <option value="">-- Semua Kelas --</option>
                            @if(isset($kelas))
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kelas ?? $item->nama ?? $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Mapel -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Mata Pelajaran</label>
                        <select id="filter-mapel" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                            <option value="">-- Semua Mapel --</option>
                            @if(isset($mapel))
                                @foreach ($mapel as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama ?? $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT NILAI -->
            @if($historyNilai->count() > 0)
                <div class="space-y-6">
                    @foreach($historyNilai as $date => $items)
                        <div class="history-group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-date="{{ $date }}">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-l-4 border-gray-400 px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h4>
                                        <p class="text-sm text-gray-600">{{ $items->count() }} nilai terdaftar</p>
                                    </div>
                                    <div class="text-sm font-medium text-gray-600 bg-white px-3 py-1 rounded-full">{{ $items->count() }} data</div>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">#</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Siswa</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Kelas</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Mapel</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Jenis</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Nilai</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Waktu</th>
                                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($items as $n)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    @php
                                                        $namasiswa = optional($n->siswa)->nama_siswa ?? optional($n->siswa)->nama ?? optional($n->siswa)->name ?? 'Siswa #' . ($n->siswa_id ?? 'N/A');
                                                    @endphp
                                                    {{ $namasiswa }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->kelas)->nama_kelas ?? optional($n->kelas)->nama ?? optional($n->kelas)->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->mapel)->nama ?? optional($n->mapel)->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                        @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') bg-blue-100 text-blue-800
                                                        @elseif($n->jenis === 'uts') bg-orange-100 text-orange-800
                                                        @elseif($n->jenis === 'uas') bg-red-100 text-red-800
                                                        @endif">
                                                        @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') Tugas Harian
                                                        @elseif($n->jenis === 'uts') UTS
                                                        @elseif($n->jenis === 'uas') UAS
                                                        @else {{ ucfirst($n->jenis) }}
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $n->nilai }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-600">{{ $n->keterangan ? Str::limit($n->keterangan, 40) : '-' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $n->created_at->format('H:i') }}</td>
                                                <td class="px-6 py-4 text-sm flex gap-2">
                                                    <a href="{{ route('nilai.edit', $n->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                                    <button type="button" onclick="openDeleteModal({{ $n->id }})" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="mx-auto w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Riwayat Nilai</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Anda belum memiliki riwayat nilai yang tersimpan.</p>
                    <a href="{{ route('nilai.create') }}" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Input Nilai Baru
                    </a>
                </div>
            @endif
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

    <!-- Delete Modals -->
    @foreach($nilai as $item)
        <div id="deleteNilaiModal{{ $item->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-lg p-6 max-w-md mx-4">
                <div class="flex items-center mb-3">
                    <div class="p-2 rounded-full bg-red-100 text-red-600 mr-3">
                        <i class="fas fa-exclamation-triangle text-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
                </div>

                <p class="text-gray-600 mb-5 text-sm">
                    Apakah Anda yakin ingin menghapus nilai untuk
                    <span class="font-semibold">{{ optional($item->siswa)->nama_siswa ?? optional($item->siswa)->nama ?? 'Siswa #' . ($item->siswa_id ?? '') }}</span>?
                    Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteModal({{ $item->id }})" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                        Batal
                    </button>

                    <form action="{{ route('nilai.destroy', $item->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('script')
<script>
    // ============ TAB SWITCHER ============
    function switchTab(tabName) {
        // Hide all tabs
        document.getElementById('today-tab-content').classList.add('hidden');
        document.getElementById('history-tab-content').classList.add('hidden');

        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('text-gray-600');
        });

        // Show selected tab
        document.getElementById(tabName + '-tab-content').classList.remove('hidden');

        // Add active class to selected tab button
        document.querySelector('.' + tabName + '-tab').classList.add('bg-blue-600', 'text-white');
        document.querySelector('.' + tabName + '-tab').classList.remove('text-gray-600');
    }

    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterDateInput = document.getElementById('filter-date');
        const filterKelasSelect = document.getElementById('filter-kelas');
        const filterMapelSelect = document.getElementById('filter-mapel');
        const historyGroups = document.querySelectorAll('.history-group');

        function applyFilters() {
            const selectedDate = filterDateInput ? filterDateInput.value : '';
            const selectedKelas = filterKelasSelect ? filterKelasSelect.value : '';
            const selectedMapel = filterMapelSelect ? filterMapelSelect.value : '';

            historyGroups.forEach(group => {
                const groupDate = group.getAttribute('data-date');
                let showGroup = true;

                // Filter by date
                if (selectedDate && groupDate !== selectedDate) {
                    showGroup = false;
                }

                // Filter by kelas and mapel
                if (showGroup && (selectedKelas || selectedMapel)) {
                    const rows = group.querySelectorAll('tbody tr');
                    let hasVisibleRow = false;

                    rows.forEach(row => {
                        const kelasCell = row.cells[2].textContent.trim();
                        const mapelCell = row.cells[3].textContent.trim();

                        let showRow = true;

                        if (selectedKelas && !kelasCell.includes(selectedKelas)) {
                            showRow = false;
                        }

                        if (selectedMapel && !mapelCell.includes(selectedMapel)) {
                            showRow = false;
                        }

                        row.style.display = showRow ? '' : 'none';
                        if (showRow) hasVisibleRow = true;
                    });

                    if (!hasVisibleRow) showGroup = false;
                }

                group.style.display = showGroup ? '' : 'none';
            });

            // Show message if all groups are hidden
            const anyVisible = Array.from(historyGroups).some(g => g.style.display !== 'none');
            if (!anyVisible && (selectedDate || selectedKelas || selectedMapel)) {
                // Optional: Show "no data" message
            }
        }

        // Add event listeners
        filterDateInput?.addEventListener('change', applyFilters);
        filterKelasSelect?.addEventListener('change', applyFilters);
        filterMapelSelect?.addEventListener('change', applyFilters);

        // Clear filter button
        if (filterDateInput) {
            const clearBtn = document.createElement('button');
            clearBtn.className = 'btn btn-sm btn-ghost';
            clearBtn.textContent = '✕ Hapus Filter';
            clearBtn.addEventListener('click', () => {
                filterDateInput.value = '';
                filterKelasSelect.value = '';
                filterMapelSelect.value = '';
                historyGroups.forEach(g => g.style.display = '');

                // Reset all rows visibility
                document.querySelectorAll('.history-group tbody tr').forEach(row => {
                    row.style.display = '';
                });
            });
            filterDateInput.parentElement.appendChild(clearBtn);
        }
    });

    // Modal helpers
    function openDeleteModal(id) {
        const el = document.getElementById('deleteNilaiModal' + id);
        if (el) el.classList.remove('hidden');
    }

    function closeDeleteModal(id) {
        const el = document.getElementById('deleteNilaiModal' + id);
        if (el) el.classList.add('hidden');
    }
</script>
@endpush

