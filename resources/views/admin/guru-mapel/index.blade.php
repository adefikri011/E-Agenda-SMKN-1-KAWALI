@extends('layout.main')

@section('title', 'Kelola Penugasan Guru ke Mata Pelajaran')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Penugasan Guru</h1>
        <p class="text-gray-600 mt-1">Assign guru ke mata pelajaran dan kelas</p>
    </div>

    <!-- Pesan Sukses/Error -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-start gap-3">
            <i class="fas fa-check-circle text-emerald-600 text-xl mt-0.5 flex-shrink-0"></i>
            <div class="flex-1">
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-xl mt-0.5 flex-shrink-0"></i>
            <div class="flex-1">
                <p class="font-semibold">Gagal!</p>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Filter & Action Buttons -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('guru-mapel.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Penugasan
            </a>
            <button type="button" onclick="document.getElementById('bulkModal').classList.remove('hidden')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium flex items-center gap-2">
                <i class="fas fa-copy"></i> Bulk Assign
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Assign</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($guruMapels as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                                    <span>{{ $item->guru->nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                    {{ $item->mapel->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                    {{ $item->kelas->nama_kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm space-x-2">
                                <a href="{{ route('guru-mapel.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('guru-mapel.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus penugasan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada penugasan guru
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($guruMapels->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                {{ $guruMapels->links() }}
            </div>
        @endif
    </div>

    <!-- Bulk Assign Modal -->
    <div id="bulkModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Bulk Assign Guru ke Mapel</h3>
            
            <form action="{{ route('guru-mapel.bulk-assign') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guru</label>
                        <select name="guru_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                            <option value="">Pilih Guru</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran (Pilih Multiple)</label>
                        <div class="border border-gray-300 rounded-lg p-3 max-h-48 overflow-y-auto">
                            @foreach ($mapels as $mapel)
                                <label class="flex items-center mb-2 cursor-pointer">
                                    <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id }}" class="mr-2">
                                    <span class="text-sm">{{ $mapel->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('bulkModal').classList.add('hidden')" class="flex-1 px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Assign
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
