<!-- Modal Detail Agenda -->
<div id="agendaDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
    <div class="relative mx-auto p-0 w-11/12 md:w-4/5 lg:w-3/4 max-w-5xl shadow-2xl rounded-2xl bg-white overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Detail Agenda Mengajar</h3>
                    <p class="text-blue-100 mt-1">Informasi lengkap agenda pembelajaran</p>
                </div>
                <button type="button" onclick="closeDetailModal()" class="text-white hover:text-blue-200 transition-colors p-2 rounded-full hover:bg-white/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-8">
            <!-- Loading State -->
            <div id="detailLoading" class="hidden text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-700 font-medium">Memuat data agenda...</p>
                <p class="text-sm text-gray-500 mt-1">Mohon tunggu sebentar</p>
            </div>

            <!-- Content -->
            <div id="detailContent" class="hidden">
                <!-- Grid Layout untuk Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <!-- Card Informasi Umum -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                                <h4 class="font-semibold text-blue-900 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    Informasi Umum
                                </h4>
                            </div>
                            <div class="p-6">
                                <dl class="space-y-4">
                                    <div class="flex items-start">
                                        <dt class="w-36 text-sm font-medium text-gray-600 flex-shrink-0">Tanggal:</dt>
                                        <dd class="text-sm text-gray-900 font-medium" id="detailTanggal">-</dd>
                                    </div>
                                    <div class="flex items-start">
                                        <dt class="w-36 text-sm font-medium text-gray-600 flex-shrink-0">Jam Pelajaran:</dt>
                                        <dd class="text-sm text-gray-900 font-medium" id="detailJam">-</dd>
                                    </div>
                                    <div class="flex items-start">
                                        <dt class="w-36 text-sm font-medium text-gray-600 flex-shrink-0">Kelas:</dt>
                                        <dd class="text-sm text-gray-900 font-medium" id="detailKelas">-</dd>
                                    </div>
                                    <div class="flex items-start">
                                        <dt class="w-36 text-sm font-medium text-gray-600 flex-shrink-0">Mata Pelajaran:</dt>
                                        <dd class="text-sm text-gray-900 font-medium" id="detailMapel">-</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Card Materi Pembelajaran -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                                <h4 class="font-semibold text-purple-900 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    Materi Pembelajaran
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                                    <p class="text-sm text-gray-800" id="detailMateri">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Siswa Tidak Hadir -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-b border-red-200">
                                <h4 class="font-semibold text-red-900 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    Siswa Tidak Hadir
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 max-h-60 overflow-y-auto">
                                    <div id="siswaTidakHadirContainer">
                                        <p class="text-sm text-gray-500">Memuat data...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Card Kegiatan Pembelajaran -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-4 border-b border-green-200">
                                <h4 class="font-semibold text-green-900 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-green-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                    Kegiatan Pembelajaran
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="bg-green-50 rounded-lg p-4 h-40 overflow-y-auto border border-green-100">
                                    <p class="text-sm text-gray-800 whitespace-pre-line" id="detailKegiatan">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Catatan -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 px-6 py-4 border-b border-yellow-200">
                                <h4 class="font-semibold text-yellow-900 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    Catatan
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-800 whitespace-pre-line" id="detailCatatan">Tidak ada catatan</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Tanda Tangan -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 px-6 py-4 border-b border-indigo-200">
                                <h4 class="font-semibold text-indigo-900 flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </div>
                                    Tanda Tangan Digital
                                </h4>
                            </div>
                            <div class="p-6">
                                <div class="bg-white border-2 border-gray-300 rounded-lg p-4 flex justify-center">
                                    <img id="detailTtd" src="" alt="Tanda Tangan" class="max-h-20">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timestamp -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-center">
                    <div class="flex items-center text-sm text-gray-500 bg-gray-50 px-4 py-2 rounded-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Dibuat pada: <span id="detailCreated" class="ml-1 font-medium">-</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-end space-x-3">
            <button type="button" onclick="closeDetailModal()"
                class="px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                Tutup
            </button>
            <button type="button" onclick="editAgenda()"
                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </button>
        </div>
    </div>
</div>

<!-- Hidden input untuk menyimpan ID agenda -->
<input type="hidden" id="detailAgendaId" value="">

@push('script')
    <script>
        // Fungsi untuk menampilkan detail agenda
        function showAgendaDetail(agendaId) {
            console.log('Opening agenda detail for ID:', agendaId);

            // Simpan ID agenda
            document.getElementById('detailAgendaId').value = agendaId;

            // Reset modal state
            document.getElementById('detailLoading').classList.remove('hidden');
            document.getElementById('detailContent').classList.add('hidden');

            // Tampilkan modal dengan animasi
            const modal = document.getElementById('agendaDetailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Tambahkan animasi fade-in
            setTimeout(() => {
                modal.querySelector('.relative').classList.add('animate-fadeIn');
            }, 10);

            // Fetch data dari server
            const url = `/agenda/${agendaId}/detail`;
            console.log('Fetching from URL:', url);

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Server error');
                        });
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    // Sembunyikan loading
                    document.getElementById('detailLoading').classList.add('hidden');
                    document.getElementById('detailContent').classList.remove('hidden');

                    // Isi data ke modal
                    document.getElementById('detailTanggal').textContent = data.tanggal;
                    document.getElementById('detailJam').textContent = data.jam;
                    document.getElementById('detailKelas').textContent = data.kelas;
                    document.getElementById('detailMapel').textContent = data.mata_pelajaran;
                    document.getElementById('detailMateri').textContent = data.materi;
                    document.getElementById('detailKegiatan').textContent = data.kegiatan;
                    document.getElementById('detailCatatan').textContent = data.catatan;
                    document.getElementById('detailTtd').src = data.tanda_tangan;
                    document.getElementById('detailCreated').textContent = data.created_at;

                    // Tampilkan siswa tidak hadir
                    renderSiswaTidakHadir(data.siswa_tidak_hadir, data.ada_absensi_hari_ini);
                })
                .catch(error => {
                    console.error('Fetch error:', error);

                    // Sembunyikan loading
                    document.getElementById('detailLoading').classList.add('hidden');

                    // Tampilkan pesan error
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'bg-red-50 border border-red-200 text-red-800 rounded-xl p-6 mb-4';
                    errorDiv.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-red-800">Gagal memuat data</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>${error.message}</p>
                                    <p class="mt-2">Silakan coba lagi atau hubungi administrator.</p>
                                </div>
                                <div class="mt-4 flex space-x-3">
                                    <button onclick="closeDetailModal()" class="px-4 py-2 bg-red-100 text-red-800 rounded-lg text-sm hover:bg-red-200 transition-colors font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tutup
                                    </button>
                                    <button onclick="retryFetch(${agendaId})" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm hover:bg-blue-200 transition-colors font-medium">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Coba Lagi
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    // Kosongkan content dan tambahkan error
                    const contentDiv = document.getElementById('detailContent');
                    contentDiv.innerHTML = '';
                    contentDiv.appendChild(errorDiv);
                    contentDiv.classList.remove('hidden');
                });
        }

        // Fungsi untuk menampilkan siswa tidak hadir
        function renderSiswaTidakHadir(siswaList, adaAbsensi) {
            const container = document.getElementById('siswaTidakHadirContainer');

            if (siswaList.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-4">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Tidak ada siswa di kelas ini</p>
                    </div>
                `;
                return;
            }

            let html = '';

            // Jika belum ada absensi hari ini, tampilkan tombol untuk input absensi
            if (!adaAbsensi) {
                html += `
                    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-yellow-800 font-medium">Belum ada data absensi hari ini</p>
                                <p class="text-xs text-yellow-700 mt-1">Input absensi untuk melihat data siswa tidak hadir</p>
                                <button onclick="inputAbsensiHariIni()" class="mt-3 px-4 py-2 bg-yellow-600 text-white text-sm rounded-lg hover:bg-yellow-700 transition-colors font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Input Absensi Hari Ini
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }

            html += '<div class="space-y-3">';
            siswaList.forEach(siswa => {
                // Tentukan warna badge berdasarkan status
                let badgeClass = '';
                let statusText = '';
                let statusIcon = '';

                switch (siswa.status) {
                    case 'sakit':
                        badgeClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        statusText = 'Sakit';
                        statusIcon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
                        break;
                    case 'izin':
                        badgeClass = 'bg-blue-100 text-blue-800 border-blue-200';
                        statusText = 'Izin';
                        statusIcon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        break;
                    case 'alpha':
                        badgeClass = 'bg-red-100 text-red-800 border-red-200';
                        statusText = 'Alpha';
                        statusIcon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        break;
                    case 'belum_input':
                        badgeClass = 'bg-gray-100 text-gray-800 border-gray-200';
                        statusText = 'Belum Input';
                        statusIcon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                        break;
                }

                html += `
                    <div class="p-4 bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900">${siswa.nama}</p>
                                <p class="text-xs text-gray-500">NIS: ${siswa.nis}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ${badgeClass}">
                                ${statusIcon}${statusText}
                            </span>
                        </div>
                        <div class="mt-2 text-xs">
                            <span class="text-gray-500">Mapel: </span>
                            <span class="font-medium">${siswa.mapel}</span>
                        </div>
                        ${siswa.keterangan && siswa.keterangan !== '-' ? `
                            <div class="mt-2 p-2 bg-gray-50 rounded text-xs">
                                <span class="text-gray-500">Keterangan: </span>
                                <span class="font-medium text-gray-700">${siswa.keterangan}</span>
                            </div>
                        ` : ''}
                    </div>
                `;
            });
            html += '</div>';

            container.innerHTML = html;
        }

        // Fungsi untuk input absensi hari ini
        function inputAbsensiHariIni() {
            const agendaId = document.getElementById('detailAgendaId').value;

            // Ambil data agenda untuk mendapatkan kelas_id
            fetch(`/agenda/${agendaId}/detail`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    // Redirect ke halaman absensi dengan parameter kelas dan tanggal hari ini
                    window.location.href =
                        `/absensi?kelas_id=${data.kelas_id}&tanggal=${new Date().toISOString().split('T')[0]}`;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data agenda: ' + error.message);
                });
        }

        // Fungsi untuk mencoba kembali fetch
        function retryFetch(agendaId) {
            closeDetailModal();
            setTimeout(() => {
                showAgendaDetail(agendaId);
            }, 300);
        }

        // Fungsi untuk menutup modal
        function closeDetailModal() {
            const modal = document.getElementById('agendaDetailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Fungsi untuk edit agenda
        function editAgenda() {
            const agendaId = document.getElementById('detailAgendaId').value;
            if (agendaId) {
                window.location.href = `/agenda/${agendaId}/edit`;
            }
        }

        // Tambahkan event listener untuk menutup modal saat klik di luar
        window.onclick = function(event) {
            const modal = document.getElementById('agendaDetailModal');
            if (event.target == modal) {
                closeDetailModal();
            }
        }

        // Tambahkan animasi CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush
