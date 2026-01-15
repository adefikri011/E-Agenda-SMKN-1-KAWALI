@extends('layout.main')

@section('title', 'Laporan Absensi & Nilai')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Laporan Presensi & Nilai</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Rekap presensi dan nilai siswa per kelas</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Unduh Laporan -->
            <a href="#" onclick="downloadReport('pdf')" class="group block">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Unduh Laporan</h3>
                    <p class="text-base text-gray-600">Ekspor laporan dalam format PDF atau Excel</p>
                </div>
            </a>

            <!-- Filter Data -->
            <button onclick="document.getElementById('filter-section').scrollIntoView({behavior: 'smooth'})" class="group block text-left">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Filter Data</h3>
                    <p class="text-base text-gray-600">Sesuaikan laporan dengan filter yang diinginkan</p>
                </div>
            </button>
        </div>

        <!-- Dashboard Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Kelas</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $kelas->nama_kelas ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ count($siswa) }} siswa</p>
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
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Pertemuan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="totalPertemuan">{{ $summaryData['totalPertemuan'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Kehadiran Rata-rata</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="avgKehadiran">{{ round($summaryData['avgKehadiran'] ?? 0, 1) }}%</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Nilai Rata-rata</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2" id="avgNilai">{{ round($summaryData['avgNilai'] ?? 0, 1) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div id="filter-section" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Filter Data</h3>
            </div>

            <form method="GET" action="{{ route('rekap.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Filter Mapel -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Mata Pelajaran</label>
                        <select name="mapel_id" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                            <option value="">-- Semua Mapel --</option>
                            @foreach($mapelOptions ?? [] as $m)
                                <option value="{{ $m->id }}" {{ $selectedMapelId == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Dari Tanggal</label>
                        <input type="date" name="start_date" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('rekap.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-base font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Reset
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-base font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="text-lg font-semibold text-gray-900">Aksi Laporan</div>
                <div class="flex flex-wrap gap-3">
                    <button onclick="downloadReport('pdf')" class="px-6 py-2.5 bg-red-600 text-white text-base font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Unduh PDF
                    </button>
                    <button onclick="downloadReport('excel')" class="px-6 py-2.5 bg-green-600 text-white text-base font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8m5-4h.01M9 16h.01" />
                        </svg>
                        Unduh Excel
                    </button>
                    <button onclick="refreshReport()" class="px-6 py-2.5 bg-blue-600 text-white text-base font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- Report Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-900">Laporan Ringkasan</h2>
                <p class="text-sm text-gray-600 mt-1">Rekapan lengkap kehadiran dan nilai siswa kelas {{ $kelas->nama_kelas ?? '' }}</p>
            </div>

            <!-- Attendance Summary Table -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Ringkasan Kehadiran per Siswa</h2>
                        <p class="text-sm text-gray-600 mt-1">Data presensi harian siswa</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Pertemuan</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Hadir</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Sakit</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Izin</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Alpa</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Presentase</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceSummaryTable" class="divide-y divide-gray-200 bg-white">
                            @forelse($absensiData as $siswaId => $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">{{ strtoupper(substr($data['nama'] ?? '', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $data['nama'] ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $data['nis'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $data['nis'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-center text-gray-900 font-medium">{{ $data['totalPertemuan'] ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm text-center text-green-600 font-medium">{{ $data['hadir'] ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm text-center text-yellow-600 font-medium">{{ $data['sakit'] ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm text-center text-blue-600 font-medium">{{ $data['izin'] ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm text-center text-red-600 font-medium">{{ $data['alpa'] ?? 0 }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ ($data['persentase'] ?? 0) >= 90 ? 'bg-green-100 text-green-800' : (($data['persentase'] ?? 0) >= 75 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ round($data['persentase'] ?? 0, 1) }}%
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-gray-500">Tidak ada data siswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Nilai (Grades) Summary Table -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Ringkasan Nilai per Siswa</h2>
                        <p class="text-sm text-gray-600 mt-1">Rekapan nilai tugas, UTS, dan UAS</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        <span class="inline-block mr-4">Tugas Harian, UTS, UAS</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Total Nilai</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Rata-rata Nilai</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Tertinggi</th>
                                <th class="px-6 py-3 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Terendah</th>
                            </tr>
                        </thead>
                        <tbody id="nilaiSummaryTable" class="divide-y divide-gray-200 bg-white">
                            @forelse($nilaiData as $siswaId => $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">{{ strtoupper(substr($data['nama'] ?? '', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $data['nama'] ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $data['nis'] ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $data['nis'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $data['totalTugas'] ?? 0 }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span class="inline-block px-2 py-0.5 bg-gray-100 rounded mr-1">Tugas: {{ $data['jenisCounts']['tugas'] ?? 0 }}</span>
                                        <span class="inline-block px-2 py-0.5 bg-gray-100 rounded mr-1">UTS: {{ $data['jenisCounts']['uts'] ?? 0 }}</span>
                                        <span class="inline-block px-2 py-0.5 bg-gray-100 rounded">UAS: {{ $data['jenisCounts']['uas'] ?? 0 }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        {{ ($data['nilaiRataRata'] ?? 0) >= 80 ? 'bg-green-100 text-green-800' : (($data['nilaiRataRata'] ?? 0) >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ round($data['nilaiRataRata'] ?? 0, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-green-600">{{ $data['nilaiTertinggi'] ?? 0 }}</td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-red-600">{{ $data['nilaiTerendah'] ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-base font-medium text-gray-700 mb-2">Belum ada data nilai</p>
                                    <p class="text-sm text-gray-500">Guru akan menambahkan nilai melalui menu Input Nilai.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
@endsection

@push('script')
    <script>
        /**
         * Download report dalam berbagai format
         */
        function downloadReport(format) {
            let url = new URL('{{ url("/rekap/download") }}/' + format);

            // Show loading state
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengunduh...';
            btn.disabled = true;

            // Navigate dan restore button
            setTimeout(() => {
                window.location.href = url.toString();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 1000);
            }, 500);
        }

        /**
         * Refresh report tanpa reload penuh
         */
        function refreshReport() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memuat...';
            btn.disabled = true;

            setTimeout(() => {
                location.reload();
            }, 500);
        }

        /**
         * Show alert dengan style yang bagus
         */
        function showAlert(message, type = 'info') {
            const alertDiv = document.createElement('div');
            const bgColor = type === 'warning' ? 'bg-yellow-50' : 'bg-blue-50';
            const borderColor = type === 'warning' ? 'border-yellow-200' : 'border-blue-200';
            const textColor = type === 'warning' ? 'text-yellow-800' : 'text-blue-800';

            alertDiv.className = `fixed top-4 right-4 ${bgColor} border ${borderColor} ${textColor} px-6 py-4 rounded-lg shadow-lg z-50 animate-fadeIn`;
            alertDiv.innerHTML = message;

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Keyboard shortcut untuk print (Ctrl+P)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                printReport.call({ target: { closest: () => ({ innerHTML: '<i class="fas fa-print mr-2"></i>Print', disabled: false }) } });
            }
        });
    </script>
@endpush

