@extends('layout.main')

@section('title', 'Input Agenda')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Input Agenda Mengajar</h1>
        <p class="text-gray-600 mt-1">Isi agenda pembelajaran harian Anda</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Form Input -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-200 mb-6">
                    <button type="button" id="agendaTab"
                        class="px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600 focus:outline-none">
                        <i class="fas fa-clipboard-list mr-2"></i>Agenda Mengajar
                    </button>
                    <!-- Kegiatan dipindah ke halaman terpisah -->
                </div>

                <!-- Agenda Form -->
                <form action="{{ route('agenda.store') }}" method="POST" id="agendaForm">
                    @csrf
                    <input type="hidden" name="tanda_tangan" id="tanda_tangan" value="">

                    <div class="space-y-6" id="agendaContent">
                        <!-- Tanggal & Waktu -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-calendar text-blue-600 mr-2"></i>Tanggal
                                </label>
                                <input type="date" name="tanggal"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-hourglass-start text-green-600 mr-2"></i>Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <select name="start_jampel_id" id="startJampelSelect"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none"
                                    required>
                                    <option value="">Pilih Jam Mulai</option>
                                    @foreach ($jampel as $item)
                                        <option value="{{ $item->id }}" data-hari="{{ $item->hari_tipe }}">
                                            Jam {{ $item->jam_ke }} - {{ $item->jam_mulai }} ({{ $item->nama_jam }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-hourglass-end text-red-600 mr-2"></i>Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <select name="end_jampel_id" id="endJampelSelect"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none"
                                    required>
                                    <option value="">Pilih Jam Selesai</option>
                                    @foreach ($jampel as $item)
                                        <option value="{{ $item->id }}" data-hari="{{ $item->hari_tipe }}">
                                            Jam {{ $item->jam_ke }} - {{ $item->jam_selesai }} ({{ $item->nama_jam }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Bagian pemilihan kelas dan mata pelajaran -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-users text-blue-600 mr-2"></i>Kelas <span class="text-red-500">*</span>
                                </label>
                                <select name="kelas_id" id="kelasSelect"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Pilih kelas terlebih dahulu untuk melihat mata
                                    pelajaran</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-book text-blue-600 mr-2"></i>Mata Pelajaran <span
                                        class="text-red-500">*</span>
                                </label>
                                <select name="mata_pelajaran_id" id="mapelSelect"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required disabled>
                                    <option value="">Pilih Kelas Terlebih Dahulu</option>
                                </select>
                                <input type="hidden" name="mata_pelajaran" id="mata_pelajaran_nama">
                                <input type="hidden" name="guru_id" id="guru_id">
                            </div>
                        </div>

                        <!-- Info Guru -->
                        <div id="guruInfo" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-900">Pengampu Mata Pelajaran</h3>
                                    <div class="mt-1 text-sm text-blue-700">
                                        <span id="guruNama">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Materi Pembelajaran -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>Materi Pembelajaran
                            </label>
                            <input type="text" name="materi" placeholder="contoh: Aljabar dan Persamaan Linear"
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required>
                        </div>

                        <!-- Kegiatan/Aktivitas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-tasks text-blue-600 mr-2"></i>Kegiatan/Aktivitas
                            </label>
                            <textarea name="kegiatan" rows="4" placeholder="Jelaskan kegiatan pembelajaran yang dilakukan..."
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none"
                                required></textarea>
                        </div>

                        <!-- Tanda Tangan Digital -->
                        @if (auth()->user()->hasRole('guru'))
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-signature text-blue-600 mr-2"></i>Tanda Tangan Digital
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                                    <div class="relative">
                                        <canvas id="signatureCanvas"
                                            class="bg-white border-2 border-gray-400 rounded-lg cursor-crosshair"
                                            width="600" height="250"
                                            style="width: 100%; height: 250px; display: block; background-color: white;">
                                        </canvas>
                                        <div id="canvasPlaceholder"
                                            class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <p class="text-gray-400 text-sm">Gambar tanda tangan di sini</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between mt-3">
                                        <button type="button" id="clearSignature"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                            <i class="fas fa-eraser mr-2"></i>Hapus
                                        </button>
                                        <div class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Tanda tangan di atas dengan mouse atau jari
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Minimal 50px lebar untuk tanda tangan yang valid
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Agenda yang Anda buat akan ditinjau dan ditandatangani oleh guru.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Catatan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Catatan Tambahan
                            </label>
                            <textarea name="catatan" rows="3" placeholder="Catatan khusus atau informasi tambahan (opsional)"
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Agenda
                            </button>
                            <button type="reset"
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-all flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Hari Ini</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clipboard-check text-blue-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Agenda Diisi</span>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">5</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Kelas Diajar</span>
                        </div>
                        <span class="text-2xl font-bold text-green-600">3</span>
                    </div>
                </div>
            </div>

            <!-- Recent Agenda -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Agenda Terbaru</h3>
                <div class="space-y-3">
                    @foreach ($recentAgendas as $agenda)
                        <div class="p-3 bg-blue-50 border-l-4 border-blue-600 rounded flex justify-between items-center">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $agenda->mata_pelajaran }} -
                                    {{ $agenda->kelas->nama_kelas }}</div>
                                @if($agenda->jampel)
                                    <div class="text-xs text-gray-600 mt-1">{{ $agenda->jampel->rentang_waktu }} -
                                        {{ $agenda->materi }}</div>
                                @elseif($agenda->startJampel && $agenda->endJampel)
                                    <div class="text-xs text-gray-600 mt-1">{{ $agenda->startJampel->jam_mulai }} - {{ $agenda->endJampel->jam_selesai }} -
                                        {{ $agenda->materi }}</div>
                                @else
                                    <div class="text-xs text-gray-600 mt-1">Waktu Fleksibel - {{ $agenda->materi }}</div>
                                @endif
                            </div>
                            <button onclick="showAgendaDetail({{ $agenda->id }})"
                                class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, initializing signature pad...');

                // Auto-populate jam mulai dan jam selesai
                const jampelSelect = document.getElementById('jampelSelect');
                const jamMulaiInput = document.getElementById('jamMulai');
                const jamSelesaiInput = document.getElementById('jamSelesai');

                // Inisialisasi variabel untuk tanda tangan
                const canvas = document.getElementById('signatureCanvas');
                const ctx = canvas.getContext('2d');
                const placeholder = document.getElementById('canvasPlaceholder');
                const clearBtn = document.getElementById('clearSignature');
                const form = document.getElementById('agendaForm');
                const signatureInput = document.getElementById('tanda_tangan');

                // Inisialisasi variabel untuk form
                const kelasSelect = document.getElementById('kelasSelect');
                const mapelSelect = document.getElementById('mapelSelect');
                const guruInfo = document.getElementById('guruInfo');
                const guruNama = document.getElementById('guruNama');
                const guruIdInput = document.getElementById('guru_id');
                const mapelNamaInput = document.getElementById('mata_pelajaran_nama');

                // Variabel untuk tanda tangan
                let isDrawing = false;
                let hasSignature = false;

                // Set canvas background
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Set drawing styles
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                // Fungsi untuk mendapatkan posisi mouse/touch
                function getPosition(e) {
                    const rect = canvas.getBoundingClientRect();
                    const scaleX = canvas.width / rect.width;
                    const scaleY = canvas.height / rect.height;

                    let clientX, clientY;

                    if (e.touches) {
                        clientX = e.touches[0].clientX;
                        clientY = e.touches[0].clientY;
                    } else {
                        clientX = e.clientX;
                        clientY = e.clientY;
                    }

                    return {
                        x: (clientX - rect.left) * scaleX,
                        y: (clientY - rect.top) * scaleY
                    };
                }

                // Fungsi untuk mulai menggambar
                function startDrawing(e) {
                    isDrawing = true;
                    hasSignature = true;

                    const pos = getPosition(e);
                    ctx.beginPath();
                    ctx.moveTo(pos.x, pos.y);

                    // Hide placeholder
                    placeholder.style.display = 'none';

                    e.preventDefault();
                }

                // Fungsi untuk menggambar
                function draw(e) {
                    if (!isDrawing) return;

                    const pos = getPosition(e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();

                    e.preventDefault();
                }

                // Fungsi untuk berhenti menggambar
                function stopDrawing(e) {
                    if (!isDrawing) return;

                    isDrawing = false;
                    ctx.closePath();

                    e.preventDefault();
                }

                // Event listeners untuk mouse
                canvas.addEventListener('mousedown', startDrawing);
                canvas.addEventListener('mousemove', draw);
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mouseout', stopDrawing);

                // Event listeners untuk touch
                canvas.addEventListener('touchstart', startDrawing);
                canvas.addEventListener('touchmove', draw);
                canvas.addEventListener('touchend', stopDrawing);
                canvas.addEventListener('touchcancel', stopDrawing);

                // Fungsi untuk menghapus tanda tangan
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Clear canvas
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    // Reset state
                    hasSignature = false;

                    // Show placeholder
                    placeholder.style.display = 'flex';

                    console.log('Signature cleared');
                });

                // Validasi form saat submit
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted, checking signature...');

                    // Only validate signature if user is guru
                    @if (auth()->user()->hasRole('guru'))
                        if (!hasSignature) {
                            e.preventDefault();
                            alert('Harap berikan tanda tangan digital terlebih dahulu!');
                            return false;
                        }

                        // Get signature data
                        const signatureData = canvas.toDataURL('image/png');
                        signatureInput.value = signatureData;

                        console.log('Signature captured, length:', signatureData.length);

                        if (signatureData.length < 50) {
                            e.preventDefault();
                            alert('Tanda tangan terlalu pendek. Silakan gambar tanda tangan yang lebih jelas.');
                            return false;
                        }
                    @endif

                    return true;
                });

                console.log('Signature pad initialized successfully');

                // Mapel/guru handling consolidated in the global script below

                // Tab switching functionality
                const agendaTab = document.getElementById('agendaTab');
                const kegiatanTab = document.getElementById('kegiatanTab');
                const agendaContent = document.getElementById('agendaContent');
                const kegiatanContent = document.getElementById('kegiatanContent');

                if (agendaTab && kegiatanTab) {
                    agendaTab.addEventListener('click', function() {
                        // Update tab styles
                        agendaTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                        agendaTab.classList.remove('text-gray-500');
                        kegiatanTab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                        kegiatanTab.classList.add('text-gray-500');

                        // Show/hide content
                        agendaContent.classList.remove('hidden');
                        kegiatanContent.classList.add('hidden');
                    });

                    kegiatanTab.addEventListener('click', function() {
                        // Update tab styles
                        kegiatanTab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
                        kegiatanTab.classList.remove('text-gray-500');
                        agendaTab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                        agendaTab.classList.add('text-gray-500');

                        // Show/hide content
                        kegiatanContent.classList.remove('hidden');
                        agendaContent.classList.add('hidden');
                    });
                }

                // Hari tab switching untuk kegiatan sebelum KBM
                const hariTabs = document.querySelectorAll('.hari-tab');
                const hariSelect = document.getElementById('hariSelect');

                if (hariTabs && hariSelect) {
                    hariTabs.forEach(tab => {
                        tab.addEventListener('click', function() {
                            const hari = this.getAttribute('data-hari');

                            // Update select value
                            hariSelect.value = hari;

                            // Update tab styles
                            hariTabs.forEach(t => {
                                t.classList.remove('border-blue-500', 'text-blue-600');
                                t.classList.add('border-transparent', 'text-gray-500');
                            });

                            this.classList.remove('border-transparent', 'text-gray-500');
                            this.classList.add('border-blue-500', 'text-blue-600');
                        });
                    });
                }
            });

            // ============================================
            // AUTO-POPULATE MAPEL DAN GURU (Support Multiple Guru)
            // ============================================
            const kelasSelect = document.getElementById('kelasSelect');
            const mapelSelect = document.getElementById('mapelSelect');
            const guruNamaDisplay = document.getElementById('guruNama');
            const guruInfoBox = document.getElementById('guruInfo');
            const guruIdInput = document.getElementById('guru_id');
            const mataPelajaranNamaInput = document.getElementById('mata_pelajaran_nama');

            // Store untuk mapel data (untuk get guru list nanti)
            let mapelData = {};

            // Ketika kelas dipilih, fetch mapel yang tersedia
            if (kelasSelect) {
                kelasSelect.addEventListener('change', async function() {
                    const kelasId = this.value;

                    // Reset mapel jika kelas tidak dipilih
                    if (!kelasId) {
                        mapelSelect.disabled = true;
                        mapelSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
                        guruInfoBox.classList.add('hidden');
                        guruIdInput.value = '';
                        mataPelajaranNamaInput.value = '';
                        mapelData = {};
                        return;
                    }

                    try {
                        // Fetch mapel dari server
                        const response = await fetch(`/agenda/get-mapel-by-kelas/${kelasId}`);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const mapels = await response.json();

                        // Populate mapel dropdown
                        mapelSelect.innerHTML = '<option value="">Pilih Mata Pelajaran</option>';
                        mapelData = {};

                        if (Array.isArray(mapels) && mapels.length > 0) {
                            mapels.forEach(mapel => {
                                const option = document.createElement('option');
                                option.value = mapel.id;

                                // Tampilkan nama guru(s)
                                let guruDisplay = mapel.gurus.map(g => g.guru_nama).join(', ');
                                option.textContent = `${mapel.nama} (Guru: ${guruDisplay})`;
                                option.dataset.mapelId = mapel.id;

                                mapelSelect.appendChild(option);
                                mapelData[mapel.id] = mapel;
                            });
                            mapelSelect.disabled = false;
                        } else {
                            mapelSelect.innerHTML =
                                '<option value="">Tidak ada mata pelajaran untuk kelas ini</option>';
                            mapelSelect.disabled = true;
                        }

                        // Reset guru info
                        guruInfoBox.classList.add('hidden');
                        guruIdInput.value = '';
                        mataPelajaranNamaInput.value = '';

                    } catch (error) {
                        console.error('Error fetching mapel:', error);
                        mapelSelect.innerHTML =
                            '<option value="">Terjadi kesalahan saat memuat mata pelajaran</option>';
                        mapelSelect.disabled = true;
                        alert('Terjadi kesalahan: ' + error.message);
                    }
                });

                // Ketika mapel dipilih, tampilkan opsi guru (jika ada multiple)
                mapelSelect.addEventListener('change', function() {
                    if (this.value && mapelData[this.value]) {
                        const mapel = mapelData[this.value];
                        mataPelajaranNamaInput.value = mapel.nama;

                        // Jika hanya ada 1 guru, auto-select
                        if (mapel.gurus.length === 1) {
                            guruIdInput.value = mapel.gurus[0].guru_id;
                            guruNamaDisplay.textContent = mapel.gurus[0].guru_nama;
                            guruInfoBox.classList.remove('hidden');
                        } else if (mapel.gurus.length > 1) {
                            // Jika ada multiple guru, tampilkan dropdown untuk pilih guru
                            showGuruSelectionModal(mapel);
                        }
                    } else {
                        guruIdInput.value = '';
                        mataPelajaranNamaInput.value = '';
                        guruInfoBox.classList.add('hidden');
                    }
                });
            }

            // Modal untuk pilih guru (jika ada multiple)
            function showGuruSelectionModal(mapel) {
                let guruOptions = mapel.gurus.map((g, idx) =>
                    `<label class="flex items-center mb-2 cursor-pointer">
                        <input type="radio" name="guru_selection" value="${g.guru_id}" class="mr-2">
                        <span>${g.guru_nama}</span>
                    </label>`
                ).join('');

                let modal = `
                <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="guruModal">
                    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Pilih Guru Pengampu Mata Pelajaran "${mapel.nama}"
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Ada ${mapel.gurus.length} guru yang mengajar mata pelajaran ini di kelas ini.
                        </p>
                        <div class="space-y-2 mb-6">
                            ${guruOptions}
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="closeGuruModal()" class="flex-1 px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400">
                                Batal
                            </button>
                            <button type="button" onclick="confirmGuruSelection()" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
                `;

                document.body.insertAdjacentHTML('beforeend', modal);
            }

            window.closeGuruModal = function() {
                const modal = document.getElementById('guruModal');
                if (modal) modal.remove();
                mapelSelect.value = '';
                guruIdInput.value = '';
                mataPelajaranNamaInput.value = '';
                guruInfoBox.classList.add('hidden');
            }

            window.confirmGuruSelection = function() {
                const selectedGuru = document.querySelector('input[name="guru_selection"]:checked');
                if (!selectedGuru) {
                    alert('Pilih guru terlebih dahulu');
                    return;
                }

                const guruId = selectedGuru.value;
                const mapelId = mapelSelect.value;
                const mapel = mapelData[mapelId];
                const selectedGuruName = mapel.gurus.find(g => g.guru_id == guruId).guru_nama;

                guruIdInput.value = guruId;
                guruNamaDisplay.textContent = selectedGuruName;
                guruInfoBox.classList.remove('hidden');

                const modal = document.getElementById('guruModal');
                if (modal) modal.remove();
            }

            // Functions for kegiatan sebelum KBM
            function editKegiatan(id) {
                // Implementation for edit functionality
                console.log('Edit kegiatan with ID:', id);
                // You can implement a modal or redirect to edit page
            }

            function deleteKegiatan(id) {
                if (confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) {
                    // Implementation for delete functionality
                    console.log('Delete kegiatan with ID:', id);
                    // You can implement AJAX call or form submission

                    // Example AJAX call:
                    fetch(`/kegiatan-sebelum-kbm/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                // Reload the page or remove the row from the table
                                location.reload();
                            } else {
                                alert('Gagal menghapus kegiatan');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menghapus kegiatan');
                        });
                }
            }

            // Function for showing agenda detail
            function showAgendaDetail(id) {
                // Implementation for showing agenda detail
                console.log('Show agenda detail with ID:', id);
                // You can implement a modal or redirect to detail page

                // Example redirect:
                window.location.href = `/agenda/${id}`;
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Fungsi untuk memfilter Jam Pelajaran berdasarkan tanggal
                function filterJamPelajaran(basedOnDate = null) {
                    const jampelSelect = document.querySelector('select[name="jampel_id"]');
                    if (!jampelSelect) return;

                    // Tentukan tanggal yang akan dicek (gunakan input tanggal atau hari ini)
                    const dateToCheck = basedOnDate ? new Date(basedOnDate) : new Date();
                    const dayOfWeek = dateToCheck.getDay(); // 0 = Minggu, 1 = Senin, dst.

                    // Mapping hari (JavaScript) ke tipe hari (Database)
                    let hariTipe;
                    switch (dayOfWeek) {
                        case 1: // Senin
                            hariTipe = 'senin';
                            break;
                        case 2: // Selasa
                        case 3: // Rabu
                        case 4: // Kamis
                            hariTipe = 'selasa_rabu_kamis';
                            break;
                        case 5: // Jumat
                            hariTipe = 'jumat';
                            break;
                        default: // Sabtu (6) & Minggu (0)
                            // Default ke jadwal Senin jika hari tidak ada di database
                            hariTipe = 'senin';
                            break;
                    }

                    // Dapatkan semua opsi jam pelajaran
                    const options = jampelSelect.querySelectorAll('option');

                    options.forEach(option => {
                        // Lewati opsi placeholder "Pilih Jam"
                        if (option.value === '') {
                            return;
                        }

                        const optionHariTipe = option.getAttribute('data-hari');

                        // Tampilkan opsi jika sesuai dengan hari, sembunyikan jika tidak
                        if (optionHariTipe === hariTipe) {
                            option.style.display = 'block';
                        } else {
                            option.style.display = 'none';
                        }
                    });

                    // Reset pilihan jika pilihan sebelumnya tidak lagi valid
                    if (jampelSelect.value && jampelSelect.querySelector(`option[value="${jampelSelect.value}"]`).style
                        .display === 'none') {
                        jampelSelect.value = '';
                    }
                }

                // Jalankan filter saat pertama kali halaman dimuat (berdasarkan hari ini)
                filterJamPelajaran();

                // Tambahkan event listener pada input tanggal
                // agar filter berjalan saat user mengganti tanggal
                const tanggalInput = document.querySelector('input[name="tanggal"]');
                if (tanggalInput) {
                    tanggalInput.addEventListener('change', function() {
                        filterJamPelajaran(this.value);
                    });
                }
            });
        </script>
    @endpush
@endsection
