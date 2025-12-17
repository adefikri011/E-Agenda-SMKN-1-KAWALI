@extends('layout.main')

@section('title', 'Input Absensi')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Input Absensi Siswa</h1>
        <p class="text-gray-500">Catat kehadiran siswa per mata pelajaran</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal</label>
                <input type="date" id="tanggal" value="{{ $selectedTanggal or now()->format('Y-m-d') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    required>
            </div>

            <!-- Kelas -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                <select id="kelas_id"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-white">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}"
                            {{ isset($selectedKelas) && $selectedKelas == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mata Pelajaran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Mata Pelajaran</label>
                <select id="mapel_id"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-white">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapel as $item)
                        <option value="{{ $item->id }}" data-kelas-id=""
                            {{ isset($selectedMapel) && $selectedMapel == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Jam Pelajaran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Pelajaran</label>
                <select id="jampel_id"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-white">
                    <option value="">-- Pilih Jam --</option>
                    @foreach ($jampel as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_jam }} ({{ $item->rentang_waktu }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end">
            <button id="btnLanjut" onclick="loadStudents()"
                class="px-8 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                Lanjutkan
            </button>
        </div>
    </div>

    <!-- Student Section (Hidden by default) -->
    <div id="studentSection" class="hidden">
        <!-- Info Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Mata Pelajaran</p>
                    <h2 class="text-2xl font-bold text-gray-900" id="mapelName">-</h2>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Tanggal: <span id="tanggalDisplay"
                            class="font-semibold text-gray-900">-</span></p>
                    <p class="text-sm text-gray-500 mt-1">Total Siswa: <span id="totalSiswa"
                            class="font-semibold text-gray-900">0</span></p>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                <p class="text-sm text-blue-600 font-medium mb-1">Total</p>
                <p class="text-2xl font-bold text-blue-900" id="statTotal">0</p>
            </div>
            <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                <p class="text-sm text-green-600 font-medium mb-1">Hadir</p>
                <p class="text-2xl font-bold text-green-900" id="statHadir">0</p>
            </div>
            <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
                <p class="text-sm text-yellow-600 font-medium mb-1">Izin/Sakit</p>
                <p class="text-2xl font-bold text-yellow-900" id="statIzin">0</p>
            </div>
            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                <p class="text-sm text-red-600 font-medium mb-1">Alpa</p>
                <p class="text-2xl font-bold text-red-900" id="statAlpa">0</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="flex gap-3 mb-6">
            <button onclick="markAllPresent()"
                class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all">
                <i class="fas fa-check mr-2"></i> Tandai Semua Hadir
            </button>
            <input type="text" id="searchInput" placeholder="Cari siswa..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        <!-- Student Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama Siswa</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">NIS</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Kehadiran</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Nilai</th>
                        </tr>
                    </thead>
                    <tbody id="studentList" class="divide-y divide-gray-100">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <button onclick="saveAbsensi()"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
                <i class="fas fa-save mr-2"></i> Simpan Absensi
            </button>
            <a href="{{ route('absensi.index') }}"
                class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:border-blue-500 hover:text-blue-600 transition-all text-center">
                <i class="fas fa-undo mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full text-center shadow-2xl">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-3xl text-green-600"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Berhasil!</h3>
            <p class="text-gray-600 mb-6">Data absensi telah tersimpan dengan aman</p>
            <button onclick="window.location.href='{{ route('absensi.index') }}'"
                class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
                Tutup
            </button>
        </div>
    </div>

    <script>
        // Data storage
        let formData = {
            tanggal: null,
            kelas_id: null,
            mapel_id: null,
            jampel_id: null
        };
        let students = [];
        let attendance = {};
        let nilai = {};

        // Mapping guru_mapel untuk filter mapel per kelas
        const guruMapel = {!! json_encode(
            \App\Models\GuruMapel::where('guru_id', \App\Models\Guru::where('users_id', auth()->id())->first()?->id)->get(['kelas_id', 'mapel_id'])->groupBy('kelas_id')->map(fn($items) => $items->pluck('mapel_id')->toArray())->toArray(),
        ) !!};

        // Set today as default date
        document.getElementById('tanggal').valueAsDate = new Date();

        // Event Listeners
        document.getElementById('tanggal').addEventListener('change', validateForm);
        document.getElementById('kelas_id').addEventListener('change', handleKelasChange);
        document.getElementById('mapel_id').addEventListener('change', validateForm);
        document.getElementById('jampel_id').addEventListener('change', validateForm);
        document.getElementById('searchInput').addEventListener('input', filterStudents);

        function handleKelasChange() {
            const kelasId = document.getElementById('kelas_id').value;
            const mapelSelect = document.getElementById('mapel_id');

            // Reset mapel selection
            mapelSelect.value = '';

            // Filter mapel options berdasarkan kelas
            const options = mapelSelect.querySelectorAll('option');
            options.forEach(opt => {
                if (opt.value === '') {
                    opt.style.display = '';
                } else {
                    // Tampilkan hanya mapel yang diajar di kelas ini
                    const isAllowed = guruMapel[kelasId] && guruMapel[kelasId].includes(parseInt(opt.value));
                    opt.style.display = isAllowed ? '' : 'none';
                }
            });

            validateForm();
        }

        function validateForm() {
            formData.tanggal = document.getElementById('tanggal').value;
            formData.kelas_id = document.getElementById('kelas_id').value;
            formData.mapel_id = document.getElementById('mapel_id').value;
            formData.jampel_id = document.getElementById('jampel_id').value;

            const isValid = formData.tanggal && formData.kelas_id && formData.mapel_id && formData.jampel_id;
            document.getElementById('btnLanjut').disabled = !isValid;
        }

        function loadStudents() {
            if (!formData.kelas_id) {
                alert('Pilih kelas terlebih dahulu');
                return;
            }

            // Show loading state
            const btnLanjut = document.getElementById('btnLanjut');
            btnLanjut.disabled = true;
            btnLanjut.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memuat...';

            fetch(`/absensi/siswa/${formData.kelas_id}`)
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(err => {
                            throw new Error(err.error || `HTTP Error: ${res.status}`);
                        });
                    }
                    return res.json();
                })
                .then(data => {
                    students = data;
                    attendance = {};
                    nilai = {};
                    students.forEach(s => {
                        attendance[s.id] = 'hadir';
                        nilai[s.id] = {
                            jenis: '',
                            nilai: ''
                        };
                    });
                    renderStudents();
                    updateStats();
                    document.getElementById('studentSection').classList.remove('hidden');
                    document.getElementById('mapelName').textContent = document.getElementById('mapel_id').options[
                        document.getElementById('mapel_id').selectedIndex].text;
                    document.getElementById('tanggalDisplay').textContent = formData.tanggal;
                    document.getElementById('totalSiswa').textContent = students.length;
                })
                .catch(err => {
                    console.error('Error loading students:', err);
                    alert('Gagal memuat siswa: ' + err.message);
                })
                .finally(() => {
                    // Reset button state
                    btnLanjut.disabled = false;
                    btnLanjut.innerHTML = 'Lanjutkan';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const kelasId = "{{ $selectedKelas ?? '' }}";
            const tanggal = "{{ $selectedTanggal ?? now()->format('Y-m-d') }}";

            if (kelasId && tanggal) {
                document.getElementById('kelas_id').value = kelasId;
                document.getElementById('tanggal').value = tanggal;

                // Trigger change event to populate mapel options
                handleKelasChange();

                // If mapel is also selected, load students
                const mapelId = "{{ $selectedMapel ?? '' }}";
                if (mapelId) {
                    document.getElementById('mapel_id').value = mapelId;
                    validateForm();

                    // Auto load students if all required fields are filled
                    if (kelasId && mapelId && tanggal) {
                        setTimeout(() => {
                            loadStudents();
                        }, 500);
                    }
                }
            }
        });

        function renderStudents() {
            const list = document.getElementById('studentList');
            list.innerHTML = '';

            students.forEach((student, idx) => {
                const row = document.createElement('tr');
                row.className = 'student-row';
                row.dataset.search = student.nama_siswa.toLowerCase();
                row.innerHTML = `
                <td class="px-6 py-4 text-sm text-gray-900">${idx + 1}</td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">${student.nama_siswa}</td>
                <td class="px-6 py-4 text-sm text-gray-500 text-center">${student.nis}</td>
                <td class="px-6 py-4 text-center">
                    <select onchange="updateAttendance(${student.id}, this.value)" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm">
                        <option value="hadir" selected>Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center space-x-2">
                        <input type="text"
                               id="jenis-nilai-${student.id}"
                               placeholder="Jenis nilai"
                               class="w-24 px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm"
                               onchange="updateJenisNilai(${student.id}, this.value)">
                        <input type="number"
                               id="nilai-${student.id}"
                               min="0"
                               max="100"
                               class="w-16 px-3 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-sm"
                               placeholder="0-100"
                               onchange="updateNilai(${student.id}, this.value)">
                        <button onclick="saveNilai(${student.id})"
                                class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-all">
                            Simpan
                        </button>
                    </div>
                </td>
            `;
                list.appendChild(row);
            });
        }

        function updateAttendance(studentId, status) {
            attendance[studentId] = status;
            updateStats();
        }

        function updateNilai(studentId, value) {
            if (!nilai[studentId]) {
                nilai[studentId] = {
                    jenis: '',
                    nilai: ''
                };
            }
            nilai[studentId].nilai = value;
        }

        function updateJenisNilai(studentId, value) {
            if (!nilai[studentId]) {
                nilai[studentId] = {
                    jenis: '',
                    nilai: ''
                };
            }
            nilai[studentId].jenis = value;
        }

        function updateStats() {
            let hadir = 0,
                sakit = 0,
                izin = 0,
                alpha = 0;
            Object.values(attendance).forEach(status => {
                if (status === 'hadir') hadir++;
                else if (status === 'sakit') sakit++;
                else if (status === 'izin') izin++;
                else if (status === 'alpha') alpha++;
            });

            document.getElementById('statTotal').textContent = students.length;
            document.getElementById('statHadir').textContent = hadir;
            document.getElementById('statIzin').textContent = sakit + izin;
            document.getElementById('statAlpa').textContent = alpha;
        }

        function markAllPresent() {
            students.forEach(s => {
                attendance[s.id] = 'hadir';
                document.querySelector(`select[onchange*="${s.id}"]`).value = 'hadir';
            });
            updateStats();
        }

        function filterStudents() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('.student-row').forEach(row => {
                row.style.display = row.dataset.search.includes(search) ? '' : 'none';
            });
        }

        function saveNilai(studentId) {
            if (!nilai[studentId] || !nilai[studentId].nilai || !nilai[studentId].jenis) {
                alert('Silakan lengkapi jenis dan nilai terlebih dahulu');
                return;
            }

            const data = {
                siswa_id: studentId,
                kelas_id: parseInt(formData.kelas_id),
                mapel_id: parseInt(formData.mapel_id),
                jenis: nilai[studentId].jenis,
                nilai: parseInt(nilai[studentId].nilai),
                keterangan: null
            };

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            // Show loading state on button
            const saveBtn = event.target;
            const originalText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('/nilai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(err => {
                            throw new Error(err.message || `HTTP Error: ${res.status}`);
                        });
                    }
                    return res.json();
                })
                .then(result => {
                    // Show success message
                    const toast = document.createElement('div');
                    toast.className =
                        'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    toast.textContent = 'Nilai berhasil disimpan!';
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Gagal menyimpan nilai: ' + err.message);
                })
                .finally(() => {
                    // Reset button state
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                });
        }

        function saveAbsensi() {
            const data = {
                kelas_id: parseInt(formData.kelas_id),
                mapel_id: parseInt(formData.mapel_id),
                jampel_id: parseInt(formData.jampel_id),
                tanggal: formData.tanggal,
                pertemuan: 0,
                absensi: Object.keys(attendance).map(siswa_id => ({
                    siswa_id: parseInt(siswa_id),
                    status: attendance[siswa_id]
                }))
            };

            if (data.absensi.length === 0) {
                alert('Tidak ada siswa untuk diproses');
                return;
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                alert('CSRF token tidak ditemukan. Silakan refresh halaman.');
                return;
            }

            // Show loading state
            const saveBtn = event.target;
            const originalText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

            fetch('/absensi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => {
                    // Handle non-JSON responses (like HTML error pages)
                    const contentType = res.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return res.text().then(text => {
                            throw new Error(`Server mengembalikan respons non-JSON: ${text.substring(0, 100)}`);
                        });
                    }

                    return res.json().then(data => {
                        if (!res.ok) {
                            throw new Error(data.message || `HTTP Error: ${res.status}`);
                        }
                        return data;
                    });
                })
                .then(result => {
                    if (result.success) {
                        document.getElementById('successModal').classList.remove('hidden');
                        setTimeout(() => window.location.href = '{{ route('absensi.index') }}', 2000);
                    } else {
                        throw new Error(result.message || 'Gagal menyimpan data absensi');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Gagal menyimpan: ' + err.message);
                })
                .finally(() => {
                    // Reset button state
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                });
        }
    </script>
@endsection
