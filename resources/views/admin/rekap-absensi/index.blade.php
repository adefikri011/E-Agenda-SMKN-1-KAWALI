@extends('layout.main')

@section('title', 'Rekap Absensi')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Rekap Absensi</h1>
            <p class="text-gray-600">Kelola dan analisis data kehadiran siswa per kelas</p>
        </div>  

        <!-- Main Container -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar Filter -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-filter text-blue-600"></i>
                        Filter
                    </h2>

                    <form method="GET" id="filterForm" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                            <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-medium">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelases as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                            <input type="month" name="bulan" value="{{ $selectedBulan }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Spesifik</label>
                            <input type="date" name="tanggal" value="{{ $selectedTanggal }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm font-medium">
                        </div>

                        <div class="border-t border-gray-200 pt-5">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-search mr-2"></i>Terapkan Filter
                            </button>
                        </div>

                        @if($selectedKelas || $selectedTanggal)
                            <a href="{{ route('admin.rekap-absensi.index') }}" class="block w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors text-sm text-center">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if(!$selectedKelas && !$selectedTanggal)
                    <!-- Panduan Penggunaan -->
                    <div class="space-y-6">
                        <!-- Welcome Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                                    <i class="fas fa-book-open text-2xl text-blue-600"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang</h3>
                                <p class="text-gray-600">Ikuti langkah-langkah di bawah untuk melihat data rekap absensi</p>
                            </div>
                        </div>

                        <!-- Steps -->
                        <div class="space-y-4">
                            <!-- Step 1 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-600 text-white font-bold">1</div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Pilih Kelas</h4>
                                        <p class="text-gray-600 text-sm mb-3">Gunakan dropdown "Kelas" di panel filter untuk memilih kelas yang ingin ditinjau.</p>
                                        <div class="bg-gray-50 rounded border border-gray-200 p-3">
                                            <p class="text-xs text-gray-500 font-mono">Contoh: X-A, X-B, X-C, dsb.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-600 text-white font-bold">2</div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Atur Periode (Opsional)</h4>
                                        <p class="text-gray-600 text-sm mb-3">Masukkan bulan atau tanggal spesifik untuk membatasi data yang ditampilkan.</p>
                                        <ul class="text-sm text-gray-600 space-y-1">
                                            <li class="flex items-center gap-2"><i class="fas fa-check text-blue-600 text-xs"></i> Bulan: Tampilkan semua record bulan tersebut</li>
                                            <li class="flex items-center gap-2"><i class="fas fa-check text-blue-600 text-xs"></i> Tanggal Spesifik: Tampilkan hanya data tanggal itu</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-600 text-white font-bold">3</div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Terapkan Filter</h4>
                                        <p class="text-gray-600 text-sm mb-3">Klik tombol "Terapkan Filter" untuk menampilkan data rekap absensi berdasarkan pilihan Anda.</p>
                                        <div class="bg-gray-50 rounded border border-gray-200 p-3">
                                            <p class="text-xs text-gray-500 font-semibold">💡 Catatan: Minimal pilih satu kelas untuk melihat hasilnya</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-600 text-white font-bold">4</div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Export Data (Opsional)</h4>
                                        <p class="text-gray-600 text-sm mb-3">Setelah data ditampilkan, Anda dapat mengunduh laporan dalam format PDF.</p>
                                        <div class="bg-gray-50 rounded border border-gray-200 p-3">
                                            <p class="text-xs text-gray-500 font-semibold">📥 Tersedia di bagian bawah hasil filter</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5 flex-shrink-0"></i>
                                <div>
                                    <h4 class="font-semibold text-blue-900 mb-1">Informasi Statistik</h4>
                                    <p class="text-sm text-blue-700">Setelah menerapkan filter, Anda akan melihat:</p>
                                    <ul class="mt-2 text-sm text-blue-700 space-y-1">
                                        <li>✓ Ringkasan kehadiran per kelas</li>
                                        <li>✓ Daftar siswa yang tidak hadir (beserta alasan)</li>
                                        <li>✓ Statistik persentase kehadiran</li>
                                        <li>✓ Opsi untuk mengexport ke PDF</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Data Results -->
                    <div class="space-y-6">
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                                <p class="text-xs font-semibold text-gray-600 mb-1">Total Record</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $absensiData->count() }}</p>
                            </div>
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                                <p class="text-xs font-semibold text-gray-600 mb-1">Total Kelas</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $statistik ? count($statistik) : 0 }}</p>
                            </div>
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                                <p class="text-xs font-semibold text-gray-600 mb-1">Hadir</p>
                                <p class="text-2xl font-bold text-green-600">{{ collect($statistik)->sum('hadir') }}</p>
                            </div>
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                                <p class="text-xs font-semibold text-gray-600 mb-1">Tidak Hadir</p>
                                <p class="text-2xl font-bold text-red-600">{{ collect($statistik)->sum('tidak_hadir') + collect($statistik)->sum('alpha') }}</p>
                            </div>
                        </div>

                        <!-- Export Button -->
                        <div class="flex gap-3">
                            <a href="{{ route('admin.rekap-absensi.export-pdf', ['kelas_id' => $selectedKelas, 'bulan' => $selectedBulan, 'tanggal' => $selectedTanggal]) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-file-pdf"></i>Export PDF
                            </a>
                            <a href="{{ route('admin.rekap-absensi.export', ['kelas_id' => $selectedKelas, 'bulan' => $selectedBulan, 'tanggal' => $selectedTanggal]) }}" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors text-sm">
                                <i class="fas fa-file-excel"></i>Export Excel
                            </a>
                        </div>

                        <!-- Data Sections -->
                        @if(!empty($statistik))
                            <div class="space-y-6">
                                @foreach($statistik as $kelasId => $stats)
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                                        <!-- Header -->
                                        <div class="bg-gray-900 text-white px-6 py-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <h3 class="text-lg font-bold">{{ $stats['kelas_nama'] }}</h3>
                                                <span class="text-sm font-semibold px-3 py-1 bg-gray-700 rounded">Total Siswa: {{ $stats['total_siswa_unik'] }}</span>
                                            </div>
                                            
                                            <!-- Stats Grid -->
                                            <div class="grid grid-cols-2 sm:grid-cols-6 gap-3">
                                                <div class="text-center">
                                                    <p class="text-xs opacity-75 mb-1">Hadir</p>
                                                    <p class="text-xl font-bold text-green-300">{{ $stats['hadir'] }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs opacity-75 mb-1">Tidak Hadir</p>
                                                    <p class="text-xl font-bold text-red-300">{{ $stats['tidak_hadir'] }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs opacity-75 mb-1">Izin</p>
                                                    <p class="text-xl font-bold text-yellow-300">{{ $stats['izin'] }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs opacity-75 mb-1">Sakit</p>
                                                    <p class="text-xl font-bold text-orange-300">{{ $stats['sakit'] }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs opacity-75 mb-1">Alpha</p>
                                                    <p class="text-xl font-bold text-purple-300">{{ $stats['alpha'] }}</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xs opacity-75 mb-1">% Hadir</p>
                                                    <p class="text-xl font-bold">
                                                        @php
                                                            $total = $stats['hadir'] + $stats['tidak_hadir'] + $stats['izin'] + $stats['sakit'] + $stats['alpha'];
                                                            $percentage = $total > 0 ? round(($stats['hadir'] / $total) * 100, 1) : 0;
                                                        @endphp
                                                        {{ $percentage }}%
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        @if(count($stats['siswa_tidak_hadir']) > 0)
                                            <div class="p-6">
                                                <h4 class="font-semibold text-gray-900 mb-4">Siswa Tidak Hadir</h4>
                                                <div class="overflow-x-auto">
                                                    <table class="w-full">
                                                        <thead>
                                                            <tr class="border-b border-gray-200">
                                                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">No</th>
                                                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Nama Siswa</th>
                                                                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 uppercase">NIS</th>
                                                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Izin</th>
                                                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Sakit</th>
                                                                <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600 uppercase">Alpha</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-gray-200">
                                                            @foreach($stats['siswa_tidak_hadir'] as $index => $siswaTidakHadir)
                                                                <tr class="hover:bg-gray-50">
                                                                    <td class="py-3 px-4 text-sm text-gray-900 font-semibold">{{ $index + 1 }}</td>
                                                                    <td class="py-3 px-4 text-sm text-gray-900">{{ $siswaTidakHadir['nama'] }}</td>
                                                                    <td class="py-3 px-4 text-sm text-gray-600 font-mono">{{ $siswaTidakHadir['nis'] }}</td>
                                                                    <td class="py-3 px-4 text-center text-sm font-semibold">
                                                                        @if($siswaTidakHadir['izin'] > 0)
                                                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">{{ $siswaTidakHadir['izin'] }}x</span>
                                                                        @else
                                                                            <span class="text-gray-400">—</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="py-3 px-4 text-center text-sm font-semibold">
                                                                        @if($siswaTidakHadir['sakit'] > 0)
                                                                            <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded text-xs">{{ $siswaTidakHadir['sakit'] }}x</span>
                                                                        @else
                                                                            <span class="text-gray-400">—</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="py-3 px-4 text-center text-sm font-semibold">
                                                                        @if($siswaTidakHadir['alpha'] > 0)
                                                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">{{ $siswaTidakHadir['alpha'] }}x</span>
                                                                        @else
                                                                            <span class="text-gray-400">—</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @else
                                            <div class="p-8 text-center">
                                                <i class="fas fa-check-circle text-3xl text-green-500 mb-3 block"></i>
                                                <p class="text-gray-600 font-semibold">Semua Siswa Hadir</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        if (form) {
            form.addEventListener('submit', function() {
                // Form will submit naturally
            });
        }
    });
</script>
@endsection
