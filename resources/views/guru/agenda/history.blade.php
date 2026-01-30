@extends('layout.main')

@section('title', 'Riwayat Agenda')

@section('content')
    <!-- Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Riwayat Agenda</h1>
                <p class="text-gray-500 mt-1">Lihat dan kelola riwayat agenda pembelajaran</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('agenda.index') }}"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-calendar-day mr-2"></i> Agenda Hari Ini
                </a>
                <a href="{{ route('agenda.create') }}"
                    class="px-4 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors">
                    <i class="fas fa-plus mr-2"></i> Agenda Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-8 py-6">
        <!-- Filter Card -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Filter Riwayat</h2>
                <button type="button" onclick="resetFilters()"
                    class="text-sm text-gray-600 hover:text-gray-900">
                    <i class="fas fa-redo mr-1"></i> Reset Filter
                </button>
            </div>

            <form method="GET" action="{{ route('agenda.history') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $filters['start_date'] }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="end_date" value="{{ $filters['end_date'] }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ $filters['kelas_id'] == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status TTD -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status TTD</label>
                        <select name="status_ttd"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Semua Status</option>
                            <option value="sudah" {{ $filters['status_ttd'] == 'sudah' ? 'selected' : '' }}>Sudah TTD</option>
                            <option value="belum" {{ $filters['status_ttd'] == 'belum' ? 'selected' : '' }}>Belum TTD</option>
                        </select>
                    </div>

                    <!-- Pembuat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pembuat</label>
                        <select name="pembuat"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="">Semua</option>
                            <option value="guru" {{ $filters['pembuat'] == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ $filters['pembuat'] == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        </select>
                    </div>

                    <!-- Pencarian -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                        <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari agenda..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Agenda -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Agenda</p>
                        <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Sudah TTD -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sudah TTD</p>
                        <p class="text-2xl font-semibold text-green-600 mt-1">{{ $stats['sudah_ttd'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Belum TTD -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Belum TTD</p>
                        <p class="text-2xl font-semibold text-yellow-600 mt-1">{{ $stats['belum_ttd'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Dibuat oleh -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Dibuat Oleh Guru</p>
                        <p class="text-2xl font-semibold text-purple-600 mt-1">{{ $stats['by_guru'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Agenda -->
        <div class="space-y-4">
            @forelse ($agendas as $agenda)
                <div class="bg-white rounded-lg border border-gray-200 hover:border-gray-300 transition-colors">
                    <div class="p-5">
                        <!-- Header Card -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <!-- Badge Tanggal -->
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-sm">
                                        <i class="far fa-calendar"></i>
                                        {{ $agenda->tanggal->translatedFormat('d M Y') }}
                                    </span>

                                    <!-- Badge Jam -->
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm">
                                        <i class="far fa-clock"></i>
                                        {{ $agenda->startJampel?->nama_jam ?? '-' }}
                                    </span>

                                    <!-- Badge Status -->
                                    @if($agenda->status_ttd == 'sudah')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-700 text-sm">
                                            <i class="fas fa-check-circle"></i>
                                            Sudah TTD
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-sm">
                                            <i class="fas fa-clock"></i>
                                            Belum TTD
                                        </span>
                                    @endif

                                    <!-- Badge Pembuat -->
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $agenda->pembuat == 'guru' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700' }} text-sm">
                                        <i class="far fa-user"></i>
                                        {{ $agenda->pembuat == 'guru' ? 'Guru' : 'Siswa' }}
                                    </span>
                                </div>

                                <!-- Informasi Utama -->
                                <div class="space-y-2">
                                    <div class="flex items-center gap-4">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $agenda->mata_pelajaran }}</h3>
                                        <span class="text-gray-500">•</span>
                                        <span class="text-gray-600">{{ $agenda->kelas->nama_kelas }}</span>
                                    </div>

                                    <p class="text-gray-700">
                                        <span class="font-medium">Materi:</span> {{ Str::limit($agenda->materi, 150) }}
                                    </p>

                                    <div class="flex items-center gap-4 text-sm text-gray-600">
                                        <span class="flex items-center gap-1.5">
                                            <i class="far fa-user"></i>
                                            Dibuat oleh: {{ $agenda->user->name }}
                                        </span>

                                        @if($agenda->status_ttd == 'sudah' && $agenda->guruTtd)
                                            <span class="flex items-center gap-1.5">
                                                <i class="fas fa-signature"></i>
                                                Ditandatangani oleh: {{ $agenda->guruTtd->name }}
                                            </span>
                                        @endif

                                        <span class="flex items-center gap-1.5">
                                            <i class="far fa-clock"></i>
                                            Dibuat: {{ $agenda->created_at->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Aksi -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('agenda.show', $agenda->id) }}"
                                    class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if(!$agenda->status_ttd && in_array(auth()->user()->role, ['guru', 'walikelas']))
                                    <a href="{{ route('agenda.sign-form', $agenda->id) }}"
                                        class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                        title="Tanda Tangan">
                                        <i class="fas fa-signature"></i>
                                    </a>
                                @endif

                                <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Preview Kegiatan -->
                        @if($agenda->kegiatan)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    <span class="font-medium">Kegiatan:</span> {{ Str::limit($agenda->kegiatan, 200) }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-20 h-20 mx-auto mb-6 text-gray-300">
                            <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada agenda ditemukan</h3>
                        <p class="text-gray-500 mb-6">
                            @if(collect($filters)->filter()->isNotEmpty())
                                Coba ubah filter pencarian Anda untuk menemukan agenda.
                            @else
                                Belum ada agenda yang dibuat untuk periode ini.
                            @endif
                        </p>
                        <div class="space-x-3">
                            @if(collect($filters)->filter()->isNotEmpty())
                                <button onclick="resetFilters()"
                                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                                    Reset Filter
                                </button>
                            @endif
                            <a href="{{ route('agenda.create') }}"
                                class="px-4 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Buat Agenda
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    <script>
        function resetFilters() {
            // Reset form
            document.getElementById('filterForm').reset();

            // Remove query string from URL and reload
            window.location.href = '{{ route("agenda.history") }}';
        }

        // Auto submit form when date range is selected
        document.addEventListener('DOMContentLoaded', function() {
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Jika kedua tanggal sudah diisi, submit form
                    const startDate = document.querySelector('input[name="start_date"]').value;
                    const endDate = document.querySelector('input[name="end_date"]').value;

                    if (startDate && endDate) {
                        document.getElementById('filterForm').submit();
                    }
                });
            });
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
@endsection
