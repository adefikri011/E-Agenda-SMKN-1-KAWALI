@extends('layout.main')

@section('title', 'Detail Nilai')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold">📊 Detail Nilai</h2>
            <p class="text-sm text-gray-500">Informasi lengkap nilai siswa</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-primary">✏️ Edit</a>
            <a href="{{ route('nilai.index') }}" class="btn btn-outline">← Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <!-- Header with Student Info -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                            <span class="text-2xl font-bold text-white">{{ strtoupper(substr(optional($nilai->siswa)->nama_siswa ?? '', 0, 1)) }}</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ optional($nilai->siswa)->nama_siswa ?? 'Siswa N/A' }}</h3>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">NIS:</span> {{ optional($nilai->siswa)->nis ?? '-' }}
                                <span class="mx-2">|</span>
                                <span class="font-semibold">Kelas:</span> {{ optional($nilai->kelas)->nama_kelas ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Grade Information -->
                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Informasi Nilai</h4>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-600 uppercase">Mata Pelajaran</p>
                                <p class="text-lg font-bold text-gray-900 mt-2">{{ optional($nilai->mapel)->nama ?? optional($nilai->mapel)->nama_mapel ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-600 uppercase">Jenis Nilai</p>
                                <div class="mt-2">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                        @if($nilai->jenis === 'tugas' || $nilai->jenis === 'tugas_harian') bg-blue-100 text-blue-700
                                        @elseif($nilai->jenis === 'uts') bg-orange-100 text-orange-700
                                        @elseif($nilai->jenis === 'uas') bg-red-100 text-red-700
                                        @endif">
                                        @if($nilai->jenis === 'tugas' || $nilai->jenis === 'tugas_harian') Tugas Harian
                                        @elseif($nilai->jenis === 'uts') UTS
                                        @elseif($nilai->jenis === 'uas') UAS
                                        @else {{ ucfirst($nilai->jenis) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                                <p class="text-xs font-semibold text-gray-600 uppercase">Nilai</p>
                                <p class="text-4xl font-bold text-green-600 mt-2">{{ $nilai->nilai }}</p>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        @if($nilai->keterangan)
                            <div class="bg-gray-50 border-l-4 border-gray-300 rounded p-4 mt-6">
                                <p class="text-xs font-semibold text-gray-600 uppercase mb-2">Keterangan</p>
                                <p class="text-gray-800">{{ $nilai->keterangan }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Teacher Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Informasi Guru</h4>
                        <div class="space-y-2 text-sm">
                            <p><span class="font-semibold text-gray-700">Nama Guru:</span> <span class="text-gray-600">{{ optional($nilai->guru)->name ?? 'N/A' }}</span></p>
                            <p><span class="font-semibold text-gray-700">Input Tanggal:</span> <span class="text-gray-600">{{ $nilai->created_at->translatedFormat('l, d F Y \p\u\k\u\l H:i') }}</span></p>
                            <p><span class="font-semibold text-gray-700">Terakhir Diubah:</span> <span class="text-gray-600">{{ $nilai->updated_at->translatedFormat('l, d F Y \p\u\k\u\l H:i') }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Grade Scale -->
            <div class="bg-white rounded-xl shadow p-4">
                <h4 class="text-sm font-bold text-gray-900 mb-4">Skala Nilai</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between items-center p-2 bg-red-50 rounded">
                        <span>0-39</span>
                        <span class="font-bold text-red-600">Kurang</span>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-yellow-50 rounded">
                        <span>40-69</span>
                        <span class="font-bold text-yellow-600">Cukup</span>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-blue-50 rounded">
                        <span>70-79</span>
                        <span class="font-bold text-blue-600">Baik</span>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-green-50 rounded">
                        <span>80-100</span>
                        <span class="font-bold text-green-600">Sangat Baik</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow p-4">
                <h4 class="text-sm font-bold text-gray-900 mb-4">Aksi Cepat</h4>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-sm btn-primary w-full">✏️ Edit Nilai</a>
                    <a href="{{ route('nilai.index') }}" class="btn btn-sm btn-ghost w-full">📋 Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>

@endsection
