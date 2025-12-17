@foreach ($mapel as $item)
    <!-- Modal Delete Mata Pelajaran -->
    <div id="deleteModal{{ $item->id }}" class="modal">
        <div class="modal-content">
            <div class="flex items-center mb-3">
                <div class="p-2 rounded-full bg-red-100 text-red-600 mr-3">
                    <i class="fas fa-exclamation-triangle text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
            </div>

            <p class="text-gray-600 mb-5 text-sm">
                Apakah Anda yakin ingin menghapus data mata pelajaran
                <span class="font-semibold">{{ $item->nama }}</span>?
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex justify-end space-x-2">
                <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                    Batal
                </a>

                <form action="{{ route('mapel.destroy', $item->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
