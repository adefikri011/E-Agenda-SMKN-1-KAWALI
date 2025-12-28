{{--
    File ini dimaksudkan untuk di-include di dalam loop @foreach di index.blade.php
    Contoh: @include('admin.data.wali_kelas.edit', ['item' => $item])
--}}
<div id="editModal{{ $item->id }}" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Ubah Penugasan Wali Kelas</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </a>
        </div>

        {{-- Form untuk update --}}
        <form action="{{ route('wali_kelas.update', $item->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Input Guru --}}
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Pilih Guru <span class="text-red-500">*</span></label>
                <select name="guru_id" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    <option value="">-- Pilih Guru --</option>

                    {{-- Tampilkan guru yang saat ini dipilih sebagai pilihan pertama --}}
                    <option value="{{ $item->guru->id }}" selected>
                        {{ $item->guru->nama }} ({{ $item->guru->nip }})
                    </option>

                    {{-- Tampilkan guru lain yang BELUM ditugaskan sebagai wali kelas --}}
                    @foreach ($guruAvailable as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->nama }} ({{ $guru->nip }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Input Kelas --}}
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">Pilih Kelas <span class="text-red-500">*</span></label>
                <select name="kelas_id" class="selct2 w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    <option value="">-- Pilih Kelas --</option>

                    {{-- Tampilkan kelas yang saat ini dipilih sebagai pilihan pertama --}}
                    <option value="{{ $item->kelasAsWali->id }}" selected>
                        {{ $item->kelasAsWali->nama_kelas }}
                    </option>

                    {{-- Tampilkan kelas lain yang BELUM memiliki wali kelas --}}
                    @foreach ($kelasAvailable as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2 pt-2">
                <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Update</button>
            </div>
        </form>
    </div>
</div>
