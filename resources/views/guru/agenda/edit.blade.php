@extends('layout.main')

@section('title', 'Edit Agenda')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Agenda</h1>
        <p class="text-gray-600 mt-1">Perbarui agenda pembelajaran yang sudah ada</p>
    </div>

    <!-- Pesan Sukses/Error -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-start gap-3 animate-pulse">
            <i class="fas fa-check-circle text-emerald-600 text-xl mt-0.5 flex-shrink-0"></i>
            <div class="flex-1">
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
            <button class="text-emerald-600 hover:text-emerald-800" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3 animate-pulse">
            <i class="fas fa-exclamation-circle text-red-600 text-xl mt-0.5 flex-shrink-0"></i>
            <div class="flex-1">
                <p class="font-semibold">Gagal!</p>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
            <button class="text-red-600 hover:text-red-800" onclick="this.parentElement.style.display='none'">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg">
            <p class="font-semibold mb-2"><i class="fas fa-warning mr-2"></i>Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Form Edit -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <form action="{{ route('agenda.update', $agenda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tanda_tangan" id="tanda_tangan" value="{{ $agenda->tanda_tangan }}">

                    <div class="space-y-6">
                        <!-- Tanggal & Waktu -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-calendar text-blue-600 mr-2"></i>Tanggal
                                </label>
                                <input type="date" name="tanggal"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $agenda->tanggal->format('Y-m-d') }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-clock text-blue-600 mr-2"></i>Jam Pelajaran
                                </label>
                                <select name="jampel_id"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required>
                                    <option value="">Pilih Jam</option>
                                    @foreach ($jampel as $item)
                                        <option value="{{ $item->id }}" {{ $agenda->jampel_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_jam }} ({{ $item->rentang_waktu }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Kelas & Mata Pelajaran -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-users text-blue-600 mr-2"></i>Kelas
                                </label>
                                <select name="kelas_id"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}" {{ $agenda->kelas_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-book text-blue-600 mr-2"></i>Mata Pelajaran
                                </label>
                                <input type="text" name="mata_pelajaran" placeholder="contoh: Matematika"
                                    class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                    value="{{ $agenda->mata_pelajaran }}" required>
                            </div>
                        </div>

                        <!-- Materi Pembelajaran -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>Materi Pembelajaran
                            </label>
                            <input type="text" name="materi" placeholder="contoh: Aljabar dan Persamaan Linear"
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                value="{{ $agenda->materi }}" required>
                        </div>

                        <!-- Kegiatan/Aktivitas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-tasks text-blue-600 mr-2"></i>Kegiatan/Aktivitas
                            </label>
                            <textarea name="kegiatan" rows="4" placeholder="Jelaskan kegiatan pembelajaran yang dilakukan..."
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none"
                                required>{{ $agenda->kegiatan }}</textarea>
                        </div>

                        <!-- Tanda Tangan Digital -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-signature text-blue-600 mr-2"></i>Tanda Tangan Digital
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                                <div class="relative">
                                    <canvas id="signatureCanvas"
                                        class="bg-white border-2 border-gray-400 rounded-lg cursor-crosshair" width="600"
                                        height="250"
                                        style="width: 100%; height: 250px; display: block; background-color: white;">
                                    </canvas>
                                    <div id="canvasPlaceholder"
                                        class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <p class="text-gray-400 text-sm">Gambar tanda tangan di sini</p>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-3">
                                    <button type="button" id="clearSignature"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                        <i class="fas fa-eraser mr-2"></i>Hapus
                                    </button>
                                    <div class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Tanda tangan di atas dengan mouse atau jari
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Minimal 50px lebar untuk tanda tangan yang valid</p>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Catatan Tambahan
                            </label>
                            <textarea name="catatan" rows="3" placeholder="Catatan khusus atau informasi tambahan (opsional)"
                                class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none resize-none">{{ $agenda->catatan }}</textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Update Agenda
                            </button>
                            <a href="{{ route('agenda.index') }}"
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-all flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Info Agenda -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Agenda</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar text-blue-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Dibuat Oleh</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $agenda->user->name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-green-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Terakhir Update</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $agenda->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-signature text-purple-600"></i>
                            </div>
                            <span class="text-gray-700 font-medium">Status TTD</span>
                        </div>
                        @if ($agenda->status_ttd)
                            <span class="text-sm font-medium text-green-600">Sudah Ditandatangani</span>
                        @else
                            <span class="text-sm font-medium text-yellow-600">Belum Ditandatangani</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-6 border border-blue-100">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb text-white"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-2">Tips Mengedit Agenda</h4>
                        <ul class="text-xs text-gray-700 space-y-1">
                            <li>• Periksa kembali materi pembelajaran</li>
                            <li>• Update kegiatan yang dilakukan</li>
                            <li>• Beri tanda tangan digital kembali</li>
                            <li>• Pastikan semua data sudah benar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, initializing signature pad...');

                const canvas = document.getElementById('signatureCanvas');
                const ctx = canvas.getContext('2d');
                const placeholder = document.getElementById('canvasPlaceholder');
                const clearBtn = document.getElementById('clearSignature');
                const form = document.querySelector('form');
                const signatureInput = document.getElementById('tanda_tangan');

                let isDrawing = false;
                let hasSignature = false;

                // Set canvas background
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Load existing signature if any
                @if ($agenda->tanda_tangan)
                    const img = new Image();
                    img.onload = function() {
                        ctx.drawImage(img, 0, 0);
                        hasSignature = true;
                        placeholder.style.display = 'none';
                    };
                    img.src = '{{ $agenda->tanda_tangan }}';
                @endif

                // Set drawing styles
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                // Get mouse/touch position
                function getPosition(e) {
                    const rect = canvas.getBoundingClientRect();
                    const scaleX = canvas.width / rect.width;
                    const scaleY = canvas.height / rect.height;

                    let clientX, clientY;

                    if (e.touches) {
                        clientX = e.touches[0].clientX;
                        clientY = e.touches[0].clientY;
                    } else {
                        clientX = e.clientX;
                        clientY = e.clientY;
                    }

                    return {
                        x: (clientX - rect.left) * scaleX,
                        y: (clientY - rect.top) * scaleY
                    };
                }

                // Start drawing
                function startDrawing(e) {
                    isDrawing = true;
                    hasSignature = true;

                    const pos = getPosition(e);
                    ctx.beginPath();
                    ctx.moveTo(pos.x, pos.y);

                    // Hide placeholder
                    placeholder.style.display = 'none';

                    e.preventDefault();
                }

                // Draw
                function draw(e) {
                    if (!isDrawing) return;

                    const pos = getPosition(e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();

                    e.preventDefault();
                }

                // Stop drawing
                function stopDrawing(e) {
                    if (!isDrawing) return;

                    isDrawing = false;
                    ctx.closePath();

                    e.preventDefault();
                }

                // Mouse events
                canvas.addEventListener('mousedown', startDrawing);
                canvas.addEventListener('mousemove', draw);
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mouseout', stopDrawing);

                // Touch events
                canvas.addEventListener('touchstart', startDrawing);
                canvas.addEventListener('touchmove', draw);
                canvas.addEventListener('touchend', stopDrawing);
                canvas.addEventListener('touchcancel', stopDrawing);

                // Clear signature
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Clear canvas
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    // Reset state
                    hasSignature = false;

                    // Show placeholder
                    placeholder.style.display = 'flex';

                    console.log('Signature cleared');
                });

                // Form submission
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted, checking signature...');

                    if (!hasSignature) {
                        e.preventDefault();
                        alert('Harap berikan tanda tangan digital terlebih dahulu!');
                        return false;
                    }

                    // Get signature data
                    const signatureData = canvas.toDataURL('image/png');
                    signatureInput.value = signatureData;

                    console.log('Signature captured, length:', signatureData.length);

                    if (signatureData.length < 50) {
                        e.preventDefault();
                        alert('Tanda tangan terlalu pendek. Silakan gambar tanda tangan yang lebih jelas.');
                        return false;
                    }

                    return true;
                });

                console.log('Signature pad initialized successfully');
            });
        </script>
    @endpush
@endsection
