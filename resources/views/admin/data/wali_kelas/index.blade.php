@extends('layout.main')

@section('title', 'Data Wali Kelas')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-5 mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Data Wali Kelas</h1>
                <p class="text-gray-600 text-sm">Kelola penugasan wali kelas di setiap kelas</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <!-- Tombol untuk membuka modal Tambah -->
                <a href="#addModal" class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-[2.5] group-hover:rotate-90 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium text-sm">Tugaskan Wali Kelas</span>
                </a>
                <!-- Tombol untuk membuka modal Import -->
                <a href="#importModal" class="group bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                    </svg>
                    <span class="font-medium text-sm">Import Excel</span>
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <form id="filterForm" action="{{ route('wali_kelas.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" placeholder="Cari wali kelas berdasarkan nama atau NIP..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Cari
                        </button>
                        <a href="{{ route('wali_kelas.index') }}" class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors inline-flex items-center">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-lg">No</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIP</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Wali Kelas</th>
                        <th class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($waliKelas as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $waliKelas->firstItem() + $loop->index }}</td>
                            <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $item->guru->nip }}</td>
                            <td class="py-3 px-5 text-sm font-medium text-gray-900">{{ $item->guru->nama }}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{ $item->email }}</td>
                            <td class="py-3 px-5 text-sm text-gray-900 font-medium">{{ $item->kelasAsWali->nama_kelas }}</td>
                            <td class="py-3 px-5 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <a href="#editModal{{ $item->id }}" class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    
                                    <!-- Tombol Delete (Final) -->
                                    <form action="{{ route('wali_kelas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mencabut penugasan wali kelas ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-200">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-600">
                                Belum ada data wali kelas yang ditugaskan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-5">
            <div class="text-sm text-gray-700">
                Menampilkan <span class="font-medium text-gray-900">{{ $waliKelas->firstItem() }}</span> hingga <span class="font-medium text-gray-900">{{ $waliKelas->lastItem() }}</span> dari <span class="font-medium text-gray-900">{{ $waliKelas->total() }}</span> wali kelas
            </div>
            {{ $waliKelas->links() }}
        </div>
    </div>

    {{-- 
        PEMANGGILAN MODAL
        - Modal Tambah & Import dipanggil sekali di luar loop
        - Modal Edit dipanggil di dalam loop
        - Modal Delete tidak lagi dipanggil karena aksi hapus pindah ke dalam tabel
    --}}
    @include('admin.data.wali_kelas.create')
    @include('admin.data.wali_kelas.import')

    @foreach ($waliKelas as $item)
        @include('admin.data.wali_kelas.edit', ['item' => $item])
    @endforeach

    <style>
        .modal {
            display: none; 
            position: fixed; 
            z-index: 50; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.5);
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
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let searchTimeout;
                const searchInput = document.getElementById('searchInput');
                const filterForm = document.getElementById('filterForm');

                function submitForm() {
                    filterForm.submit();
                }

                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(submitForm, 500);
                });
            });
        </script>
    @endpush
@endsection