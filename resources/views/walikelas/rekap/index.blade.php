@extends('layout.main')

@section('title', 'Laporan Absensi & Nilai')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📊 Rekap Absensi & Nilai</h1>
                <p class="text-gray-600 mt-1">Kelas: <span class="font-semibold text-blue-600">{{ $kelas->nama_kelas ?? 'N/A' }}</span> | Total Siswa: <span class="font-semibold">{{ count($siswa) }}</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-book text-blue-600 mr-2"></i>Mata Pelajaran
                </label>
                <select id="mapelFilter"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    <option value="all">Semua Mapel</option>
                    @if(!empty($mapels) && $mapels->count())
                        @foreach($mapels as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-calendar text-blue-600 mr-2"></i>Periode
                </label>
                <select id="periodeFilter"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    <option value="all">Semua Periode</option>
                    <option value="thisWeek">Minggu Ini</option>
                    <option value="thisMonth">Bulan Ini</option>
                    <option value="lastMonth">Bulan Lalu</option>
                    <option value="custom">Periode Kustom</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="generateReport()" class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all flex items-center justify-center">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Generate Laporan
                </button>
            </div>
        </div>

        <!-- Custom Date Range (hidden by default) -->
        <div id="customDateRange" class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Dari Tanggal</label>
                <input type="date" id="startDate" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Sampai Tanggal</label>
                <input type="date" id="endDate" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm mb-1">Total Pertemuan</div>
                    <div class="text-2xl font-bold text-gray-900" id="totalPertemuan">{{ $summaryData['totalPertemuan'] ?? 0 }}</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm mb-1">Kehadiran Rata-rata</div>
                    <div class="text-2xl font-bold text-green-600" id="avgKehadiran">{{ round($summaryData['avgKehadiran'] ?? 0, 1) }}%</div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm mb-1">Nilai Rata-rata</div>
                    <div class="text-2xl font-bold text-yellow-600" id="avgNilai">{{ round($summaryData['avgNilai'] ?? 0, 1) }}</div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm mb-1">Total Tugas</div>
                    <div class="text-2xl font-bold text-purple-600" id="totalTugas">{{ $summaryData['totalTugas'] ?? 0 }}</div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tasks text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap gap-3">
                <button onclick="window.location.href='{{ url('/rekap/download/csv') }}'" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition-all flex items-center">
                    <i class="fas fa-file-csv mr-2"></i>
                    Download CSV
                </button>
                <button onclick="window.location.href='{{ url('/rekap/download/excel') }}'" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-all flex items-center">
                    <i class="fas fa-file-excel mr-2"></i>
                    Download Excel
                </button>
                <button onclick="window.location.href='{{ url('/rekap/download/pdf') }}'" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-all flex items-center">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Download PDF
                </button>
            </div>
            <button onclick="printReport()" class="px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:border-gray-400 transition-all flex items-center">
                <i class="fas fa-print mr-2"></i>
                Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Report Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Ringkasan Kehadiran per Siswa</h2>
        </div>

        <!-- Attendance Summary Table -->
        <div class="p-6 border-b border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Pertemuan</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Sakit</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Izin</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Alpa</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Persentase</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceSummaryTable" class="divide-y divide-gray-200">
                        @forelse($absensiData as $siswaId => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <span class="text-sm font-semibold text-blue-600">{{ substr($data['nama'] ?? '', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $data['nama'] ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $data['nis'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $data['totalPertemuan'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm text-green-600 font-medium">{{ $data['hadir'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm text-yellow-600 font-medium">{{ $data['sakit'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm text-blue-600 font-medium">{{ $data['izin'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm text-red-600 font-medium">{{ $data['alpa'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-bold {{ ($data['persentase'] ?? 0) >= 90 ? 'bg-green-600' : (($data['persentase'] ?? 0) >= 75 ? 'bg-yellow-600' : 'bg-red-600') }}">
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
            <h2 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Nilai Tugas per Siswa</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Total Tugas</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Nilai Rata-rata</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Nilai Tertinggi</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Nilai Terendah</th>
                        </tr>
                    </thead>
                    <tbody id="nilaiSummaryTable" class="divide-y divide-gray-200">
                        @forelse($nilaiData as $siswaId => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <span class="text-sm font-semibold text-blue-600">{{ substr($data['nama'] ?? '', 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $data['nama'] ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $data['nis'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-900">{{ $data['totalTugas'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium {{ ($data['nilaiRataRata'] ?? 0) >= 80 ? 'text-green-600' : (($data['nilaiRataRata'] ?? 0) >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ round($data['nilaiRataRata'] ?? 0, 1) }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-green-600 font-medium">{{ $data['nilaiTertinggi'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm text-red-600 font-medium">{{ $data['nilaiTerendah'] ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data nilai</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setupEventListeners();
            });

            function setupEventListeners() {
                document.getElementById('periodeFilter').addEventListener('change', function() {
                    const periodeFilter = document.getElementById('periodeFilter').value;
                    const customDateRange = document.getElementById('customDateRange');

                    if (periodeFilter === 'custom') {
                        customDateRange.classList.remove('hidden');
                    } else {
                        customDateRange.classList.add('hidden');
                    }
                });
            }

            function generateReport() {
                // Report sudah di-generate oleh server saat load, cukup refresh page
                location.reload();
            }

            function printReport() {
                window.print();
            }
        </script>
    @endpush
@endsection
