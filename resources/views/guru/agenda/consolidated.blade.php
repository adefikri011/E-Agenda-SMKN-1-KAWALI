@extends('layout.main')

@section('title', 'Gabungan Agenda per Kelas')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Gabungan Agenda per Kelas</h1>
        <p class="text-gray-600 mt-1">Menampilkan agenda yang sudah ditandatangani digabung per kelas untuk tanggal yang dipilih.</p>
    </div>

    <form method="GET" action="{{ route('agenda.consolidated') }}" class="mb-4">
        <label class="block text-sm font-medium mb-2">Pilih Tanggal</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}" class="border p-2 rounded" />
        <button class="ml-2 px-4 py-2 bg-blue-600 text-white rounded">Tampilkan</button>
    </form>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-100 text-red-800 rounded mb-4">{{ session('error') }}</div>
    @endif

    @forelse($groups as $group)
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <h3 class="font-semibold">Kelas: {{ $group['kelas']->nama_kelas ?? 'Unknown' }}</h3>
                    <div class="text-sm text-gray-600">Jumlah agenda: {{ count($group['entries']) }}</div>
                </div>
                <form method="POST" action="{{ route('agenda.consolidate.save') }}">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $group['kelas']->id }}" />
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}" />
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Gabungkan & Simpan</button>
                </form>
            </div>

            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Mata Pelajaran</th>
                        <th class="p-2 border">Materi</th>
                        <th class="p-2 border">Kegiatan</th>
                        <th class="p-2 border">Guru (TTD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group['entries'] as $i => $entry)
                        <tr>
                            <td class="p-2 border">{{ $i+1 }}</td>
                            <td class="p-2 border">{{ $entry['mapel'] }}</td>
                            <td class="p-2 border" style="white-space:pre-wrap">{{ $entry['materi'] }}</td>
                            <td class="p-2 border" style="white-space:pre-wrap">{{ $entry['kegiatan'] }}</td>
                            <td class="p-2 border">{{ $entry['guru'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="p-4 bg-yellow-50 rounded">Tidak ada agenda bertanda tangan pada tanggal ini.</div>
    @endforelse

@endsection
