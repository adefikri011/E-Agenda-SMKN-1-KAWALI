@extends('layout.main')

@section('title', 'Detail Agenda')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Detail Agenda</h1>
        <p class="text-gray-600 mt-1">Informasi lengkap agenda pembelajaran</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <!-- Header dengan Status -->
        <div class="mb-6 pb-6 border-b border-gray-200">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                @if ($agenda->pembuat === 'guru')
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Dibuat oleh Guru
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Dibuat oleh Siswa
                    </span>
                @endif

                @if ($agenda->status_ttd)
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sudah Ditandatangani
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Belum Ditandatangani
                    </span>
                @endif
            </div>
            <h2 class="text-xl font-bold text-gray-900">{{ $agenda->mata_pelajaran }}</h2>
            <p class="text-gray-600 text-sm mt-1">{{ $agenda->kelas->nama_kelas ?? 'N/A' }} - {{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} s/d {{ $agenda->endJampel?->nama_jam ?? '-' }}</p>
        </div>

        <!-- Detail Agenda -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Detail Agenda</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-medium text-gray-900">{{ $agenda->tanggal->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jam Pelajaran</p>
                    <p class="font-medium text-gray-900">{{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} ({{ $agenda->startJampel?->rentang_waktu ?? '-' }}) s/d {{ $agenda->endJampel?->nama_jam ?? '-' }} ({{ $agenda->endJampel?->rentang_waktu ?? '-' }})</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-medium text-gray-900">{{ $agenda->kelas->nama_kelas ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mata Pelajaran</p>
                    <p class="font-medium text-gray-900">{{ $agenda->mata_pelajaran }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat Oleh</p>
                    <p class="font-medium text-gray-900">{{ $agenda->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat Pada</p>
                    <p class="font-medium text-gray-900">{{ $agenda->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Materi Pembelajaran -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📚 Materi Pembelajaran</h3>
            <div class="bg-purple-50 border border-purple-100 rounded-lg p-4">
                <p class="text-gray-800">{{ $agenda->materi ?? 'Tidak ada materi' }}</p>
            </div>
        </div>

        <!-- Kegiatan/Aktivitas -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">✓ Kegiatan/Aktivitas</h3>
            <div class="bg-green-50 border border-green-100 rounded-lg p-4">
                <p class="text-gray-800 whitespace-pre-line">{{ $agenda->kegiatan ?? 'Tidak ada kegiatan' }}</p>
            </div>
        </div>

        @if ($agenda->catatan)
            <!-- Catatan Tambahan -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Catatan Tambahan</h3>
                <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4">
                    <p class="text-gray-800 whitespace-pre-line">{{ $agenda->catatan }}</p>
                </div>
            </div>
        @endif

        <!-- Status Tanda Tangan -->
        @if ($agenda->status_ttd)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">✍️ Status Tanda Tangan</h3>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Ditandatangani Oleh:</span>
                        <span class="font-medium text-gray-900">{{ $agenda->guruTtd?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Waktu TTD:</span>
                        <span class="font-medium text-gray-900">{{ $agenda->waktu_ttd?->format('d/m/Y H:i') ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tanda Tangan Digital -->
        @if ($agenda->tanda_tangan)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">🖋️ Tanda Tangan Digital</h3>
                <div class="bg-white border-2 border-gray-300 rounded-lg p-4 flex justify-center">
                    <img src="{{ $agenda->tanda_tangan }}" alt="Tanda Tangan" class="max-h-24">
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('agenda.edit', $agenda->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>

            @if (!$agenda->status_ttd && auth()->user()->hasRole('guru'))
                <a href="{{ route('agenda.sign-form', $agenda->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Tanda Tangan
                </a>
            @endif

            <a href="{{ route('agenda.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection
