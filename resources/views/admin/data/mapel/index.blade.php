@extends('layout.main')

@section('title', 'Data Mata Pelajaran')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Data Mata Pelajaran</h1>
                <p class="text-gray-600 text-sm">Kelola informasi mata pelajaran sekolah dengan efisien</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <a href="#addModal"
                    class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 stroke-[2.5] group-hover:rotate-90 transition duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium text-sm">Tambah Mapel</span>
                </a>
                <button type="button" onclick="document.getElementById('importModalMapel').classList.remove('hidden')"
                    class="group bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95 cursor-pointer border-0 outline-none">

                    <!-- Ikon Upload -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>

                    <!-- Teks -->
                    <span class="font-medium text-sm">Import Excel</span>
                </button>
            </div>
        </div>
        <form id="filterForm" action="{{ route('mapel.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput"
                                placeholder="Cari mata pelajaran berdasarkan nama atau kode..."
                                value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-48">
                        <select name="tingkat" id="tingkatFilter"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="">Semua Tingkat</option>
                            @foreach ($tingkatList as $tingkat)
                                <option value="{{ $tingkat }}" {{ request('tingkat') == $tingkat ? 'selected' : '' }}>
                                    {{ $tingkat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors inline-flex items-center">
                        <i class="fas fa-filter mr-1"></i> Cari
                    </button>
                    <a href="{{ route('mapel.index') }}"
                        class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors inline-flex items-center">
                        <i class="fas fa-redo mr-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Desktop Table (Hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th
                            class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-lg">
                            No</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                            Mata Pelajaran</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode
                        </th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tingkat
                        </th>
                        <th
                            class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-lg">
                            Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse ($mapel as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $mapel->firstItem() + $loop->index }}
                            </td>
                            <td class="py-3 px-5 text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $item->kode }}</td>
                            <td class="py-3 px-5 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-medium">
                                    {{ $item->tingkat ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3 px-5 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="#editModal{{ $item->id }}"
                                        class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200 p-1.5 rounded-full hover:bg-yellow-50"
                                        title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <a href="#deleteModal{{ $item->id }}"
                                        class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1.5 rounded-full hover:bg-red-50"
                                        title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="mx-auto mb-4 w-20 h-20 text-gray-300" fill="none" viewBox="0 0 64 64"
                                        stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <rect x="12" y="8" width="40" height="48" rx="3" stroke-width="2" />
                                        <path d="M24 20h16M24 28h16M24 36h12" stroke-width="2" />
                                        <path d="M36 44H28" stroke-width="2" />
                                    </svg>

                                    <h3 class="mt-2 text-lg font-semibold text-gray-800">Belum ada data mata pelajaran</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada mata pelajaran yang ditambahkan.
                                        Tambahkan data mata pelajaran
                                        agar dapat dikelola di sini.</p>

                                    <div class="mt-4 flex items-center justify-center space-x-3">
                                        <a href="#addModal"
                                            class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700">
                                            + Tambah Mapel
                                        </a>
                                        <a href="{{ url()->current() }}"
                                            class="inline-flex items-center px-4 py-2 rounded-md border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                            Segarkan
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (Hidden on desktop) -->
        <div class="md:hidden space-y-4">
            @forelse ($mapel as $item)
                <div
                    class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $item->nama }}</h3>
                            <div class="flex items-center mt-1">
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full mr-2">
                                    {{ $item->tingkat ?? '-' }}
                                </span>
                                <span class="font-mono text-sm text-gray-600">Kode: {{ $item->kode }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <a href="{{ route('mapel.show', $item->id) }}"
                                class="text-blue-600 hover:text-blue-800 p-2 rounded-full hover:bg-blue-50 transition-colors">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="#editModal{{ $item->id }}"
                                class="text-yellow-600 hover:text-yellow-800 p-2 rounded-full hover:bg-yellow-50 transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <a href="#deleteModal{{ $item->id }}"
                                class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <div class="text-gray-500 font-medium mb-1">Kode Mapel</div>
                            <div class="font-mono text-gray-900 bg-gray-50 p-2 rounded">{{ $item->kode }}</div>
                        </div>
                        <div>
                            <div class="text-gray-500 font-medium mb-1">No. Urut</div>
                            <div class="font-mono text-gray-900 bg-gray-50 p-2 rounded">
                                {{ $mapel->firstItem() + $loop->index }}</div>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="text-gray-500 text-xs flex justify-between items-center">
                            <span>ID: {{ $item->id }}</span>
                            <span><i class="fas fa-calendar-alt mr-1"></i>
                                {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-6 text-center">
                    <svg class="mx-auto mb-4 w-16 h-16 text-gray-300" fill="none" viewBox="0 0 64 64"
                        stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <rect x="12" y="8" width="40" height="48" rx="3" stroke-width="2" />
                        <path d="M24 20h16M24 28h16M24 36h12" stroke-width="2" />
                        <path d="M36 44H28" stroke-width="2" />
                    </svg>

                    <h3 class="mt-2 text-lg font-semibold text-gray-800">Belum ada data mata pelajaran</h3>
                    <p class="mt-1 text-sm text-gray-500 mb-4">Belum ada mata pelajaran yang ditambahkan. Tambahkan data
                        mata pelajaran
                        agar dapat dikelola di sini.</p>

                    <div class="flex flex-col space-y-2">
                        <a href="#addModal"
                            class="w-full py-3 rounded-md bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700">
                            + Tambah Mapel
                        </a>
                        <a href="{{ url()->current() }}"
                            class="w-full py-3 rounded-md border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                            Segarkan
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between mt-5 space-y-3 sm:space-y-0">
            <div class="text-sm text-gray-700 text-center sm:text-left">
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
            const kelompokFilter = document.getElementById('tingkatFilter');
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

            // Submit form saat filter tingkat berubah
            kelompokFilter.addEventListener('change', function() {
                submitForm();
            });
        });
    </script>
@endpush
