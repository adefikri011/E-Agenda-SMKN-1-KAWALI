@extends('layout.main')

@section('title', 'Kegiatan Sebelum KBM')

@section('content')
    <!-- Full Screen Header -->
    <div class="px-8 py-6 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-900">Kegiatan Sebelum KBM</h1>
                </div>
                <p class="text-lg text-gray-600 ml-4">Atur kegiatan singkat yang dilakukan sebelum proses pembelajaran dimulai.</p>
            </div>
        </div>
    </div>

    <!-- Full Screen Content -->
    <div class="px-8 py-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Tambah / Perbarui Kegiatan</h2>
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
            </div>

            <form action="{{ route('kegiatan-sebelum-kbm.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-lg font-semibold text-gray-700 mb-3">Jurusan</label>
                        <select name="jurusan_id" class="mt-1 block w-full px-4 py-4 text-lg rounded-md border-2 border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-white">
                            <option value="">Semua Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                            @endforeach
                        </select>
                        <p class="text-base text-gray-500 mt-3">Pilih jurusan jika kegiatan hanya berlaku untuk jurusan tertentu.</p>
                    </div>

                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-lg font-semibold text-gray-700 mb-3">Hari</label>
                        <div class="mt-1 px-4 py-4 bg-white rounded-md text-lg text-gray-700 font-medium border-2 border-gray-300">
                            {{ $todayHari }} (otomatis)
                        </div>
                        <p class="text-base text-gray-500 mt-3">Hari akan diisi otomatis berdasarkan hari saat ini</p>
                    </div>

                    <div class="md:col-span-2 border border-gray-300 rounded-lg p-4 bg-gray-50">
                        <label class="block text-lg font-semibold text-gray-700 mb-3">Kegiatan</label>
                        <input type="text" name="kegiatan" class="mt-1 block w-full px-4 py-4 text-lg rounded-md border-2 border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-white"
                            placeholder="Contoh: Doa bersama / Absensi cepat" required>
                        <p class="text-base text-gray-500 mt-3">Gunakan kata-kata singkat dan jelas untuk kegiatan ini</p>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6">
                    <div class="flex items-center space-x-4">
                        <button type="submit"
                            class="px-8 py-4 bg-blue-600 text-white text-lg font-medium rounded-lg hover:bg-blue-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            Simpan Kegiatan
                        </button>
                        <button type="reset"
                            class="px-8 py-4 bg-white border-2 border-gray-300 text-lg font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Reset Form
                        </button>
                    </div>
                    <a href="{{ route('kegiatan.index') ?? url()->current() }}"
                        class="text-lg text-gray-500 hover:text-gray-700 transition-colors">
                        Batal
                    </a>
                </div>
            </form>

            <hr class="my-8 border-gray-300">

            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Daftar Kegiatan</h3>
                    <div class="bg-blue-50 px-4 py-2 rounded-lg">
                        <span class="text-base font-medium text-blue-700">Hari: {{ $todayHari }}</span>
                    </div>
                </div>

                <div id="activitiesList">
                    @if ($activities->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p class="text-lg font-medium text-gray-700 mb-2">Belum ada kegiatan untuk hari {{ $todayHari }}</p>
                            <p class="text-base text-gray-500">Tambahkan kegiatan menggunakan form di atas</p>
                        </div>
                    @else
                        <ul class="space-y-4">
                            @foreach ($activities as $hari => $list)
                                @foreach ($list as $item)
                                    <li class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900 mb-3">{{ $item->kegiatan }}</h4>
                                                <div class="flex items-center gap-4 text-base text-gray-600">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span>{{ $item->created_at->format('d M Y H:i') }}</span>
                                                    </div>
                                                    @if ($item->jurusan)
                                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-base font-medium">
                                                            {{ $item->jurusan->nama_jurusan }}
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-base font-medium">
                                                            Umum
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 ml-6">
                                                <button onclick="openEdit({{ $item->id }})"
                                                    class="inline-flex items-center gap-2 px-4 py-2 text-base font-medium bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </button>
                                                <form action="{{ route('kegiatan-sebelum-kbm.destroy', $item->id) }}"
                                                    method="POST" onsubmit="return confirm('Hapus kegiatan ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 px-4 py-2 text-base font-medium bg-red-50 text-red-800 border border-red-200 rounded-lg hover:bg-red-100 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
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

    <!-- Full Screen Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl p-8 max-w-xl w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Edit Kegiatan</h3>
                <button onclick="closeEdit()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="_method" value="PUT">

                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                    <label class="block text-lg font-semibold text-gray-700 mb-3">Hari</label>
                    <div id="editHariDisplay" class="px-4 py-4 bg-white rounded-md text-lg text-gray-700 font-medium border-2 border-gray-300">-</div>
                </div>

                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                    <label class="block text-lg font-semibold text-gray-700 mb-3">Kegiatan</label>
                    <input type="text" name="kegiatan" id="editKegiatan"
                        class="mt-1 block w-full px-4 py-4 text-lg rounded-md border-2 border-gray-300 focus:border-blue-500 focus:ring-blue-500 bg-white" required>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeEdit()" class="px-6 py-3 bg-gray-100 text-lg font-medium rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white text-lg font-medium rounded-lg hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
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
