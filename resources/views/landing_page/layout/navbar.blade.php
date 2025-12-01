<!-- Navbar -->
<nav class="fixed w-full bg-white/95 backdrop-blur-lg shadow-sm z-50 transition-all duration-300" id="navbar">
    <div class="container mx-auto px-4 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <!-- Bagian Logo yang Diperbaiki -->
            <div class="flex items-center space-x-2 group">
                <div class="relative overflow-hidden rounded-lg">
                    <img src="{{ asset('image/logoo.png') }}" alt="Logo E-Agenda"
                        class="w-12 h-12 object-contain transform transition-transform duration-300 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-linear-to-r from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg">
                    </div>
                </div>
                <span
                    class="text-2xl font-extrabold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent leading-none">
                    E-Agenda
                </span>

            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="#beranda"
                    class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium text-sm rounded-lg hover:bg-blue-50 transition-all">Beranda</a>
                <a href="#fitur"
                    class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium text-sm rounded-lg hover:bg-blue-50 transition-all">Fitur</a>
                <a href="#manfaat"
                    class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium text-sm rounded-lg hover:bg-blue-50 transition-all">Manfaat</a>
                <a href="#tim"
                    class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium text-sm rounded-lg hover:bg-blue-50 transition-all">Tim
                    Kami</a>
                <a href="#kontak"
                    class="nav-link px-4 py-2 text-gray-700 hover:text-blue-600 font-medium text-sm rounded-lg hover:bg-blue-50 transition-all">Kontak</a>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-3">
                <a href=""
                    class="hidden sm:block px-4 py-2 text-sm text-gray-700 hover:text-blue-600 font-medium transition-colors rounded-lg hover:bg-gray-50">
                    Masuk
                </a>

                <!-- Mobile menu button -->
                <button class="lg:hidden text-gray-700 p-2 rounded-lg hover:bg-gray-100" id="mobile-menu-button">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg" id="mobile-menu">
        <div class="container mx-auto px-4 py-3 space-y-1">
            <a href="#beranda"
                class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all">Beranda</a>
            <a href="#fitur"
                class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all">Fitur</a>
            <a href="#manfaat"
                class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all">Manfaat</a>
            <a href="#tim"
                class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all">Tim
                Kami</a>
            <a href="#kontak"
                class="block px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 font-medium rounded-lg transition-all">Kontak</a>
            <div class="pt-3 flex flex-col sm:flex-row gap-3">
                <a href=""
                    class="px-4 py-2 text-center text-gray-700 hover:text-blue-600 font-medium border border-gray-300 rounded-lg hover:border-blue-300 transition-all">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</nav>
