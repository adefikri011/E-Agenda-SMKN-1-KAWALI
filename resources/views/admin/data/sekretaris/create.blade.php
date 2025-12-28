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
                <select name="kelas_id" id="kelas_id" required class="select2 select-kelas w-full text-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Siswa (Baru) --}}
            <div>
                <label class="block text-sm font-medium">Siswa <span class="text-red-500">*</span></label>
                <select name="siswa_id" id="siswa_id" required class="select2 select-siswa w-full text-sm" disabled>
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
    // Use jQuery-based flow for more reliable integration with Select2
    $(function() {
        const $kelas = $('#kelas_id');
        const $siswa = $('#siswa_id');
        const $nis = $('#nis');
        const $jenkel = $('#jenkel');

        function resetSiswa() {
            $siswa.empty().append($('<option>').val('').text('Pilih Siswa'));
            $siswa.prop('disabled', true);
            $nis.value = '';
            $nis.val('');
            $jenkel.val('');
            $jenkel.prop('disabled', true);
            try { window.initSelect2('#siswa_id'); } catch (e) { /* ignore */ }
        }

        // Initial reset
        resetSiswa();

        $kelas.on('change', function() {
            const kelasId = $(this).val();
            resetSiswa();

            if (!kelasId) return;

            const url = '{{ url('/sekretaris/get-siswa-by-kelas') }}' + '/' + kelasId;
            console.log('Fetching siswa for kelas:', kelasId, url);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(data) {
                    console.log('Siswa response:', data);
                    $siswa.empty().append($('<option>').val('').text('Pilih Siswa'));

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(function(siswa) {
                            const $opt = $('<option>')
                                .val(siswa.id)
                                .text(siswa.nama_siswa)
                                .attr('data-nis', siswa.nis)
                                .attr('data-jenkel', siswa.jenkel);
                            $siswa.append($opt);
                        });
                        $siswa.prop('disabled', false);
                    } else {
                        $siswa.append($('<option>').val('').text('Tidak ada siswa yang tersedia'));
                        $siswa.prop('disabled', true);
                    }

                    try {
                        window.initSelect2('#siswa_id');
                    } catch (e) {
                        console.error('initSelect2 error:', e);
                    }
                },
                error: function(xhr, status, err) {
                    console.error('Gagal ambil siswa:', status, err, xhr.responseText);
                    $siswa.empty().append($('<option>').val('').text('Gagal mengambil data siswa'));
                    $siswa.prop('disabled', true);
                    try { window.initSelect2('#siswa_id'); } catch (e) {}
                }
            });
        });

        // When siswa changes, fill NIS and Jenis Kelamin
        $siswa.on('change', function() {
            const $opt = $(this).find('option:selected');
            if ($opt.val()) {
                $nis.val($opt.data('nis') || '');
                $jenkel.val($opt.data('jenkel') || '');
                $jenkel.prop('disabled', false);
            } else {
                $nis.val('');
                $jenkel.val('');
                $jenkel.prop('disabled', true);
            }
        });
    });
</script>
