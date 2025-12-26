@extends('layout.main')

@section('title', 'Kegiatan Sebelum KBM')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kegiatan Sebelum KBM</h1>
        <p class="text-gray-600 mt-1">Atur kegiatan singkat yang dilakukan sebelum proses pembelajaran dimulai.</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Tambah / Perbarui Kegiatan</h2>
                </div>
                <form action="{{ route('kegiatan-sebelum-kbm.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                            <select name="jurusan_id" class="mt-1 block w-full rounded-md border-gray-200">
                                <option value="">Semua Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Pilih jurusan jika kegiatan hanya berlaku untuk jurusan
                                tertentu.</p>
                        </div>
                        <!-- Hari akan diisi otomatis berdasarkan hari saat ini -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hari</label>
                            <div class="mt-1 text-sm text-gray-600">(otomatis berdasarkan hari ini)</div>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
                            <input type="text" name="kegiatan" class="mt-1 block w-full rounded-md border-gray-200"
                                placeholder="Contoh: Doa bersama / Absensi cepat" required>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center space-x-3">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300">Simpan</button>
                        <button type="reset"
                            class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50">Reset</button>
                        <a href="{{ route('kegiatan.index') ?? url()->current() }}"
                            class="ml-auto text-xs text-gray-500">Batal</a>
                    </div>
                </form>

                <hr class="my-6">

                <div>
                    <h3 class="text-md font-semibold mb-3">Daftar Kegiatan (per hari)</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-gray-700">Kegiatan Hari Ini: <span
                                    class="text-blue-600">{{ $todayHari }}</span></h4>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Lihat semua hari →</a>
                        </div>

                        <div id="activitiesList">
                            @if ($activities->isEmpty())
                                <div class="text-gray-500 py-8 text-center">
                                    <p class="text-sm">Belum ada kegiatan untuk hari {{ $todayHari }}.</p>
                                    <p class="text-xs text-gray-400 mt-2">Tambahkan kegiatan menggunakan form di atas.</p>
                                </div>
                            @else
                                <ul class="mt-2 space-y-3">
                                    @foreach ($activities as $hari => $list)
                                        @foreach ($list as $item)
                                            <li
                                                class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex-1">
                                                    <div class="text-sm font-semibold text-gray-900">{{ $item->kegiatan }}
                                                    </div>
                                                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                                        <span>Dibuat: {{ $item->created_at->format('d M Y H:i') }}</span>
                                                        @if ($item->jurusan)
                                                            <span
                                                                class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded">{{ $item->jurusan->nama_jurusan }}</span>
                                                        @else
                                                            <span
                                                                class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded">Umum</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 ml-4">
                                                    <button onclick="openEdit({{ $item->id }})"
                                                        class="inline-flex items-center gap-2 px-3 py-1 text-sm bg-yellow-50 text-yellow-800 border border-yellow-100 rounded-md hover:bg-yellow-100">Edit</button>
                                                    <form action="{{ route('kegiatan-sebelum-kbm.destroy', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Hapus kegiatan ini?')"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-2 px-3 py-1 text-sm bg-red-50 text-red-800 border border-red-100 rounded-md hover:bg-red-100">Hapus</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Petunjuk Singkat</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li>- Gunakan satu kegiatan per hari. Gunakan kata-kata singkat dan jelas.</li>
                    <li>- Kegiatan akan tampil pada halaman input agenda (jika aktif di agenda).</li>
                    <li>- Tekan Edit untuk memperbarui atau Hapus untuk menghapus.</li>
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Tip</h3>
                <div class="text-sm text-gray-600">Simpan kegiatan yang ringkas agar guru dapat cepat memilih saat
                    memasukkan agenda.</div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full mx-4">
            <h3 class="text-lg font-semibold mb-3">Edit Kegiatan</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_method" value="PUT">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Hari</label>
                    <div id="editHariDisplay" class="mt-1 text-sm text-gray-700">-</div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
                    <input type="text" name="kegiatan" id="editKegiatan"
                        class="mt-1 block w-full rounded-md border-gray-200" required>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeEdit()" class="px-4 py-2 bg-gray-100 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script>
            function openEdit(id) {
                fetch(`/kegiatan-sebelum-kbm/${id}/edit`)
                    .then(r => r.json())
                    .then(data => {
                        const display = document.getElementById('editHariDisplay');
                        if (display) display.textContent = data.hari ?? '-';
                        document.getElementById('editKegiatan').value = data.kegiatan;
                        const form = document.getElementById('editForm');
                        form.action = `/kegiatan-sebelum-kbm/${id}`;
                        document.getElementById('editModal').classList.remove('hidden');
                        document.getElementById('editModal').classList.add('flex');
                    })
                    .catch(err => alert('Gagal memuat data: ' + err));
            }

            function closeEdit() {
                document.getElementById('editModal').classList.add('hidden');
                document.getElementById('editModal').classList.remove('flex');
            }
        </script>
    @endpush

@endsection
