@extends('layout.main')

@section('title', 'Detail Absensi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Absensi</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Absensi</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p><span class="font-medium">Kelas:</span> {{ $absensi->kelas->nama_kelas }}</p>
                        <p><span class="font-medium">Mata Pelajaran:</span> {{ $absensi->mapel->nama }}</p>
                        <p><span class="font-medium">Jam Pelajaran:</span> {{ $absensi->jampel->nama_jam }} ({{ $absensi->jampel->rentang_waktu }})</p>
                        <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</p>
                        <p><span class="font-medium">Pertemuan ke-:</span> {{ $absensi->pertemuan }}</p>
                        <p><span class="font-medium">Guru:</span> {{ $absensi->guru->name }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Statistik Kehadiran</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-green-700">{{ $absensi->detailAbsensi->where('status', 'hadir')->count() }}</p>
                            <p class="text-green-600">Hadir</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-red-700">{{ $absensi->detailAbsensi->where('status', 'alpha')->count() }}</p>
                            <p class="text-red-600">Alpa</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-yellow-700">{{ $absensi->detailAbsensi->where('status', 'sakit')->count() }}</p>
                            <p class="text-yellow-600">Sakit</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-blue-700">{{ $absensi->detailAbsensi->where('status', 'izin')->count() }}</p>
                            <p class="text-blue-600">Izin</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Kehadiran Siswa</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border-b text-left">No</th>
                                <th class="py-2 px-4 border-b text-left">NIS</th>
                                <th class="py-2 px-4 border-b text-left">Nama Siswa</th>
                                <th class="py-2 px-4 border-b text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensi->detailAbsensi as $index => $detail)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                                    <td class="py-2 px-4 border-b">{{ $detail->siswa->nis }}</td>
                                    <td class="py-2 px-4 border-b">{{ $detail->siswa->nama_siswa }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($detail->status == 'hadir') bg-green-100 text-green-800
                                            @elseif($detail->status == 'sakit') bg-yellow-100 text-yellow-800
                                            @elseif($detail->status == 'izin') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($detail->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('absensi.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Kembali
                </a>
                <a href="{{ route('absensi.update', $absensi->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Absensi
                </a>
            </div>
        </div>
    </div>
@endsection
