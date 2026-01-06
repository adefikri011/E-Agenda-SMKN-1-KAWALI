@extends('layout.main')

@section('title', 'Rekap Absensi')

@section('content')
<div class="bg-white rounded-xl shadow-md p-4 sm:p-5 mb-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">📊 Rekap Presensi</h1>
            <p class="text-gray-600 text-sm">Lihat ringkasan presensi semua kelas</p>
        </div>
        <button id="filterBtn" class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95 mt-3 md:mt-0">
            <i class="fas fa-filter text-sm"></i>
            <span class="font-medium text-sm">Filter</span>
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 sm:p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Total Record Presensi</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $absensiData->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-blue-50 to-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 sm:p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Total Kelas</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $kelases->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-green-50 to-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-school text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 sm:p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Hadir</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-600">{{ collect($statistik)->sum('hadir') }}</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-green-50 to-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 sm:p-5 hover:shadow-md transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs font-medium mb-1">Tidak Hadir</p>
                    <p class="text-xl sm:text-2xl font-bold text-red-600">
                        {{ collect($statistik)->sum('tidak_hadir') + collect($statistik)->sum('alpha') }}
                    </p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-red-50 to-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6 hidden" id="filterForm">
        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-filter text-blue-600"></i>
            Filter Data
        </h3>
        <form method="GET" class="space-y-4 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-white">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $kelas)
                        <option value="{{ $kelas->id }}" {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan</label>
                <input type="month" name="bulan" value="{{ $selectedBulan }}"
                       class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Spesifik</label>
                <input type="date" name="tanggal" value="{{ $selectedTanggal }}"
                       class="w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
            </div>

            <div class="flex flex-col justify-end space-y-2 md:space-y-0 md:flex-row md:items-end md:gap-2">
                <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-filter"></i>
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.rekap-absensi.index') }}"
                   class="px-4 py-2.5 bg-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-400 transition-colors flex items-center justify-center gap-2">
                    <i class="fas fa-redo"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Desktop Table View (Hidden on mobile) -->
    @if(!empty($statistik))
    <div class="hidden md:block space-y-6">
        @foreach($statistik as $kelasId => $stats)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <!-- Kelas Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-4 text-white">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-bold">{{ $stats['kelas_nama'] }}</h2>
                        <div class="flex items-center gap-2">
                            <span class="text-sm bg-blue-800 bg-opacity-30 px-3 py-1 rounded-full">
                                Total Siswa: {{ $stats['total_siswa_unik'] }}
                            </span>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-6 gap-3 mt-3">
                        <div class="text-center">
                            <div class="text-xs opacity-75">Hadir</div>
                            <div class="font-bold text-green-200">{{ $stats['hadir'] }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs opacity-75">Tidak Hadir</div>
                            <div class="font-bold text-red-200">{{ $stats['tidak_hadir'] }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs opacity-75">Izin</div>
                            <div class="font-bold text-yellow-200">{{ $stats['izin'] }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs opacity-75">Sakit</div>
                            <div class="font-bold text-orange-200">{{ $stats['sakit'] }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs opacity-75">Alpha</div>
                            <div class="font-bold text-purple-200">{{ $stats['alpha'] }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs opacity-75">% Hadir</div>
                            <div class="font-bold text-white">
                                @php
                                    $total = $stats['hadir'] + $stats['tidak_hadir'] + $stats['izin'] + $stats['sakit'] + $stats['alpha'];
                                    $percentage = $total > 0 ? round(($stats['hadir'] / $total) * 100, 1) : 0;
                                @endphp
                                {{ $percentage }}%
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Absensi Per Siswa -->
                @if(count($stats['siswa_tidak_hadir']) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-lg">No</th>
                                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                                    <th class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Izin</th>
                                    <th class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Sakit</th>
                                    <th class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-lg">Alpha</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($stats['siswa_tidak_hadir'] as $index => $siswaTidakHadir)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="py-3 px-5 text-sm font-medium text-gray-900">{{ $siswaTidakHadir['nama'] }}</td>
                                        <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $siswaTidakHadir['nis'] }}</td>
                                        <td class="py-3 px-5 text-center">
                                            @if($siswaTidakHadir['izin'] > 0)
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                                    <i class="fas fa-envelope text-xs"></i>
                                                    {{ $siswaTidakHadir['izin'] }}x
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-5 text-center">
                                            @if($siswaTidakHadir['sakit'] > 0)
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-xs font-semibold">
                                                    <i class="fas fa-heartbeat text-xs"></i>
                                                    {{ $siswaTidakHadir['sakit'] }}x
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-5 text-center">
                                            @if($siswaTidakHadir['alpha'] > 0)
                                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                                    <i class="fas fa-exclamation-triangle text-xs"></i>
                                                    {{ $siswaTidakHadir['alpha'] }}x
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-50 to-green-100 rounded-full mb-3">
                            <i class="fas fa-check text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Semua Siswa Hadir</h3>
                        <p class="text-gray-500 text-sm">Tidak ada catatan ketidakhadiran untuk kelas ini</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    @endif

    <!-- Mobile Card View (Hidden on desktop) -->
    <div class="md:hidden space-y-4">
        @forelse($statistik as $kelasId => $stats)
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <!-- Kelas Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-white">
                    <h3 class="font-bold text-lg">{{ $stats['kelas_nama'] }}</h3>
                    <div class="flex items-center justify-between mt-2">
                        <div class="text-sm opacity-90">Total Siswa: {{ $stats['total_siswa_unik'] }}</div>
                        <div class="text-sm font-bold bg-blue-800 bg-opacity-30 px-2 py-1 rounded">
                            @php
                                $total = $stats['hadir'] + $stats['tidak_hadir'] + $stats['izin'] + $stats['sakit'] + $stats['alpha'];
                                $percentage = $total > 0 ? round(($stats['hadir'] / $total) * 100, 1) : 0;
                            @endphp
                            {{ $percentage }}%
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-2 p-3 bg-blue-50">
                    <div class="text-center">
                        <div class="text-xs text-gray-600">Hadir</div>
                        <div class="font-bold text-green-600">{{ $stats['hadir'] }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-600">Izin</div>
                        <div class="font-bold text-yellow-600">{{ $stats['izin'] }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xs text-gray-600">Sakit</div>
                        <div class="font-bold text-orange-600">{{ $stats['sakit'] }}</div>
                    </div>
                </div>

                <!-- Siswa yang Tidak Hadir -->
                @if(count($stats['siswa_tidak_hadir']) > 0)
                    <div class="p-4">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-orange-500"></i>
                            Siswa Tidak Hadir
                        </h4>
                        <div class="space-y-3">
                            @foreach($stats['siswa_tidak_hadir'] as $siswaTidakHadir)
                                <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h5 class="font-medium text-gray-900 text-sm">{{ $siswaTidakHadir['nama'] }}</h5>
                                            <p class="text-xs text-gray-500">NIS: {{ $siswaTidakHadir['nis'] }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2 text-center">
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Izin</div>
                                            @if($siswaTidakHadir['izin'] > 0)
                                                <span class="inline-block w-8 h-8 bg-yellow-100 text-yellow-800 rounded-full flex items-center justify-center text-xs font-bold mx-auto">
                                                    {{ $siswaTidakHadir['izin'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Sakit</div>
                                            @if($siswaTidakHadir['sakit'] > 0)
                                                <span class="inline-block w-8 h-8 bg-orange-100 text-orange-800 rounded-full flex items-center justify-center text-xs font-bold mx-auto">
                                                    {{ $siswaTidakHadir['sakit'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 mb-1">Alpha</div>
                                            @if($siswaTidakHadir['alpha'] > 0)
                                                <span class="inline-block w-8 h-8 bg-red-100 text-red-800 rounded-full flex items-center justify-center text-xs font-bold mx-auto">
                                                    {{ $siswaTidakHadir['alpha'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-6 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-50 to-green-100 rounded-full mb-3">
                            <i class="fas fa-check text-xl text-green-600"></i>
                        </div>
                        <h4 class="text-sm font-semibold text-gray-800 mb-1">Semua Hadir</h4>
                        <p class="text-gray-500 text-xs">Tidak ada siswa yang tidak hadir</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-lg border border-gray-200 p-6 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-4">
                    <i class="fas fa-inbox text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Tidak Ada Data</h3>
                <p class="text-gray-600 text-sm mb-4">Tidak ada data presensi untuk periode yang dipilih</p>

                <button id="filterBtnMobile" class="w-full py-3 rounded-lg bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i> Coba Filter Lain
                </button>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtn = document.getElementById('filterBtn');
        const filterBtnMobile = document.getElementById('filterBtnMobile');
        const filterForm = document.getElementById('filterForm');

        // Toggle filter form
        function toggleFilterForm() {
            filterForm.classList.toggle('hidden');
        }

        if (filterBtn) {
            filterBtn.addEventListener('click', toggleFilterForm);
        }

        if (filterBtnMobile) {
            filterBtnMobile.addEventListener('click', toggleFilterForm);
        }

        // Close filter form when clicking outside (optional)
        document.addEventListener('click', function(event) {
            if (!filterForm.classList.contains('hidden')) {
                if (!filterForm.contains(event.target) &&
                    event.target !== filterBtn &&
                    !filterBtn.contains(event.target) &&
                    event.target !== filterBtnMobile &&
                    !filterBtnMobile.contains(event.target)) {
                    filterForm.classList.add('hidden');
                }
            }
        });
    });
</script>
@endsection
