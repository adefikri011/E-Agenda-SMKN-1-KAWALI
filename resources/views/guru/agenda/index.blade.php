@extends('layout.main')

@section('title', 'Agenda')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Agenda</h1>
        <p class="text-gray-600 mt-1">Kelola agenda pembelajaran harian</p>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('agenda.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Buat Agenda Baru
        </a>

        @if (auth()->user()->hasRole('guru'))
            <a href="{{ route('agenda.need-signature') }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg font-medium hover:bg-yellow-600 transition-colors">
                <i class="fas fa-signature mr-2"></i> Agenda Menunggu TTD
            </a>
        @endif

        <a href="{{ route('agenda.rekap') }}"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors">
            <i class="fas fa-chart-bar mr-2"></i> Rekap Agenda
        </a>
    </div>

    <!-- Tabel Agenda -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jam
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mata Pelajaran
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pembuat
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status TTD
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($agendas as $agenda)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $agenda->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $agenda->startJampel?->nama_jam ?? 'Jam -' }} s/d {{ $agenda->endJampel?->nama_jam ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $agenda->kelas->nama_kelas }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $agenda->mata_pelajaran }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $agenda->user->name }}
                                @if ($agenda->pembuat === 'guru')
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Guru
                                    </span>
                                @else
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Siswa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($agenda->status_ttd)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Sudah
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Belum
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('agenda.show', $agenda->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3" title="Lihat Lengkap">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <a href="{{ route('agenda.edit', $agenda->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if (!$agenda->status_ttd && in_array(auth()->user()->role , ['guru' , 'walikelas']))
                                    <a href="{{ route('agenda.sign-form', $agenda->id) }}"
                                        class="text-green-600 hover:text-green-900 mr-3" title="Tanda Tangan">
                                        <i class="fas fa-signature"></i>
                                    </a>
                                @endif
                                <form action="{{ route('agenda.destroy', $agenda->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data agenda
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($agendas->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                {{ $agendas->links() }}
            </div>
        @endif
    </div>

    @include('guru.agenda.detail')
@endsection
