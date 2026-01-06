@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.lihat-agenda.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
            ← Kembali ke Daftar Agenda
        </a>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Agenda Detail -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Agenda Info Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Detail Agenda</h1>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        Agenda #{{ $agenda->id }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Umum -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Informasi Umum</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Tanggal</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d MMMM Y') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Kelas</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ $agenda->kelas->nama_kelas ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Mata Pelajaran</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ $agenda->mapel->nama_mapel ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Jam Pelajaran</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ $agenda->jampel->jam_mulai ?? 'N/A' }} - {{ $agenda->jampel->jam_selesai ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Guru & Sekretaris -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Pembuat Agenda</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Guru/Sekretaris</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ $agenda->guru->nama_guru ?? 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Dibuat Pada</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($agenda->created_at)->format('d M Y - H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold">Terakhir Diubah</p>
                                <p class="text-base text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($agenda->updated_at)->format('d M Y - H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <hr class="my-6">

                <!-- Materi -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Materi Pelajaran</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-gray-800">{{ $agenda->deskripsi_materi ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>
            </div>

            <!-- Kegiatan Sebelum KBM -->
            @if($agenda->kegiatanSebelumKBM && $agenda->kegiatanSebelumKBM->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">📝 Kegiatan Sebelum KBM</h2>
                    <div class="space-y-3">
                        @foreach($agenda->kegiatanSebelumKBM as $kegiatan)
                            <div class="flex items-start gap-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                <span class="text-xl">📌</span>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $kegiatan->jenis_kegiatan }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $kegiatan->deskripsi }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Absensi Detail -->
            @if($agenda->detailAbsensi && $agenda->detailAbsensi->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">📋 Detail Presensi Siswa</h2>

                    <!-- Summary -->
                    <div class="grid grid-cols-4 gap-2 mb-6">
                        <div class="bg-green-50 border border-green-200 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-green-600">
                                {{ $agenda->detailAbsensi->where('keterangan', 'Hadir')->count() }}
                            </p>
                            <p class="text-xs text-green-700 font-medium">Hadir</p>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-red-600">
                                {{ $agenda->detailAbsensi->where('keterangan', 'Tidak Hadir')->count() }}
                            </p>
                            <p class="text-xs text-red-700 font-medium">Tidak Hadir</p>
                        </div>
                        <div class="bg-yellow-50 border border-yellow-200 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-yellow-600">
                                {{ $agenda->detailAbsensi->where('keterangan', 'Izin')->count() }}
                            </p>
                            <p class="text-xs text-yellow-700 font-medium">Izin</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-200 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-orange-600">
                                {{ $agenda->detailAbsensi->where('keterangan', 'Sakit')->count() }}
                            </p>
                            <p class="text-xs text-orange-700 font-medium">Sakit</p>
                        </div>
                    </div>

                    <!-- Tabel Absensi -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama Siswa</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">NIS</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-700">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($agenda->detailAbsensi as $index => $detail)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-gray-900">
                                            {{ $detail->siswa->nama_siswa ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $detail->siswa->nis ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @switch($detail->keterangan)
                                                @case('Hadir')
                                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold text-xs">✅ Hadir</span>
                                                    @break
                                                @case('Tidak Hadir')
                                                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold text-xs">❌ Tidak Hadir</span>
                                                    @break
                                                @case('Izin')
                                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-xs">📝 Izin</span>
                                                    @break
                                                @case('Sakit')
                                                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 rounded-full font-semibold text-xs">🤒 Sakit</span>
                                                    @break
                                                @default
                                                    <span class="text-gray-500">-</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-4">
            <!-- Waktu Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">⏰ Waktu</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Jam Mulai</p>
                        <p class="text-base font-semibold text-gray-900">{{ $agenda->jampel->jam_mulai ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Jam Selesai</p>
                        <p class="text-base font-semibold text-gray-900">{{ $agenda->jampel->jam_selesai ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Durasi</p>
                        <p class="text-base font-semibold text-gray-900">{{ $agenda->jampel->durasi_menit ?? '-' }} menit</p>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">📊 Statistik</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">Total Siswa</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $agenda->detailAbsensi?->count() ?? 0 }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">Attendance Rate</p>
                        <p class="text-lg font-bold text-green-600">
                            @if($agenda->detailAbsensi && $agenda->detailAbsensi->count() > 0)
                                {{ round(($agenda->detailAbsensi->where('keterangan', 'Hadir')->count() / $agenda->detailAbsensi->count()) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">⚙️ Aksi</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.lihat-agenda.index') }}" class="block w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium rounded-lg transition text-center">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
