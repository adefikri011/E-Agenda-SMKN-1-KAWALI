@extends('layout.main')

@section('title', 'Agenda')

@section('content')
    <!-- Header Minimalis -->
    <div class="px-8 py-6 bg-white border-b border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Agenda Harian</h1>
                <p class="text-gray-500 mt-1">Kelola agenda pembelajaran untuk hari ini</p>
            </div>
            <div class="text-gray-600">
                <span class="font-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-8 py-6">
        <!-- Tombol Aksi Minimalis -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('agenda.create') }}"
                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-plus mr-2"></i> Buat Agenda
            </a>

            @if (auth()->user()->hasRole('guru'))
                <a href="{{ route('agenda.need-signature') }}"
                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <i class="fas fa-signature mr-2"></i> Menunggu TTD
                </a>
            @endif

            <a href="{{ route('agenda.rekap') }}"
                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-chart-bar mr-2"></i> Rekap
            </a>

            @if (auth()->user()->hasRole('guru') || auth()->user()->hasRole('walikelas') || auth()->user()->hasRole('siswa'))
                <a href="{{ route('agenda.history') }}"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-history mr-3 text-gray-500"></i>
                    <span>Riwayat Agenda</span>
                </a>
            @endif
        </div>

        <!-- Card Agenda -->
        <div class="space-y-4">
            @forelse ($agendas as $agenda)
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:border-gray-300 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-500">
                                        <i class="far fa-calendar mr-1"></i>
                                        {{ $agenda->tanggal->format('d/m') }}
                                    </span>
                                    <span class="text-sm text-gray-500">•</span>
                                    <span class="text-sm text-gray-500">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $agenda->startJampel?->nama_jam ?? '-' }}
                                    </span>
                                </div>

                                <span
                                    class="text-xs px-2 py-1 rounded-full border {{ $agenda->status_ttd ? 'border-green-200 bg-green-50 text-green-700' : 'border-yellow-200 bg-yellow-50 text-yellow-700' }}">
                                    {{ $agenda->status_ttd ? 'Sudah TTD' : 'Belum TTD' }}
                                </span>
                            </div>

                            <h3 class="font-medium text-gray-900 mb-1">{{ $agenda->mata_pelajaran }}</h3>

                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-2">
                                <span class="flex items-center">
                                    <i class="far fa-building mr-2"></i>
                                    {{ $agenda->kelas->nama_kelas }}
                                </span>
                                <span class="flex items-center">
                                    <i class="far fa-user mr-2"></i>
                                    {{ $agenda->user->name }}
                                    <span
                                        class="ml-2 text-xs px-1.5 py-0.5 rounded {{ $agenda->pembuat === 'guru' ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-green-50 text-green-700 border border-green-100' }}">
                                        {{ $agenda->pembuat === 'guru' ? 'Guru' : 'Siswa' }}
                                    </span>
                                </span>
                            </div>

                            <p class="text-sm text-gray-700 line-clamp-2 mb-1">
                                <span class="font-medium">Materi:</span> {{ Str::limit($agenda->materi, 120) }}
                            </p>
                        </div>

                        <!-- Aksi -->
                        <div class="flex items-center gap-2 ml-4">
                            <a href="{{ route('agenda.show', $agenda->id) }}"
                                class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors"
                                title="Lihat Lengkap">
                                <i class="fas fa-eye"></i>
                            </a>

                            @if (!$agenda->status_ttd && in_array(auth()->user()->role, ['guru', 'walikelas']))
                                <a href="{{ route('agenda.sign-form', $agenda->id) }}"
                                    class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded transition-colors"
                                    title="Tanda Tangan">
                                    <i class="fas fa-signature"></i>
                                </a>
                            @endif

                            <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                    title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                    <div class="mx-auto w-16 h-16 mb-4">
                        <svg class="w-full h-full text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada agenda hari ini</h3>
                    <p class="text-gray-500 mb-4">Mulai dengan membuat agenda pertama Anda</p>
                    <a href="{{ route('agenda.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-colors">
                        <i class="fas fa-plus mr-2"></i> Buat Agenda
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination Minimalis -->
        @if ($agendas->hasPages())
            <div class="mt-6">
                {{ $agendas->links('vendor.pagination.simple-tailwind') }}
            </div>
        @endif
    </div>

    @include('guru.agenda.detail')
@endsection

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>