<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('image/smk.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            overflow: hidden;
        }

        .login-container {
            background: white;
            border-radius: 32px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            max-width: 1050px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
        }

        .login-container::-webkit-scrollbar {
            width: 8px;
        }

        .login-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .login-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .login-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .input-field {
            transition: all 0.3s ease;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
        }

        .input-field:focus {
            background: white;
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .feature-card {
            background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%);
            border: 1px solid #dbeafe;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .slide-in-left {
            animation: slideInLeft 0.7s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.7s ease-out;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .pulse-badge {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .success-animation {
            animation: successPulse 0.6s ease-in-out;
        }

        @keyframes successPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="login-container fade-in">
        <div class="grid lg:grid-cols-2">

            <!-- Left Panel - Info -->
            <div class="p-10 lg:p-12 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 slide-in-left">
                <div class="h-full flex flex-col justify-between">

                    <!-- Logo & Badge -->
                    <div>
                        <div class="flex items-center gap-3 mb-5">
                            <img src="{{ asset('image/smk.png') }}" alt="Logo E-Agenda"
                                class="w-14 h-14 object-contain rounded-2xl shadow-xl">
                            <span class="text-3xl font-bold text-gray-900">E-Agenda</span>
                        </div>


                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-6">
                            <span class="w-2 h-2 bg-blue-500 rounded-full pulse-badge"></span>
                            SMK Negeri 1 Kawali
                        </div>

                        <!-- Headline -->
                        <h1 class="text-3xl lg:text-4xl font-black text-gray-900 leading-tight mb-5">
                            Website Agenda Kelas untuk
                            <span class="gradient-text">
                                Manajemen Pembelajaran Digital
                            </span>
                        </h1>

                        <p class="text-base text-gray-600 leading-relaxed mb-8">
                            Solusi berbasis teknologi untuk memudahkan pencatatan dan pengelolaan agenda kelas secara
                            teratur dan terpusat.
                        </p>

                    </div>
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="p-10 lg:p-12 flex items-center justify-center bg-white slide-in-right">
                <div class="w-full max-w-md">

                    <!-- Welcome -->
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-black text-gray-900 mb-2">Selamat Datang</h2>
                        <p class="text-gray-600">Silakan login untuk melanjutkan</p>
                    </div>

                    <!-- Error Message -->
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form id="loginForm" action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl font-medium @error('email') border-red-500 @enderror"
                                    placeholder="nama@sekolah.ac.id" />
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    class="input-field w-full pl-12 pr-12 py-3.5 rounded-xl font-medium @error('password') border-red-500 @enderror"
                                    placeholder="••••••••" />
                                <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center z-10">
                                    <i id="toggleIcon"
                                        class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500" />
                                <span
                                    class="ml-2 text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Ingat
                                    saya</span>
                            </label>
                            <a href="#"
                                class="text-sm font-bold text-blue-600 hover:text-purple-600 transition-colors">Lupa
                                password?</a>
                        </div>

                        <button type="submit"
                            class="btn-primary w-full py-3.5 rounded-xl text-white font-bold shadow-xl mt-6">
                            <span id="buttonText">Masuk ke Dashboard</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah submit form langsung

            const button = this.querySelector('button[type="submit"]');
            const buttonText = document.getElementById('buttonText');
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                return;
            }

            // Nonaktifkan tombol dan tampilkan loading
            button.disabled = true;
            buttonText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memverifikasi...';

            // Simpan form data
            const formData = new FormData(this);

            // Kirim data dengan fetch
            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tampilkan animasi sukses
                        button.classList.add('success-animation');
                        buttonText.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Login Berhasil!';

                        // Tunggu 2 detik untuk animasi sukses selesai
                        setTimeout(() => {
                            // Redirect ke halaman tujuan
                            window.location.href = data.redirect;
                        }, 2000);
                    } else {
                        // Jika tidak berhasil, tampilkan error
                        // Hapus error lama jika ada
                        const oldError = document.querySelector('.bg-red-50');
                        if (oldError) {
                            oldError.remove();
                        }

                        // Cari pesan error
                        if (data.errors && data.errors.email) {
                            // Tampilkan error baru
                            const errorContainer = document.createElement('div');
                            errorContainer.className = 'mb-4 p-3 bg-red-50 text-red-700 rounded-lg text-sm';
                            errorContainer.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + data.errors.email;

                            // Sisipkan error sebelum form
                            this.parentNode.insertBefore(errorContainer, this);
                        }

                        // Kembalikan tombol ke keadaan semula
                        button.disabled = false;
                        buttonText.innerHTML = 'Masuk ke Dashboard';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Kembalikan tombol ke keadaan semula jika terjadi error
                    button.disabled = false;
                    buttonText.innerHTML = 'Masuk ke Dashboard';
                });
        });
    </script>
</body>
</html>
