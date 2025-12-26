
<!-- Modal Edit Kelas -->
@foreach ($kelas as $item)
    <div id="editModal{{ $item->id }}" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Edit Kelas</h3>
                <a href="#" class="text-gray-500 hover:text-gray-700 modal-close"><i class="fas fa-times"></i></a>
            </div>

            <form action="{{ route('kelas.update', $item->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kelas" value="{{ $item->nama_kelas }}" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Wali Kelas (Opsional)</label>
                    <select name="wali_kelas_id" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                        <option value="">Pilih Wali Kelas</option>
                        @foreach ($users as $u)
                            <option value="{{ $u->id }}" {{ $item->wali_kelas_id == $u->id ? 'selected' : '' }}>
                                {{ $u->name }} ({{ $u->role }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium">Jurusan (Opsional)</label>
                    <select name="jurusan_id" class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusans as $j)
                            <option value="{{ $j->id }}" {{ $item->jurusan_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <a href="#" class="px-4 py-2 border rounded-lg text-sm modal-close">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
