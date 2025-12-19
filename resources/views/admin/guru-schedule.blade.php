@extends('layout.main')

@section('title', 'Kelola Jadwal Guru')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">📚 Kelola Jadwal Mengajar Guru</h1>
        <p class="text-gray-500 mt-2">Admin mengatur jadwal mengajar setiap guru per kelas dan mata pelajaran</p>
    </div>

    <!-- Add New Schedule Button -->
    <div class="mb-6">
        <button onclick="openAddModal()"
            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
            <i class="fas fa-plus mr-2"></i> Tambah Jadwal Baru
        </button>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Guru</label>
                <input type="text" id="filterGuru" placeholder="Ketik nama guru..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Kelas</label>
                <select id="filterKelas"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-white">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Filter Mapel</label>
                <select id="filterMapel"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-white">
                    <option value="">-- Semua Mapel --</option>
                    @foreach ($mapel as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Jadwal Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Guru</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kelas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Jam Pelajaran</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody id="scheduleList" class="divide-y divide-gray-100">
                    <!-- Loaded via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Add/Edit Schedule -->
    <div id="scheduleModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6" id="modalTitle">Tambah Jadwal</h3>

            <form id="scheduleForm" onsubmit="saveSchedule(event)">
                @csrf
                <input type="hidden" id="scheduleId" name="schedule_id">
                <input type="hidden" id="hariTipe" name="hari_tipe">

                <!-- GURU -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Guru <span
                            class="text-red-600">*</span></label>
                    <select id="guruId" name="guru_id" class="w-full px-4 py-2.5 border rounded-lg" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach ($guru as $g)
                            <option value="{{ $g->id }}">{{ $g->user->name }} ({{ $g->nip ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- KELAS -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span
                            class="text-red-600">*</span></label>
                    <select id="kelasId" name="kelas_id" class="w-full px-4 py-2.5 border rounded-lg" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- MAPEL -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mata Pelajaran <span
                            class="text-red-600">*</span></label>
                    <select id="mapelId" name="mapel_id" class="w-full px-4 py-2.5 border rounded-lg" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- HARI -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hari <span
                            class="text-red-600">*</span></label>
                    <select id="hariSelect" class="w-full px-4 py-2.5 border rounded-lg" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="senin">Senin</option>
                        <option value="selasa_rabu_kamis">Selasa - Rabu - Kamis</option>
                        <option value="jumat">Jumat</option>
                    </select>
                </div>

                <!-- JAM -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Pelajaran <span
                            class="text-red-600">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-gray-600 mb-1">Mulai</label>
                            <select id="startJampelId" name="start_jampel_id" class="w-full px-4 py-2.5 border rounded-lg"
                                required>
                                <option value="">-- Pilih Jam --</option>
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
                            <select id="endJampelId" name="end_jampel_id" class="w-full px-4 py-2.5 border rounded-lg">
                                <option value="">-- Otomatis --</option>
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
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeScheduleModal()" class="px-6 py-2 border rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                        Simpan Jadwal
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        // Load schedules on page load
        loadSchedules();

        function loadSchedules() {
            const filterGuru = document.getElementById('filterGuru').value.toLowerCase();
            const filterKelas = document.getElementById('filterKelas').value;
            const filterMapel = document.getElementById('filterMapel').value;

            fetch('/api/guru-schedules')
                .then(r => r.json())
                .then(schedules => {
                    const list = document.getElementById('scheduleList');
                    list.innerHTML = '';

                    // Filter schedules
                    const filtered = schedules.filter(s => {
                        const guruMatch = !filterGuru || s.guru_name.toLowerCase().includes(filterGuru);
                        const kelasMatch = !filterKelas || s.kelas_id == filterKelas;
                        const mapelMatch = !filterMapel || s.mapel_id == filterMapel;
                        return guruMatch && kelasMatch && mapelMatch;
                    });

                    if (filtered.length === 0) {
                        list.innerHTML =
                            '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada jadwal</td></tr>';
                        return;
                    }

                    // Group schedules by guru to show duplicates
                    const groupedSchedules = {};
                    filtered.forEach(schedule => {
                        const key = `${schedule.guru_id}-${schedule.kelas_id}-${schedule.mapel_id}`;
                        if (!groupedSchedules[key]) {
                            groupedSchedules[key] = [];
                        }
                        groupedSchedules[key].push(schedule);
                    });

                    // Display schedules
                    Object.values(groupedSchedules).forEach(group => {
                        group.forEach((schedule, index) => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50 transition-colors';

                            // Only show guru name on first row of group
                            const guruCell = index === 0 ?
                                `<td class="px-6 py-4 text-sm font-medium text-gray-900" rowspan="${group.length}">${schedule.guru_name}</td>` :
                                '';

                            // Only show kelas name on first row of group
                            const kelasCell = index === 0 ?
                                `<td class="px-6 py-4 text-sm text-gray-700" rowspan="${group.length}">${schedule.kelas_name}</td>` :
                                '';

                            // Only show mapel name on first row of group
                            const mapelCell = index === 0 ?
                                `<td class="px-6 py-4 text-sm text-gray-700" rowspan="${group.length}">${schedule.mapel_name}</td>` :
                                '';

                            const jamDisplay = (() => {
                                if (schedule.start_jampel_name && schedule.end_jampel_name) {
                                    if (schedule.start_jampel_name === schedule
                                        .end_jampel_name) {
                                        return `${schedule.start_jampel_name} (${schedule.start_rentang || '-'})`;
                                    }
                                    return `${schedule.start_jampel_name} - ${schedule.end_jampel_name} (${schedule.start_rentang || schedule.end_rentang || '-'})`;
                                }
                                return '-';
                            })();

                            row.innerHTML = `
                            ${guruCell}
                            ${kelasCell}
                            ${mapelCell}
                            <td class="px-6 py-4 text-sm text-gray-600">${jamDisplay}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick="editSchedule(${schedule.id})" class="px-4 py-2 bg-blue-100 text-blue-700 font-semibold rounded-lg hover:bg-blue-200 transition-colors">
                                    ✏️ Edit
                                </button>
                                <button onclick="deleteSchedule(${schedule.id})" class="px-4 py-2 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition-colors">
                                    🗑️ Hapus
                                </button>
                            </td>
                        `;
                            list.appendChild(row);
                        });
                    });
                });
        }

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
                        alert('Jadwal berhasil disimpan!');
                    } else {
                        alert('Error: ' + (result.message || 'Gagal menyimpan'));
                    }
                })
                .catch(e => alert('Error: ' + e.message));
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

        document.getElementById('startJampelId').addEventListener('change', updateEndOptions);
        document.getElementById('endJampelId').addEventListener('change', updateEndOptions);

        function deleteSchedule(id) {
            if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
                fetch(`/api/guru-schedules/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(r => r.json())
                    .then(result => {
                        if (result.success) {
                            loadSchedules();
                            alert('Jadwal berhasil dihapus!');
                        }
                    });
            }
        }

        const hariSelect = document.getElementById('hariSelect');
        const startSelect = document.getElementById('startJampelId');
        const endSelect = document.getElementById('endJampelId');
        const hariInput = document.getElementById('hariTipe');

        hariSelect.addEventListener('change', function() {
            const hari = this.value;
            hariInput.value = hari;

            filterJamByHari(hari);
        });

        function filterJamByHari(hari) {
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

        // pastikan jam selesai >= jam mulai
        startSelect.addEventListener('change', function() {
            const startOrder = this.selectedOptions[0]?.dataset.order;

            Array.from(endSelect.options).forEach(opt => {
                if (!opt.dataset.order) return;
                opt.disabled = Number(opt.dataset.order) < Number(startOrder);
            });

            endSelect.value = this.value;
        });
    </script>

@endsection
