<!-- Premium Navbar with Sky Blue Theme -->
<nav class="fixed w-full bg-white/30 backdrop-blur-2xl shadow-sm z-50 transition-all duration-500 border-b border-sky-100/30" id="navbar">
    <div class="container mx-auto px-4 lg:px-6 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3 group cursor-pointer">
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-sky-50/80 to-cyan-50/80 p-2 shadow-lg shadow-sky-200/50 border border-sky-100/50">
                    <img src="{{ asset('image/logo10.png') }}" alt="Logo E-Agenda"
                        class="w-10 h-10 object-contain transform transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-sky-400/20 to-cyan-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black bg-gradient-to-r from-sky-600 via-cyan-600 to-blue-600 bg-clip-text text-transparent leading-tight tracking-tight drop-shadow-sm">
                        E-Agenda
                    </span>
                    <span class="text-[10px] font-semibold text-sky-600/80 tracking-wider drop-shadow-sm">SMKN 1 KAWALI</span>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="#beranda" class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Beranda</span>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full"></div>
                </a>
                <a href="#fitur" class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Fitur</span>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full"></div>
                </a>
                <a href="#manfaat" class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Manfaat</span>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full"></div>
                </a>
                <a href="#tim" class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Tim Kami</span>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full"></div>
                </a>
                <a href="#kontak" class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Kontak</span>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full"></div>
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}" class="hidden sm:flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500/90 via-cyan-500/90 to-blue-600/90 rounded-xl hover:shadow-lg hover:shadow-sky-300/50 hover:scale-105 transition-all duration-300 group backdrop-blur-sm">
                    <span>Masuk</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>

                <!-- Mobile menu button -->
                <button class="lg:hidden relative p-2.5 rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group backdrop-blur-sm" id="mobile-menu-button">
                    <div class="w-6 h-5 flex flex-col justify-between">
                        <span class="w-full h-0.5 bg-sky-600 rounded-full transform transition-all duration-300 group-hover:bg-cyan-600"></span>
                        <span class="w-full h-0.5 bg-sky-600 rounded-full transform transition-all duration-300 group-hover:bg-cyan-600"></span>
                        <span class="w-full h-0.5 bg-sky-600 rounded-full transform transition-all duration-300 group-hover:bg-cyan-600"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Premium Mobile Menu -->
    <div class="lg:hidden hidden bg-white/40 backdrop-blur-2xl border-t border-sky-100/30 shadow-2xl" id="mobile-menu">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="#beranda" class="flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Beranda</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#fitur" class="flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Fitur</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#manfaat" class="flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Manfaat</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#tim" class="flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Tim Kami</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#kontak" class="flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Kontak</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <div class="pt-4 border-t border-sky-100/30">
                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full px-5 py-3.5 text-center text-white font-bold bg-gradient-to-r from-sky-500/90 via-cyan-500/90 to-blue-600/90 rounded-xl hover:shadow-lg hover:shadow-sky-300/50 hover:scale-105 transition-all duration-300 backdrop-blur-sm">
                    <span>Masuk Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar scroll effect dengan transparansi */
    #navbar.scrolled {
        background: rgba(255, 255, 255, 0.4) !important;
        backdrop-filter: blur(20px);
        box-shadow: 0 4px 30px rgba(14, 165, 233, 0.1);
        border-bottom: 1px solid rgba(14, 165, 233, 0.15);
    }

    /* Smooth underline effect */
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #0ea5e9, #06b6d4);
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    .nav-link:hover::after {
        width: 80%;
    }
</style>

<script>
    // Mobile menu toggle (guard checks)
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        mobileMenuButton.setAttribute('aria-controls', 'mobile-menu');
        mobileMenuButton.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.toggle('hidden');
            mobileMenuButton.setAttribute('aria-expanded', String(!isHidden));
        });
    }

    // Enhanced scroll effect dengan transparansi
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');

        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            navbar.style.padding = '0.5rem 0';
        } else {
            navbar.classList.remove('scrolled');
            navbar.style.padding = '0.75rem 0';
        }
    });

    // Smooth scroll untuk semua anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));

            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            // Tutup mobile menu setelah klik
            mobileMenu.classList.add('hidden');
        });
    });
</script>
