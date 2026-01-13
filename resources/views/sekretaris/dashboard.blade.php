@extends('layout.main')

@section('title', 'Dashboard Sekretaris')

@section('content')
    <!-- Professional Header -->
    <div class="mb-8 animate-fadeIn">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                        <h1 class="text-3xl font-bold text-gray-800">Dashboard Agenda</h1>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ $user->name }} (Sekretaris)</span>
                            @if($kelas)
                            <span class="text-gray-400">•</span>
                            <span>{{ $kelas->nama_kelas }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-1">Hari Ini</p>
                    <p class="text-xl font-semibold text-gray-800">{{ date('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Siswa Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-800 mb-1">{{ $jumlahSiswa }}</p>
                        <p class="text-sm text-gray-600">SISWA AKTIF</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mapel Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-gray-800 mb-1">{{ $jumlahMapel }}</p>
                        <p class="text-sm text-gray-600">MATA PELAJARAN</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Agenda Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                            Agenda Hari Ini
                        </h2>
                        @if($kelas)
                        <p class="text-sm text-gray-600 mt-1">{{ $kelas->nama_kelas }}</p>
                        @endif
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ count($agendaHariIni) }} Jadwal
                    </div>
                </div>

                <div class="p-6">
                    @forelse($agendaHariIni as $agenda)
                        <!-- Agenda Item -->
                        <div class="mb-6 pb-6 border-b border-gray-200 {{ $loop->last ? 'border-b-0 mb-0 pb-0' : '' }}">
                            <!-- Time Header -->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        @if($agenda->startJampel && $agenda->endJampel)
                                            {{ $agenda->startJampel->jam_mulai }} - {{ $agenda->endJampel->jam_selesai }}
                                        @elseif($agenda->jampel)
                                            {{ $agenda->jampel->jam_mulai }} - {{ $agenda->jampel->jam_selesai }}
                                        @else
                                            Jam Fleksibel
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $agenda->mata_pelajaran }}</p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="ml-15 bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <!-- Guru Info -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $agenda->guru?->user?->name ?? ($agenda->user?->name ?? 'Tidak ada guru') }}</p>
                                    </div>
                                </div>

                                <!-- Materi -->
                                @if($agenda->materi)
                                <div class="mb-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Materi</p>
                                    <p class="text-sm text-gray-700">{{ $agenda->materi }}</p>
                                </div>
                                @endif

                                <!-- Kegiatan -->
                                @if($agenda->kegiatan)
                                <div class="mb-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Kegiatan</p>
                                    <p class="text-sm text-gray-700">{{ $agenda->kegiatan }}</p>
                                </div>
                                @endif

                                <!-- Status -->
                                <div class="pt-3 border-t border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $agenda->status_ttd ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                                        <span class="text-xs font-medium {{ $agenda->status_ttd ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $agenda->status_ttd ? 'Sudah Ditandatangani' : 'Menunggu Tanda Tangan' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium mb-2">Tidak ada agenda untuk hari ini</p>
                            <p class="text-sm text-gray-400">Mulai buat agenda baru di menu Agenda</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Side Section -->
        <div class="space-y-6">
            <!-- Kegiatan Sebelum KBM -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                        <div class="w-1 h-4 bg-orange-500 rounded-full"></div>
                        Kegiatan Sebelum KBM
                    </h2>
                </div>

                <div class="p-6">
                    @if($kegiatanPreKBM)
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $kegiatanPreKBM->kegiatan }}</h3>
                                    <p class="text-sm text-gray-600">{{ $kegiatanPreKBM->hari }}</p>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-orange-200">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Berlaku untuk</p>
                                @if($jurusan && $kegiatanPreKBM->jurusan_id)
                                <p class="text-sm font-medium text-gray-800">{{ $jurusan->nama_jurusan }}</p>
                                @elseif(!$kegiatanPreKBM->jurusan_id)
                                <p class="text-sm font-medium text-gray-800">Semua Jurusan</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 text-center">
                            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium mb-1">Tidak ada kegiatan</p>
                            <p class="text-sm text-gray-400">Tidak ada kegiatan sebelum KBM untuk hari ini</p>
                            @if($jurusan)
                            <p class="text-xs text-gray-500 mt-3">Jurusan: {{ $jurusan->nama_jurusan }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
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

        .ml-15 {
            margin-left: 3.75rem; /* 60px */
        }

        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
    </style>
@endsection
