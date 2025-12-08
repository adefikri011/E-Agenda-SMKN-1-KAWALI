
<!-- Modal Edit Sekretaris -->
@foreach ($sekretaris as $item)
    @if ($item->siswa)
    <div id="editModal{{ $item->id }}" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Edit Sekretaris</h3>
                <a href="#" class="text-gray-500 hover:text-gray-700 modal-close"><i class="fas fa-times"></i></a>
            </div>

            <form action="{{ route('sekretaris.update', $item->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $item->name }}" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ $item->email }}" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas_id" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                        <option value="">Pilih Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $item->siswa && $item->siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">NIS <span class="text-red-500">*</span></label>
                    <input type="text" name="nis" value="{{ $item->siswa->nis ?? '' }}" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenkel" required class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                        <option value="">Pilih</option>
                        <option value="laki-laki" {{ $item->siswa && $item->siswa->jenkel == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="perempuan" {{ $item->siswa && $item->siswa->jenkel == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <a href="#" class="px-4 py-2 border rounded-lg text-sm modal-close">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endforeach
