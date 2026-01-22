
@extends('layout.main')

@section('title', 'Kelola Jadwal Guru')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 mb-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Kelola Jadwal Mengajar Guru</h1>
                <p class="text-gray-600 text-sm">Admin mengatur jadwal mengajar setiap guru per kelas dan mata pelajaran</p>
            </div>
            <div class="mt-3 md:mt-0 flex flex-wrap gap-2">
                <!-- Tombol Tambah Jadwal -->
                <button onclick="openAddModal()"
                    class="group bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-indigo-700 hover:to-blue-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 stroke-[2.5] group-hover:rotate-90 transition duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium text-sm">Tambah Jadwal</span>
                </button>

                <!-- Tombol Bulk Assign -->
                <button onclick="document.getElementById('bulkModal').classList.remove('hidden')"
                    class="group bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg flex items-center gap-2 shadow-md hover:shadow-lg transition-all duration-300 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 stroke-[2.5] group-hover:scale-110 transition duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3" />
                    </svg>
                    <span class="font-medium text-sm">Bulk Assign</span>
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-gray-50 rounded-lg p-4 mb-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Guru</label>
                    <div class="relative">
                        <input type="text" id="filterGuru" placeholder="Ketik nama guru..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kelas</label>
                    <select id="filterKelas"
                        class="select2 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Mapel</label>
                    <select id="filterMapel"
                        class="select2 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-white">
                        <option value="">Semua Mapel</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Desktop Table (Hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th
                            class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tl-lg">
                            No</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Guru
                        </th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas
                        </th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata
                            Pelajaran</th>
                        <th class="py-3 px-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam
                            Pelajaran</th>
                        <th
                            class="py-3 px-5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider rounded-tr-lg">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody id="scheduleList" class="divide-y divide-gray-200">
                    <!-- Loaded via JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (Hidden on desktop) -->
        <div class="md:hidden space-y-4" id="mobileScheduleList">
            <!-- Loaded via JavaScript -->
        </div>

        <!-- Empty State Template (hidden by default) -->
        <div id="emptyState" class="hidden">
            <div class="text-center py-12">
                <svg class="mx-auto mb-4 w-20 h-20 text-gray-300" fill="none" viewBox="0 0 64 64" stroke="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <rect x="12" y="10" width="40" height="44" rx="3" stroke-width="2" />
                    <path d="M24 20h16M24 30h16M24 40h16M24 50h8" stroke-width="2" />
                    <path d="M48 30l4-4M48 40l4-4" stroke-width="2" />
                </svg>

                <h3 class="mt-2 text-lg font-semibold text-gray-800">Belum ada jadwal mengajar</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada jadwal yang ditambahkan. Tambahkan jadwal untuk mengatur
                    pengajaran.</p>

                <div class="mt-4 flex items-center justify-center space-x-3">
                    <button onclick="openAddModal()"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-medium shadow-sm hover:bg-blue-700">
                        + Tambah Jadwal
                    </button>
                    <button onclick="loadSchedules()"
                        class="inline-flex items-center px-4 py-2 rounded-md border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                        Segarkan
                    </button>
                </div>
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
                        <select name="guru_id"
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm"
                            required>
                            <option value="">Pilih Guru</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->user->name ?? $g->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <select name="kelas_id"
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm"
                            required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran (Pilih Multiple)</label>
                        <div class="border border-gray-300 rounded-lg p-3 max-h-48 overflow-y-auto bg-gray-50">
                            @foreach ($mapel as $m)
                                <label class="flex items-center mb-2 cursor-pointer hover:bg-gray-100 p-2 rounded">
                                    <input type="checkbox" name="mapel_ids[]" value="{{ $m->id }}"
                                        class="mr-2 rounded">
                                    <span class="text-sm text-gray-700">{{ $m->nama }}</span>
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

    <!-- Modal Add/Edit Schedule -->
    <div id="scheduleModal"
        class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Tambah Jadwal</h3>
                <button onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="scheduleForm" onsubmit="saveSchedule(event)">
                @csrf
                <input type="hidden" id="scheduleId" name="schedule_id">
                <input type="hidden" id="hariTipe" name="hari_tipe">

                <!-- GURU -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Guru <span
                            class="text-red-500">*</span></label>
                    <select id="guruId" name="guru_id"
                        class="select2 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        required>
                        <option value="">Pilih Guru</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->user->name }} ({{ $g->nip ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- KELAS -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kelas <span
                            class="text-red-500">*</span></label>
                    <select id="kelasId" name="kelas_id"
                        class="select2 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        required>
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- MAPEL -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran <span
                            class="text-red-500">*</span></label>
                    <select id="mapelId" name="mapel_id"
                        class="select2 w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        required>
                        <option value="">Pilih Mapel</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->nama }} ({{ $m->tingkat }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- HARI -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hari <span
                            class="text-red-500">*</span></label>
                    <select id="hariSelect"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        required>
                        <option value="">Pilih Hari</option>
                        <option value="senin">Senin</option>
                        <option value="selasa_rabu_kamis">Selasa - Rabu - Kamis</option>
                        <option value="jumat">Jumat</option>
                    </select>
                </div>

                <!-- JAM -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Pelajaran <span
                            class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Mulai</label>
                            <select id="startJampelId" name="start_jampel_id"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                required>
                                <option value="">Pilih Jam</option>
                                @foreach ($jampel as $j)
                                    <option value="{{ $j->id }}" data-hari="{{ $j->hari_tipe }}"
                                        data-order="{{ $j->jam_ke }}">
                                        {{ $j->nama_jam }} ({{ $j->rentang_waktu }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Selesai</label>
                            <select id="endJampelId" name="end_jampel_id"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <option value="">Otomatis</option>
                                @foreach ($jampel as $j)
                                    <option value="{{ $j->id }}" data-hari="{{ $j->hari_tipe }}"
                                        data-order="{{ $j->jam_ke }}">
                                        {{ $j->nama_jam }} ({{ $j->rentang_waktu }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeScheduleModal()"
                        class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-colors text-sm font-medium">
                        Simpan Jadwal
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

        #bulkModal>div {
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


    <script>
        // Load schedules on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadSchedules();

            // Filter event listeners
            document.getElementById('filterGuru').addEventListener('input', loadSchedules);
            document.getElementById('filterKelas').addEventListener('change', loadSchedules);
            document.getElementById('filterMapel').addEventListener('change', loadSchedules);

            // Event listener untuk perubahan jam mulai
            document.getElementById('startJampelId')?.addEventListener('change', function() {
                const selectedOption = this.selectedOptions[0];
                if (selectedOption) {
                    const hariTipe = selectedOption.dataset.hari;
                    document.getElementById('hariTipe').value = hariTipe;
                    updateEndOptions();
                }
            });

            // Close modal when clicking outside
            document.getElementById('scheduleModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeScheduleModal();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeScheduleModal();
                }
            });

            // Event listeners for jam filtering
            const hariSelect = document.getElementById('hariSelect');
            const startSelect = document.getElementById('startJampelId');
            const endSelect = document.getElementById('endJampelId');
            const hariInput = document.getElementById('hariTipe');

            hariSelect.addEventListener('change', function() {
                const hari = this.value;
                hariInput.value = hari;
                filterJamByHari(hari);
            });

            startSelect.addEventListener('change', function() {
                updateEndOptions();
            });
        });

        function loadSchedules() {
            const filterGuru = document.getElementById('filterGuru').value.toLowerCase();
            const filterKelas = document.getElementById('filterKelas').value;
            const filterMapel = document.getElementById('filterMapel').value;

            fetch('/api/guru-schedules')
                .then(r => r.json())
                .then(schedules => {
                    const desktopList = document.getElementById('scheduleList');
                    const mobileList = document.getElementById('mobileScheduleList');
                    const emptyState = document.getElementById('emptyState');

                    desktopList.innerHTML = '';
                    mobileList.innerHTML = '';

                    // Filter schedules
                    const filtered = schedules.filter(s => {
                        const guruMatch = !filterGuru || s.guru_name.toLowerCase().includes(filterGuru);
                        const kelasMatch = !filterKelas || s.kelas_id == filterKelas;
                        const mapelMatch = !filterMapel || s.mapel_id == filterMapel;
                        return guruMatch && kelasMatch && mapelMatch;
                    });

                    if (filtered.length === 0) {
                        emptyState.classList.remove('hidden');
                        desktopList.innerHTML = '<tr><td colspan="6" class="px-6 py-12">' + emptyState.innerHTML +
                            '</td></tr>';
                        return;
                    }

                    emptyState.classList.add('hidden');

                    // Group schedules by guru to show duplicates
                    const groupedSchedules = {};
                    filtered.forEach(schedule => {
                        const key = `${schedule.guru_id}-${schedule.kelas_id}-${schedule.mapel_id}`;
                        if (!groupedSchedules[key]) {
                            groupedSchedules[key] = [];
                        }
                        groupedSchedules[key].push(schedule);
                    });

                    // Display desktop schedules
                    Object.values(groupedSchedules).forEach(group => {
                        group.forEach((schedule, index) => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50 transition-colors duration-200';

                            // Only show guru name on first row of group
                            const guruCell = index === 0 ?
                                `<td class="py-3 px-5 font-mono text-sm text-gray-900" rowspan="${group.length}">${group.length > 1 ? 'Multi' : schedule.id}</td>` :
                                '';

                            const guruNameCell = index === 0 ?
                                `<td class="py-3 px-5 text-sm font-medium text-gray-900" rowspan="${group.length}">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                            <i class="fas fa-chalkboard-teacher text-xs"></i>
                                        </div>
                                        <span>${schedule.guru_name}</span>
                                    </div>
                                </td>` :
                                '';

                            // Only show kelas name on first row of group
                            const kelasCell = index === 0 ?
                                `<td class="py-3 px-5 text-sm text-gray-900 font-medium" rowspan="${group.length}">
                                    <span class="inline-flex items-center gap-1 bg-gradient-to-r from-green-50 to-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-chalkboard text-xs"></i>
                                        ${schedule.kelas_name}
                                    </span>
                                </td>` :
                                '';

                            // Only show mapel name on first row of group
                            const mapelCell = index === 0 ?
                                `<td class="py-3 px-5 text-sm" rowspan="${group.length}">
                                    <span class="inline-flex items-center gap-1 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-book text-xs"></i>
                                        ${schedule.mapel_name}
                                    </span>
                                </td>` :
                                '';

                            const jamDisplay = (() => {
                                if (schedule.start_jampel_name && schedule.end_jampel_name) {
                                    if (schedule.start_jampel_name === schedule
                                        .end_jampel_name) {
                                        return `${schedule.start_jampel_name}`;
                                    }
                                    return `${schedule.start_jampel_name} - ${schedule.end_jampel_name}`;
                                }
                                return '-';
                            })();

                            row.innerHTML = `
                                ${guruCell}
                                ${guruNameCell}
                                ${kelasCell}
                                ${mapelCell}
                                <td class="py-3 px-5 text-sm text-gray-600">
                                    <div class="font-medium">${jamDisplay}</div>
                                    <div class="text-xs text-gray-500">${schedule.start_rentang || ''}</div>
                                </td>
                                <td class="py-3 px-5 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="editSchedule(${schedule.id})"
                                                class="text-yellow-600 hover:text-yellow-800 transition-colors duration-200 p-1.5 rounded-full hover:bg-yellow-50">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <button onclick="deleteSchedule(${schedule.id})"
                                                class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1.5 rounded-full hover:bg-red-50">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </td>
                            `;
                            desktopList.appendChild(row);
                        });
                    });

                    // Display mobile card view
                    filtered.forEach((schedule, index) => {
                        const card = document.createElement('div');
                        card.className =
                            'bg-white rounded-lg border border-gray-200 p-4 shadow-sm hover:shadow-md transition-shadow duration-200';

                        const jamDisplay = (() => {
                            if (schedule.start_jampel_name && schedule.end_jampel_name) {
                                if (schedule.start_jampel_name === schedule.end_jampel_name) {
                                    return `${schedule.start_jampel_name}`;
                                }
                                return `${schedule.start_jampel_name} - ${schedule.end_jampel_name}`;
                            }
                            return '-';
                        })();

                        card.innerHTML = `
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                            <i class="fas fa-chalkboard-teacher text-xs"></i>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-sm">${schedule.guru_name}</h3>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex items-center gap-1">
                                            <span class="bg-gradient-to-r from-green-50 to-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                                <i class="fas fa-chalkboard mr-1 text-xs"></i>${schedule.kelas_name}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="bg-gradient-to-r from-blue-50 to-blue-100 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-full">
                                                <i class="fas fa-book mr-1 text-xs"></i>${schedule.mapel_name}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-1">
                                    <button onclick="editSchedule(${schedule.id})"
                                            class="text-yellow-600 hover:text-yellow-800 p-2 rounded-full hover:bg-yellow-50 transition-colors">
                                        <i class="fas fa-edit text-sm"></i>
                                    </button>
                                    <button onclick="deleteSchedule(${schedule.id})"
                                            class="text-red-600 hover:text-red-800 p-2 rounded-full hover:bg-red-50 transition-colors">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm mt-3">
                                <div>
                                    <div class="text-gray-500 font-medium mb-1">Jam</div>
                                    <div class="text-gray-900 bg-gray-50 p-2 rounded font-medium">${jamDisplay}</div>
                                </div>
                                <div>
                                    <div class="text-gray-500 font-medium mb-1">Waktu</div>
                                    <div class="text-gray-900 bg-gray-50 p-2 rounded">${schedule.start_rentang || '-'}</div>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <div class="text-gray-500 text-xs flex justify-between items-center">
                                    <span>ID: ${schedule.id}</span>
                                    <span><i class="fas fa-calendar-alt mr-1"></i> ${new Date(schedule.created_at).toLocaleDateString('id-ID')}</span>
                                </div>
                            </div>
                        `;
                        mobileList.appendChild(card);
                    });
                });
        }

        function openAddModal() {
            document.getElementById('scheduleForm').reset();
            document.getElementById('scheduleId').value = '';
            document.getElementById('modalTitle').textContent = 'Tambah Jadwal';
            document.getElementById('scheduleModal').classList.remove('hidden');
        }

        function closeScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
        }

        function editSchedule(id) {
            fetch(`/api/guru-schedules/${id}`)
                .then(r => r.json())
                .then(schedule => {
                    document.getElementById('scheduleForm').reset();
                    document.getElementById('scheduleId').value = schedule.id;
                    document.getElementById('guruId').value = schedule.guru_id;
                    document.getElementById('kelasId').value = schedule.kelas_id;
                    document.getElementById('mapelId').value = schedule.mapel_id;
                    document.getElementById('hariTipe').value = schedule.hari_tipe;

                    // Set jam setelah dropdown terisi
                    setTimeout(() => {
                        document.getElementById('startJampelId').value = schedule.start_jampel_id || '';
                        document.getElementById('endJampelId').value = schedule.end_jampel_id || '';
                        updateEndOptions();
                    }, 100);

                    document.getElementById('modalTitle').textContent = 'Edit Jadwal';
                    document.getElementById('scheduleModal').classList.remove('hidden');
                });
        }

        function saveSchedule(e) {
            e.preventDefault();

            const form = new FormData(document.getElementById('scheduleForm'));
            const scheduleId = form.get('schedule_id');
            const data = {
                guru_id: form.get('guru_id'),
                kelas_id: form.get('kelas_id'),
                mapel_id: form.get('mapel_id'),
                hari_tipe: form.get('hari_tipe'),
                start_jampel_id: form.get('start_jampel_id') || null,
                end_jampel_id: form.get('end_jampel_id') || null,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            const method = scheduleId ? 'PUT' : 'POST';
            const url = scheduleId ? `/api/guru-schedules/${scheduleId}` : '/api/guru-schedules';

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                })
                .then(r => r.json())
                .then(result => {
                    if (result.success) {
                        closeScheduleModal();
                        loadSchedules();
                        showToast('success', 'Berhasil', result.message || 'Jadwal berhasil disimpan');
                    } else {
                        showToast('error', 'Gagal', result.message || 'Gagal menyimpan');
                    }
                })
                .catch(e => showToast('error', 'Error', e.message || 'Terjadi kesalahan'));
        }

        // Keep end options >= start option and same hari
        function updateEndOptions() {
            const start = document.getElementById('startJampelId');
            const end = document.getElementById('endJampelId');
            const startVal = start.value;

            // If start is empty, enable all
            Array.from(end.options).forEach(opt => {
                opt.disabled = false;
            });

            if (!startVal) return;

            // Get selected start option
            const startOption = start.selectedOptions[0];
            if (!startOption) return;

            const startOrder = startOption.dataset.order;
            const startHari = startOption.dataset.hari;

            Array.from(end.options).forEach(opt => {
                const order = opt.dataset.order;
                const hari = opt.dataset.hari;
                if (!order || !hari) return;
                // Disable if different hari or order < startOrder
                opt.disabled = (hari !== startHari) || (Number(order) < Number(startOrder));
            });

            // If currently selected end is before start or different hari, reset it
            const selectedEnd = end.value;
            if (selectedEnd) {
                const endOption = end.selectedOptions[0];
                if (endOption) {
                    const endOrder = endOption.dataset.order;
                    const endHari = endOption.dataset.hari;
                    if (endHari !== startHari || Number(endOrder) < Number(startOrder)) {
                        end.value = startVal;
                    }
                }
            }
        }

        function filterJamByHari(hari) {
            const startSelect = document.getElementById('startJampelId');
            const endSelect = document.getElementById('endJampelId');

            [startSelect, endSelect].forEach(select => {
                Array.from(select.options).forEach(opt => {
                    if (!opt.dataset.hari) return;

                    const match = opt.dataset.hari === hari;
                    opt.hidden = !match;
                    opt.disabled = !match;
                });
                select.value = '';
            });
        }

        function deleteSchedule(id) {
            // Open confirmation modal instead of browser confirm
            openConfirmDelete(id);
        }

        // Open confirm delete modal and store target id
        function openConfirmDelete(id) {
            const modal = document.getElementById('confirmDeleteModal');
            if (!modal) return;
            modal.dataset.targetId = id;
            // Optional: set description if you have access to the schedule element
            const nameEl = modal.querySelector('.confirm-target-name');
            if (nameEl) {
                nameEl.textContent = `ID: ${id}`;
            }
            modal.classList.remove('hidden');
        }

        function closeConfirmDelete() {
            const modal = document.getElementById('confirmDeleteModal');
            if (!modal) return;
            modal.classList.add('hidden');
            delete modal.dataset.targetId;
        }

        function performDelete() {
            const modal = document.getElementById('confirmDeleteModal');
            if (!modal) return;
            const id = modal.dataset.targetId;
            if (!id) return;

            fetch(`/api/guru-schedules/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(r => r.json())
                .then(result => {
                    if (result.success) {
                        showToast('success', 'Berhasil', result.message || 'Jadwal berhasil dihapus');
                        closeConfirmDelete();
                        loadSchedules();
                    } else {
                        showToast('error', 'Gagal', result.message || 'Gagal menghapus jadwal');
                    }
                })
                .catch(e => showToast('error', 'Error', e.message || 'Terjadi kesalahan'));
        }

            // Client-side toast helper for AJAX feedback
            function showToast(type = 'info', title = '', message = '') {
                const id = 'ajax-toast-wrapper';
                let wrapper = document.getElementById(id);
                if (!wrapper) {
                    wrapper = document.createElement('div');
                    wrapper.id = id;
                    wrapper.className = 'fixed bottom-6 right-6 z-[9999] pointer-events-none';
                    document.body.appendChild(wrapper);
                }

                const toast = document.createElement('div');
                toast.className = 'notification-toast pointer-events-auto mb-3';
                const color = (type === 'success') ? 'emerald' : (type === 'error') ? 'red' : (type === 'warning') ? 'amber' : 'blue';

                toast.innerHTML = `
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 flex items-center gap-3 min-w-[280px] max-w-[420px]">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-${color}-100 flex items-center justify-center">
                                ${type === 'success' ? '<svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>' : ''}
                                ${type === 'error' ? '<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>' : ''}
                                ${type === 'warning' ? '<svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>' : ''}
                                ${type === 'info' ? '<svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' : ''}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 mb-0.5">${title}</p>
                            <p class="text-sm text-gray-600">${message}</p>
                        </div>
                        <button class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors" aria-label="close">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                `;

                toast.querySelector('button')?.addEventListener('click', () => {
                    toast.classList.add('hiding');
                    setTimeout(() => toast.remove(), 300);
                });

                wrapper.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.classList.add('hiding');
                        setTimeout(() => toast.remove(), 300);
                    }
                }, 4500);
            }
    </script>

    <!-- Confirm Delete Modal -->
    <div id="confirmDeleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <div class="flex items-start gap-3 mb-4">
                <div class="p-2 rounded-full bg-red-100 text-red-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus Jadwal</h3>
                    <p class="text-sm text-gray-600 mt-1">Apakah Anda yakin ingin menghapus jadwal <span class="font-semibold confirm-target-name">?</span> ? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeConfirmDelete()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">Batal</button>
                <button type="button" onclick="performDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
            </div>
        </div>
    </div>
@endsection
