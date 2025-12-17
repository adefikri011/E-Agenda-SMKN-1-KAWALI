{{-- 
    CATATAN:
    File modal ini tidak lagi digunakan oleh index.blade.php karena 
    aksi hapus telah dipindah menjadi inline di dalam tabel 
    dengan menggunakan JavaScript confirm().
--}}
<div id="deleteModal{{ $item->id }}" class="modal">
    <div class="modal-content">
        <div class="flex items-center mb-3">
            <div class="p-2 rounded-full bg-red-100 text-red-600 mr-3">
                <i class="fas fa-exclamation-triangle text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Hapus</h3>
        </div>

        <p class="text-gray-600 mb-5 text-sm">
            Apakah Anda yakin ingin mencabut penugasan
            <span class="font-semibold">{{ $item->guru->nama }}</span> sebagai wali kelas
            <span class="font-semibold">{{ $item->kelasAsWali->nama_kelas }}</span>?
        </p>

        <div class="flex justify-end space-x-2">
            <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                Batal
            </a>

            <form action="{{ route('wali_kelas.destroy', $item->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                    Cabut
                </button>
            </form>
        </div>
    </div>
</div>