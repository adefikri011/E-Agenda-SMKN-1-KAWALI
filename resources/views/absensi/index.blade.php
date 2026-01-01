@extends('layout.main')

@section('title', 'Manajemen Absensi')

@php
    // Get data from controller
    $startDate = request('start_date')
        ? \Carbon\Carbon::parse(request('start_date'))
        : \Carbon\Carbon::now()->startOfMonth();
    $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : \Carbon\Carbon::now();
    $activeTab = request('tab', 'dashboard');
@endphp

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manajemen Absensi</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola data kehadiran siswa dengan mudah</p>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-8 border-b border-gray-200">
            <div class="flex space-x-8">
                <button onclick="switchTab('dashboard')"
                    class="tab-btn dashboard-tab py-3 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'dashboard' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                    Dashboard
                </button>
                <button onclick="switchTab('history')"
                    class="tab-btn history-tab py-3 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'history' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                    Riwayat Absensi
                </button>
                <button onclick="switchTab('petunjuk')"
                    class="tab-btn petunjuk-tab py-3 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'petunjuk' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                    Petunjuk
                </button>
            </div>
        </div>

        <!-- ============ DASHBOARD TAB ============ -->
        <div id="dashboard-tab-content" class="{{ $activeTab !== 'dashboard' ? 'hidden' : '' }}">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

                <!-- Jadwal Saya -->
                <a href="{{ route('guru.jadwal-saya') }}" class="group block">
                    <div
                        class="bg-white rounded-lg border border-gray-200 p-6 hover:border-gray-300 hover:shadow-sm transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Jadwal Saya</h3>
                        <p class="text-sm text-gray-600">Input absensi dari jadwal mengajar</p>
                    </div>
                </a>

                <!-- Riwayat -->
                <button onclick="switchTab('history')" class="group block text-left">
                    <div
                        class="bg-white rounded-lg border border-gray-200 p-6 hover:border-gray-300 hover:shadow-sm transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                                    </path>
                                </svg>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">Riwayat Absensi</h3>
                        <p class="text-sm text-gray-600">Analisis data kehadiran siswa</p>
                    </div>
                </button>
            </div>

            <!-- Dashboard Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Total Catatan</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="dashboardTotalAbsensi">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Kehadiran</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="dashboardRataKehadiran">0%</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Ketidakhadiran</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="dashboardTidakHadir">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Jumlah Siswa</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="dashboardSiswaUnik">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM8 7a1 1 0 11-2 0 1 1 0 012 0zM14 6a3 3 0 11-6 0 3 3 0 016 0zM15 13H9v2h6v-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIWAYAT TAB ============ -->
        <div id="history-tab-content" class="{{ $activeTab !== 'history' ? 'hidden' : '' }}">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Riwayat Absensi</h2>
                <p class="mt-2 text-sm text-gray-600">Lihat dan analisis data kehadiran siswa dalam periode waktu tertentu
                </p>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                <form method="GET" action="{{ route('absensi.index') }}" class="space-y-6">
                    <input type="hidden" name="tab" value="history">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Tanggal Mulai -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="start_date"
                                value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none">
                        </div>

                        <!-- Tanggal Akhir -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="end_date"
                                value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none">
                        </div>

                        <!-- Kelas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                            <select name="kelas_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none bg-white">
                                <option value="">-- Semua Kelas --</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                            <select name="mapel_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-500 focus:border-transparent outline-none bg-white">
                                <option value="">-- Semua Mapel --</option>
                                @foreach ($mapel as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('mapel_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Button -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full px-4 py-2 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition-colors text-sm">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Total Catatan</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="totalAbsensi">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Kehadiran</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="rataKehadiran">0%</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Ketidakhadiran</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="totalTidakHadir">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-600 font-medium uppercase tracking-wide">Jumlah Siswa</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-2" id="totalSiswaUnik">0</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM8 7a1 1 0 11-2 0 1 1 0 012 0zM14 6a3 3 0 11-6 0 3 3 0 016 0zM15 13H9v2h6v-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="font-semibold text-gray-900">Detail Absensi</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Kelas</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Mata Pelajaran</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Nama Siswa</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    NIS</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody id="absensiTableBody" class="divide-y divide-gray-200">
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <p class="text-sm">Pilih filter dan klik Tampilkan untuk melihat data</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                    <p class="text-sm text-gray-600">Total: <span id="totalRows" class="font-semibold">0</span> catatan
                    </p>
                    <p class="text-sm text-gray-600">Periode: <span id="periodInfo" class="font-semibold">-</span></p>
                </div>
            </div>
        </div>

        <!-- ============ PETUNJUK TAB ============ -->
        <div id="petunjuk-tab-content" class="{{ $activeTab !== 'petunjuk' ? 'hidden' : '' }}">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Petunjuk Penggunaan</h2>
                <p class="mt-2 text-sm text-gray-600">Panduan lengkap untuk menggunakan sistem manajemen absensi</p>
            </div>

            <div class="space-y-6">
                <!-- Panduan 1 -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.050a3.066 3.066 0 01-3.062 3.062H5.5a3.066 3.066 0 01-3.062-3.062v-6.05a3.066 3.066 0 012.812-3.062zm9.01-1.07a1.033 1.033 0 11-2.066 0 1.033 1.033 0 012.066 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2">Cara Input Absensi</h3>
                            <p class="text-sm text-gray-600 mb-3">Ada dua cara untuk input absensi siswa:</p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span><strong>Dari Dashboard:</strong> Klik tombol "Input Absensi" untuk langsung
                                        membuka form input</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span><strong>Dari Jadwal Saya:</strong> Klik menu "Jadwal Saya", pilih kelas dan mata
                                        pelajaran, kemudian klik tombol "Input Absensi"</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Panduan 2 -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 2a1 1 0 011-1h8a1 1 0 011 1v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v6h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H6v1a1 1 0 11-2 0v-1H2a2 2 0 01-2-2v-2H1a1 1 0 110-2h1V7H1a1 1 0 012-2h2V3a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2">Mengisi Form Input Absensi</h3>
                            <p class="text-sm text-gray-600 mb-3">Langkah-langkah mengisi form:</p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>Pilih kelas dan mata pelajaran (jika belum otomatis)</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>Untuk setiap siswa, pilih status: <strong>Hadir</strong>, <strong>Izin</strong>,
                                        <strong>Sakit</strong>, atau <strong>Alpha</strong></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>Klik tombol "Simpan Absensi" untuk menyimpan data</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Panduan 3 -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-2">Melihat Riwayat Absensi</h3>
                            <p class="text-sm text-gray-600 mb-3">Untuk melihat data kehadiran yang telah disimpan:</p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>Klik tab "Riwayat Absensi" di bagian atas halaman</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>Gunakan filter tanggal, kelas, atau mata pelajaran untuk mencari data
                                        tertentu</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span
                                        class="inline-block w-1.5 h-1.5 bg-gray-400 rounded-full mt-1.5 flex-shrink-0"></span>
                                    <span>Klik tombol "Tampilkan" untuk melihat hasil filter</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    </div>
    </div>

    <script>
        // ============ TAB SWITCHER ============
        function switchTab(tabName) {
            // Hide all tabs
            document.getElementById('dashboard-tab-content').classList.add('hidden');
            document.getElementById('history-tab-content').classList.add('hidden');
            document.getElementById('petunjuk-tab-content').classList.add('hidden');

            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-700');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab-content').classList.remove('hidden');

            // Add active class to selected tab button
            document.querySelector('.' + tabName + '-tab').classList.add('border-blue-600', 'text-blue-600');
            document.querySelector('.' + tabName + '-tab').classList.remove('border-transparent', 'text-gray-700');

            // If history tab, load data
            if (tabName === 'history') {
                setTimeout(() => loadAbsensiHistory(), 100);
            }

            // If dashboard tab, load dashboard stats
            if (tabName === 'dashboard') {
                setTimeout(() => loadDashboardStats(), 100);
            }

            // Update URL
            const newUrl = window.location.pathname + '?tab=' + tabName;
            window.history.replaceState({
                path: newUrl
            }, '', newUrl);
        }

        // ============ LOAD DASHBOARD STATS ============
        function loadDashboardStats() {
            const currentMonth = new Date();
            const startDate = new Date(currentMonth.getFullYear(), currentMonth.getMonth(), 1).toISOString().split('T')[0];
            const endDate = currentMonth.toISOString().split('T')[0];

            const params = new URLSearchParams({
                start_date: startDate,
                end_date: endDate
            });

            fetch(`/api/absensi/history?${params}`)
                .then(res => res.json())
                .then(data => {
                    updateDashboardStatistics(data);
                })
                .catch(err => {
                    console.error('Error loading dashboard stats:', err);
                });
        }

        // Update dashboard statistics
        function updateDashboardStatistics(data) {
            if (!data || data.length === 0) {
                document.getElementById('dashboardTotalAbsensi').textContent = '0';
                document.getElementById('dashboardRataKehadiran').textContent = '0%';
                document.getElementById('dashboardTidakHadir').textContent = '0';
                document.getElementById('dashboardSiswaUnik').textContent = '0';
                return;
            }

            const total = data.length;
            const hadir = data.filter(d => d.status === 'hadir').length;
            const tidakHadir = total - hadir;
            const siswaUnik = new Set(data.map(d => d.siswa_id)).size;
            const rataKehadiran = Math.round((hadir / total) * 100);

            document.getElementById('dashboardTotalAbsensi').textContent = total;
            document.getElementById('dashboardRataKehadiran').textContent = rataKehadiran + '%';
            document.getElementById('dashboardTidakHadir').textContent = tidakHadir;
            document.getElementById('dashboardSiswaUnik').textContent = siswaUnik;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentTab = "{{ $activeTab }}";
            if (currentTab === 'history') {
                loadAbsensiHistory();
            } else if (currentTab === 'dashboard') {
                loadDashboardStats();
            }
        });

        // Status badge color mapping
        const statusColors = {
            'hadir': {
                bg: 'bg-green-100',
                text: 'text-green-800',
                label: 'Hadir'
            },
            'sakit': {
                bg: 'bg-yellow-100',
                text: 'text-yellow-800',
                label: 'Sakit'
            },
            'izin': {
                bg: 'bg-blue-100',
                text: 'text-blue-800',
                label: 'Izin'
            },
            'alpha': {
                bg: 'bg-red-100',
                text: 'text-red-800',
                label: 'Alpa'
            }
        };

        // Load history absensi
        function loadAbsensiHistory() {
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');
            const kelasSelect = document.querySelector('select[name="kelas_id"]');
            const mapelSelect = document.querySelector('select[name="mapel_id"]');

            if (!startDateInput || !endDateInput) {
                return;
            }

            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const kelasId = kelasSelect ? kelasSelect.value : '';
            const mapelId = mapelSelect ? mapelSelect.value : '';


            if (!startDate || !endDate) {
                return;
            }

            // Build query string
            const params = new URLSearchParams({
                start_date: startDate,
                end_date: endDate,
                ...(kelasId && {
                    kelas_id: kelasId
                }),
                ...(mapelId && {
                    mapel_id: mapelId
                })
            });

            fetch(`/api/absensi/history?${params}`)
                .then(res => res.json())
                .then(data => {
                    renderAbsensiData(data);
                    updateStatistics(data);
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Gagal memuat data absensi');
                });
        }

        // Render absensi data ke table
        function renderAbsensiData(data) {
            const tbody = document.getElementById('absensiTableBody');
            const totalRowsSpan = document.getElementById('totalRows');
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;

            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2 block opacity-50"></i>
                            <p>Tidak ada data absensi untuk periode ini</p>
                        </td>
                    </tr>
                `;
                totalRowsSpan.textContent = '0';
                document.getElementById('periodInfo').textContent = formatDateRange(startDate, endDate);
                return;
            }

            tbody.innerHTML = data.map(item => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">${formatDate(item.tanggal)}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">${item.kelas?.nama_kelas || '-'}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">${item.mapel?.nama || '-'}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">${item.siswa?.nama_siswa || '-'}</td>
                    <td class="px-6 py-4 text-sm text-center text-gray-600">${item.siswa?.nis || '-'}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ${statusColors[item.status].bg} ${statusColors[item.status].text}">
                            ${statusColors[item.status].label}
                        </span>
                    </td>
                </tr>
            `).join('');

            totalRowsSpan.textContent = data.length;
            document.getElementById('periodInfo').textContent = formatDateRange(startDate, endDate);
        }

        // Update statistics
        function updateStatistics(data) {
            if (!data || data.length === 0) {
                document.getElementById('totalAbsensi').textContent = '0';
                document.getElementById('rataKehadiran').textContent = '0%';
                document.getElementById('totalTidakHadir').textContent = '0';
                document.getElementById('totalSiswaUnik').textContent = '0';
                return;
            }

            const total = data.length;
            const hadir = data.filter(d => d.status === 'hadir').length;
            const tidakHadir = total - hadir;
            const siswaUnik = new Set(data.map(d => d.siswa_id)).size;
            const rataKehadiran = Math.round((hadir / total) * 100);

            document.getElementById('totalAbsensi').textContent = total;
            document.getElementById('rataKehadiran').textContent = rataKehadiran + '%';
            document.getElementById('totalTidakHadir').textContent = tidakHadir;
            document.getElementById('totalSiswaUnik').textContent = siswaUnik;
        }

        // Format date helper
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            return date.toLocaleDateString('id-ID', options);
        }

        // Format date range
        function formatDateRange(startDate, endDate) {
            return `${formatDate(startDate)} - ${formatDate(endDate)}`;
        }

        // Handle form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            loadAbsensiHistory();
        });

        // Auto load on date change
        document.querySelector('input[name="start_date"]').addEventListener('change', loadAbsensiHistory);
        document.querySelector('input[name="end_date"]').addEventListener('change', loadAbsensiHistory);
        document.querySelector('select[name="kelas_id"]').addEventListener('change', loadAbsensiHistory);
        document.querySelector('select[name="mapel_id"]').addEventListener('change', loadAbsensiHistory);
    </script>
@endsection
