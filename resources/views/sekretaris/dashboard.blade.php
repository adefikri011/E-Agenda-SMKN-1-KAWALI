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
                    {{ $user->name }} (Sekretaris) @if($kelas) - {{ $kelas->nama }} @endif
                </p>
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
                        <h2 class="text-2xl font-bold text-gray-900">Jadwal Hari Ini</h2>
                        <p class="text-sm text-gray-500 mt-1">@if($kelas){{ $kelas->nama }}@else Tidak ada kelas yang ditugaskan @endif</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse($agendaHariIni as $agenda)
                        @php
                            $colors = [
                                ['border' => 'border-blue-300', 'bg' => 'bg-blue-50', 'icon' => 'bg-gradient-to-br from-blue-500 to-blue-600'],
                                ['border' => 'border-purple-300', 'bg' => 'bg-purple-50', 'icon' => 'bg-gradient-to-br from-purple-500 to-purple-600'],
                                ['border' => 'border-green-300', 'bg' => 'bg-green-50', 'icon' => 'bg-gradient-to-br from-green-500 to-green-600'],
                            ];
                            $color = $colors[$loop->index % 3];
                        @endphp
                        <!-- Agenda Item -->
                        <div class="group flex items-center gap-4 p-6 rounded-xl border {{ $color['border'] }} hover:{{ $color['bg'] }} transition-all duration-200">
                            <div class="w-12 h-12 rounded-xl {{ $color['icon'] }} flex items-center justify-center flex-shrink-0 shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $agenda->mata_pelajaran }}</h3>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        @if($agenda->startJampel && $agenda->endJampel)
                                            {{ $agenda->startJampel->jam_mulai }} - {{ $agenda->endJampel->jam_selesai }}
                                        @elseif($agenda->jampel)
                                            {{ $agenda->jampel->jam_mulai }} - {{ $agenda->jampel->jam_selesai }}
                                        @else
                                            Jam tidak tersedia
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $agenda->guru?->user?->name ?? ($agenda->user?->name ?? 'N/A') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-sm">Tidak ada jadwal untuk hari ini</p>
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
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 text-center">
                        <p class="text-sm text-gray-600">Tidak ada kegiatan sebelum KBM untuk hari ini</p>
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
