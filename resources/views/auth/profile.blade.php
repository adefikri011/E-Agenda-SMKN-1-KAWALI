@extends('layout.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 pb-12 -mx-4 lg:-mx-8">
    <div class="max-w-4xl mx-auto px-4 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-2xl font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
                    <p class="text-gray-500 mt-1">Kelola informasi akun Anda</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-8 border-b border-gray-200">
            <div class="flex space-x-8">
                <button type="button" onclick="switchTab('profile', this)"
                    class="tab-button active pb-4 px-1 font-medium text-gray-900 border-b-2 border-blue-600 transition-colors duration-200"
                    data-tab="profile">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Profil
                </button>
                <button type="button" onclick="switchTab('security', this)"
                    class="tab-button pb-4 px-1 font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300 transition-colors duration-200"
                    data-tab="security">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Keamanan
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="space-y-8">
            <!-- Profile Tab -->
            <div id="profile-tab" class="tab-content active">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Profil</h2>

                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-200 @error('name') border-red-500 @enderror"
                                    placeholder="Masukkan nama lengkap Anda">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-200 @error('email') border-red-500 @enderror"
                                    placeholder="Masukkan email Anda">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role Field (Read-only) -->
                            <div>
                                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Role / Peran
                                </label>
                                <div class="px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-700 font-medium">
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold"
                                        style="background-color: {{ getRoleColor(auth()->user()->role)['bg'] }}; color: {{ getRoleColor(auth()->user()->role)['text'] }};">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end items-center space-x-4 pt-6 border-t border-gray-100">
                                <a href="{{ route('dashboard.' . auth()->user()->role) }}"
                                    class="px-6 py-2.5 text-gray-700 font-medium border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md hover:shadow-lg transition-all duration-200 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div id="security-tab" class="tab-content">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Keamanan Akun</h2>
                        <p class="text-gray-600 mb-6">Kelola pengaturan keamanan dan ubah password Anda</p>

                        <!-- Change Password Section -->
                        <div class="space-y-8">
                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-lg p-6">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-amber-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <h3 class="font-semibold text-amber-900">Tips Keamanan</h3>
                                        <p class="text-sm text-amber-700 mt-1">Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk melindungi akun Anda.</p>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('profile.change-password') }}"
                                class="block p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-all duration-200 cursor-pointer group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.753 5.917m-2.106-4.986V5m0 0a2 2 0 112 2h.01M7 14H5.414a1 1 0 00-.707.293l-2.414 2.414"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">Ubah Password</h4>
                                            <p class="text-sm text-gray-600">Perbarui password Anda dengan yang baru dan lebih aman</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600 transition-colors transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Info Footer -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-blue-600 font-medium">Dibuat</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-blue-600 font-medium">Treakhir Update</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ auth()->user()->updated_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-blue-600 font-medium">Status</p>
                    <p class="text-lg font-semibold text-green-600 mt-1">✓ Aktif</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName, clickedBtn) {
    // Hide all tabs by removing active class
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active state from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('border-b-2', 'border-blue-600', 'text-gray-900');
        btn.classList.add('border-transparent', 'text-gray-600');
    });

    // Show selected tab by adding active class
    const targetTab = document.getElementById(tabName + '-tab');
    if (targetTab) {
        targetTab.classList.add('active');
    }

    // Add active state to clicked button
    let targetBtn = clickedBtn;
    if (!targetBtn) {
        targetBtn = document.querySelector(`.tab-button[data-tab="${tabName}"]`);
    }
    if (targetBtn) {
        targetBtn.classList.add('border-b-2', 'border-blue-600', 'text-gray-900');
        targetBtn.classList.remove('border-transparent', 'text-gray-600');
    }
}
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-in {
    animation: fadeIn 0.3s ease-out;
}

.tab-button {
    position: relative;
    display: inline-flex;
    align-items: center;
}

/* Tab Content Visibility Control */
.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
    animation: fadeIn 0.3s ease-out;
}
</style>
@endsection
