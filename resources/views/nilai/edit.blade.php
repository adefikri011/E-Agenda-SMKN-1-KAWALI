@extends('layout.main')

@section('title', 'Edit Nilai')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold">✏️ Edit Nilai</h2>
            <p class="text-sm text-gray-500">Perbarui data nilai siswa</p>
        </div>
        <a href="{{ route('nilai.index') }}" class="btn btn-outline">← Kembali ke Daftar Nilai</a>
    </div>

    <div class="bg-white rounded-xl shadow p-6 max-w-2xl">
        <form action="{{ route('nilai.update', $nilai->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="kelas_id" value="{{ $nilai->kelas_id }}">
            <input type="hidden" name="siswa_id" value="{{ $nilai->siswa_id }}">

            <!-- Student Info (Read-only) -->
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-600 uppercase">Siswa</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ optional($nilai->siswa)->nama_siswa ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-600 uppercase">NIS</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ optional($nilai->siswa)->nis ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-600 uppercase">Kelas</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">{{ optional($nilai->kelas)->nama_kelas ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Editable Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mata Pelajaran</label>
                    <select name="mapel_id" class="select select-bordered w-full" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapel as $m)
                            <option value="{{ $m->id }}" {{ $nilai->mapel_id === $m->id ? 'selected' : '' }}>
                                {{ $m->nama ?? $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                    @error('mapel_id')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Nilai</label>
                    <select name="jenis" class="select select-bordered w-full" required>
                        <option value="">Pilih Jenis</option>
                        <option value="tugas" {{ $nilai->jenis === 'tugas' || $nilai->jenis === 'tugas_harian' ? 'selected' : '' }}>Tugas Harian</option>
                        <option value="uts" {{ $nilai->jenis === 'uts' ? 'selected' : '' }}>UTS</option>
                        <option value="uas" {{ $nilai->jenis === 'uas' ? 'selected' : '' }}>UAS</option>
                    </select>
                    @error('jenis')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai (0-100)</label>
                    <input type="number" name="nilai" min="0" max="100" class="input input-bordered w-full text-lg font-bold"
                        value="{{ $nilai->nilai }}" required>
                    @error('nilai')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" class="input input-bordered w-full"
                        value="{{ $nilai->keterangan ?? '' }}" placeholder="Catatan atau komentar">
                    @error('keterangan')
                        <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Metadata -->
            <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-600">
                <p><span class="font-semibold">Dibuat:</span> {{ $nilai->created_at->format('d/m/Y H:i') }}</p>
                <p><span class="font-semibold">Diperbarui:</span> {{ $nilai->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between gap-3 pt-4 border-t">
                <a href="{{ route('nilai.index') }}" class="btn btn-ghost">Batal</a>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </div>
        </form>

        <div class="mt-3">
            <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Hapus nilai ini? Tindakan tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-outline">🗑️ Hapus</button>
            </form>
        </div>
    </div>

@endsection
