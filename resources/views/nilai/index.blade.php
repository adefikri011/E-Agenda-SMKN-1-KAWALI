@extends('layout.main')

@section('title', 'Daftar Nilai')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold">Daftar Nilai</h2>
            <p class="text-sm text-gray-500">Input nilai siswa dan riwayat per hari</p>
        </div>
        <a href="{{ route('nilai.create') }}" class="btn btn-primary">+ Input Nilai Baru</a>
    </div>

    @php
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $nilaiByDate = $nilai->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        })->sortByDesc(function($items, $date) {
            return $date;
        });

        $todayNilai = $nilaiByDate->get($today, collect());
        $historyNilai = $nilaiByDate->filter(function($items, $date) use ($today) {
            return $date !== $today;
        });
    @endphp

    <!-- NILAI HARI INI -->
    @if($todayNilai->count() > 0)
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-50 to-emerald-100 border-l-4 border-green-500 rounded-xl shadow p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-green-900">Nilai Hari Ini</h3>
                        <p class="text-sm text-green-700 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="text-4xl font-bold text-green-600">{{ $todayNilai->count() }}</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">#</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kelas</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mapel</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nilai</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($todayNilai as $n)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        @php
                                            $namasiswa = optional($n->siswa)->nama_siswa ?? optional($n->siswa)->nama ?? optional($n->siswa)->name ?? 'Siswa #' . ($n->siswa_id ?? 'N/A');
                                        @endphp
                                        {{ $namasiswa }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->kelas)->nama_kelas ?? optional($n->kelas)->nama ?? optional($n->kelas)->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->mapel)->nama ?? optional($n->mapel)->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-2 py-1 rounded text-xs font-semibold
                                            @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') bg-blue-100 text-blue-700
                                            @elseif($n->jenis === 'uts') bg-orange-100 text-orange-700
                                            @elseif($n->jenis === 'uas') bg-red-100 text-red-700
                                            @endif">
                                            @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') Tugas Harian
                                            @elseif($n->jenis === 'uts') UTS
                                            @elseif($n->jenis === 'uas') UAS
                                            @else {{ ucfirst($n->jenis) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $n->nilai }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $n->keterangan ? Str::limit($n->keterangan, 40) : '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $n->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-sm flex gap-2">
                                        <a href="{{ route('nilai.edit', $n->id) }}" class="btn btn-sm btn-ghost">Edit</a>
                                        <form action="{{ route('nilai.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost text-red-600">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <p class="text-blue-700 text-center">Belum ada nilai hari ini. <a href="{{ route('nilai.create') }}" class="font-semibold underline">Mulai input nilai sekarang →</a></p>
        </div>
    @endif

    <!-- RIWAYAT NILAI -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Riwayat Nilai</h3>
            <input type="date" id="filter-date" class="input input-bordered input-sm w-40" placeholder="Filter tanggal">
        </div>

        @if($historyNilai->count() > 0)
            <div class="space-y-4">
                @foreach($historyNilai as $date => $items)
                    <div class="history-group bg-white rounded-xl shadow overflow-hidden" data-date="{{ $date }}">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 border-l-4 border-gray-400 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h4>
                                    <p class="text-sm text-gray-600">{{ $items->count() }} nilai terdaftar</p>
                                </div>
                                <div class="text-sm font-medium text-gray-600 bg-white px-3 py-1 rounded-full">{{ $items->count() }} data</div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">#</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Siswa</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kelas</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Mapel</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nilai</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($items as $n)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                @php
                                                    $namasiswa = optional($n->siswa)->nama_siswa ?? optional($n->siswa)->nama ?? optional($n->siswa)->name ?? 'Siswa #' . ($n->siswa_id ?? 'N/A');
                                                @endphp
                                                {{ $namasiswa }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->kelas)->nama_kelas ?? optional($n->kelas)->nama ?? optional($n->kelas)->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ optional($n->mapel)->nama ?? optional($n->mapel)->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-sm">
                                                <span class="px-2 py-1 rounded text-xs font-semibold
                                                    @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') bg-blue-100 text-blue-700
                                                    @elseif($n->jenis === 'uts') bg-orange-100 text-orange-700
                                                    @elseif($n->jenis === 'uas') bg-red-100 text-red-700
                                                    @endif">
                                                    @if($n->jenis === 'tugas' || $n->jenis === 'tugas_harian') Tugas Harian
                                                    @elseif($n->jenis === 'uts') UTS
                                                    @elseif($n->jenis === 'uas') UAS
                                                    @else {{ ucfirst($n->jenis) }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $n->nilai }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $n->keterangan ? Str::limit($n->keterangan, 40) : '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $n->created_at->format('H:i') }}</td>
                                            <td class="px-6 py-4 text-sm flex gap-2">
                                                <a href="{{ route('nilai.edit', $n->id) }}" class="btn btn-sm btn-ghost">Edit</a>
                                                <form action="{{ route('nilai.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-ghost text-red-600">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow p-8 text-center">
                <p class="text-gray-600">Belum ada riwayat nilai.</p>
            </div>
        @endif
    </div>

@endsection

@push('script')
<script>
    const filterDateInput = document.getElementById('filter-date');
    const historyGroups = document.querySelectorAll('.history-group');

    filterDateInput?.addEventListener('change', function(e) {
        const selectedDate = e.target.value; // format: YYYY-MM-DD

        historyGroups.forEach(group => {
            const groupDate = group.getAttribute('data-date');
            if (!selectedDate || groupDate === selectedDate) {
                group.style.display = '';
            } else {
                group.style.display = 'none';
            }
        });

        // show message if all hidden
        if (selectedDate && Array.from(historyGroups).every(g => g.style.display === 'none')) {
            // optional: show "no data" message
        }
    });

    // Clear filter button (optional, add after filter input)
    document.addEventListener('DOMContentLoaded', function() {
        const clearBtn = document.createElement('button');
        clearBtn.className = 'btn btn-sm btn-ghost';
        clearBtn.textContent = '✕ Hapus Filter';
        clearBtn.addEventListener('click', () => {
            filterDateInput.value = '';
            historyGroups.forEach(g => g.style.display = '');
        });
        filterDateInput?.parentElement?.appendChild(clearBtn);
    });
</script>
@endpush
