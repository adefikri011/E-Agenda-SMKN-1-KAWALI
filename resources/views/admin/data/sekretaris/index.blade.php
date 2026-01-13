@extends('layout.main')

@section('title', 'Data Sekretaris')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-5 mb-6">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Data Sekretaris</h1>
                <p class="text-gray-600 text-sm">Kelola data petugas sekretaris kelas</p>
            </div>

            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <a href="#addModal" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium">
                    Tambah Sekretaris
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <form id="filterForm" action="{{ route('sekretaris.index') }}" method="GET">
            <div class="bg-gray-50 rounded-lg p-3 mb-5">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" id="searchInput"
                                placeholder="Cari sekretaris berdasarkan nama atau NIS..." value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-48">
                        <select name="kelas_id" id="kelasFilter"
                            class="select2 w-full px-3 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">

                            @if ($kelas->count() > 0)
                                <option value="">Semua Kelas</option>

                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('kelas_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_kelas }}
                                    </option>
                                @endforeach
                            @else
                                <option disabled selected>Belum ada kelas</option>
                            @endif

                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('sekretaris.index') }}" id="resetFilter"
                            class="px-4 py-2.5 bg-gray-500 text-white rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors inline-flex items-center">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- GRID DATA SEKRETARIS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($sekretaris as $item)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md p-5 transition">

                    <div class="flex justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                            <p class="text-sm text-gray-600">Email: {{ $item->email }}</p>
                            <p class="text-sm text-gray-600">NIS: {{ $item->siswa->nis ?? '-' }}</p>
                        </div>

                        <div class="flex gap-2">
                            <a href="#editModal{{ $item->id }}" class="text-yellow-600">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="#deleteModal{{ $item->id }}" class="text-red-600">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600">
                        <p>Kelas: {{ $item->siswa->kelas->nama_kelas ?? '-' }}</p>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <h3 class="text-lg font-semibold">Belum ada data sekretaris</h3>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="flex justify-between mt-8">
            <div class="text-sm text-gray-700">
                Menampilkan {{ $sekretaris->firstItem() }} - {{ $sekretaris->lastItem() }}
                dari {{ $sekretaris->total() }} sekretaris
            </div>

            <div>{{ $sekretaris->links() }}</div>
        </div>
    </div>

    <!-- MODAL -->
    @include('admin.data.sekretaris.create')
    @include('admin.data.sekretaris.edit')
    @include('admin.data.sekretaris.delete')
    @include('admin.data.sekretaris.import')

    <!-- MODAL CSS FIX -->
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
        .modal:target { display: flex; }
        .modal-content {
            background: white;
            padding: 1.5rem;
            border-radius: .75rem;
            width: 100%;
            max-width: 28rem;
        }
    </style>

    <script>
        // Handle modal close buttons
        document.querySelectorAll('.modal-close').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                // Get parent modal and close it
                const modal = this.closest('.modal');
                if (modal) {
                    history.back(); // Go back in history to remove the hash
                }
            });
        });
    </script>

@endsection
