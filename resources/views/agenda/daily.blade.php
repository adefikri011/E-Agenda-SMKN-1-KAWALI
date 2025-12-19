@extends('layout.main')

@section('title', 'Agenda Harian')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">📅 Agenda Harian</h1>
        <p class="text-gray-500 mt-2">Atur agenda kelas dengan mudah sesuai jadwal mengajar</p>
    </div>

    <!-- Real-time Clock Card -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl shadow-lg border border-blue-500/20 p-6 mb-6 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-24 -mb-24"></div>

        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <!-- Time Display -->
                <div class="flex-1">
                    <div class="flex items-baseline gap-2 mb-1">
                        <span class="text-sm font-semibold text-blue-200 uppercase tracking-wider">Waktu Saat Ini</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-white/10 rounded-full">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                            <span class="text-xs font-medium text-white">Live</span>
                        </span>
                    </div>
                    <div class="flex items-baseline gap-3">
                        <h2 class="text-5xl md:text-6xl font-bold text-white tracking-tight" id="realtimeClock">00:00:00</h2>
                        <span class="text-xl font-semibold text-blue-200" id="realtimeTimezone">WIB</span>
                    </div>
                    <p class="text-blue-200 mt-2 text-sm font-medium" id="realtimeFullDate">Loading...</p>
                </div>

                <!-- Decorative Icon -->
                <div class="hidden md:flex items-center justify-center w-24 h-24 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Selector -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                <input type="date" id="selectedDate"
                    class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 mb-1">Hari</p>
                <p class="text-2xl font-bold text-gray-900" id="dayName">-</p>
            </div>
        </div>
    </div>

    <!-- Jadwal Per Hari -->
    <div id="scheduleContainer" class="space-y-4">
        <!-- Will be loaded via JavaScript -->
    </div>

    <!-- Modal Add Agenda -->
    <div id="agendaModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 max-h-screen overflow-y-auto">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Tambah Agenda</h3>

            <form id="agendaForm" onsubmit="saveAgenda(event)">
                @csrf

                <input type="hidden" id="agendaId" name="agenda_id">
                <input type="hidden" id="modalKelasId" name="kelas_id">
                <input type="hidden" id="modalMapelId" name="mapel_id">

                <div class="grid grid-cols-3 gap-4 mb-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Kelas</label>
                        <p class="text-gray-900 font-bold text-lg" id="modalKelasName">-</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Mata Pelajaran</label>
                        <p class="text-gray-900 font-bold text-lg" id="modalMapelName">-</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Jam Pelajaran</label>
                        <select id="modalJampelId" name="jampel_id"
                            class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm font-semibold"
                            required>
                            <option value="">-- Pilih Jam --</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Materi Ajar</label>
                    <input type="text" name="materi" placeholder="Contoh: Persamaan Linear"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kegiatan Pembelajaran</label>
                    <textarea name="kegiatan" placeholder="Apa yang akan dilakukan di kelas?"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        rows="4" required></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" placeholder="Catatan tambahan..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        rows="2"></textarea>
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeAgendaModal()"
                        class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:border-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Real-time Clock Function
        function updateRealtimeClock() {
            const now = new Date();

            // Format time
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            // Format date
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            const fullDateString = `${dayName}, ${day} ${month} ${year}`;

            // Update DOM
            document.getElementById('realtimeClock').textContent = timeString;
            document.getElementById('realtimeFullDate').textContent = fullDateString;
        }

        // Update clock every second
        updateRealtimeClock();
        setInterval(updateRealtimeClock, 1000);

        const today = new Date().toISOString().split('T')[0];
        document.getElementById('selectedDate').value = today;

        // Days in Indonesian
        const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Guru schedule data
        const guruSchedule = {!! json_encode(
            \App\Models\GuruMapel::where('guru_id', \App\Models\Guru::where('users_id', auth()->id())->first()?->id ?? 0)->with(['kelas', 'mapel'])->get()->groupBy('kelas_id')->map(
                    fn($items) => $items->map(
                            fn($item) => [
                                'kelas_id' => $item->kelas_id,
                                'kelas_name' => $item->kelas->nama_kelas,
                                'mapel_id' => $item->mapel_id,
                                'mapel_name' => $item->mapel->nama,
                            ],
                        )->toArray(),
                ),
        ) !!};

        // Load schedule when date changes
        document.getElementById('selectedDate').addEventListener('change', loadDailySchedule);

        function loadDailySchedule() {
            const date = document.getElementById('selectedDate').value;
            const dateObj = new Date(date + 'T00:00:00');
            const dayName = dayNames[dateObj.getDay()];
            document.getElementById('dayName').textContent = dayName;

            const container = document.getElementById('scheduleContainer');
            container.innerHTML = '';

            // Get all kelas with their mapel
            const allEntries = [];
            for (const [kelasId, mapels] of Object.entries(guruSchedule)) {
                mapels.forEach(m => {
                    allEntries.push(m);
                });
            }

            if (allEntries.length === 0) {
                container.innerHTML =
                    '<div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center"><p class="text-gray-600">Anda tidak memiliki jadwal mengajar hari ini</p></div>';
                return;
            }

            // Fetch existing agendas for this date
            fetch(`/api/agendas/${date}`)
                .then(r => r.json())
                .then(agendas => {
                    const agendaMap = {};
                    agendas.forEach(a => {
                        agendaMap[`${a.kelas_id}-${a.mapel_id}`] = a;
                    });

                    // Render each kelas-mapel entry
                    allEntries.forEach(entry => {
                        const agenda = agendaMap[`${entry.kelas_id}-${entry.mapel_id}`];
                        const html = `
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 text-white">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm opacity-90">Kelas</p>
                                        <h3 class="text-xl font-bold">${entry.kelas_name}</h3>
                                        <p class="text-sm opacity-90 mt-1">${entry.mapel_name}</p>
                                    </div>
                                    <div class="text-right">
                                        ${agenda ? '<span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">✓ Sudah Ada</span>' : '<span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">⊕ Belum Ada</span>'}
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                ${agenda ? `
                                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                            <p class="text-sm text-gray-600 mb-1">Materi:</p>
                                            <p class="font-semibold text-gray-900">${agenda.materi}</p>
                                            <p class="text-sm text-gray-600 mt-3 mb-1">Kegiatan:</p>
                                            <p class="text-gray-700">${agenda.kegiatan}</p>
                                        </div>
                                    ` : '<p class="text-gray-500 text-sm mb-4">Belum ada agenda untuk kelas dan mapel ini</p>'}

                                <div class="flex gap-3">
                                    <button onclick="openAgendaModal(${entry.kelas_id}, '${entry.kelas_name}', ${entry.mapel_id}, '${entry.mapel_name}'${agenda ? `, ${agenda.id}` : ''})"
                                        class="flex-1 px-4 py-2.5 ${agenda ? 'bg-blue-100 text-blue-700 hover:bg-blue-200' : 'bg-blue-600 text-white hover:bg-blue-700'} font-semibold rounded-lg transition-colors">
                                        ${agenda ? '✏️ Edit Agenda' : '➕ Tambah Agenda'}
                                    </button>
                                    ${agenda ? `
                                            <button onclick="deleteAgenda(${agenda.id})" class="px-4 py-2.5 border-2 border-red-300 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors">
                                                🗑️ Hapus
                                            </button>
                                        ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                        container.innerHTML += html;
                    });
                });
        }

        function openAgendaModal(kelasId, kelasName, mapelId, mapelName, agendaId = null) {
            document.getElementById('agendaForm').reset();
            document.getElementById('modalKelasId').value = kelasId;
            document.getElementById('modalMapelId').value = mapelId;
            document.getElementById('modalKelasName').textContent = kelasName;
            document.getElementById('modalMapelName').textContent = mapelName;
            document.getElementById('agendaId').value = agendaId || '';

            // Load jam pelajaran options
            const jampelSelect = document.getElementById('modalJampelId');
            fetch('/api/jampel')
                .then(r => r.json())
                .then(jampels => {
                    jampelSelect.innerHTML = '<option value="">-- Pilih Jam --</option>';
                    jampels.forEach(j => {
                        const option = document.createElement('option');
                        option.value = j.id;
                        option.textContent = `${j.nama_jam} (${j.rentang_waktu})`;
                        jampelSelect.appendChild(option);
                    });

                    // If editing, load existing data
                    if (agendaId) {
                        fetch(`/api/agendas/${agendaId}`)
                            .then(r => r.json())
                            .then(agenda => {
                                document.querySelector('input[name="materi"]').value = agenda.materi;
                                document.querySelector('textarea[name="kegiatan"]').value = agenda.kegiatan;
                                document.querySelector('textarea[name="catatan"]').value = agenda.catatan || '';
                                jampelSelect.value = agenda.jampel_id || '';
                            });
                    }
                });

            document.getElementById('agendaModal').classList.remove('hidden');
        }

        function closeAgendaModal() {
            document.getElementById('agendaModal').classList.add('hidden');
        }

        function saveAgenda(e) {
            e.preventDefault();

            const form = new FormData(document.getElementById('agendaForm'));
            const agendaId = form.get('agenda_id');
            const kelasId = form.get('kelas_id');
            const mapelId = form.get('mapel_id');
            const tanggal = document.getElementById('selectedDate').value;

            const data = {
                kelas_id: kelasId,
                mapel_id: mapelId,
                jampel_id: form.get('jampel_id'),
                tanggal: tanggal,
                materi: form.get('materi'),
                kegiatan: form.get('kegiatan'),
                catatan: form.get('catatan'),
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            const method = agendaId ? 'PUT' : 'POST';
            const url = agendaId ? `/api/agendas/${agendaId}` : '/api/agendas';

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
                        closeAgendaModal();
                        loadDailySchedule();
                        alert('Agenda berhasil disimpan!');
                    } else {
                        alert('Error: ' + (result.message || 'Gagal menyimpan'));
                    }
                })
                .catch(e => alert('Error: ' + e.message));
        }

        function deleteAgenda(agendaId) {
            if (confirm('Apakah Anda yakin ingin menghapus agenda ini?')) {
                fetch(`/api/agendas/${agendaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(r => r.json())
                    .then(result => {
                        if (result.success) {
                            loadDailySchedule();
                            alert('Agenda berhasil dihapus!');
                        }
                    });
            }
        }

        // Load on page load
        loadDailySchedule();
    </script>

@endsection
