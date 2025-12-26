@extends('layout.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📋 Lihat Semua Agenda</h1>
                <p class="text-gray-600 mt-2">Pantau agenda dari semua guru dan sekretaris</p>
            </div>
            <button onclick="document.getElementById('filterBtn').click()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                🔍 Filter
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Agenda</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $totalAgenda }}</p>
                </div>
                <div class="text-3xl">📊</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Hari Ini</p>
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $totalHariIni }}</p>
                </div>
                <div class="text-3xl">📅</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Minggu Ini</p>
                    <p class="text-2xl font-bold text-purple-600 mt-2">{{ $totalMingguIni }}</p>
                </div>
                <div class="text-3xl">📆</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">
                        {{ $agendas->total() }}
                    </p>
                </div>
                <div class="text-3xl">📈</div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-8" id="filterForm" style="display: none;">
        <h3 class="text-lg font-bold text-gray-900 mb-4">🔍 Filter Data</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                <select name="kelas_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelases as $kelas)
                        <option value="{{ $kelas->id }}" {{ $selectedKelas == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Guru</label>
                <select name="guru_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Guru --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ $selectedGuru == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_guru }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Mapel</label>
                <select name="mapel_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Mapel --</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ $selectedMapel == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" value="{{ $selectedTanggalAwal }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" value="{{ $selectedTanggalAkhir }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition">
                    Filter
                </button>
                <a href="{{ route('admin.lihat-agenda.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 px-4 rounded-lg transition text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($agendas->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kelas</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Guru/Sekretaris</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mapel</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jam Pelajaran</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Materi</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($agendas as $agenda)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $agenda->kelas->nama_kelas ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $agenda->guru->nama_guru ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $agenda->mapel->nama_mapel ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $agenda->jampel->jam_mulai ?? 'N/A' }} - {{ $agenda->jampel->jam_selesai ?? '' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="line-clamp-2">
                                        {{ Str::limit($agenda->deskripsi_materi, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.lihat-agenda.show', $agenda->id) }}"
                                       class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                        👁️ Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $agendas->links('pagination::simple-bootstrap-4') }}
            </div>
        @else
            <div class="px-6 py-8 text-center text-gray-500">
                <p class="text-lg">📭 Tidak ada agenda untuk filter yang dipilih</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.getElementById('filterBtn').addEventListener('click', function() {
        const form = document.getElementById('filterForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
@endsection
