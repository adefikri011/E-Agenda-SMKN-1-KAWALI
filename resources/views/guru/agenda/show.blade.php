@extends('layout.main')

@section('title', 'Detail Agenda')

@section('content')
    <!-- Header Section dengan Background Gradient -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 mb-6 text-white relative overflow-hidden">
        <!-- Decorative SVG Background -->
        <svg class="absolute top-0 right-0 w-32 h-32 text-blue-500 opacity-10" fill="currentColor" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M44.6,-76.4C58.8,-69.2,72.2,-59.3,79.8,-46.2C87.4,-33.1,89.2,-16.9,87.9,-1C86.6,14.9,82.2,29.7,75.1,43.6C68,57.5,58.2,70.4,45.4,77.9C32.6,85.4,16.8,87.5,0.1,87.3C-16.6,87.1,-33.2,84.6,-46.8,77.5C-60.4,70.4,-71,58.7,-78.3,45.2C-85.6,31.7,-89.6,16.4,-89.4,1.1C-89.2,-14.2,-84.8,-28.4,-77.2,-41.1C-69.6,-53.8,-58.8,-65,-45.5,-72.2C-32.2,-79.4,-16.1,-82.6,0.2,-82.9C16.5,-83.2,30.4,-83.6,44.6,-76.4Z" transform="translate(100 100)" />
        </svg>

        <div class="relative z-10 flex items-center">
            <!-- Education Icon -->
            <div class="mr-4 p-3 bg-white/10 rounded-xl backdrop-blur-sm">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Detail Agenda</h1>
                <p class="text-blue-100 mt-1">Informasi lengkap agenda pembelajaran</p>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Info -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-b border-gray-200">
            <div class="flex flex-wrap justify-between items-start gap-4">
                <div class="flex items-center">
                    <div class="mr-4 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $agenda->mata_pelajaran }}</h2>
                        <p class="text-gray-600 mt-1">{{ $agenda->kelas->nama_kelas }} - {{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} s/d {{ $agenda->endJampel?->nama_jam ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
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
            </div>
        </div>

        <div class="p-6 lg:p-8">
            <!-- Detail Agenda -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Card Informasi Agenda -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                        <h3 class="font-semibold text-blue-900 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Informasi Agenda
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Tanggal</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $agenda->tanggal->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Jam Pelajaran</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} ({{ $agenda->startJampel?->rentang_waktu ?? '-' }}) s/d {{ $agenda->endJampel?->nama_jam ?? '-' }} ({{ $agenda->endJampel?->rentang_waktu ?? '-' }})</span>
                            </div>
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Kelas</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $agenda->kelas->nama_kelas }}</span>
                            </div>
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Mata Pelajaran</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $agenda->mata_pelajaran }}</span>
                            </div>
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Dibuat Oleh</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $agenda->user->name }}</span>
                            </div>
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Dibuat Pada</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $agenda->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Status Tanda Tangan -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-4 border-b border-indigo-200">
                        <h3 class="font-semibold text-indigo-900 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            Status Tanda Tangan
                        </h3>
                    </div>
                    <div class="p-6">
                        @if ($agenda->status_ttd)
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Status</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Sudah Ditandatangani
                                    </span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Ditandatangani Oleh</span>
                                    <span class="text-sm text-gray-900 font-medium">{{ $agenda->guruTtd->name }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Waktu TTD</span>
                                    <span class="text-sm text-gray-900 font-medium">{{ $agenda->waktu_ttd->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start">
                                <span class="w-32 text-sm font-medium text-gray-600 flex-shrink-0">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Belum Ditandatangani
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Materi dan Kegiatan -->
            <div class="grid grid-cols-1 gap-6 mb-8">
                <!-- Card Materi Pembelajaran -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                        <h3 class="font-semibold text-purple-900 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            Materi Pembelajaran
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                            <p class="text-sm text-gray-800">{{ $agenda->materi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Kegiatan/Aktivitas -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                        <h3 class="font-semibold text-green-900 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            Kegiatan/Aktivitas
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                            <p class="text-sm text-gray-800 whitespace-pre-line">{{ $agenda->kegiatan }}</p>
                        </div>
                    </div>
                </div>

                @if ($agenda->catatan)
                    <!-- Card Catatan Tambahan -->
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 px-6 py-4 border-b border-yellow-200">
                            <h3 class="font-semibold text-yellow-900 flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-yellow-600 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                Catatan Tambahan
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $agenda->catatan }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tanda Tangan -->
            @if ($agenda->tanda_tangan)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
                    <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-4 border-b border-indigo-200">
                        <h3 class="font-semibold text-indigo-900 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            Tanda Tangan Digital
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-white border-2 border-gray-300 rounded-lg p-4 flex justify-center">
                            <img src="{{ $agenda->tanda_tangan }}" alt="Tanda Tangan" class="max-h-20">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('agenda.edit', $agenda->id) }}"
                   class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Agenda
                </a>

                @if (!$agenda->status_ttd && auth()->user()->hasRole('guru'))
                    <a href="{{ route('agenda.sign-form', $agenda->id) }}"
                       class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Tanda Tangan
                    </a>
                @endif

                <a href="{{ route('agenda.index') }}"
                   class="inline-flex items-center px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
