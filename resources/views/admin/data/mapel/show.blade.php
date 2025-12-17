@extends('layout.main')

@section('title', 'Detail Mata Pelajaran')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-5 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Detail Mata Pelajaran</h1>
                <p class="text-gray-600 text-sm">Informasi lengkap mata pelajaran dan penugasan guru</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <a href="{{ route('mapel.index') }}"
                    class="group bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="font-medium text-sm">Kembali</span>
                </a>
                <a href="#editModal{{ $mapel->id }}"
                    class="group bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span class="font-medium text-sm">Edit</span>
                </a>
                <a href="#assignModal"
                    class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="font-medium text-sm">Assign Guru</span>
                </a>
            </div>
        </div>

        <!-- Detail Mata Pelajaran -->
        <div class="bg-gray-50 rounded-lg p-5 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Mata Pelajaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Mata Pelajaran</p>
                    <p class="text-base font-medium text-gray-900">{{ $mapel->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kode</p>
                    <p class="text-base font-medium text-gray-900">{{ $mapel->kode }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelompok</p>
                    <span class="inline-block px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                        {{ $mapel->kelompok }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jumlah Guru</p>
                    <p class="text-base font-medium text-gray-900">{{ $mapel->gurus->count() }} guru</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('guru')" id="guru-tab" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                    Guru Pengajar
                </button>
                <button onclick="showTab('kelas')" id="kelas-tab" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Kelas
                </button>
                <button onclick="showTab('agenda')" id="agenda-tab" class="tab-button py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Agenda
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div id="guru-content" class="tab-content">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($mapel->gurus as $guru)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $guru->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $guru->nip ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $guru->pivot->kelas_id ? \App\Models\Kelas::find($guru->pivot->kelas_id)->nama_kelas : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada guru yang ditugaskan untuk mata pelajaran ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="kelas-content" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Pengajar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($mapel->kelas as $kelas)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kelas->nama_kelas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $kelas->pivot->guru_id ? \App\Models\Guru::find($kelas->pivot->guru_id)->nama : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Mata pelajaran ini belum ditugaskan ke kelas mana pun.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="agenda-content" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($mapel->agendas as $agenda)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $agenda->tanggal }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $agenda->materi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $agenda->kelas }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $agenda->status == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $agenda->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada agenda untuk mata pelajaran ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.data.mapel.edit')
    @include('admin.data.mapel.assign')

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
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active styling from all tabs
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');

            // Add active styling to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-blue-500', 'text-blue-600');
        }
    </script>
@endpush
