@extends('layout.main')

@section('title', 'Input Nilai')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Input Nilai</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Masukkan nilai untuk siswa (Tugas Harian, UTS, UAS)</p>
            </div>
            <div class="bg-blue-50 px-6 py-3 rounded-xl border border-blue-100">
                <p class="text-sm text-blue-600 font-medium">Hari ini</p>
                <p class="text-xl font-bold text-blue-800">{{ date('d F') }}</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Kembali ke Daftar Nilai -->
            <a href="{{ route('nilai.index') }}" class="group block">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center shadow-lg shadow-gray-700/30 group-hover:shadow-gray-700/50 transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kembali ke Daftar Nilai</h3>
                    <p class="text-base text-gray-600">Lihat semua nilai yang telah diinput</p>
                </div>
            </a>

            <!-- Statistik Nilai -->
            <a href="{{ route('nilai.index') }}" class="group block">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Statistik Nilai</h3>
                    <p class="text-base text-gray-600">Lihat analisis nilai siswa</p>
                </div>
            </a>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">Form Input Nilai</h2>
            </div>

            <form action="{{ route('nilai.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Kelas</label>
                        <select id="kelas-select" name="kelas_id" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white" data-placeholder="Pilih kelas" required>
                            <option value="">Pilih kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas ?? $k->nama ?? $k->name ?? 'Kelas '.$k->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Mata Pelajaran</label>
                        <select id="mapel-select" name="mapel_id" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white" data-placeholder="Pilih mata pelajaran" required>
                            <option value="">Pilih mata pelajaran</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->id }}">{{ $m->nama ?? $m->nama_mapel ?? $m->mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-base font-semibold text-gray-700 mb-3">Jenis Nilai</label>
                        <select id="jenis-select" name="jenis" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg text-base focus:border-blue-500 focus:ring-blue-500 bg-white" data-placeholder="Pilih jenis nilai" required>
                            <option value="tugas">Tugas Harian</option>
                            <option value="uts">UTS</option>
                            <option value="uas">UAS</option>
                        </select>
                    </div>
                </div>

                <div id="students-section" class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <p id="students-note" class="text-base text-gray-600">Pilih kelas untuk memuat daftar siswa.</p>
                        <div id="students-meta" class="text-base text-gray-600"></div>
                    </div>
                    <div id="students-table-container" class="overflow-x-auto mt-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="p-8 text-center text-gray-500">
                            <div class="mx-auto w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <p class="text-base font-medium text-gray-700 mb-2">Tidak ada siswa yang dimuat</p>
                            <p class="text-sm text-gray-500">Pilih kelas untuk mulai menginput nilai.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="reset" id="reset-btn" class="px-6 py-2.5 bg-gray-100 text-gray-700 text-base font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Reset
                    </button>
                    <button type="submit" id="submit-btn" class="px-6 py-2.5 bg-blue-600 text-white text-base font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200" disabled>
                        Simpan Semua Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
@endsection

@push('script')
<script>
    // Ensure Select2 is initialized (layout.main provides window.initSelect2)
    if (window.initSelect2) {
        window.initSelect2('.select2');
    }

    const kelasSelect = document.getElementById('kelas-select');
    const mapelSelect = document.getElementById('mapel-select');
    const jenisSelect = document.getElementById('jenis-select');
    const studentsContainer = document.getElementById('students-table-container');
    const studentsNote = document.getElementById('students-note');
    const studentsMeta = document.getElementById('students-meta');
    const submitBtn = document.getElementById('submit-btn');
    const resetBtn = document.getElementById('reset-btn');

    function clearStudents() {
        studentsContainer.innerHTML = `
            <div class="p-8 text-center text-gray-500">
                <div class="mx-auto w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-base font-medium text-gray-700 mb-2">Tidak ada siswa yang dimuat</p>
                <p class="text-sm text-gray-500">Pilih kelas untuk mulai menginput nilai.</p>
            </div>
        `;
        studentsNote.textContent = 'Pilih kelas untuk memuat daftar siswa.';
        submitBtn.disabled = true;
    }

    async function loadStudents(kelasId) {
        if (!kelasId) { clearStudents(); return; }
        studentsNote.textContent = 'Memuat siswa...';
        studentsContainer.innerHTML = `
            <div class="p-8 text-center">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-600">Memuat data siswa...</p>
            </div>
        `;

        try {
            const res = await fetch('/absensi/siswa/' + kelasId);
            const data = await res.json();

            studentsMeta.textContent = data.length + ' siswa ditemukan';

            if (!Array.isArray(data) || data.length === 0) {
                studentsNote.textContent = 'Tidak ada siswa di kelas ini.';
                studentsContainer.innerHTML = `
                    <div class="p-8 text-center text-gray-500">
                        <div class="mx-auto w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <p class="text-base font-medium text-gray-700 mb-2">Tidak ada siswa di kelas ini</p>
                        <p class="text-sm text-gray-500">Pilih kelas lain untuk melanjutkan.</p>
                    </div>
                `;
                submitBtn.disabled = true;
                return;
            }

            studentsNote.textContent = '';

            // Build modern table
            const table = document.createElement('table');
            table.className = 'min-w-full divide-y divide-gray-200';

            const thead = document.createElement('thead');
            thead.className = 'bg-gray-50';
            thead.innerHTML = `<tr class="text-left text-sm font-bold text-gray-700 uppercase tracking-wider">
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">NIS/NISN</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Nilai (0-100)</th>
                <th class="px-6 py-3">Keterangan</th>
            </tr>`;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            tbody.className = 'bg-white divide-y divide-gray-200';

            data.forEach((s, idx) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 transition-colors';

                const noTd = document.createElement('td');
                noTd.className = 'px-6 py-4 text-sm text-gray-700';
                noTd.textContent = idx + 1;

                const nisTd = document.createElement('td');
                nisTd.className = 'px-6 py-4 text-sm text-gray-600';
                nisTd.textContent = s.nis || s.nisn || '-';

                const namaTd = document.createElement('td');
                namaTd.className = 'px-6 py-4 text-sm text-gray-900 font-medium';
                namaTd.textContent = s.nama_siswa || s.nama || s.name || 'Siswa ' + s.id;

                const nilaiTd = document.createElement('td');
                nilaiTd.className = 'px-6 py-4';
                const nilaiInput = document.createElement('input');
                nilaiInput.type = 'number';
                nilaiInput.name = `grades[${idx}][nilai]`;
                nilaiInput.min = 0;
                nilaiInput.max = 100;
                nilaiInput.className = 'w-28 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500';
                nilaiTd.appendChild(nilaiInput);

                const ketTd = document.createElement('td');
                ketTd.className = 'px-6 py-4';
                const ketInput = document.createElement('input');
                ketInput.type = 'text';
                ketInput.name = `grades[${idx}][keterangan]`;
                ketInput.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500';
                ketTd.appendChild(ketInput);

                // hidden siswa_id input
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = `grades[${idx}][siswa_id]`;
                hidden.value = s.id;

                tr.appendChild(noTd);
                tr.appendChild(nisTd);
                tr.appendChild(namaTd);
                tr.appendChild(nilaiTd);
                tr.appendChild(ketTd);
                tr.appendChild(hidden);

                tbody.appendChild(tr);
            });

            table.appendChild(tbody);
            // wrap table to match styles
            const wrapper = document.createElement('div');
            wrapper.className = 'overflow-x-auto p-4';
            wrapper.appendChild(table);

            studentsContainer.innerHTML = '';
            studentsContainer.appendChild(wrapper);
            submitBtn.disabled = false;
        } catch (err) {
            studentsNote.textContent = 'Gagal memuat siswa.';
            studentsContainer.innerHTML = `
                <div class="p-8 text-center text-red-500">
                    <div class="mx-auto w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-base font-medium text-red-700 mb-2">Gagal memuat data</p>
                    <p class="text-sm text-red-600">Terjadi kesalahan saat memuat data siswa. Silakan coba lagi.</p>
                </div>
            `;
            submitBtn.disabled = true;
        }
    }

    // Attach both native and Select2-aware listeners so change always triggers
    if (window.jQuery) {
        const $ = window.jQuery;
        $('#kelas-select').on('change select2:select', function(e) {
            const val = $(this).val();
            loadStudents(val);
        });
    } else {
        kelasSelect?.addEventListener('change', function(e) {
            loadStudents(e.target.value);
        });
    }

    resetBtn?.addEventListener('click', function() {
        // Reset selects and students
        kelasSelect.value = '';
        mapelSelect.value = '';
        jenisSelect.value = 'tugas';
        clearStudents();
    });

    // AJAX submit to save grades without page refresh
    const form = document.querySelector('form[action="{{ route('nilai.store') }}"]');

    // Create toast notifications similar to resources/views/components/notification.blade.php
    function showToast(type, title, message) {
        // ensure wrapper exists
        let wrapper = document.getElementById('notification-wrapper');
        if (!wrapper) {
            wrapper = document.createElement('div');
            wrapper.id = 'notification-wrapper';
            wrapper.className = 'fixed bottom-6 right-6 z-[9999] pointer-events-none';
            const stack = document.createElement('div');
            stack.className = 'notification-stack space-y-3';
            wrapper.appendChild(stack);
            document.body.appendChild(wrapper);
        }

        const stack = wrapper.querySelector('.notification-stack');

        const toast = document.createElement('div');
        toast.className = 'notification-toast pointer-events-auto animate-fadeIn';

        const inner = document.createElement('div');
        inner.className = 'bg-white rounded-xl shadow-lg border border-gray-100 p-4 flex items-center gap-3 min-w-[320px] max-w-[420px]';

        const iconWrap = document.createElement('div');
        iconWrap.className = 'flex-shrink-0';
        const iconBg = document.createElement('div');
        iconBg.className = 'w-10 h-10 rounded-full flex items-center justify-center';

        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('class', 'w-5 h-5');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', '2.5');

        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        if (type === 'success') {
            iconBg.classList.add('bg-emerald-100');
            svg.classList.add('text-emerald-600');
            path.setAttribute('d', 'M5 13l4 4L19 7');
        } else if (type === 'warning') {
            iconBg.classList.add('bg-amber-100');
            svg.classList.add('text-amber-600');
            path.setAttribute('d', 'M12 9v2m0 4h.01');
        } else {
            iconBg.classList.add('bg-red-100');
            svg.classList.add('text-red-600');
            path.setAttribute('d', 'M6 18L18 6M6 6l12 12');
        }

        svg.appendChild(path);
        iconBg.appendChild(svg);
        iconWrap.appendChild(iconBg);

        const content = document.createElement('div');
        content.className = 'flex-1 min-w-0';
        const titleEl = document.createElement('p');
        titleEl.className = 'text-sm font-semibold text-gray-900 mb-0.5';
        titleEl.textContent = title || (type === 'success' ? 'Berhasil!' : (type === 'warning' ? 'Peringatan!' : 'Error!'));
        const msgEl = document.createElement('p');
        msgEl.className = 'text-sm text-gray-600';
        msgEl.textContent = message;
        content.appendChild(titleEl);
        content.appendChild(msgEl);

        const btn = document.createElement('button');
        btn.className = 'flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors';
        btn.innerHTML = `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`;
        btn.addEventListener('click', () => { toast.remove(); });

        inner.appendChild(iconWrap);
        inner.appendChild(content);
        inner.appendChild(btn);
        toast.appendChild(inner);
        stack.appendChild(toast);

        // auto remove after 5s
        setTimeout(() => { toast.remove(); }, 5000);
    }

    form?.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (submitBtn.disabled) return;

        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span>Menyimpan...';

        const fd = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: fd,
                credentials: 'same-origin'
            });

            const data = await res.json().catch(() => null);

            if (res.ok && data && data.success) {
                showToast('success', 'Berhasil!', data.message || 'Berhasil disimpan');

                // clear only inputs that had nilai filled
                document.querySelectorAll('input[name^="grades"]').forEach(inp => {
                    // clear numeric nilai and keterangan where value was provided
                    if (inp.name.endsWith('[nilai]')) {
                        if (inp.value !== '') inp.value = '';
                    }
                    if (inp.name.endsWith('[keterangan]')) {
                        if (inp.value !== '') inp.value = '';
                    }
                });

                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            } else {
                // show message from server or generic error
                const msg = (data && data.message) ? data.message : 'Gagal menyimpan. Periksa input.';
                showToast('warning', 'Peringatan', msg);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        } catch (err) {
            showToast('error', 'Error', 'Terjadi kesalahan jaringan. Coba lagi.');
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
</script>
@endpush

