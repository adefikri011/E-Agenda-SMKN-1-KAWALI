@extends('layout.main')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Welcome Section -->
    <div class="bg-base-100 rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-2xl font-bold">Selamat Datang <span class="text-blue-500">Admin Utama</span>!</h1>
        <p class="text-gray-600 mt-2">Dashboard Sistem Agenda Sekolah</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
        <!-- Total Siswa -->
        <div class="stat bg-base-100 shadow rounded-lg">
            <div class="stat-figure text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div class="stat-title">Siswa</div>
            <div class="stat-value text-blue-500">1,245</div>
            <div class="stat-desc">Total siswa terdaftar</div>
        </div>

        <!-- Total Guru -->
        <div class="stat bg-base-100 shadow rounded-lg">
            <div class="stat-figure text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="stat-title">Guru</div>
            <div class="stat-value text-green-500">87</div>
            <div class="stat-desc">Total guru aktif</div>
        </div>

        <!-- Total Kelas -->
        <div class="stat bg-base-100 shadow rounded-lg">
            <div class="stat-figure text-purple-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="stat-title">Kelas</div>
            <div class="stat-value text-purple-500">36</div>
            <div class="stat-desc">Total kelas</div>
        </div>

        <!-- Total Jurusan -->
        <div class="stat bg-base-100 shadow rounded-lg">
            <div class="stat-figure text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="stat-title">Jurusan</div>
            <div class="stat-value text-yellow-500">7</div>
            <div class="stat-desc">Total jurusan</div>
        </div>

        <!-- Total Mapel -->
        <div class="stat bg-base-100 shadow rounded-lg">
            <div class="stat-figure text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div class="stat-title">Mapel</div>
            <div class="stat-value text-red-500">24</div>
            <div class="stat-desc">Total mata pelajaran</div>
        </div>

        <!-- Total Agenda -->
        <div class="stat bg-base-100 shadow rounded-lg">
            <div class="stat-figure text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="stat-title">Agenda</div>
            <div class="stat-value text-indigo-500">36</div>
            <div class="stat-desc">Total agenda aktif</div>
        </div>
    </div>

    <!-- Progress Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Agenda Progress -->
        <div class="bg-base-100 shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Progress Agenda</h2>
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600">Agenda Selesai</span>
                <span class="font-bold">24 / 36</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-blue-500 h-4 rounded-full" style="width: 83%"></div>
            </div>
            <div class="mt-4 text-center">
                <div class="text-3xl font-bold text-blue-500">83%</div>
                <div class="text-gray-600">Tercapai</div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-base-100 shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Agenda "Ujian Tengah Semester" selesai</p>
                        <p class="text-sm text-gray-500">2 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-green-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Guru baru ditambahkan: Budi Santoso</p>
                        <p class="text-sm text-gray-500">5 jam yang lalu</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-purple-100 rounded-full p-2 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Agenda baru: "Workshop Guru"</p>
                        <p class="text-sm text-gray-500">1 hari yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
