@extends('layout.main')

@section('title', 'Input Agenda')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Minimalis -->
        <div class="mb-8">
            <h1 class="text-2xl font-light text-gray-900 tracking-tight">Input Agenda Mengajar</h1>
            <p class="text-sm text-gray-500 mt-1 font-light">Isi detail pembelajaran harian Anda di bawah ini.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Kolom Utama Form -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Kartu Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">

                    <!-- Pesan Error & Sukses (Desain Flat) -->
                    @if ($errors->any())
                        <div class="mb-8 p-4 bg-red-50 text-red-800 rounded-lg text-sm border border-red-100 flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="font-medium">Terjadi kesalahan pada input:</p>
                                <ul class="mt-1 list-disc list-inside opacity-90">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-8 p-4 bg-green-50 text-green-800 rounded-lg text-sm border border-green-100 flex items-center">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Tab Navigasi (Sederhana) -->
                    <div class="border-b border-gray-100 mb-8">
                        <button type="button" class="pb-3 text-sm font-medium text-gray-900 border-b-2 border-gray-900 focus:outline-none">
                            Agenda Mengajar
                        </button>
                    </div>

                    <!-- FORM START -->
                    <form action="{{ route('agenda.store') }}" method="POST" id="agendaForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan" value="">

                        <!-- Section: Waktu & Kelas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">

                            <!-- Tanggal -->
                            <div class="md:col-span-1">
                                <label for="tanggal" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                                <input type="date" name="tanggal"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all placeholder-gray-400"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <!-- Jam Mulai -->
                            <div>
                                <label for="startJampelSelect" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jam Mulai <span class="text-red-500">*</span></label>
                                <select name="start_jampel_id" id="startJampelSelect"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all cursor-pointer"
                                    required>
                                    <option value="">Pilih Jam Mulai</option>
                                    @foreach ($jampel as $item)
                                        <option value="{{ $item->id }}" data-hari="{{ $item->hari_tipe }}">
                                            Jam {{ $item->jam_ke }} - {{ $item->jam_mulai }} ({{ $item->nama_jam }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Jam Selesai -->
                            <div>
                                <label for="endJampelSelect" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jam Selesai <span class="text-red-500">*</span></label>
                                <select name="end_jampel_id" id="endJampelSelect"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all cursor-pointer"
                                    required>
                                    <option value="">Pilih Jam Selesai</option>
                                    @foreach ($jampel as $item)
                                        <option value="{{ $item->id }}" data-hari="{{ $item->hari_tipe }}">
                                            Jam {{ $item->jam_ke }} - {{ $item->jam_selesai }} ({{ $item->nama_jam }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kelas -->
                            <div>
                                <label for="kelasSelect" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kelas <span class="text-red-500">*</span></label>
                                <select name="kelas_id" id="kelasSelect"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all cursor-pointer"
                                    required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-400 mt-1.5 pl-1">Pilih kelas untuk memuat mata pelajaran.</p>
                            </div>

                            <!-- Mata Pelajaran -->
                            <div>
                                <label for="mapelSelect" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mata Pelajaran <span class="text-red-500">*</span></label>
                                <select name="mata_pelajaran_id" id="mapelSelect"
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all cursor-pointer"
                                    required disabled>
                                    <option value="">Pilih Kelas Terlebih Dahulu</option>
                                </select>
                                <input type="hidden" name="mata_pelajaran" id="mata_pelajaran_nama">
                                <input type="hidden" name="guru_id" id="guru_id">
                            </div>
                        </div>

                        <!-- Info Guru (Hidden by default) -->
                        <div id="guruInfo" class="hidden bg-gray-50 rounded-lg p-4 border border-gray-100 flex items-center">
                            <div class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 mr-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Pengampu Mata Pelajaran</p>
                                <p id="guruNama" class="text-sm text-gray-900 font-medium">-</p>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 my-6"></div>

                        <!-- Section: Detail Pembelajaran -->
                        <div class="space-y-6">
                            <!-- Materi -->
                            <div>
                                <label for="materi" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Materi Pembelajaran</label>
                                <input type="text" name="materi" placeholder="Contoh: Aljabar dan Persamaan Linear"
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all"
                                    required>
                            </div>

                            <!-- Kegiatan -->
                            <div>
                                <label for="kegiatan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kegiatan & Aktivitas</label>
                                <textarea name="kegiatan" rows="4" placeholder="Jelaskan kegiatan pembelajaran yang dilakukan..."
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all resize-none"
                                    required></textarea>
                            </div>
                        </div>

                        <!-- Tanda Tangan Digital (Conditional) -->
                        @if (auth()->user()->hasRole('guru'))
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanda Tangan Digital</label>
                                <div class="bg-gray-50 rounded-xl p-1 border border-gray-200">
                                    <div class="relative bg-white rounded-lg overflow-hidden" style="height: 250px;">
                                        <canvas id="signatureCanvas"
                                            class="cursor-crosshair w-full h-full touch-none"
                                            width="600" height="250"></canvas>
                                        <div id="canvasPlaceholder"
                                            class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            <p class="text-sm text-gray-400">Tanda tangan di area ini</p>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 flex justify-between items-center bg-gray-50/50 rounded-b-lg">
                                        <button type="button" id="clearSignature" class="text-xs text-gray-500 hover:text-red-500 transition-colors flex items-center font-medium">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-start text-sm text-gray-600">
                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p>Agenda yang Anda buat akan ditinjau dan ditandatangani oleh guru.</p>
                            </div>
                        @endif

                        <!-- Catatan Tambahan -->
                        <div>
                            <label for="catatan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan" rows="2" placeholder="Catatan khusus..."
                                class="block w-full px-4 py-3 bg-white border border-gray-200 text-gray-900 rounded-lg focus:ring-1 focus:ring-gray-900 focus:border-gray-900 outline-none transition-all resize-none"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-3.5 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition-all shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                Simpan Agenda
                            </button>
                            <button type="reset"
                                class="px-6 py-3.5 bg-white border border-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-50 hover:border-gray-300 transition-all focus:outline-none">
                                Batal
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Sidebar (Simplified) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Stats Card - Enhanced -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-6 border-b border-gray-100 pb-2">📊 Statistik Hari Ini</h3>

                    @php
                        $today = date('Y-m-d');
                        $userRole = auth()->user()->role;

                        // Hitung statistik berdasarkan role
                        if ($userRole === 'guru' || $userRole === 'walikelas') {
                            // Untuk guru/walikelas
                            $guru = auth()->user()->guru;
                            if ($guru) {
                                $kelasIds = \App\Models\GuruMapel::where('guru_id', $guru->id)
                                    ->pluck('kelas_id')
                                    ->unique();

                                $agendaTodayCount = \App\Models\Agenda::whereIn('kelas_id', $kelasIds)
                                    ->where('tanggal', $today)
                                    ->count();

                                $kelasAmpuCount = $kelasIds->count();

                                $totalSiswaAmpus = \App\Models\Kelas::whereIn('id', $kelasIds)
                                    ->withCount('siswa')
                                    ->get()
                                    ->sum('siswa_count');
                            } else {
                                $agendaTodayCount = 0;
                                $kelasAmpuCount = 0;
                                $totalSiswaAmpus = 0;
                            }
                        } elseif ($userRole === 'sekretaris') {
                            // Untuk sekretaris
                            $agendaTodayCount = \App\Models\Agenda::where('tanggal', $today)->count();
                            $kelasAmpuCount = \App\Models\Kelas::count();
                            $totalSiswaAmpus = \App\Models\Siswa::count();
                        } else {
                            // Default (siswa atau role lainnya)
                            $agendaTodayCount = \App\Models\Agenda::where('users_id', auth()->id())
                                ->where('tanggal', $today)
                                ->count();
                            $kelasAmpuCount = 0;
                            $totalSiswaAmpus = 0;
                        }
                    @endphp

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Card 1: Agenda Hari Ini -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Agenda Diisi</p>
                                    <p class="text-2xl font-bold text-blue-900 mt-1">{{ $agendaTodayCount }}</p>
                                    <p class="text-xs text-blue-600 mt-2">hari ini</p>
                                </div>
                                <div class="text-3xl">📝</div>
                            </div>
                        </div>

                        <!-- Card 2: Kelas Diajar/Total Kelas -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide">
                                        {{ $userRole === 'sekretaris' ? 'Total Kelas' : 'Kelas Diampu' }}
                                    </p>
                                    <p class="text-2xl font-bold text-purple-900 mt-1">{{ $kelasAmpuCount }}</p>
                                    <p class="text-xs text-purple-600 mt-2">
                                        {{ $userRole === 'sekretaris' ? 'aktif' : 'semester ini' }}
                                    </p>
                                </div>
                                <div class="text-3xl">👥</div>
                            </div>
                        </div>

                        <!-- Card 3: Total Siswa -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-green-600 uppercase tracking-wide">
                                        {{ $userRole === 'sekretaris' ? 'Total Siswa' : 'Siswa Diampu' }}
                                    </p>
                                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $totalSiswaAmpus }}</p>
                                    <p class="text-xs text-green-600 mt-2">
                                        {{ $userRole === 'sekretaris' ? 'sekolah' : 'di kelas' }}
                                    </p>
                                </div>
                                <div class="text-3xl">🎓</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tips</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Pastikan data kelas dan mata pelajaran sesuai dengan jadwal pengajaran hari ini untuk memudahkan penginputan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT: LOGIC TIDAK DIUBAH -->
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
                const startJampelSelect = document.getElementById('startJampelSelect');
                const endJampelSelect = document.getElementById('endJampelSelect');
                const guruInfo = document.getElementById('guruInfo');
                const guruNama = document.getElementById('guruNama');
                const guruIdInput = document.getElementById('guru_id');
                const mapelNamaInput = document.getElementById('mata_pelajaran_nama');

                // Variabel untuk tanda tangan
                let isDrawing = false;
                let hasSignature = false;

                // ============================================
                // HELPER FUNCTIONS
                // ============================================
                function updateEndOptions() {
                    if (!startJampelSelect || !endJampelSelect) return;

                    const startVal = startJampelSelect.value;
                    const startOption = startJampelSelect.selectedOptions[0];

                    // Reset semua end options
                    Array.from(endJampelSelect.options).forEach(opt => {
                        opt.disabled = false;
                        opt.style.display = 'block';
                    });

                    if (!startVal || !startOption) return;

                    // Get start jam properties
                    const startHari = startOption.getAttribute('data-hari');
                    const startText = startOption.textContent;
                    let startJamKe = parseInt(startText.match(/Jam (\d+)/)?.[1] || 0);

                    // Filter end options
                    Array.from(endJampelSelect.options).forEach(opt => {
                        if (!opt.value) return;

                        const endHari = opt.getAttribute('data-hari');
                        const endText = opt.textContent;
                        let endJamKe = parseInt(endText.match(/Jam (\d+)/)?.[1] || 0);

                        if (startJamKe === 0 || endJamKe === 0) {
                            const startIdx = Array.from(startJampelSelect.options).indexOf(startOption);
                            const endIdx = Array.from(endJampelSelect.options).indexOf(opt);
                            opt.disabled = endHari !== startHari || endIdx < startIdx;
                        } else {
                            opt.disabled = endHari !== startHari || endJamKe < startJamKe;
                        }
                    });

                    const firstEnabledEnd = Array.from(endJampelSelect.options).find(opt => !opt.disabled && opt.value);
                    if (firstEnabledEnd) {
                        endJampelSelect.value = firstEnabledEnd.value;
                    }

                    console.log('End options updated');
                }

                function showErrorAlert(message) {
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'fixed top-4 right-4 bg-white border border-red-200 text-red-800 px-6 py-4 rounded-lg shadow-xl z-50 flex items-center animate-bounce';
                    alertDiv.innerHTML = `
                        <svg class="w-6 h-6 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">${message}</span>
                    `;
                    document.body.appendChild(alertDiv);
                    setTimeout(() => alertDiv.remove(), 4000);
                }

                // ============================================
                // AUTO-POPULATE DARI SCHEDULE (Jadwal-Saya)
                // ============================================
                const scheduleId = new URLSearchParams(window.location.search).get('schedule_id');
                if (scheduleId) {
                    console.log('Schedule ID detected:', scheduleId);
                    populateFromSchedule(scheduleId);
                }

                // Helper function untuk wait sampai mapel selesai di-load
                function waitForMapelLoad(kelasId) {
                    return new Promise((resolve) => {
                        let attempts = 0;
                        const maxAttempts = 30; // 30 * 100ms = 3 detik timeout

                        const checkMapel = () => {
                            attempts++;
                            // Cek apakah mapel sudah ter-populate dengan options > 1 (lebih dari "Pilih Mata Pelajaran")
                            if (mapelSelect.options.length > 1 && !mapelSelect.disabled) {
                                console.log('Mapel loaded successfully after', attempts * 100, 'ms');
                                resolve(true);
                            } else if (attempts >= maxAttempts) {
                                console.warn('Timeout waiting for mapel to load');
                                resolve(false);
                            } else {
                                setTimeout(checkMapel, 100);
                            }
                        };
                        checkMapel();
                    });
                }

                async function populateFromSchedule(scheduleId) {
                    try {
                        const response = await fetch(`/api/schedule-for-agenda/${scheduleId}`);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const result = await response.json();

                        if (result.success && result.data) {
                            const data = result.data;
                            console.log('Schedule data fetched:', data);

                            // Set tanggal ke hari ini
                            const today = new Date();
                            const year = today.getFullYear();
                            const month = String(today.getMonth() + 1).padStart(2, '0');
                            const day = String(today.getDate()).padStart(2, '0');
                            const todayString = `${year}-${month}-${day}`;

                            document.querySelector('input[name="tanggal"]').value = todayString;

                            // STEP 1: Set Kelas terlebih dahulu
                            console.log('Step 1: Setting kelas to:', data.kelas_id);
                            kelasSelect.value = data.kelas_id;
                            // Don't disable - disabled fields won't be submitted!

                            // STEP 2: Trigger kelas change event untuk load mapel
                            console.log('Step 2: Triggering kelas change event');
                            const changeEvent = new Event('change', { bubbles: true });
                            kelasSelect.dispatchEvent(changeEvent);

                            // STEP 3: Wait untuk mapel to load
                            console.log('Step 3: Waiting for mapel to load');
                            const mapelLoaded = await waitForMapelLoad(data.kelas_id);
                            if (!mapelLoaded) {
                                console.warn('Mapel failed to load within timeout');
                            }

                            console.log('Step 4: Setting mapel to:', data.mapel_id);
                            mapelSelect.value = data.mapel_id;
                            // Don't disable - disabled fields won't be submitted!

                            // Set guru info
                            guruIdInput.value = data.guru_id;
                            guruNama.textContent = data.guru_name;
                            guruInfo.classList.remove('hidden');
                            mapelNamaInput.value = data.mapel_name;

                            console.log('Step 5: Setting jam mulai to:', data.start_jampel_id);
                            startJampelSelect.value = data.start_jampel_id;
                            // Don't disable - disabled fields won't be submitted!

                            // STEP 6: Call updateEndOptions directly to update options
                            updateEndOptions();

                            // STEP 7: Set jam selesai
                            console.log('Step 7: Setting jam selesai to:', data.end_jampel_id);
                            endJampelSelect.value = data.end_jampel_id;
                            // Don't disable - disabled fields won't be submitted!

                            // Show success banner
                            showScheduleInfoBanner(data);

                            // STEP 8: Final validation
                            console.log('=== FINAL VALIDATION ===');
                            console.log('Kelas ID:', kelasSelect.value, '(expected:', data.kelas_id + ')');
                            console.log('Start Jampel ID:', startJampelSelect.value, '(expected:', data.start_jampel_id + ')');
                            console.log('End Jampel ID:', endJampelSelect.value, '(expected:', data.end_jampel_id + ')');
                            console.log('Guru ID:', guruIdInput.value, '(expected:', data.guru_id + ')');
                            console.log('Mapel ID:', mapelSelect.value, '(expected:', data.mapel_id + ')');
                            console.log('======================');
                        } else {
                            console.error('Failed to fetch schedule:', result.message);
                            showErrorBanner('Gagal memuat jadwal: ' + (result.message || 'Unknown error'));
                        }
                    } catch (error) {
                        console.error('Error fetching schedule:', error);
                        showErrorBanner('Terjadi kesalahan: ' + error.message);
                    }
                }

                function showScheduleInfoBanner(data) {
                    const banner = document.createElement('div');
                    banner.className = 'mb-8 p-4 bg-gray-50 border-l-4 border-gray-800 rounded-r-lg';
                    banner.innerHTML = `
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-gray-800 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Data Jadwal Dimuat Otomatis</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    <strong>${data.kelas_name}</strong> - ${data.mapel_name} dengan <strong>${data.guru_name}</strong>
                                    | Jam: ${data.start_jampel_name} s/d ${data.end_jampel_name}
                                </p>
                            </div>
                        </div>
                    `;

                    // Insert banner at top of form
                    const agendaContent = document.getElementById('agendaForm');
                    if (agendaContent) {
                        agendaContent.insertBefore(banner, agendaContent.firstChild);
                    }
                }

                function showErrorBanner(message) {
                    const banner = document.createElement('div');
                    banner.className = 'mb-8 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg';
                    banner.innerHTML = `
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-red-900">Error</p>
                                <p class="text-sm text-red-800 mt-1">${message}</p>
                            </div>
                        </div>
                    `;

                    const agendaContent = document.getElementById('agendaForm');
                    if (agendaContent) {
                        agendaContent.insertBefore(banner, agendaContent.firstChild);
                    }
                }

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
                    console.log('Form submitted, checking all validations...');

                    // Validasi field yang required
                    const startJampel = startJampelSelect.value;
                    const endJampel = endJampelSelect.value;
                    const kelas = kelasSelect.value;
                    const mapel = mapelSelect.value;
                    const guru = guruIdInput.value;
                    const materi = document.querySelector('input[name="materi"]').value;
                    const kegiatan = document.querySelector('textarea[name="kegiatan"]').value;

                    // Log detail untuk debugging
                    console.log('Field values:', {
                        startJampel: startJampel,
                        endJampel: endJampel,
                        kelas: kelas,
                        mapel: mapel,
                        guru: guru,
                        materi: materi,
                        kegiatan: kegiatan
                    });

                    if (!startJampel) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Jam Mulai harus diisi!');
                        console.error('Validation failed: startJampel is empty');
                        return false;
                    }

                    if (!endJampel) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Jam Selesai harus diisi!');
                        console.error('Validation failed: endJampel is empty');
                        return false;
                    }

                    if (!kelas) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Kelas harus dipilih!');
                        console.error('Validation failed: kelas is empty');
                        return false;
                    }

                    if (!mapel) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Mata Pelajaran harus dipilih!');
                        console.error('Validation failed: mapel is empty');
                        return false;
                    }

                    if (!guru) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Data Guru tidak valid!');
                        console.error('Validation failed: guru is empty');
                        return false;
                    }

                    if (!materi.trim()) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Materi Pembelajaran harus diisi!');
                        console.error('Validation failed: materi is empty');
                        return false;
                    }

                    if (!kegiatan.trim()) {
                        e.preventDefault();
                        showErrorAlert('⚠️ Kegiatan/Aktivitas harus diisi!');
                        console.error('Validation failed: kegiatan is empty');
                        return false;
                    }

                    console.log('Form data validation passed, checking signature...');

                    // Only validate signature if user is guru
                    @if (auth()->user()->hasRole('guru'))
                        if (!hasSignature) {
                            e.preventDefault();
                            showErrorAlert('⚠️ Harap berikan tanda tangan digital terlebih dahulu!');
                            return false;
                        }

                        // Get signature data
                        const signatureData = canvas.toDataURL('image/png');
                        signatureInput.value = signatureData;

                        console.log('Signature captured, length:', signatureData.length);

                        if (signatureData.length < 50) {
                            e.preventDefault();
                            showErrorAlert('⚠️ Tanda tangan terlalu pendek. Silakan gambar tanda tangan yang lebih jelas.');
                            return false;
                        }
                    @endif

                    console.log('All validations passed, form will be submitted');
                    return true;
                });

                console.log('Signature pad initialized successfully');

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
                        mapelSelect.innerHTML = '<option value="">Pilih Kelas Terlebih Dahulu</option>';
                        mapelSelect.disabled = false; // Don't disable - allow form to be filled
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
                            mapelSelect.disabled = false; // Don't disable - allow form submission
                        }

                        // Reset guru info
                        guruInfoBox.classList.add('hidden');
                        guruIdInput.value = '';
                        mataPelajaranNamaInput.value = '';

                    } catch (error) {
                        console.error('Error fetching mapel:', error);
                        mapelSelect.innerHTML =
                            '<option value="">Terjadi kesalahan saat memuat mata pelajaran</option>';
                        mapelSelect.disabled = false; // Don't disable - allow form submission
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
                // Store current mapel for use in closing
                currentMapelForGuruSelection = mapel;

                // Auto-select first guru by default
                const firstGuruId = mapel.gurus[0].guru_id;

                let guruOptions = mapel.gurus.map((g, idx) =>
                    `<label class="flex items-center mb-2 cursor-pointer">
                        <input type="radio" name="guru_selection" value="${g.guru_id}" class="mr-2" ${idx === 0 ? 'checked' : ''}>
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
                            <button type="button" onclick="confirmGuruSelection()" class="flex-1 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                                Pilih
                            </button>
                        </div>
                    </div>
                </div>
                `;

                document.body.insertAdjacentHTML('beforeend', modal);
            }

            // Store current mapel for guru selection
            let currentMapelForGuruSelection = null;

            window.closeGuruModal = function() {
                const modal = document.getElementById('guruModal');
                if (modal) modal.remove();

                // Auto-confirm first guru if one is checked
                const selectedGuru = document.querySelector('input[name="guru_selection"]:checked');
                if (selectedGuru && currentMapelForGuruSelection) {
                    confirmGuruSelectionAuto(selectedGuru.value, currentMapelForGuruSelection);
                }
            }

            // Auto-confirm guru selection (called when modal closes or user selects)
            window.confirmGuruSelectionAuto = function(guruId, mapel) {
                guruIdInput.value = guruId;
                mataPelajaranNamaInput.value = mapel.nama;

                const selectedGuru = mapel.gurus.find(g => g.guru_id == guruId);
                if (selectedGuru) {
                    guruNamaDisplay.textContent = selectedGuru.guru_nama;
                    guruInfoBox.classList.remove('hidden');
                }

                // Close modal if it exists
                const modal = document.getElementById('guruModal');
                if (modal) modal.remove();
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

                // ============================================
                // EVENT LISTENER UNTUK JAM PELAJARAN
                // ============================================
                if (startJampelSelect && endJampelSelect) {
                    startJampelSelect.addEventListener('change', function() {
                        console.log('Start jampel changed');
                        updateEndOptions();
                    });
                }

                // Fungsi untuk memfilter Jam Pelajaran berdasarkan tanggal
                function filterJamPelajaran(basedOnDate = null) {
                    const jampelSelect = document.querySelector('select[name="jampel_id"]');
                    if (!jampelSelect) return;

                    const dateToCheck = basedOnDate ? new Date(basedOnDate) : new Date();
                    const dayOfWeek = dateToCheck.getDay();

                    let hariTipe;
                    switch (dayOfWeek) {
                        case 1:
                            hariTipe = 'senin';
                            break;
                        case 2:
                        case 3:
                        case 4:
                            hariTipe = 'selasa_rabu_kamis';
                            break;
                        case 5:
                            hariTipe = 'jumat';
                            break;
                        default:
                            hariTipe = 'senin';
                            break;
                    }

                    const options = jampelSelect.querySelectorAll('option');

                    options.forEach(option => {
                        if (option.value === '') {
                            return;
                        }

                        const optionHariTipe = option.getAttribute('data-hari');

                        if (optionHariTipe === hariTipe) {
                            option.style.display = 'block';
                        } else {
                            option.style.display = 'none';
                        }
                    });

                    if (jampelSelect.value && jampelSelect.querySelector(`option[value="${jampelSelect.value}"]`).style.display === 'none') {
                        jampelSelect.value = '';
                    }
                }

                filterJamPelajaran();

                const tanggalInput = document.querySelector('input[name="tanggal"]');
                if (tanggalInput) {
                    tanggalInput.addEventListener('change', function() {
                        filterJamPelajaran(this.value);
                    });
                }
        </script>
    @endpush
@endsection
