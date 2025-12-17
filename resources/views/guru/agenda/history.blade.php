<!-- Agenda History Section -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Agenda</h2>

        @if($agendas->count() > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach($agendas as $agenda)
                    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                        {{ $agenda->kelas->nama_kelas }}
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $agenda->mata_pelajaran }}</h3>
                                <p class="text-sm text-gray-600 mb-3">
                                    <i class="fas fa-clock mr-1 text-blue-600"></i>
                                    {{ $agenda->jampel->nama_jam ?? '-' }} ({{ $agenda->jampel->rentang_waktu ?? '-' }})
                                </p>
                                <div class="text-sm text-gray-700">
                                    <p class="font-semibold mb-1">Materi:</p>
                                    <p>{{ $agenda->materi }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                @if($agenda->tanda_tangan)
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 mb-2">TTD Digital</p>
                                        <img src="{{ $agenda->tanda_tangan }}" alt="Tanda Tangan" class="w-24 h-16 border border-gray-300 rounded bg-white">
                                        <p class="text-xs text-emerald-600 mt-1">
                                            <i class="fas fa-check-circle"></i> TTD Tersimpan
                                        </p>
                                    </div>
                                @endif
                                <a href="#detailModal{{ $agenda->id }}" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-eye mr-1"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-2xl text-gray-400"></i>
                </div>
                <p class="text-gray-600 font-medium">Belum ada agenda yang disimpan</p>
                <p class="text-gray-500 text-sm mt-1">Mulai isi agenda pembelajaran Anda di atas</p>
            </div>
        @endif
    </div>