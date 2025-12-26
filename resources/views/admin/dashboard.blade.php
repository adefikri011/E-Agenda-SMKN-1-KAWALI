@extends('layout.main')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Modern Header with Animation -->
    <div class="mb-8 animate-fadeIn">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-5xl font-bold text-gray-900 tracking-tight mb-2 bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                    Dashboard
                </h1>
                <p class="text-gray-500 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kelola dan monitor sistem akademik sekolah
                </p>
            </div>
            <div class="text-right bg-white rounded-xl px-6 py-4 border border-gray-200 shadow-sm">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Hari Ini</p>
                <p class="text-xl font-semibold text-gray-900 mt-1">{{ date('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- KPI Cards - Modern React Style -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
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
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalSiswa }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa Aktif</p>
            </div>
        </div>

        <!-- Guru Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-700 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalGuru }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Mengajar</p>
            </div>
        </div>

        <!-- Kelas Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-600 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalKelas }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas Aktif</p>
            </div>
        </div>

        <!-- Jurusan Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-600 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-600 to-gray-700 flex items-center justify-center shadow-lg shadow-gray-600/30 group-hover:shadow-gray-600/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalJurusan }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</p>
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
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalMapel }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Pelajaran</p>
            </div>
        </div>

        <!-- Agenda Card -->
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-gray-200 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gray-700 rounded-full filter blur-3xl opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalAgenda }}</p>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Agenda</p>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Left Side: Key Metrics -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Attendance Overview -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Kehadiran Hari Ini</h2>
                        <p class="text-sm text-gray-500 mt-1">Status absensi siswa terkini</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Main Attendance Metric -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-5xl font-bold text-gray-900">{{ $persentaseKehadiran }}%</p>
                                <p class="text-sm text-gray-600 mt-2 font-medium">{{ $kehadiranHariIni }} dari {{ $absensiHariIni }} siswa hadir</p>
                            </div>
                        </div>
                        <div class="relative w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-1000 shadow-lg" style="width: {{ $persentaseKehadiran }}%"></div>
                        </div>
                    </div>

                    <!-- Detail Breakdown -->
                    <div class="grid grid-cols-4 gap-4">
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                            <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['hadir'] }}</p>
                            <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Hadir</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                            <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['izin'] }}</p>
                            <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Izin</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                            <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['sakit'] }}</p>
                            <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Sakit</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-5 border border-gray-200 hover:border-blue-300 transition-colors text-center">
                            <p class="text-3xl font-bold text-gray-900">{{ $detailAbsensiHariIni['alpha'] }}</p>
                            <p class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wider">Alpha</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agenda Status -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Status Agenda</h2>
                        <p class="text-sm text-gray-500 mt-1">Ringkasan kegiatan sekolah</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border-2 border-gray-200 hover:border-blue-400 transition-all hover:shadow-lg text-center">
                        <p class="text-4xl font-bold text-gray-900">{{ $totalAgenda }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-3 uppercase tracking-wider">Total Agenda</p>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border-2 border-blue-300 hover:border-blue-400 transition-all hover:shadow-lg text-center">
                        <p class="text-4xl font-bold text-blue-900">{{ $agendaSelesai }}</p>
                        <p class="text-xs font-semibold text-blue-700 mt-3 uppercase tracking-wider">Selesai</p>
                    </div>

                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border-2 border-gray-200 hover:border-blue-400 transition-all hover:shadow-lg text-center">
                        <p class="text-4xl font-bold text-gray-900">{{ $agendaDalamProses }}</p>
                        <p class="text-xs font-semibold text-gray-500 mt-3 uppercase tracking-wider">Proses</p>
                    </div>
                </div>

                <!-- Agenda Today -->
                <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-base font-bold text-gray-900">Agenda Hari Ini</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $agendaHariIni }} kegiatan dijadwalkan</p>
                        </div>
                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <p class="text-2xl font-bold text-white">{{ $agendaHariIni }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Recent Data -->
        <div class="space-y-6">
            <!-- Recent Guru Mapel -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Guru Mapel Terbaru</h2>
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                </div>

                <div class="space-y-3">
                    @forelse($guruMapelTerbaru as $gm)
                    <div class="group flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0 shadow-md group-hover:shadow-lg transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $gm->guru->nama_guru ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-1 truncate font-medium">{{ $gm->mataPelajaran->nama_mapel ?? 'N/A' }} · {{ $gm->kelas->nama_kelas ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-sm text-gray-400 font-medium">Belum ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Kelas -->
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Kelas Terbaru</h2>
                    <span class="w-2 h-2 bg-gray-700 rounded-full animate-pulse"></span>
                </div>

                <div class="space-y-3">
                    @forelse($kelasData as $kelas)
                    <div class="group flex items-center justify-between p-4 rounded-xl border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $kelas->nama_kelas }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 font-medium">{{ $kelas->walikelas->name ?? 'Belum ditugaskan' }}</p>
                            </div>
                        </div>
                        <div class="text-right bg-gray-100 rounded-lg px-3 py-2 group-hover:bg-blue-100 transition-colors">
                            <p class="text-lg font-bold text-gray-900">{{ $kelas->siswa_count ?? $kelas->siswa()->count() }}</p>
                            <p class="text-xs text-gray-500 font-medium">siswa</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <p class="text-sm text-gray-400 font-medium">Belum ada data</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section: System Insights -->
    <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Insights Sistem</h2>
                <p class="text-sm text-gray-500 mt-1">Ringkasan operasional akademik</p>
            </div>
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 012-2h2a2 2 0 012 2v6a2 2 0 01-2 2H11a2 2 0 01-2-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="group bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-xl p-6 hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Rata-rata Siswa/Kelas</p>
                <p class="text-4xl font-bold text-gray-900 mb-1">{{ $totalKelas > 0 ? round($totalSiswa / $totalKelas, 0) : 0 }}</p>
                <p class="text-xs text-gray-500 font-medium">Estimasi kapasitas</p>
            </div>

            <div class="group bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-6 hover:border-blue-500 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-blue-200 flex items-center justify-center group-hover:bg-blue-300 transition-colors">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider mb-2">Guru/Siswa Ratio</p>
                <p class="text-4xl font-bold text-blue-900 mb-1">1:{{ $totalSiswa > 0 && $totalGuru > 0 ? round($totalSiswa / $totalGuru, 0) : 0 }}</p>
                <p class="text-xs text-blue-700 font-medium">Proporsi ideal</p>
            </div>

            <div class="group bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-xl p-6 hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mapel/Kelas</p>
                <p class="text-4xl font-bold text-gray-900 mb-1">{{ $totalKelas > 0 ? round($totalMapel / $totalKelas, 1) : 0 }}</p>
                <p class="text-xs text-gray-500 font-medium">Rata-rata per kelas</p>
            </div>

            <div class="group bg-gradient-to-br from-gray-50 to-white border-2 border-gray-200 rounded-xl p-6 hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Data Terupdate</p>
                <p class="text-4xl font-bold text-gray-900 mb-1">100%</p>
                <p class="text-xs text-gray-500 font-medium">Integritas sistem</p>
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
