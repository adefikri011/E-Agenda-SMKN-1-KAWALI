@foreach ($guru as $item)
<div id="editModal{{ $item->id }}" class="modal">
    <div class="modal-content">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Edit Data Guru</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('guru.update', $item->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama Guru --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ $item->name }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Email --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ $item->email }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- NIP --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    NIP <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nip" value="{{ $item->nip }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Nomor HP --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Nomor HP
                </label>
                <input type="text" name="no_hp" value="{{ $item->no_hp }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block font-medium text-sm text-gray-700">
                    Alamat
                </label>
                <textarea name="alamat" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg
                          focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $item->alamat }}</textarea>
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
