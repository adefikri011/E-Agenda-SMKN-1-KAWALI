@extends('layout.main')

@section('title', 'Detail Agenda')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Detail Agenda</h1>
        <p class="text-gray-600 mt-1">Informasi lengkap agenda pembelajaran</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <!-- Header Info -->
        <div class="flex flex-wrap justify-between items-start gap-4 mb-8">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $agenda->mata_pelajaran }}</h2>
                <p class="text-gray-600 mt-1">{{ $agenda->kelas->nama_kelas }} - {{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} s/d {{ $agenda->endJampel?->nama_jam ?? '-' }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if ($agenda->pembuat === 'guru')
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        Dibuat oleh Guru
                    </span>
                @else
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        Dibuat oleh Siswa
                    </span>
                @endif

                @if ($agenda->status_ttd)
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        Sudah Ditandatangani
                    </span>
                @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                        Belum Ditandatangani
                    </span>
                @endif
            </div>
        </div>

        <!-- Detail Agenda -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Agenda</h3>
                <div class="space-y-3">
                    <div class="flex">
                        <span class="w-32 text-gray-500">Tanggal</span>
                        <span class="font-medium">{{ $agenda->tanggal->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-500">Jam Pelajaran</span>
                        <span class="font-medium">{{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} ({{ $agenda->startJampel?->rentang_waktu ?? '-' }}) s/d {{ $agenda->endJampel?->nama_jam ?? '-' }} ({{ $agenda->endJampel?->rentang_waktu ?? '-' }})</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-500">Kelas</span>
                        <span class="font-medium">{{ $agenda->kelas->nama_kelas }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-500">Mata Pelajaran</span>
                        <span class="font-medium">{{ $agenda->mata_pelajaran }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-500">Dibuat Oleh</span>
                        <span class="font-medium">{{ $agenda->user->name }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-gray-500">Dibuat Pada</span>
                        <span class="font-medium">{{ $agenda->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Tanda Tangan</h3>
                <div class="space-y-3">
                    @if ($agenda->status_ttd)
                        <div class="flex">
                            <span class="w-32 text-gray-500">Status</span>
                            <span class="font-medium text-green-600">Sudah Ditandatangani</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-500">Ditandatangani Oleh</span>
                            <span class="font-medium">{{ $agenda->guruTtd->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-500">Waktu TTD</span>
                            <span class="font-medium">{{ $agenda->waktu_ttd->format('d/m/Y H:i') }}</span>
                        </div>
                    @else
                        <div class="flex">
                            <span class="w-32 text-gray-500">Status</span>
                            <span class="font-medium text-yellow-600">Belum Ditandatangani</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Materi dan Kegiatan -->
        <div class="grid grid-cols-1 gap-6 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Materi Pembelajaran</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-800">{{ $agenda->materi }}</p>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Kegiatan/Aktivitas</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-800 whitespace-pre-line">{{ $agenda->kegiatan }}</p>
                </div>
            </div>

            @if ($agenda->catatan)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Catatan Tambahan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800 whitespace-pre-line">{{ $agenda->catatan }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Tanda Tangan -->
        @if ($agenda->tanda_tangan)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tanda Tangan Digital</h3>
                <div class="border border-gray-300 rounded-lg p-4 bg-white">
                    <img src="{{ $agenda->tanda_tangan }}" alt="Tanda Tangan" class="max-w-xs">
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-gray-200">
            <a href="{{ route('agenda.edit', $agenda->id) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i> Edit Agenda
            </a>

            @if (!$agenda->status_ttd && auth()->user()->hasRole('guru'))
                <a href="{{ route('agenda.sign-form', $agenda->id) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                    <i class="fas fa-signature mr-2"></i> Tanda Tangan
                </a>
            @endif

            <a href="{{ route('agenda.index') }}"
               class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection
