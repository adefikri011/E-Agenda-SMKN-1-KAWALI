<form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="importModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Import Data Guru dari Excel</h3>

                <button type="button" onclick="document.getElementById('importModal').style.display='none'"
                    class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto h-12 w-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>

                    <div class="mt-2 text-sm text-gray-600">
                        <label for="file-upload"
                            class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
                            <span>Pilih File Excel</span>
                            <input id="file-upload" name="file" type="file" class="sr-only" accept=".xlsx,.xls">
                        </label>
                        <p class="pl-1">Excel (.xlsx / .xls)</p>
                    </div>

                    <p class="text-xs text-gray-500 mt-1">Max 10MB</p>

                    <div id="file-name" class="mt-2 text-sm text-green-600 font-medium hidden"></div>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button"
                    onclick="document.getElementById('importModal').style.display='none'"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    Import
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');

        if (fileName) {
            fileNameDiv.textContent = fileName;
            fileNameDiv.classList.remove('hidden');
        } else {
            fileNameDiv.classList.add('hidden');
        }
    });
</script>
