<!-- Modal Add Siswa -->
<div id="addModal" class="modal"
     x-data="modalForm('formTambahSiswa')">

    <div class="modal-content">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Tambah Siswa Baru</h3>
            <!-- Tombol X menggunakan toggleModal -->
            <button type="button" onclick="toggleModal('addModal', 'close')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Form -->
        <!-- ID 'formTambahSiswa' penting agar Alpine bisa mereset form otomatis -->
        <form id="formTambahSiswa" action="{{ route('siswa.store') }}" class="space-y-4" method="POST">
            @csrf

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">NIS <span class="text-red-500">*</span></label>
                <input type="text" id="addNis" name="nis"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    placeholder="Masukkan NIS" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Nama Siswa <span class="text-red-500">*</span></label>
                <input type="text" id="addName" name="nama_siswa"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    placeholder="Masukkan nama siswa" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Kelas <span class="text-red-500">*</span></label>
                <!-- Class select2 tetap dipertahankan -->
                <select id="addKelas" name="kelas_id"
                    class="select2 select-kelas w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                    required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
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
                <!-- Tombol Batal menggunakan toggleModal -->
                <button type="button" onclick="toggleModal('addModal', 'close')"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
