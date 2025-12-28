@extends('layout.main')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 pt-24 pb-12 px-4">
    <div class="container mx-auto max-w-2xl">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Ubah Password</h1>
            <p class="text-gray-600 mt-2">Perbarui password Anda dengan yang baru dan lebih aman</p>
        </div>


        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-8">
            <div class="p-8">
                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 8a1 1 0 000 2h6a1 1 0 100-2H8zm0 3a1 1 0 000 2h3a1 1 0 100-2H8z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-blue-900">Password yang Kuat</h3>
                            <p class="text-sm text-blue-700 mt-1">Password Anda harus mengandung minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.</p>
                        </div>
                    </div>
                </div>

                <!-- Change Password Form -->
                <form action="{{ route('profile.update-password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <span>Password Saat Ini</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-200 @error('current_password') border-red-500 @enderror pr-12"
                                placeholder="Masukkan password saat ini Anda"
                                autocomplete="current-password">
                            <button type="button" class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors"
                                onclick="togglePasswordVisibility('current_password', this)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18.101 12.93l-.01.003l.023-.023a6.004 6.004 0 00-8.99-8.99l.023.023l.003-.01A6.004 6.004 0 106.956 15.852a5.989 5.989 0 008.959-1.338l-.002.002l.043-.043a5.998 5.998 0 000-8.477z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <span>Password Baru</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-200 @error('new_password') border-red-500 @enderror pr-12"
                                placeholder="Masukkan password baru Anda"
                                autocomplete="new-password">
                            <button type="button" class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors"
                                onclick="togglePasswordVisibility('new_password', this)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Password Requirements -->
                        <div class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs font-semibold text-gray-700 mb-3">Persyaratan Password:</p>
                            <div class="space-y-2">
                                <div class="flex items-center text-xs text-gray-600" id="req-length">
                                    <svg class="w-4 h-4 mr-2 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Minimal 8 karakter</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600" id="req-upper">
                                    <svg class="w-4 h-4 mr-2 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Huruf besar dan kecil</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600" id="req-number">
                                    <svg class="w-4 h-4 mr-2 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Mengandung angka (0-9)</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600" id="req-symbol">
                                    <svg class="w-4 h-4 mr-2 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Simbol (!@#$%^&*)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <span>Konfirmasi Password Baru</span>
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all duration-200 @error('new_password_confirmation') border-red-500 @enderror pr-12"
                                placeholder="Ulangi password baru Anda"
                                autocomplete="new-password">
                            <button type="button" class="toggle-password absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors"
                                onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('new_password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end items-center space-x-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('profile.show') }}"
                            class="px-6 py-2.5 text-gray-700 font-medium border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md hover:shadow-lg transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Ubah Password</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tips -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Praktik Terbaik</h3>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>✓ Jangan berbagi password dengan orang lain</li>
                    <li>✓ Gunakan password yang unik untuk setiap akun</li>
                    <li>✓ Perbarui password secara berkala</li>
                    <li>✓ Hindari password yang mudah ditebak</li>
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Hindari</h3>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>✗ Tanggal lahir atau nomor identitas</li>
                    <li>✗ Nama orang terkenal atau karakter favorit</li>
                    <li>✗ Pengulangan karakter (aaa, 111, dst)</li>
                    <li>✗ Password yang sama dengan username</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId, button) {
    const field = document.getElementById(fieldId);
    const isPassword = field.type === 'password';
    field.type = isPassword ? 'text' : 'password';

    // Update icon visual
    button.classList.toggle('opacity-50');
}

// Check password requirements
const passwordInput = document.getElementById('new_password');
if (passwordInput) {
    passwordInput.addEventListener('input', function() {
        const password = this.value;

        // Check length
        updateRequirement('req-length', password.length >= 8);

        // Check for uppercase and lowercase
        updateRequirement('req-upper', /[a-z]/.test(password) && /[A-Z]/.test(password));

        // Check for numbers
        updateRequirement('req-number', /\d/.test(password));

        // Check for symbols
        updateRequirement('req-symbol', /[!@#$%^&*]/.test(password));
    });
}

function updateRequirement(elementId, isMet) {
    const element = document.getElementById(elementId);
    const icon = element.querySelector('svg');

    if (isMet) {
        element.classList.remove('text-gray-600');
        element.classList.add('text-green-600');
        icon.classList.remove('text-gray-300');
        icon.classList.add('text-green-500');
    } else {
        element.classList.remove('text-green-600');
        element.classList.add('text-gray-600');
        icon.classList.remove('text-green-500');
        icon.classList.add('text-gray-300');
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
</style>
@endsection
