@extends('layout.main')

@section('title', 'Tambah Penugasan Guru')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Penugasan Guru</h1>
        <p class="text-gray-600 mt-1">Assign guru ke mata pelajaran di kelas tertentu</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg">
            <p class="font-semibold mb-2">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
        <form action="{{ route('guru-mapel.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Guru -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i>Guru <span class="text-red-500">*</span>
                    </label>
                    <select name="guru_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">Pilih Guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Pelajaran -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fas fa-book text-blue-600 mr-2"></i>Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <select name="mapel_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('mapel_id') == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fas fa-users text-blue-600 mr-2"></i>Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-blue-900">Informasi</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                Satu guru bisa mengajar multiple mata pelajaran di satu kelas. Kombinasi guru-mapel-kelas tidak boleh duplikat.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Penugasan
                    </button>
                    <a href="{{ route('guru-mapel.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
