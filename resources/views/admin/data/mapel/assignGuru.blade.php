<div id="assignModal" class="modal">
    <div class="modal-content" style="max-width: 40rem;">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Assign Guru ke Mata Pelajaran</h3>
            <a href="#" class="text-gray-500 hover:text-gray-700 text-lg">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <form action="{{ route('mapel.assignGuru', $mapel->id) }}" method="POST" class="space-y-4">
            @csrf

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-1"></i>
                    Anda sedang menugaskan guru untuk mata pelajaran <strong>{{ $mapel->nama }}</strong>
                </p>
            </div>

            <div id="assignments-container">
                <!-- Current assignments -->
                @foreach ($mapel->gurus as $index => $guru)
                    <div class="assignment-row flex gap-2 mb-2" data-index="{{ $index }}">
                        <div class="flex-1">
                            <select name="guru_id[]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Guru</option>
                                @foreach (\App\Models\Guru::all() as $guruOption)
                                    <option value="{{ $guruOption->id }}" {{ $guruOption->id == $guru->id ? 'selected' : '' }}>
                                        {{ $guruOption->nama }} ({{ $guruOption->nip ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="kelas_id[]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach (\App\Models\Kelas::all() as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $guru->pivot->kelas_id == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="remove-assignment px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach

                <!-- If no assignments yet -->
                @if ($mapel->gurus->count() == 0)
                    <div class="assignment-row flex gap-2 mb-2" data-index="0">
                        <div class="flex-1">
                            <select name="guru_id[]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Guru</option>
                                @foreach (\App\Models\Guru::all() as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }} ({{ $guru->nip ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <select name="kelas_id[]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Kelas</option>
                                @foreach (\App\Models\Kelas::all() as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="remove-assignment px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endif
            </div>

            <button type="button" id="add-assignment" class="w-full py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-gray-400 hover:text-gray-700">
                <i class="fas fa-plus mr-1"></i> Tambah Penugasan
            </button>

            <div class="flex justify-end gap-2 pt-2">
                <a href="#" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addAssignmentBtn = document.getElementById('add-assignment');
        const assignmentsContainer = document.getElementById('assignments-container');

        // Get all available teachers and classes
        const teachers = @json(\App\Models\Guru::all()->map(function($guru) {
            return ['id' => $guru->id, 'name' => $guru->nama . ' (' . ($guru->nip ?? '-') . ')'];
        }));

        const classes = @json(\App\Models\Kelas::all()->map(function($kelas) {
            return ['id' => $kelas->id, 'name' => $kelas->nama_kelas];
        }));

        let nextIndex = document.querySelectorAll('.assignment-row').length;

        // Add new assignment row
        addAssignmentBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'assignment-row flex gap-2 mb-2';
            newRow.setAttribute('data-index', nextIndex);

            // Create teacher select
            const teacherSelect = document.createElement('select');
            teacherSelect.name = 'guru_id[]';
            teacherSelect.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500';

            const teacherDefaultOption = document.createElement('option');
            teacherDefaultOption.value = '';
            teacherDefaultOption.textContent = 'Pilih Guru';
            teacherSelect.appendChild(teacherDefaultOption);

            teachers.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.id;
                option.textContent = teacher.name;
                teacherSelect.appendChild(option);
            });

            // Create class select
            const classSelect = document.createElement('select');
            classSelect.name = 'kelas_id[]';
            classSelect.className = 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500';

            const classDefaultOption = document.createElement('option');
            classDefaultOption.value = '';
            classDefaultOption.textContent = 'Pilih Kelas';
            classSelect.appendChild(classDefaultOption);

            classes.forEach(cls => {
                const option = document.createElement('option');
                option.value = cls.id;
                option.textContent = cls.name;
                classSelect.appendChild(option);
            });

            // Create remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-assignment px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600';
            removeBtn.innerHTML = '<i class="fas fa-trash"></i>';

            // Append elements to row
            const teacherDiv = document.createElement('div');
            teacherDiv.className = 'flex-1';
            teacherDiv.appendChild(teacherSelect);

            const classDiv = document.createElement('div');
            classDiv.className = 'flex-1';
            classDiv.appendChild(classSelect);

            newRow.appendChild(teacherDiv);
            newRow.appendChild(classDiv);
            newRow.appendChild(removeBtn);

            assignmentsContainer.appendChild(newRow);
            nextIndex++;
        });

        // Remove assignment row
        assignmentsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-assignment')) {
                const row = e.target.closest('.assignment-row');
                row.remove();
            }
        });
    });
</script>
