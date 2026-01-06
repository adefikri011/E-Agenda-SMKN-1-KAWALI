@extends('layout.main')

@section('title', 'Input Nilai')

@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold">Input Nilai</h2>
            <p class="text-sm text-gray-500">Masukkan nilai untuk siswa (Tugas Harian, UTS, UAS)</p>
        </div>
        <a href="{{ route('nilai.index') }}" class="btn btn-outline">← Kembali ke Daftar Nilai</a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('nilai.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select id="kelas-select" name="kelas_id" class="select select-bordered w-full mt-2 select2" data-placeholder="Pilih kelas" required>
                        <option value="">Pilih kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas ?? $k->nama ?? $k->name ?? 'Kelas '.$k->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mata Pelajaran</label>
                    <select id="mapel-select" name="mapel_id" class="select select-bordered w-full mt-2 select2" data-placeholder="Pilih mata pelajaran" required>
                        <option value="">Pilih mata pelajaran</option>
                        @foreach($mapel as $m)
                            <option value="{{ $m->id }}">{{ $m->nama ?? $m->nama_mapel ?? $m->mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Nilai</label>
                    <select id="jenis-select" name="jenis" class="select select-bordered w-full mt-2 select2" data-placeholder="Pilih jenis nilai" required>
                        <option value="tugas">Tugas Harian</option>
                        <option value="uts">UTS</option>
                        <option value="uas">UAS</option>
                    </select>
                </div>
            </div>

            <div id="students-section" class="mt-6">
                <div class="flex items-center justify-between mb-3">
                    <p id="students-note" class="text-sm text-gray-500">Pilih kelas untuk memuat daftar siswa.</p>
                    <div id="students-meta" class="text-sm text-gray-500"></div>
                </div>
                <div id="students-table-container" class="overflow-x-auto mt-4 bg-white rounded-lg border border-gray-100 shadow-sm">
                    <div class="p-6 text-center text-sm text-gray-400">Tidak ada siswa yang dimuat. Pilih kelas untuk mulai menginput nilai.</div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-4">
                <button type="reset" id="reset-btn" class="btn btn-ghost">Reset</button>
                <button type="submit" id="submit-btn" class="btn btn-primary" disabled>Simpan Semua Nilai</button>
            </div>
        </form>
    </div>

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
        studentsContainer.innerHTML = '';
        studentsNote.textContent = 'Pilih kelas untuk memuat daftar siswa.';
        submitBtn.disabled = true;
    }

    async function loadStudents(kelasId) {
        if (!kelasId) { clearStudents(); return; }
        studentsNote.textContent = 'Memuat siswa...';
        studentsContainer.innerHTML = '';

        try {
            const res = await fetch('/absensi/siswa/' + kelasId);
            const data = await res.json();

            studentsMeta.textContent = data.length + ' siswa ditemukan';

            if (!Array.isArray(data) || data.length === 0) {
                studentsNote.textContent = 'Tidak ada siswa di kelas ini.';
                studentsContainer.innerHTML = '';
                submitBtn.disabled = true;
                return;
            }

            studentsNote.textContent = '';

            // Build modern table
            const table = document.createElement('table');
            table.className = 'min-w-full divide-y divide-gray-200';

            const thead = document.createElement('thead');
            thead.className = 'bg-gray-50';
            thead.innerHTML = `<tr class="text-left text-sm text-gray-600">
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">NIS/NISN</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Nilai (0-100)</th>
                <th class="px-6 py-3">Keterangan</th>
            </tr>`;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            tbody.className = 'bg-white divide-y divide-gray-100';

            data.forEach((s, idx) => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50';

                const noTd = document.createElement('td'); noTd.className = 'px-6 py-4 text-sm text-gray-700'; noTd.textContent = idx + 1;
                const nisTd = document.createElement('td'); nisTd.className = 'px-6 py-4 text-sm text-gray-600'; nisTd.textContent = s.nis || s.nisn || '-';
                const namaTd = document.createElement('td'); namaTd.className = 'px-6 py-4 text-sm text-gray-800 font-medium'; namaTd.textContent = s.nama_siswa || s.nama || s.name || 'Siswa ' + s.id;

                const nilaiTd = document.createElement('td'); nilaiTd.className = 'px-6 py-4';
                const nilaiInput = document.createElement('input');
                nilaiInput.type = 'number';
                nilaiInput.name = `grades[${idx}][nilai]`;
                nilaiInput.min = 0; nilaiInput.max = 100;
                nilaiInput.className = 'input input-bordered w-28 text-sm';
                nilaiTd.appendChild(nilaiInput);

                const ketTd = document.createElement('td'); ketTd.className = 'px-6 py-4';
                const ketInput = document.createElement('input');
                ketInput.type = 'text';
                ketInput.name = `grades[${idx}][keterangan]`;
                ketInput.className = 'input input-bordered w-full text-sm';
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
            wrapper.className = 'p-4';
            wrapper.appendChild(table);

            studentsContainer.innerHTML = '';
            studentsContainer.appendChild(wrapper);
            submitBtn.disabled = false;
        } catch (err) {
            studentsNote.textContent = 'Gagal memuat siswa.';
            studentsContainer.innerHTML = '';
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
    const alertBox = document.getElementById('form-alert');

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
        toast.className = 'notification-toast pointer-events-auto';

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
        submitBtn.textContent = 'Menyimpan...';

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
            } else {
                // show message from server or generic error
                const msg = (data && data.message) ? data.message : 'Gagal menyimpan. Periksa input.';
                showToast('warning', 'Peringatan', msg);
                submitBtn.disabled = false;
            }
        } catch (err) {
            showToast('error', 'Error', 'Terjadi kesalahan jaringan. Coba lagi.');
            submitBtn.disabled = false;
        } finally {
            submitBtn.textContent = originalText;
        }
    });
</script>
@endpush
