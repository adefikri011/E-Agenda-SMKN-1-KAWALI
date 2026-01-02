@extends('layout.main')

@section('title', 'Dashboard Sekretaris')

@section('content')
    <!-- Modern Header with Animation -->
    <div class="mb-8 animate-fadeIn">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 tracking-tight mb-2">
                    Dashboard Agenda
                </h1>
                <p class="text-gray-500 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ $user->name }} (Sekretaris) @if($kelas) - {{ $kelas->nama_kelas }} @endif
                </p>
                @if($jurusan)
                    <p class="text-sm text-blue-600 font-semibold mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Jurusan: <span class="font-bold text-gray-900">{{ $jurusan->nama_jurusan }}</span>
                    </p>
                @endif
            </div>
            <div class="text-right bg-white rounded-xl px-6 py-4 border border-gray-200 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Hari Ini</p>
                <p class="text-xl font-semibold text-gray-900 mt-1">{{ date('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- KPI Cards - Equal Size (Fifty-Fifty) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <!-- Siswa Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $jumlahSiswa }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa Aktif</p>
            </div>
        </div>

        <!-- Mapel Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:shadow-blue-500/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $jumlahMapel }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</p>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Side: Schedule -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Today's Schedule -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Agenda Hari Ini</h2>
                        <p class="text-sm text-gray-500 mt-1">@if($kelas){{ $kelas->nama_kelas }}@else Tidak ada kelas yang ditugaskan @endif</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($agendaHariIni as $agenda)
                        @php
                            $colors = [
                                ['border' => 'border-blue-300', 'bg' => 'bg-blue-50', 'badge' => 'bg-blue-100 text-blue-800', 'icon' => 'bg-gradient-to-br from-blue-500 to-blue-600'],
                                ['border' => 'border-purple-300', 'bg' => 'bg-purple-50', 'badge' => 'bg-purple-100 text-purple-800', 'icon' => 'bg-gradient-to-br from-purple-500 to-purple-600'],
                                ['border' => 'border-green-300', 'bg' => 'bg-green-50', 'badge' => 'bg-green-100 text-green-800', 'icon' => 'bg-gradient-to-br from-green-500 to-green-600'],
                                ['border' => 'border-red-300', 'bg' => 'bg-red-50', 'badge' => 'bg-red-100 text-red-800', 'icon' => 'bg-gradient-to-br from-red-500 to-red-600'],
                                ['border' => 'border-yellow-300', 'bg' => 'bg-yellow-50', 'badge' => 'bg-yellow-100 text-yellow-800', 'icon' => 'bg-gradient-to-br from-yellow-500 to-yellow-600'],
                            ];
                            $color = $colors[$loop->index % 5];
                        @endphp
                        <!-- Timeline Item -->
                        <div class="relative pl-8 pb-6 before:absolute before:left-0 before:top-3 before:w-4 before:h-4 before:rounded-full {{ $color['icon'] }} before:border-4 before:border-white {{ $loop->last ? 'before:bg-gradient-to-br before:from-green-500 before:to-green-600' : '' }}">
                            <div class="border {{ $color['border'] }} rounded-xl p-4 {{ $color['bg'] }} hover:shadow-md transition-shadow">
                                <!-- Time & Subject -->
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-lg font-bold text-gray-900">
                                                @if($agenda->startJampel && $agenda->endJampel)
                                                    {{ $agenda->startJampel->jam_mulai }} - {{ $agenda->endJampel->jam_selesai }}
                                                @elseif($agenda->jampel)
                                                    {{ $agenda->jampel->jam_mulai }} - {{ $agenda->jampel->jam_selesai }}
                                                @else
                                                    Jam Fleksibel
                                                @endif
                                            </span>
                                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $color['badge'] }}">
                                                @php
                                                    $status = $loop->last ? '✓ Terakhir' : 'Jadwal ' . ($loop->index + 1);
                                                @endphp
                                                {{ $status }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $agenda->mata_pelajaran }}</h3>
                                    </div>
                                </div>

                                <!-- Guru & Details -->
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-2 text-gray-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="font-medium">{{ $agenda->guru?->user?->name ?? ($agenda->user?->name ?? 'N/A') }}</span>
                                    </div>

                                    @if($agenda->materi)
                                        <div class="flex items-start gap-2 text-gray-700">
                                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="line-clamp-2">{{ $agenda->materi }}</span>
                                        </div>
                                    @endif

                                    @if($agenda->kegiatan)
                                        <div class="flex items-start gap-2 text-gray-700">
                                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            <span class="line-clamp-1">{{ $agenda->kegiatan }}</span>
                                        </div>
                                    @endif

                                    @if($agenda->status_ttd === 'sudah')
                                        <div class="flex items-center gap-2 pt-2 border-t border-gray-300">
                                            <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                            <span class="text-xs font-semibold text-green-700">Sudah Ditandatangani</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 pt-2 border-t border-gray-300">
                                            <span class="inline-block w-2 h-2 rounded-full bg-yellow-500"></span>
                                            <span class="text-xs font-semibold text-yellow-700">Menunggu Tanda Tangan</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium mb-1">Tidak ada agenda untuk hari ini</p>
                            <p class="text-sm text-gray-400">Mulai buat agenda baru di menu Agenda</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="space-y-6">

            <!-- Kegiatan Sebelum KBM - Single Schedule -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Kegiatan Sebelum KBM</h2>
                    <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                </div>

                @if($kegiatanPreKBM)
                    <div class="bg-orange-50 rounded-xl p-6 border border-orange-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-gray-900">{{ $kegiatanPreKBM->kegiatan }}</p>
                                    <p class="text-sm text-gray-500">{{ $kegiatanPreKBM->hari }}</p>
                                </div>
                            </div>
                            <span class="bg-orange-100 text-orange-800 text-xs font-semibold px-3 py-1 rounded-full">Hari Ini</span>
                        </div>
                        @if($jurusan && $kegiatanPreKBM->jurusan_id)
                            <div class="mt-4 pt-4 border-t border-orange-200">
                                <p class="text-xs text-gray-600 font-medium">Berlaku untuk:</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $jurusan->nama_jurusan }}</p>
                            </div>
                        @elseif(!$kegiatanPreKBM->jurusan_id)
                            <div class="mt-4 pt-4 border-t border-orange-200">
                                <p class="text-xs text-gray-600 font-medium">Berlaku untuk:</p>
                                <p class="text-sm font-semibold text-gray-700 mt-1">Semua Jurusan</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 text-center">
                        <p class="text-sm text-gray-600">Tidak ada kegiatan sebelum KBM untuk hari ini</p>
                        @if($jurusan)
                            <p class="text-xs text-gray-500 mt-2">Jurusan: {{ $jurusan->nama_jurusan }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

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

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endsection
