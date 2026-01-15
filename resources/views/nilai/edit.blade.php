@extends('layout.main')

@section('title', 'Edit Nilai')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Nilai</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Perbarui data nilai siswa</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

<!-- Full Screen Content -->
    <div class="px-8 py-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Form Edit -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button type="button" id="nilaiTab"
                        class="px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600 focus:outline-none">
                        <i class="fas fa-edit mr-2"></i>Edit Nilai
                    </button>
                </div>

                <!-- Nilai Form -->
                <form action="{{ route('nilai.update', $nilai->id) }}" method="POST" id="nilaiForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="kelas_id" value="{{ $nilai->kelas_id }}">
                    <input type="hidden" name="siswa_id" value="{{ $nilai->siswa_id }}">

                    <div class="space-y-6" id="nilaiContent">
                        <!-- Student Info (Read-only) -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-book text-blue-600 mr-2"></i>Mata Pelajaran
                                </label>
                                <select name="mapel_id"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required>
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
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-tag text-blue-600 mr-2"></i>Jenis Nilai
                                </label>
                                <select name="jenis"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>Nilai (0-100)
                                </label>
                                <input type="number" name="nilai" min="0" max="100"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-lg font-bold"
                                    value="{{ $nilai->nilai }}" required>
                                @error('nilai')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Keterangan (Opsional)
                                </label>
                                <input type="text" name="keterangan"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $nilai->keterangan ?? '' }}" placeholder="Catatan atau komentar">
                                @error('keterangan')
                                    <span class="text-sm text-red-600 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <p><span class="font-semibold">Dibuat:</span> {{ $nilai->created_at->format('d/m/Y H:i') }}</p>
                                <p><span class="font-semibold">Diperbarui:</span> {{ $nilai->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                            <button type="reset"
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-all flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Hapus nilai ini? Tindakan tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-all flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Nilai
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Info Nilai -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Nilai</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Siswa</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ optional($nilai->siswa)->nama_siswa ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-green-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Kelas</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ optional($nilai->kelas)->nama_kelas ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-bar text-purple-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Nilai Saat Ini</span>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $nilai->nilai }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
