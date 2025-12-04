<!-- Modal Add Siswa -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Tambah Siswa Baru</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 modal-close">
                <i class="fas fa-times"></i>
            </a>
        </div>
        <form action="{{ route('siswa.store') }}" class="space-y-4" method="POST">
            @csrf
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">NIS <span
                        class="text-red-500">*</span></label>
                <input type="text" id="addNis" name="nis"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    placeholder="Masukkan NIS" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Nama Siswa <span
                        class="text-red-500">*</span></label>
                <input type="text" id="addName" name="nama_siswa"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    placeholder="Masukkan nama siswa" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Kelas <span
                        class="text-red-500">*</span></label>
                <select id="addKelas" name="kelas_id"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Jenis Kelamin <span
                        class="text-red-500">*</span></label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="jenkel" value="laki-laki" class="mr-2" required>
                        <span class="text-sm">Laki-laki</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="jenkel" value="perempuan" class="mr-2" required>
                        <span class="text-sm">Perempuan</span>
                    </label>
                </div>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm modal-close">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>





<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');

        if (fileName) {
            fileNameDiv.textContent = fileName;
            fileNameDiv.classList.remove('hidden');
        } else {
            fileNameDiv.classList.add('hidden');
        }
    });

    // Tambahkan event listener untuk menutup modal
    document.querySelectorAll('.modal-close').forEach(element => {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
