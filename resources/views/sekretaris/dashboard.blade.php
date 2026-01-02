@extends('layout.main')

@section('title', 'Dashboard Sekretaris')

@section('content')
    <!-- Modern Header with Animation -->
    <div class="mb-10 animate-fadeIn">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-2 bg-clip-text text-transparent bg-gradient-to-r from-gray-800 to-gray-600">
                    Dashboard Agenda
                </h1>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        <span>{{ $user->name }} (Sekretaris)</span>
                        @if($kelas)
                        <span class="text-gray-400">•</span>
                        <span>{{ $kelas->nama_kelas }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="inline-flex items-center gap-3 bg-white rounded-2xl px-5 py-3 border border-gray-100 shadow-soft">
                    <div class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Hari Ini</p>
                        <p class="text-lg font-semibold text-gray-900">{{ date('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards - Minimalist Design -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
        <!-- Siswa Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-white border border-gray-100 p-7 hover:shadow-lift transition-all duration-400 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $jumlahSiswa }}</p>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest">Siswa Aktif</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                        <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="h-1 w-full bg-gray-100 overflow-hidden rounded-full">
                    <div class="h-full w-3/4 bg-gradient-to-r from-gray-400 to-gray-300"></div>
                </div>
            </div>
        </div>

        <!-- Mapel Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-white border border-gray-100 p-7 hover:shadow-lift transition-all duration-400 cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-4xl font-bold text-gray-900 mb-1">{{ $jumlahMapel }}</p>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest">Mata Pelajaran</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gray-50 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                        <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="h-1 w-full bg-gray-100 overflow-hidden rounded-full">
                    <div class="h-full w-2/3 bg-gradient-to-r from-gray-400 to-gray-300"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Left Side: Schedule -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Today's Schedule -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-soft hover:shadow-lift transition-all duration-400">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-1.5 h-6 bg-gradient-to-b from-gray-700 to-gray-500 rounded-full"></div>
                            <h2 class="text-xl font-semibold text-gray-900">Agenda Hari Ini</h2>
                        </div>
                        @if($kelas)
                        <p class="text-sm text-gray-500 ml-5">{{ $kelas->nama_kelas }}</p>
                        @endif
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($agendaHariIni as $agenda)
                        <!-- Compact Timeline Item -->
                        <div class="relative pl-8 pb-6 last:pb-0">
                            <!-- Timeline line -->
                            <div class="absolute left-3 top-0 bottom-0 w-0.5 bg-gray-200 {{ $loop->last ? 'hidden' : '' }}"></div>

                            <!-- Timeline dot -->
                            <div class="absolute left-0 top-3 w-6 h-6 rounded-full border-2 border-white
                                {{ $loop->last ? 'bg-gradient-to-br from-green-400 to-green-500 shadow-sm' : 'bg-gradient-to-br from-gray-400 to-gray-500' }}
                                flex items-center justify-center">
                                @if($loop->last)
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span class="text-[10px] font-semibold text-white">{{ $loop->iteration }}</span>
                                @endif
                            </div>

                            <!-- Content Card (compact) -->
                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 hover:border-gray-200 transition-all duration-200">
                                <!-- Time & Subject -->
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-sm font-semibold text-gray-900">
                                                @if($agenda->startJampel && $agenda->endJampel)
                                                    {{ $agenda->startJampel->jam_mulai }} - {{ $agenda->endJampel->jam_selesai }}
                                                @elseif($agenda->jampel)
                                                    {{ $agenda->jampel->jam_mulai }} - {{ $agenda->jampel->jam_selesai }}
                                                @else
                                                    Jam Fleksibel
                                                @endif
                                            </span>

                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $agenda->mata_pelajaran }}</h3>

                                        <!-- Guru -->
                                        <div class="flex items-center gap-2 mb-1 text-sm">
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs">
                                                <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="text-xs text-gray-700">{{ $agenda->guru?->user?->name ?? ($agenda->user?->name ?? 'Tidak ada guru') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="space-y-2 text-xs text-gray-600">
                                    @if($agenda->materi)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="line-clamp-2">{{ $agenda->materi }}</span>
                                    </div>
                                    @endif

                                    @if($agenda->kegiatan)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-3 h-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <span class="line-clamp-1">{{ $agenda->kegiatan }}</span>
                                    </div>
                                    @endif

                                    <!-- Status Signature -->
                                    <div class="pt-3 border-t border-gray-200">
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-2 h-2 rounded-full {{ $agenda->status_ttd ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                                            <span class="text-xs font-medium {{ $agenda->status_ttd ? 'text-green-600' : 'text-yellow-600' }}">
                                                {{ $agenda->status_ttd ? 'Sudah Ditandatangani' : 'Menunggu Tanda Tangan' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    <div class="text-center py-16">
                        <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium mb-2">Tidak ada agenda untuk hari ini</p>
                        <p class="text-sm text-gray-400">Mulai buat agenda baru di menu Agenda</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="space-y-8">
            <!-- Kegiatan Sebelum KBM -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-soft hover:shadow-lift transition-all duration-400">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-2 h-8 bg-gradient-to-b from-orange-400 to-orange-300 rounded-full"></div>
                            <h2 class="text-xl font-bold text-gray-900">Kegiatan Sebelum KBM</h2>
                        </div>

                    </div>
                    <div class="w-3 h-3 rounded-full bg-orange-400 animate-pulse"></div>
                </div>

                @if($kegiatanPreKBM)
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-50 to-white p-6 border border-orange-100">
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 w-24 h-24 -translate-y-6 translate-x-6">
                        <div class="w-full h-full rounded-full bg-gradient-to-br from-orange-200/30 to-transparent"></div>
                    </div>

                    <div class="relative">
                        <!-- Icon and Title -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-orange-400 to-orange-300 flex items-center justify-center shadow-soft">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $kegiatanPreKBM->kegiatan }}</h3>
                                <p class="text-sm text-gray-600">{{ $kegiatanPreKBM->hari }}</p>
                            </div>
                        </div>

                        <!-- Jurusan Info -->
                        <div class="pt-6 border-t border-orange-200/50">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-2">Berlaku untuk</p>
                            @if($jurusan && $kegiatanPreKBM->jurusan_id)
                            <p class="text-sm font-semibold text-gray-900">{{ $jurusan->nama_jurusan }}</p>
                            @elseif(!$kegiatanPreKBM->jurusan_id)
                            <p class="text-sm font-semibold text-gray-900">Semua Jurusan</p>
                            @endif
                        </div>

                    </div>
                </div>
                @else
                <div class="bg-gray-50 rounded-xl p-8 border border-gray-100 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium mb-1">Tidak ada kegiatan</p>
                    <p class="text-sm text-gray-400">Tidak ada kegiatan sebelum KBM untuk hari ini</p>
                    @if($jurusan)
                    <p class="text-xs text-gray-500 mt-4">Jurusan: {{ $jurusan->nama_jurusan }}</p>
                    @endif
                </div>
                @endif
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

        .shadow-soft {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04), 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .shadow-lift {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0, 0, 0, 0.04);
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

        .border-gradient {
            border-image: linear-gradient(to right, #e5e7eb, #d1d5db) 1;
        }
    </style>
@endsection
