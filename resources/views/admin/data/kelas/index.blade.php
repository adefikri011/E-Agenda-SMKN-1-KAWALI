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
                <a href="#addModal" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">Tambah Kelas</a>

                <a href="#importModal" class="bg-red-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">Import
                    Excel</a>
            </div>
        </div>

        <!-- FILTER -->
        <form action="{{ route('kelas.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Cari kelas..." value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm">Filter</button>
                        <a href="{{ route('kelas.index') }}"
                            class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm">Reset</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                    <span>{{ $item->jurusan->jurusan ?? 'Umum' }}</span>
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
                        class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-md p-12 text-center border-2 border-dashed border-gray-300">
                        <!-- Icon -->
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                            <i class="fas fa-inbox text-5xl text-gray-400"></i>
                        </div>

                        <!-- Text -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Data Kelas</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Mulai tambahkan kelas untuk mengelola data siswa dan wali kelas dengan lebih mudah
                        </p>

                        <!-- CTA Button -->
                        <a href="#addModal"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Kelas Pertama</span>
                        </a>
                    </div>
                </div>

            @endforelse
        </div>


        <!-- PAGINATION -->
        <div class="flex justify-between mt-8">
            <div class="text-sm text-gray-700">
                Menampilkan {{ $kelas->firstItem() }} - {{ $kelas->lastItem() }} dari {{ $kelas->total() }} kelas
            </div>
            <div>{{ $kelas->links() }}</div>
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

@endsection
