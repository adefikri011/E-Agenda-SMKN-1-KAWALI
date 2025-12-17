<div id="addModal" class="modal">
    <div class="modal-content">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Tambah Mata Pelajaran Baru</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('mapel.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- NAMA --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Nama Mata Pelajaran *</label>
                <input type="text" name="nama"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan nama mata pelajaran" required>
            </div>

            {{-- KODE --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Kode Mata Pelajaran *</label>
                <input type="text" name="kode"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan kode mata pelajaran" required>
            </div>

            {{-- KELOMPOK --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">Kelompok *</label>
                <select name="kelompok"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Pilih Kelompok</option>
                    <option value="A">Kelompok A (Wajib)</option>
                    <option value="B">Kelompok B (Wajib)</option>
                    <option value="C">Kelompok C (Peminatan)</option>
                    <option value="Muatan Lokal">Muatan Lokal</option>
                </select>
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
