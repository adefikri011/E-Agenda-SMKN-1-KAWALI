@extends('layout.main')

@section('title', 'Data Mata Pelajaran')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-5 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Data Mata Pelajaran</h1>
                <p class="text-gray-600 text-sm">Kelola informasi mata pelajaran sekolah dengan efisien</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <a href="#addModal"
                    class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 stroke-[2.5] group-hover:rotate-90 transition duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium text-sm">Tambah Mata Pelajaran</span>
                </a>
                <a href="#importModal"
                    class="group bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    <span class="font-medium text-sm">Import Excel</span>
                </a>
            </div>
        </div>
        <form id="filterForm" action="{{ route('mapel.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput"
                                placeholder="Cari mata pelajaran berdasarkan nama atau kode..." value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-48">
                        <select name="kelompok" id="kelompokFilter"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">Semua Kelompok</option>
                            @foreach($kelompokList as $kelompok)
                                <option value="{{ $kelompok }}" {{ request('kelompok') == $kelompok ? 'selected' : '' }}>
                                    {{ $kelompok }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        <i class="fas fa-filter mr-1"></i> Cari
                    </button>
                    <a href="{{ route('mapel.index') }}"
                        class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- TABEL --}}
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase">Nama Mata Pelajaran</th>
                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase">Kode</th>
                    <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase">Kelompok</th>
                    <th class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($mapel as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-5 text-sm">
                            {{ $mapel->firstItem() + $loop->index }}
                        </td>
                        <td class="py-3 px-5 text-sm font-medium text-gray-900">
                            {{ $item->nama }}
                        </td>
                        <td class="py-3 px-5 text-sm font-mono text-gray-900">
                            {{ $item->kode }}
                        </td>
                        <td class="py-3 px-5 text-sm">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ $item->kelompok }}
                            </span>
                        </td>
                        <td class="py-3 px-5 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('mapel.show', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Detail">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="#editModal{{ $item->id }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="#deleteModal{{ $item->id }}" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-600">
                            Belum ada data mata pelajaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-5">
            <div class="text-sm text-gray-700">
                Menampilkan <span class="font-medium text-gray-900">{{ $mapel->firstItem() }}</span> hingga <span
                    class="font-medium text-gray-900">{{ $mapel->lastItem() }}</span> dari <span
                    class="font-medium text-gray-900">{{ $mapel->total() }}</span>
                mata pelajaran
            </div>
            <div class="flex space-x-1">
                {{-- Previous Page Link --}}
                @if ($mapel->onFirstPage())
                    <button disabled
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                @else
                    <a href="{{ $mapel->previousPageUrl() }}"
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                @endif

                {{-- Pagination Numbers --}}
                @foreach ($mapel->links()->elements[0] as $page => $url)
                    @if ($page == $mapel->currentPage())
                        <button
                            class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium text-sm">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($mapel->hasMorePages())
                    <a href="{{ $mapel->nextPageUrl() }}"
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                @else
                    <button disabled
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed text-sm">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @include('admin.data.mapel.create')
    @include('admin.data.mapel.edit')
    @include('admin.data.mapel.delete')
    @include('admin.data.mapel.import')

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal:target {
            display: flex;
        }

        .modal-content {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.25rem;
            width: 100%;
            max-width: 28rem;
            transform: scale(0.95);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal:target .modal-content {
            transform: scale(1);
            opacity: 1;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto submit form saat input search berubah (dengan debounce)
            let searchTimeout;
            const searchInput = document.getElementById('searchInput');
            const kelompokFilter = document.getElementById('kelompokFilter');
            const filterForm = document.getElementById('filterForm');

            // Fungsi untuk submit form
            function submitForm() {
                filterForm.submit();
            }

            // Debounce untuk search input (500ms delay)
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(submitForm, 500);
            });

            // Submit form saat filter kelompok berubah
            kelompokFilter.addEventListener('change', function() {
                submitForm();
            });
        });
    </script>
@endpush
