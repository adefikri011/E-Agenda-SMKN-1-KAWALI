<div id="importModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Import Data Sekretaris dari Excel</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 modal-close">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('sekretaris.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <div class="mt-2 text-sm text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500">
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
                <a href="#" class="px-4 py-2 border rounded-lg text-sm modal-close">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm">Import</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file-upload')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('file-name');
        if (fileName) { fileNameDiv.textContent = fileName; fileNameDiv.classList.remove('hidden'); } else { fileNameDiv.classList.add('hidden'); }
    });
</script>
