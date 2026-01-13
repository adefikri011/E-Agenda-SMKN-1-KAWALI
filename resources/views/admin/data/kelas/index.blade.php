@extends('layout.main')

@section('title', 'Data Kelas')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Data Kelas</h1>
                <p class="text-gray-600 text-sm">Kelola informasi kelas sekolah</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <a href="#addModal"
                    class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 stroke-[2.5] group-hover:rotate-90 transition duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium text-sm">Tambah Kelas</span>
                </a>
                <a href="#" role="button" onclick="event.preventDefault(); toggleModal('importModal', 'open')"
                    class="group bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    <span class="font-medium text-sm">Import Excel</span>
                </a>
            </div>
        </div>

        <!-- FILTER -->
        <form id="filterForm" action="{{ route('kelas.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" placeholder="Cari kelas..."
                                value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('kelas.index') }}"
                            class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors inline-flex items-center">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Desktop Grid View (Hidden on mobile) -->
        <div class="hidden md:grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse ($kelas as $item)
                <div
                    class="group bg-white border-2 border-gray-100 rounded-2xl shadow-md hover:shadow-2xl p-6 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                    <!-- Background Gradient Accent -->
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-transparent rounded-bl-full opacity-50 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <div class="relative z-10">
                        <!-- Header Card -->
                        <div class="flex justify-between items-start mb-5">
                            <div class="flex-1">
                                <!-- Badge Jurusan -->
                                <div
                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold mb-3 shadow-sm">
                                    <i class="fas fa-bookmark"></i>
                                    <span>{{ $item->jurusan->nama_jurusan ?? 'Umum' }}</span>
                                </div>

                                <!-- Nama Kelas -->
                                <h3
                                    class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors duration-200">
                                    {{ $item->nama_kelas }}
                                </h3>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="#editModal{{ $item->id }}"
                                    class="w-9 h-9 flex items-center justify-center bg-yellow-50 text-yellow-600 rounded-xl hover:bg-yellow-100 hover:scale-110 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="#deleteModal{{ $item->id }}"
                                    class="w-9 h-9 flex items-center justify-center bg-red-50 text-red-600 rounded-xl hover:bg-red-100 hover:scale-110 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Wali Kelas Section -->
                        <div
                            class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-4 mb-4 border border-gray-100 group-hover:border-blue-200 transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <!-- Avatar Icon -->
                                <div
                                    class="w-11 h-11 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold shadow-md flex-shrink-0">
                                    <i class="fas fa-user-tie text-lg"></i>
                                </div>

                                <!-- Info Wali Kelas -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500 mb-1 font-medium">Wali Kelas</p>
                                    @if ($item->waliKelas)
                                        <p class="font-semibold text-gray-900 text-sm truncate">{{ $item->waliKelas->name }}
                                        </p>
                                    @else
                                        <p class="font-medium text-gray-400 text-sm italic">Belum Ditentukan</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Footer Card -->
                        <div class="flex justify-between items-center pt-4 border-t-2 border-gray-100">
                            <!-- Jumlah Siswa -->
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-11 h-11 bg-gradient-to-br from-green-50 to-green-100 rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-users text-green-600 text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Total Siswa</p>
                                    <p class="font-bold text-gray-900 text-lg">{{ $item->siswa->count() }}</p>
                                </div>
                            </div>

                            <!-- Button Lihat Siswa -->
                            <a href="#siswaModal{{ $item->id }}"
                                class="group/btn bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                <span>Lihat</span>
                                <i
                                    class="fas fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Glow Effect on Hover (Optional) -->
                    <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                        style="box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.1);"></div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div
                        class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-md p-8 sm:p-12 text-center border-2 border-dashed border-gray-300">
                        <!-- Icon -->
                        <div
                            class="w-16 h-16 sm:w-24 sm:h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-5 shadow-inner">
                            <i class="fas fa-inbox text-3xl sm:text-5xl text-gray-400"></i>
                        </div>

                        <!-- Text -->
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Belum Ada Data Kelas</h3>
                        <p class="text-gray-600 mb-4 sm:mb-6 max-w-md mx-auto text-sm sm:text-base">
                            Mulai tambahkan kelas untuk mengelola data siswa dan wali kelas dengan lebih mudah
                        </p>

                        <!-- CTA Button -->
                        <a href="#addModal"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-sm">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Kelas Pertama</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Mobile Card View (Hidden on desktop) -->
        <div class="md:hidden space-y-4">
            @forelse ($kelas as $item)
                <div
                    class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <!-- Badge Jurusan -->
                            <div
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-semibold mb-2">
                                <i class="fas fa-bookmark text-xs"></i>
                                <span>{{ $item->jurusan->nama_jurusan ?? 'Umum' }}</span>
                            </div>

                            <h3 class="font-bold text-gray-900 text-lg">{{ $item->nama_kelas }}</h3>
                        </div>
                        <div class="flex space-x-1">
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

                    <!-- Wali Kelas Info -->
                    <div class="bg-gray-50 rounded-lg p-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                <i class="fas fa-user-tie text-xs"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 mb-1 font-medium">Wali Kelas</p>
                                @if ($item->waliKelas)
                                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $item->waliKelas->name }}
                                    </p>
                                @else
                                    <p class="font-medium text-gray-400 text-sm italic">Belum Ditentukan</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-50 to-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Total Siswa</p>
                                <p class="font-bold text-gray-900">{{ $item->siswa->count() }}</p>
                            </div>
                        </div>

                        <a href="#siswaModal{{ $item->id }}"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                            Lihat
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-6 text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-3xl text-gray-400"></i>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Kelas</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Mulai tambahkan kelas untuk mengelola data siswa dan wali kelas dengan lebih mudah
                    </p>

                    <a href="#addModal"
                        class="w-full py-3 rounded-lg bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700 block">
                        + Tambah Kelas Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="flex flex-col sm:flex-row items-center justify-between mt-5 space-y-3 sm:space-y-0">
            <div class="text-sm text-gray-700 text-center sm:text-left">
                Menampilkan <span class="font-medium text-gray-900">{{ $kelas->firstItem() }}</span> hingga <span
                    class="font-medium text-gray-900">{{ $kelas->lastItem() }}</span> dari <span
                    class="font-medium text-gray-900">{{ $kelas->total() }}</span>
                kelas
            </div>
            <div class="flex space-x-1">
                {{-- Previous Page Link --}}
                @if ($kelas->onFirstPage())
                    <button disabled
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                @else
                    <a href="{{ $kelas->previousPageUrl() }}"
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                @endif

                {{-- Pagination Numbers --}}
                @foreach ($kelas->links()->elements[0] as $page => $url)
                    @if ($page == $kelas->currentPage())
                        <button
                            class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium text-sm">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($kelas->hasMorePages())
                    <a href="{{ $kelas->nextPageUrl() }}"
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

    <!-- ===========================
                                  MODAL LIHAT SISWA (FINAL)
                            ============================ -->
    @foreach ($kelas as $item)
        <div id="siswaModal{{ $item->id }}" class="modal">
            <div class="modal-content">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Siswa Kelas {{ $item->nama_kelas }}</h3>
                    <a href="#">
                        <i class="fas fa-times text-xl text-gray-500"></i>
                    </a>
                </div>

                <div class="space-y-3 max-h-[60vh] overflow-y-auto">
                    @forelse ($item->siswa as $siswa)
                        <div class="border p-3 rounded-lg bg-white">
                            <p class="font-medium text-sm">{{ $siswa->nama_siswa }}</p>
                            <p class="text-xs text-gray-500">NIS: {{ $siswa->nis }}</p>
                        </div>
                    @empty
                        <p class="text-center py-6 text-gray-500">Belum ada siswa</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach

    @include('admin.data.kelas.create')
    @include('admin.data.kelas.edit')
    @include('admin.data.kelas.delete')
    @include('admin.data.kelas.import')

    <!-- MODAL CSS -->
    <style>
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal:target {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 1.5rem;
            border-radius: .75rem;
            width: 100%;
            max-width: 28rem;
        }

        /* Card Animation on Load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Apply animation to cards */
        .grid>div:not(.col-span-full) {
            animation: fadeInUp 0.5s ease-out backwards;
        }

        /* Stagger animation delay */
        .grid>div:nth-child(1) {
            animation-delay: 0.1s;
        }

        .grid>div:nth-child(2) {
            animation-delay: 0.2s;
        }

        .grid>div:nth-child(3) {
            animation-delay: 0.3s;
        }

        .grid>div:nth-child(4) {
            animation-delay: 0.4s;
        }

        .grid>div:nth-child(5) {
            animation-delay: 0.5s;
        }

        .grid>div:nth-child(6) {
            animation-delay: 0.6s;
        }

        /* Smooth transitions for all interactive elements */
        .group {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom scrollbar if needed */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3b82f6, #2563eb);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #2563eb, #1d4ed8);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto submit form saat input search berubah (dengan debounce)
                let searchTimeout;
                const searchInput = document.getElementById('searchInput');
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
            });
        </script>
    @endpush
@endsection
