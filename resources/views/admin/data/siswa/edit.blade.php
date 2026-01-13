@foreach ($siswa as $item)
    <div id="editModal{{ $item->id }}" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit Data Siswa</h3>
                <a href="#" class="text-gray-500 hover:text-gray-700 modal-close">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <form action="{{ route('siswa.update', $item->id) }}" class="space-y-4" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">NIS <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nis" value="{{ $item->nis }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Nama Siswa <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="editName" name="nama_siswa" value="{{ $item->nama_siswa }}"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        required>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Kelas <span
                            class="text-red-500">*</span></label>
                    <select name="kelas_id" class="select2 w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $k->id == $item->kelas_id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Jenis Kelamin <span
                            class="text-red-500">*</span></label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="jenkel" value="laki-laki" class="mr-2"
                                {{ $item->jenkel == 'laki-laki' ? 'checked' : '' }} required>
                            <span class="text-sm">Laki-laki</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="jenkel" value="perempuan" class="mr-2"
                                {{ $item->jenkel == 'perempuan' ? 'checked' : '' }} required>
                            <span class="text-sm">Perempuan</span>
                        </label>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm modal-close">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
@endforeach
