<!-- Modal Detail Agenda -->
<div id="agendaDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Detail Agenda Mengajar</h3>
            <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="mt-4">
            <!-- Loading State -->
            <div id="detailLoading" class="hidden text-center py-8">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500">
                </div>
                <p class="mt-3 text-gray-600">Memuat data agenda...</p>
                <p class="text-xs text-gray-500 mt-1">Mohon tunggu sebentar</p>
            </div>

            <!-- Content -->
            <div id="detailContent" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <!-- Informasi Umum -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-800 mb-3 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Umum
                        </h4>
                        <dl class="space-y-2">
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-600">Tanggal:</dt>
                                <dd class="text-sm text-gray-900" id="detailTanggal">-</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-600">Jam Pelajaran:</dt>
                                <dd class="text-sm text-gray-900" id="detailJam">-</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-600">Kelas:</dt>
                                <dd class="text-sm text-gray-900" id="detailKelas">-</dd>
                            </div>
                            <div class="flex">
                                <dt class="w-32 text-sm font-medium text-gray-600">Mata Pelajaran:</dt>
                                <dd class="text-sm text-gray-900" id="detailMapel">-</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Materi Pembelajaran -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-book-open mr-2 text-blue-600"></i>Materi Pembelajaran
                        </h4>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-sm text-gray-800" id="detailMateri">-</p>
                        </div>
                    </div>

                    <!-- Siswa Tidak Hadir -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-user-times mr-2 text-red-600"></i>Siswa Tidak Hadir
                        </h4>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 max-h-40 overflow-y-auto">
                            <div id="siswaTidakHadirContainer">
                                <p class="text-sm text-gray-500">Memuat data...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <!-- Kegiatan Pembelajaran -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-tasks mr-2 text-blue-600"></i>Kegiatan Pembelajaran
                        </h4>
                        <div class="bg-gray-50 rounded-lg p-3 h-32 overflow-y-auto">
                            <p class="text-sm text-gray-800 whitespace-pre-line" id="detailKegiatan">-</p>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-sticky-note mr-2 text-blue-600"></i>Catatan
                        </h4>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-sm text-gray-800 whitespace-pre-line" id="detailCatatan">Tidak ada catatan
                            </p>
                        </div>
                    </div>

                    <!-- Tanda Tangan -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-signature mr-2 text-blue-600"></i>Tanda Tangan Digital
                        </h4>
                        <div class="bg-white border border-gray-300 rounded-lg p-3 flex justify-center">
                            <img id="detailTtd" src="" alt="Tanda Tangan" class="max-h-20">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timestamp -->
            <div class="mt-4 pt-4 border-t text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Dibuat pada: <span id="detailCreated">-</span>
                </p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeDetailModal()"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                Tutup
            </button>
            <button type="button" onclick="editAgenda()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
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

            // Tampilkan modal
            document.getElementById('agendaDetailModal').classList.remove('hidden');

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
                    errorDiv.className = 'bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-4';
                    errorDiv.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-600"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Gagal memuat data</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>${error.message}</p>
                                    <p class="mt-2">Silakan coba lagi atau hubungi administrator.</p>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    <button onclick="closeDetailModal()" class="px-3 py-1 bg-red-100 text-red-800 rounded text-sm hover:bg-red-200">
                                        <i class="fas fa-times mr-1"></i> Tutup
                                    </button>
                                    <button onclick="retryFetch(${agendaId})" class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-sm hover:bg-blue-200">
                                        <i class="fas fa-redo mr-1"></i> Coba Lagi
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
                container.innerHTML = '<p class="text-sm text-gray-500">Tidak ada siswa di kelas ini</p>';
                return;
            }

            let html = '';

            // Jika belum ada absensi hari ini, tampilkan tombol untuk input absensi
            if (!adaAbsensi) {
                html += `
            <div class="mb-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800 mb-2">Belum ada data absensi hari ini</p>
                <button onclick="inputAbsensiHariIni()" class="px-3 py-1 bg-yellow-600 text-white text-sm rounded hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-plus-circle mr-1"></i> Input Absensi Hari Ini
                </button>
            </div>
        `;
            }

            html += '<ul class="space-y-2">';
            siswaList.forEach(siswa => {
                // Tentukan warna badge berdasarkan status
                let badgeClass = '';
                let statusText = '';

                switch (siswa.status) {
                    case 'sakit':
                        badgeClass = 'bg-yellow-100 text-yellow-800';
                        statusText = 'Sakit';
                        break;
                    case 'izin':
                        badgeClass = 'bg-blue-100 text-blue-800';
                        statusText = 'Izin';
                        break;
                    case 'alpha':
                        badgeClass = 'bg-red-100 text-red-800';
                        statusText = 'Alpha';
                        break;
                    case 'belum_input':
                        badgeClass = 'bg-gray-100 text-gray-800';
                        statusText = 'Belum Input';
                        break;
                }

                html += `
            <li class="py-2 border-b border-gray-100 last:border-0">
                <div class="flex justify-between items-start mb-1">
                    <div>
                        <p class="font-medium text-gray-900">${siswa.nama}</p>
                        <p class="text-xs text-gray-500">${siswa.nis}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full ${badgeClass}">${statusText}</span>
                </div>
                <div class="mt-1 text-xs">
                    <span class="text-gray-500">Mapel: </span>
                    <span class="font-medium">${siswa.mapel}</span>
                </div>
                ${siswa.keterangan && siswa.keterangan !== '-' ? `
                        <div class="mt-1 text-xs">
                            <span class="text-gray-500">Keterangan: </span>
                            <span class="font-medium text-gray-700">${siswa.keterangan}</span>
                        </div>
                    ` : ''}
            </li>
        `;
            });
            html += '</ul>';

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
            document.getElementById('agendaDetailModal').classList.add('hidden');
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
    </script>
@endpush
