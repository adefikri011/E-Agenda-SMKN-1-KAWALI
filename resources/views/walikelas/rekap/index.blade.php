@extends('layout.main')

@section('title', 'Laporan Absensi & Nilai')

@section('content')

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📊 Rekap Presensi & Nilai</h1>
                <p class="text-gray-600 mt-1">Kelas: <span class="font-semibold text-blue-600">{{ $kelas->nama_kelas ?? 'N/A' }}</span> | Total Siswa: <span class="font-semibold">{{ count($siswa) }}</span></p>
            </div>
        </div>

        <!-- Filter Section Sederhana: Mapel -->
        <div class="bg-white rounded-lg p-5 border border-gray-200 mb-6">
            <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-filter mr-2"></i>Filter Data
            </h3>

            <form method="GET" action="{{ route('rekap.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Filter Mapel -->
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">
                        <i class="fas fa-book mr-1 text-purple-600"></i>Mata Pelajaran
                    </label>
                    <select name="mapel_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none" onchange="this.form.submit()">
                        <option value="">-- Semua Mapel --</option>
                        @foreach($mapelOptions ?? [] as $m)
                            <option value="{{ $m->id }}" {{ $selectedMapelId == $m->id ? 'selected' : '' }}>
                                {{ $m->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <div>
                    <a href="{{ route('rekap.index') }}" class="px-6 py-2.5 bg-gray-400 text-white rounded-lg font-semibold hover:bg-gray-500 transition-all inline-block">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Kelas Info Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm border border-blue-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-blue-700 text-xs font-bold uppercase tracking-wide mb-1">Kelas Aktif</div>
                    <div class="text-lg font-bold text-blue-900">{{ $kelas->nama_kelas ?? 'N/A' }}</div>
                </div>
                <div class="w-12 h-12 bg-blue-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chalkboard text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

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
            <div class="flex flex-wrap gap-2">
                <button onclick="downloadReport('pdf')" class="px-4 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-all flex items-center shadow-md">
                    <i class="fas fa-file-pdf mr-2"></i>
                    PDF
                </button>
                <button onclick="downloadReport('excel')" class="px-4 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition-all flex items-center shadow-md">
                    <i class="fas fa-file-excel mr-2"></i>
                    Excel
                </button>
                <button onclick="downloadReport('csv')" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-all flex items-center shadow-md">
                    <i class="fas fa-file-csv mr-2"></i>
                    CSV
                </button>
            </div>
            <div class="flex gap-2">
                <button onclick="refreshReport()" class="px-4 py-2.5 bg-cyan-600 text-white rounded-lg text-sm font-semibold hover:bg-cyan-700 transition-all flex items-center shadow-md">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h2 class="text-2xl font-bold text-gray-900">📋 Laporan Ringkasan</h2>
            <p class="text-sm text-gray-600 mt-1">Rekapan lengkap kehadiran dan nilai siswa kelas {{ $kelas->nama_kelas ?? '' }}</p>
        </div>

        <!-- Attendance Summary Table -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">👥 Ringkasan Kehadiran per Siswa</h2>
                    <p class="text-sm text-gray-600 mt-1">Data presensi harian siswa</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-blue-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Pertemuan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Sakit</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Izin</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Alpa</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Presentase</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceSummaryTable" class="divide-y divide-gray-200">
                        @forelse($absensiData as $siswaId => $data)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm flex-shrink-0">
                                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($data['nama'] ?? '', 0, 1)) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">{{ $data['nama'] ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $data['nis'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $data['nis'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-900 bg-blue-50 rounded">{{ $data['totalPertemuan'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-green-600 bg-green-50 rounded">{{ $data['hadir'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-yellow-600 bg-yellow-50 rounded">{{ $data['sakit'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-blue-600 bg-blue-50 rounded">{{ $data['izin'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-red-600 bg-red-50 rounded">{{ $data['alpa'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1.5 rounded-full text-white text-xs font-bold shadow-sm {{ ($data['persentase'] ?? 0) >= 90 ? 'bg-green-600' : (($data['persentase'] ?? 0) >= 75 ? 'bg-amber-600' : 'bg-red-600') }}">
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
                    <h2 class="text-xl font-bold text-gray-900">📈 Ringkasan Nilai per Siswa</h2>
                    <p class="text-sm text-gray-600 mt-1">Rekapan nilai tugas, UTS, dan UAS</p>
                </div>
                <div class="text-sm text-gray-500">
                    <span class="inline-block mr-4"><i class="fas fa-tasks text-purple-600 mr-1"></i>Tugas Harian, UTS, UAS</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-purple-100 border-b-2 border-purple-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Total Nilai</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Rata-rata</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Tertinggi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">Terendah</th>
                        </tr>
                    </thead>
                    <tbody id="nilaiSummaryTable" class="divide-y divide-gray-200">
                        @forelse($nilaiData as $siswaId => $data)
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center shadow-sm flex-shrink-0">
                                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($data['nama'] ?? '', 0, 1)) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900">{{ $data['nama'] ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $data['nis'] ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ $data['nis'] ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-900 bg-purple-50 rounded">
                                <div>{{ $data['totalTugas'] ?? 0 }}</div>
                                <div class="text-xs text-gray-500 mt-1 grid grid-cols-2 gap-1">
                                    <span class="px-2 py-0.5 bg-gray-100 rounded">Tugas: {{ $data['jenisCounts']['tugas'] ?? 0 }}</span>
                                    <span class="px-2 py-0.5 bg-gray-100 rounded">Ulangan: {{ $data['jenisCounts']['ulangan'] ?? 0 }}</span>
                                    <span class="px-2 py-0.5 bg-gray-100 rounded">UTS: {{ $data['jenisCounts']['uts'] ?? 0 }}</span>
                                    <span class="px-2 py-0.5 bg-gray-100 rounded">UAS: {{ $data['jenisCounts']['uas'] ?? 0 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold {{ ($data['nilaiRataRata'] ?? 0) >= 80 ? 'text-green-600 bg-green-50' : (($data['nilaiRataRata'] ?? 0) >= 60 ? 'text-amber-600 bg-amber-50' : 'text-red-600 bg-red-50') }} rounded">
                                {{ round($data['nilaiRataRata'] ?? 0, 1) }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-emerald-600 bg-emerald-50 rounded">{{ $data['nilaiTertinggi'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-rose-600 bg-rose-50 rounded">{{ $data['nilaiTerendah'] ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-inbox mr-2"></i>Belum ada data nilai. Guru akan menambahkan nilai melalui menu Input Nilai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @push('script')
        <style>
            /* Custom animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            /* Custom scrollbar untuk tabel */
            .overflow-x-auto::-webkit-scrollbar {
                height: 8px;
            }

            .overflow-x-auto::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 10px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }

            .overflow-x-auto::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Print styles */
            @media print {
                .bg-gradient-to-r {
                    background: white !important;
                }
                .shadow-md {
                    box-shadow: none !important;
                }
                button {
                    display: none !important;
                }
            }
        </style>
        <script>
            /**
             * Download report dalam berbagai format
             */
            function downloadReport(format) {
                let url = new URL('{{ url("/rekap/download") }}/' + format);

                // Show loading state
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Downloading...';
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
             * Print current report
             */
            function printReport() {
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                btn.disabled = true;

                setTimeout(() => {
                    window.print();
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }, 500);
                }, 300);
            }

            /**
             * Refresh report tanpa reload penuh
             */
            function refreshReport() {
                const btn = event.target.closest('button');
                const originalText = btn.innerHTML;
                
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Refreshing...';
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
                
                alertDiv.className = `fixed top-4 right-4 ${bgColor} border ${borderColor} ${textColor} px-6 py-4 rounded-lg shadow-lg z-50 animate-fade-in`;
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
@endsection
