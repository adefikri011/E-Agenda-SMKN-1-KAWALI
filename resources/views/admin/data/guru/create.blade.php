<div id="addModal" class="modal">
    <div class="modal-content">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Tambah Guru Baru</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('guru.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- NAMA --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Nama Guru *</label>
                <input type="text" name="nama"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan nama guru" required>
            </div>

            {{-- NIP --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">NIP *</label>
                <input type="text" name="nip"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan NIP guru" required>
            </div>

            {{-- JENIS KELAMIN --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Jenis Kelamin *</label>
                <select name="jenis_kelamin"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>

            {{-- EMAIL LOGIN --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Email</label>
                <input type="email" name="email"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="email@gmail.com" required>
            </div>
            
            <div class="flex justify-end gap-2 pt-2">
                <a href="#" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Batal</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
