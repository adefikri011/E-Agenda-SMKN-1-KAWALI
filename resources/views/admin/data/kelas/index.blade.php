@extends('layout.main')

@section('title', 'Data Kelas')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-5 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Data Kelas</h1>
                <p class="text-gray-600 text-sm">Kelola informasi kelas sekolah</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <a href="#addModal"
                    class="group bg-gradient-to-r from-blue-600 to-indigo-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2">
                    <span class="font-medium text-sm">Tambah Kelas</span>
                </a>
                <a href="#importModal"
                    class="group bg-gradient-to-r from-red-600 to-red-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2">
                    <span class="font-medium text-sm">Import Excel</span>
                </a>
            </div>
        </div>

        <form id="filterForm" action="{{ route('kelas.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" placeholder="Cari kelas..."
                                value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm">Filter</button>
                        <a href="{{ route('kelas.index') }}" id="resetFilter"
                            class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm">Reset</a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Grid Kelas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($kelas as $item)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $item->nama_kelas }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $item->jurusan->jurusan ?? '-' }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#editModal{{ $item->id }}" class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#deleteModal{{ $item->id }}" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Wali Kelas:</p>
                            <p class="font-medium">{{ $item->waliKelas->name ?? '-' }}</p>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $item->siswa->count() }} siswa</span>
                            <button onclick="openSiswaModal({{ $item->id }})"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Lihat Siswa
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <h3 class="text-lg font-semibold text-gray-900">Belum ada data kelas</h3>
                    <p class="text-gray-600 mt-1">Silakan tambahkan kelas terlebih dahulu</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-8">
            <div class="text-sm text-gray-700">
                Menampilkan <span class="font-medium">{{ $kelas->firstItem() }}</span> hingga <span
                    class="font-medium">{{ $kelas->lastItem() }}</span> dari <span class="font-medium">{{ $kelas->total() }}</span>
                kelas
            </div>
            <div>
                {{ $kelas->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Siswa untuk setiap kelas -->
    @foreach ($kelas as $item)
        <div id="siswaModal{{ $item->id }}" class="modal">
            <div class="modal-content max-w-4xl w-full">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Siswa Kelas {{ $item->nama_kelas }}</h3>
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </a>
                </div>

                <div class="relative">
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <div class="flex transition-transform duration-500 ease-in-out" id="siswaCarousel{{ $item->id }}">
                            @forelse ($item->siswa->chunk(8) as $chunk)
                                <div class="w-full flex-shrink-0">
                                    <div class="p-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach ($chunk as $siswa)
                                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                                                <span class="text-blue-600 font-medium">{{ strtoupper(substr($siswa->nama, 0, 1)) }}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">{{ $siswa->nama }}</p>
                                                            <p class="text-xs text-gray-500">NIS: {{ $siswa->nis }}</p>
                                                            <p class="text-xs text-gray-500">{{ $siswa->jenkel == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="w-full flex-shrink-0">
                                    <div class="px-6 py-12 text-center">
                                        <p class="text-gray-500">Belum ada siswa di kelas ini</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Carousel Navigation -->
                    @if($item->siswa->count() > 8)
                        <button onclick="prevSlide({{ $item->id }})" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md ml-2">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                        </button>
                        <button onclick="nextSlide({{ $item->id }})" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white rounded-full p-2 shadow-md mr-2">
                            <i class="fas fa-chevron-right text-gray-600"></i>
                        </button>
                    @endif

                    <!-- Carousel Indicators -->
                    @if($item->siswa->count() > 8)
                        <div class="flex justify-center mt-4 space-x-2">
                            @for ($i = 0; $i < ceil($item->siswa->count() / 8); $i++)
                                <button onclick="goToSlide({{ $item->id }}, {{ $i }})" class="w-3 h-3 rounded-full bg-gray-300 indicator{{ $item->id }} {{ $i == 0 ? 'bg-blue-500' : '' }}" data-slide="{{ $i }}"></button>
                            @endfor
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    @include('admin.data.kelas.create')
    @include('admin.data.kelas.edit')
    @include('admin.data.kelas.delete')
    @include('admin.data.kelas.import')

    <style>
        .modal { display: none; position: fixed; z-index: 50; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items:center; justify-content:center; }
        .modal:target { display:flex; }
        .modal-content { background-color: white; border-radius: .5rem; padding: 1.25rem; width:100%; max-width:28rem; }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let searchTimeout;
                const searchInput = document.getElementById('searchInput');
                const filterForm = document.getElementById('filterForm');

                // Search functionality
                function submitForm() {
                    filterForm.submit();
                }

                searchInput?.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(submitForm, 500);
                });
            });

            // Function to open siswa modal
            function openSiswaModal(kelasId) {
                document.getElementById(`siswaModal${kelasId}`).style.display = 'flex';
                // Reset carousel position
                document.getElementById(`siswaCarousel${kelasId}`).style.transform = 'translateX(0)';

                // Reset indicators
                const indicators = document.querySelectorAll(`.indicator${kelasId}`);
                indicators.forEach((indicator, index) => {
                    if (index === 0) {
                        indicator.classList.remove('bg-gray-300');
                        indicator.classList.add('bg-blue-500');
                    } else {
                        indicator.classList.remove('bg-blue-500');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }

            // Carousel functions
            function prevSlide(kelasId) {
                const carousel = document.getElementById(`siswaCarousel${kelasId}`);
                const indicators = document.querySelectorAll(`.indicator${kelasId}`);
                const totalSlides = carousel.children.length;
                let currentSlide = getCurrentSlide(carousel);

                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateCarousel(carousel, indicators, currentSlide);
            }

            function nextSlide(kelasId) {
                const carousel = document.getElementById(`siswaCarousel${kelasId}`);
                const indicators = document.querySelectorAll(`.indicator${kelasId}`);
                const totalSlides = carousel.children.length;
                let currentSlide = getCurrentSlide(carousel);

                currentSlide = (currentSlide + 1) % totalSlides;
                updateCarousel(carousel, indicators, currentSlide);
            }

            function goToSlide(kelasId, slideIndex) {
                const carousel = document.getElementById(`siswaCarousel${kelasId}`);
                const indicators = document.querySelectorAll(`.indicator${kelasId}`);
                updateCarousel(carousel, indicators, slideIndex);
            }

            function getCurrentSlide(carousel) {
                const transform = window.getComputedStyle(carousel).transform;
                if (transform === 'none') return 0;

                const matrix = new DOMMatrix(transform);
                const translateX = matrix.m41;
                const slideWidth = carousel.offsetWidth;
                return Math.abs(Math.round(translateX / slideWidth));
            }

            function updateCarousel(carousel, indicators, slideIndex) {
                carousel.style.transform = `translateX(-${slideIndex * 100}%)`;

                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === slideIndex) {
                        indicator.classList.remove('bg-gray-300');
                        indicator.classList.add('bg-blue-500');
                    } else {
                        indicator.classList.remove('bg-blue-500');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }
        </script>
    @endpush

@endsection
