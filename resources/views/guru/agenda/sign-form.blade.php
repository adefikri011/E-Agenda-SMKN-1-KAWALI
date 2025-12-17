@extends('layout.main')

@section('title', 'Tanda Tangan Agenda')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tanda Tangan Agenda</h1>
        <p class="text-gray-600 mt-1">Berikan tanda tangan digital untuk agenda ini</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <!-- Flash messages / validation errors -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Detail Agenda -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Agenda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-medium">{{ $agenda->tanggal->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jam Pelajaran</p>
                    <p class="font-medium">{{ $agenda->jampel->nama_jam }} ({{ $agenda->jampel->rentang_waktu }})</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-medium">{{ $agenda->kelas->nama_kelas }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mata Pelajaran</p>
                    <p class="font-medium">{{ $agenda->mata_pelajaran }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Materi</p>
                    <p class="font-medium">{{ $agenda->materi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat Oleh</p>
                    <p class="font-medium">{{ $agenda->user->name }}</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-500">Kegiatan</p>
                <p class="font-medium">{{ $agenda->kegiatan }}</p>
            </div>
            @if ($agenda->catatan)
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Catatan</p>
                    <p class="font-medium">{{ $agenda->catatan }}</p>
                </div>
            @endif
        </div>

        <!-- Siswa Tidak Hadir -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user-times text-red-600 mr-2"></i>Siswa Tidak Hadir
            </h2>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 max-h-60 overflow-y-auto">
                @if ($siswaTidakHadir->count() > 0)
                    <p class="text-sm text-gray-500 mb-2">Jumlah siswa: {{ $siswaTidakHadir->count() }}</p>
                    <ul class="space-y-2">
                        @foreach ($siswaTidakHadir as $siswa)
                            <li class="flex justify-between items-center py-2 border-b border-red-100 last:border-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $siswa['nama'] }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-500">{{ $siswa['nis'] }}</span>
                                    @php
                                        switch ($siswa['status']) {
                                            case 'sakit':
                                                $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                $statusText = 'Sakit';
                                                break;
                                            case 'izin':
                                                $badgeClass = 'bg-blue-100 text-blue-800';
                                                $statusText = 'Izin';
                                                break;
                                            case 'alpha':
                                                $badgeClass = 'bg-red-100 text-red-800';
                                                $statusText = 'Alpha';
                                                break;
                                            case 'belum_input':
                                                $badgeClass = 'bg-gray-100 text-gray-800';
                                                $statusText = 'Belum Input';
                                                break;
                                            default:
                                                $badgeClass = 'bg-gray-100 text-gray-800';
                                                $statusText = 'Tidak Diketahui';
                                        }
                                    @endphp
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $badgeClass }}">{{ $statusText }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">Tidak ada siswa yang tidak hadir</p>
                    <p class="text-xs text-gray-400 mt-1">Debug: siswaTidakHadir count = {{ $siswaTidakHadir->count() }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Form Tanda Tangan -->
        <form action="{{ route('agenda.sign', $agenda->id) }}" method="POST" id="signatureForm">
            @csrf
            <input type="hidden" name="tanda_tangan" id="tanda_tangan" value="">

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    <i class="fas fa-signature text-blue-600 mr-2"></i>Tanda Tangan Digital
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                    <div class="relative">
                        <canvas id="signatureCanvas" class="bg-white border-2 border-gray-400 rounded-lg cursor-crosshair"
                            width="600" height="250"
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

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Tanda Tangan
                </button>
                <a href="{{ route('agenda.need-signature') }}"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-blue-600 hover:text-blue-600 transition-all flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, initializing signature pad...');

                const canvas = document.getElementById('signatureCanvas');
                const ctx = canvas.getContext('2d');
                const placeholder = document.getElementById('canvasPlaceholder');
                const clearBtn = document.getElementById('clearSignature');
                const form = document.getElementById('signatureForm');
                const signatureInput = document.getElementById('tanda_tangan');

                let isDrawing = false;
                let hasSignature = false;

                // Set canvas background
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Set drawing styles
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                console.log('Canvas initialized');

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

                    e.preventDefault(); // Mencegah submit form default

                    if (!hasSignature) {
                        alert('Harap berikan tanda tangan digital terlebih dahulu!');
                        return false;
                    }

                    // Get signature data
                    const signatureData = canvas.toDataURL('image/png');
                    signatureInput.value = signatureData;

                    console.log('Signature captured, length:', signatureData.length);

                    if (signatureData.length < 50) {
                        alert('Tanda tangan terlalu pendek. Silakan gambar tanda tangan yang lebih jelas.');
                        console.warn('Signature too short:', signatureData.length);
                        return false;
                    }

                    // Submit form via JavaScript
                    form.submit();
                });

                console.log('Signature pad initialized successfully');
            });
        </script>
    @endpush
@endsection
