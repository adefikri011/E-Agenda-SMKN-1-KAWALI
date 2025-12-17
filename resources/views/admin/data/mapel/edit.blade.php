@foreach ($mapel as $item)
<div id="editModal{{ $item->id }}" class="modal">
    <div class="modal-content">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Edit Data Mata Pelajaran</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('mapel.update', $item->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama Mata Pelajaran --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Nama Mata Pelajaran <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama" value="{{ $item->nama }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Kode --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Kode Mata Pelajaran <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kode" value="{{ $item->kode }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Kelompok --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Kelompok <span class="text-red-500">*</span>
                </label>
                <select name="kelompok"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg
                        focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                    <option value="">Pilih Kelompok</option>
                    <option value="A" {{ $item->kelompok == 'A' ? 'selected' : '' }}>Kelompok A (Wajib)</option>
                    <option value="B" {{ $item->kelompok == 'B' ? 'selected' : '' }}>Kelompok B (Wajib)</option>
                    <option value="C" {{ $item->kelompok == 'C' ? 'selected' : '' }}>Kelompok C (Peminatan)</option>
                    <option value="Muatan Lokal" {{ $item->kelompok == 'Muatan Lokal' ? 'selected' : '' }}>Muatan Lokal</option>
                </select>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 pt-2">
                <a href="#"
                   class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">
                    Batal
                </a>

                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
@endforeach
