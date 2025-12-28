<form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="importModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Import Data Siswa dari Excel</h3>
                <button type="button" onclick="document.getElementById('importModal').style.display='none'"
                    class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <a href="{{ asset('template/siswa_template.csv') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md text-sm text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M20 21H4" />
                        </svg>
                        Download Template
                    </a>
                </div>
            </div>

            <div class="mb-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors duration-200 bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto h-12 w-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

                    <div class="mt-2 text-sm text-gray-600">
                        <label for="file-upload"
                            class="relative cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-white text-green-600 border border-green-200 rounded-md font-medium hover:bg-green-50 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4" />
                            </svg>
                            <span>Pilih File Excel</span>
                            <input id="file-upload" name="file" type="file" class="sr-only" accept=".xlsx,.xls">
                        </label>
                        <p class="pl-1 mt-2 text-xs text-gray-500">Excel (.xlsx / .xls) • Max 10MB</p>
                    </div>

                    <div id="file-name" class="mt-3 text-sm text-gray-700 font-medium hidden"></div>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button"
                    onclick="document.getElementById('importModal').style.display='none'"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm shadow">
                    <i class="fas fa-file-import mr-2"></i> Import
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('file-upload');
        const fileNameEl = document.getElementById('file-name');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                fileNameEl.classList.add('hidden');
                fileNameEl.textContent = '';
                return;
            }

            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('Ukuran file melebihi 10MB. Silakan pilih file yang lebih kecil.');
                fileInput.value = '';
                fileNameEl.classList.add('hidden');
                return;
            }

            fileNameEl.textContent = 'File terpilih: ' + file.name;
            fileNameEl.classList.remove('hidden');
        });
    });
</script>
