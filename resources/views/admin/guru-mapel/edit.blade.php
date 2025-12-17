@extends('layout.main')

@section('title', 'Edit Penugasan Guru')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Penugasan Guru</h1>
        <p class="text-gray-600 mt-1">Ubah penugasan guru ke mata pelajaran</p>
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
        <form action="{{ route('guru-mapel.update', $guruMapel->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Guru -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i>Guru <span class="text-red-500">*</span>
                    </label>
                    <select name="guru_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ $guruMapel->guru_id == $guru->id ? 'selected' : '' }}>
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
                        @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ $guruMapel->mapel_id == $mapel->id ? 'selected' : '' }}>
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
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $guruMapel->kelas_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('guru-mapel.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
