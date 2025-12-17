<!-- Modal Tambah Sekretaris -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Tambah Sekretaris</h3>
            <a href="#" class="modal-close text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('sekretaris.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Kelas --}}
            <div>
                <label class="block text-sm font-medium">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas_id" id="kelas_id" required class="w-full px-3 py-2 border rounded-lg text-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Siswa (Baru) --}}
            <div>
                <label class="block text-sm font-medium">Siswa <span class="text-red-500">*</span></label>
                <select name="siswa_id" id="siswa_id" required class="w-full px-3 py-2 border rounded-lg text-sm" disabled>
                    <option value="">Pilih Siswa</option>
                </select>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg text-sm"
                    placeholder="email@example.com">
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium">NIS <span class="text-red-500">*</span></label>
                <input type="text" name="nis" id="nis" required class="w-full px-3 py-2 border rounded-lg text-sm"
                    placeholder="Masukkan NIS siswa" readonly>
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-sm font-medium">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenkel" id="jenkel" required class="w-full px-3 py-2 border rounded-lg text-sm" disabled>
                    <option value="">Pilih</option>
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="#" class="px-4 py-2 border rounded-lg text-sm modal-close">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Tambahkan script di bagian bawah halaman -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kelasSelect = document.getElementById('kelas_id');
        const siswaSelect = document.getElementById('siswa_id');
        const nisInput = document.getElementById('nis');
        const jenkelSelect = document.getElementById('jenkel');
        kelasSelect.addEventListener('change', function() {
            const kelasId = this.value;

            // Reset dropdown siswa
            siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
            siswaSelect.disabled = true;
            nisInput.value = '';
            jenkelSelect.value = '';
            jenkelSelect.disabled = true;

            if (!kelasId) return;

            const url = '{{ url('/sekretaris/get-siswa-by-kelas') }}' + '/' + kelasId;
            console.log('Fetching siswa for kelas:', kelasId, url);

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => {
                    if (!response.ok) throw new Error('HTTP ' + response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Siswa response:', data);
                    siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                    if (Array.isArray(data) && data.length > 0) {
                        siswaSelect.disabled = false;
                        data.forEach(siswa => {
                            const option = document.createElement('option');
                            option.value = siswa.id;
                            option.textContent = siswa.nama_siswa;
                            option.setAttribute('data-nis', siswa.nis);
                            option.setAttribute('data-jenkel', siswa.jenkel);
                            siswaSelect.appendChild(option);
                        });
                    } else {
                        // No students available; enable select and show message
                        siswaSelect.disabled = false;
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = 'Tidak ada siswa yang tersedia';
                        siswaSelect.appendChild(opt);
                    }
                })
                .catch(error => {
                    console.error('Gagal ambil siswa:', error);
                    siswaSelect.innerHTML = '<option value="">Pilih Siswa</option>';
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Gagal mengambil data siswa';
                    siswaSelect.appendChild(opt);
                    siswaSelect.disabled = false;
                });
        });

        siswaSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption && selectedOption.value) {
                // Isi NIS dan Jenis Kelamin otomatis
                nisInput.value = selectedOption.getAttribute('data-nis') || '';
                jenkelSelect.value = selectedOption.getAttribute('data-jenkel') || '';
                jenkelSelect.disabled = false;
            } else {
                nisInput.value = '';
                jenkelSelect.value = '';
                jenkelSelect.disabled = true;
            }
        });
    });
</script>
