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

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" required
                       class="w-full px-3 py-2 border rounded-lg text-sm"
                       placeholder="Masukkan nama lengkap">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" required
                       class="w-full px-3 py-2 border rounded-lg text-sm"
                       placeholder="email@example.com">
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block text-sm font-medium">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas_id" required
                        class="w-full px-3 py-2 border rounded-lg text-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium">NIS <span class="text-red-500">*</span></label>
                <input type="text" name="nis" required
                       class="w-full px-3 py-2 border rounded-lg text-sm"
                       placeholder="Masukkan NIS siswa">
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-sm font-medium">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenkel" required
                        class="w-full px-3 py-2 border rounded-lg text-sm">
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
