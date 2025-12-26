@extends('layout.main')

@section('title', 'Kelola Penugasan Guru ke Mata Pelajaran')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Kelola Penugasan Guru</h1>
                <p class="text-gray-600 text-sm">Assign guru ke mata pelajaran dan kelas</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <!-- Tombol Tambah Penugasan -->
                <a href="{{ route('guru-mapel.create') }}"
                   class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 stroke-[2.5] group-hover:rotate-90 transition duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium text-sm">Tambah Penugasan</span>
                </a>
                <!-- Tombol Bulk Assign -->
                <button type="button" onclick="document.getElementById('bulkModal').classList.remove('hidden')"
                        class="group bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <i class="fas fa-copy text-sm"></i>
                    <span class="font-medium text-sm">Bulk Assign</span>
                </button>
            </div>
        </div>

        <!-- Filter Section (jika diperlukan) -->
        <form id="filterForm" action="{{ route('guru-mapel.index') }}" method="GET" class="mb-5">
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput"
                                   placeholder="Cari berdasarkan nama guru atau mapel..."
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors inline-flex items-center">
                            <i class="fas fa-filter mr-1"></i> Cari
                        </button>
                        <a href="{{ route('guru-mapel.index') }}"
                           class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors inline-flex items-center">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Desktop Table (Hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-lg">No</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Guru</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Assign</th>
                        <th class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($guruMapels as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-3 px-5 font-mono text-sm text-gray-900">{{ $guruMapels->firstItem() + $loop->index }}</td>
                            <td class="py-3 px-5 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                        <i class="fas fa-chalkboard-teacher text-xs"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $item->guru->nama }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-5 text-sm">
                                <span class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-book text-xs"></i>
                                    {{ $item->mapel->nama }}
                                </span>
                            </td>
                            <td class="py-3 px-5 text-sm">
                                <span class="inline-flex items-center gap-1 bg-gradient-to-r from-green-50 to-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-chalkboard text-xs"></i>
                                    {{ $item->kelas->nama_kelas }}
                                </span>
                            </td>
                            <td class="py-3 px-5 text-sm text-gray-600">
                                <span class="font-medium">{{ $item->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-3 px-5 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('guru-mapel.edit', $item->id) }}"
                                       class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200 p-1.5 rounded-full hover:bg-yellow-50">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('guru-mapel.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus penugasan ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1.5 rounded-full hover:bg-red-50">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12">
                                <div class="text-center">
                                    <svg class="mx-auto mb-4 w-20 h-20 text-gray-300" fill="none" viewBox="0 0 64 64"
                                        stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M32 28c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12z"
                                              stroke-width="2" fill="none"/>
                                        <path d="M40 24c0-4.418-3.582-8-8-8s-8 3.582-8 8M32 16v8M22 26l4-4M42 26l-4-4"
                                              stroke-width="2"/>
                                        <path d="M28 40l-4 4M40 40l4 4M44 40l-4 4M24 44l4-4" stroke-width="2"/>
                                        <path d="M28 48h8" stroke-width="2"/>
                                    </svg>

                                    <h3 class="mt-2 text-lg font-semibold text-gray-800">Belum ada penugasan guru</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada penugasan guru ke mata pelajaran. Tambahkan penugasan untuk mengelola pengajaran.</p>

                                    <div class="mt-4 flex items-center justify-center space-x-3">
                                        <a href="{{ route('guru-mapel.create') }}"
                                            class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700">
                                            + Tambah Penugasan
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
            @forelse ($guruMapels as $item)
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <i class="fas fa-chalkboard-teacher text-xs"></i>
                                </div>
                                <h3 class="font-bold text-gray-900 text-sm">{{ $item->guru->nama }}</h3>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center gap-1">
                                    <span class="bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                        <i class="fas fa-book mr-1 text-xs"></i>{{ $item->mapel->nama }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="bg-gradient-to-r from-green-50 to-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                        <i class="fas fa-chalkboard mr-1 text-xs"></i>{{ $item->kelas->nama_kelas }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <a href="{{ route('guru-mapel.edit', $item->id) }}"
                               class="text-yellow-600 hover:text-yellow-800 p-2 rounded-full hover:bg-yellow-50 transition-colors">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('guru-mapel.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus penugasan ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition-colors">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm mt-3">
                        <div>
                            <div class="text-gray-500 font-medium mb-1">No. Urut</div>
                            <div class="font-mono text-gray-900 bg-gray-50 p-2 rounded">{{ $guruMapels->firstItem() + $loop->index }}</div>
                        </div>
                        <div>
                            <div class="text-gray-500 font-medium mb-1">Tanggal</div>
                            <div class="text-gray-900 bg-gray-50 p-2 rounded font-medium">{{ $item->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="text-gray-500 text-xs">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Ditugaskan: {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border border-gray-200 p-6 text-center">
                    <svg class="mx-auto mb-4 w-16 h-16 text-gray-300" fill="none" viewBox="0 0 64 64"
                        stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 28c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12z"
                              stroke-width="2" fill="none"/>
                        <path d="M40 24c0-4.418-3.582-8-8-8s-8 3.582-8 8M32 16v8M22 26l4-4M42 26l-4-4"
                              stroke-width="2"/>
                        <path d="M28 40l-4 4M40 40l4 4M44 40l-4 4M24 44l4-4" stroke-width="2"/>
                        <path d="M28 48h8" stroke-width="2"/>
                    </svg>

                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada penugasan guru</h3>
                    <p class="text-gray-600 text-sm mb-4">Belum ada penugasan guru ke mata pelajaran. Tambahkan penugasan untuk mengelola pengajaran.</p>

                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('guru-mapel.create') }}"
                            class="w-full py-3 rounded-lg bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700">
                            + Tambah Penugasan
                        </a>
                        <a href="{{ url()->current() }}"
                            class="w-full py-3 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                            Segarkan
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between mt-5 space-y-3 sm:space-y-0">
            <div class="text-sm text-gray-700 text-center sm:text-left">
                Menampilkan <span class="font-medium text-gray-900">{{ $guruMapels->firstItem() }}</span> hingga <span class="font-medium text-gray-900">{{ $guruMapels->lastItem() }}</span> dari <span class="font-medium text-gray-900">{{ $guruMapels->total() }}</span> penugasan
            </div>
            <div class="flex space-x-1">
                {{-- Previous Page Link --}}
                @if ($guruMapels->onFirstPage())
                    <button disabled
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-400 cursor-not-allowed text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                @else
                    <a href="{{ $guruMapels->previousPageUrl() }}"
                        class="px-2.5 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </a>
                @endif

                {{-- Pagination Numbers --}}
                @foreach ($guruMapels->links()->elements[0] as $page => $url)
                    @if ($page == $guruMapels->currentPage())
                        <button
                            class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-medium text-sm">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-sm">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($guruMapels->hasMorePages())
                    <a href="{{ $guruMapels->nextPageUrl() }}"
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

    <!-- Bulk Assign Modal -->
    <div id="bulkModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Bulk Assign Guru ke Mapel</h3>
                <button type="button" onclick="document.getElementById('bulkModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('guru-mapel.bulk-assign') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guru</label>
                        <select name="guru_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm" required>
                            <option value="">Pilih Guru</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran (Pilih Multiple)</label>
                        <div class="border border-gray-300 rounded-lg p-3 max-h-48 overflow-y-auto bg-gray-50">
                            @foreach ($mapels as $mapel)
                                <label class="flex items-center mb-2 cursor-pointer hover:bg-gray-100 p-2 rounded">
                                    <input type="checkbox" name="mapel_ids[]" value="{{ $mapel->id }}" class="mr-2 rounded">
                                    <span class="text-sm text-gray-700">{{ $mapel->nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('bulkModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition-colors text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition-colors text-sm font-medium">
                        Assign
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modal styles */
        #bulkModal {
            backdrop-filter: blur(4px);
        }
        #bulkModal > div {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(submitForm, 500);
                    });
                }

                // Close modal dengan ESC key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        document.getElementById('bulkModal').classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
@endsection
