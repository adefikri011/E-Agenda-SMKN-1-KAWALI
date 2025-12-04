@foreach ($kelas as $item)
    <div id="deleteModal{{ $item->id }}" class="modal">
        <div class="modal-content">
            <div class="flex items-center mb-3">
                <div class="p-2 rounded-full bg-red-100 text-red-600 mr-3">
                    <i class="fas fa-exclamation-triangle text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
            </div>

            <p class="text-gray-600 mb-5 text-sm">
                Apakah Anda yakin ingin menghapus kelas
                <span class="font-semibold">{{ $item->nama_kelas }}</span>?
            </p>

            <div class="flex justify-end space-x-2">
                <a href="#" class="px-4 py-2 border rounded-lg text-sm">Batal</a>

                <form action="{{ route('kelas.delete', $item->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
