<!-- Premium Navbar with Sky Blue Theme -->
<nav id="navbar" class="fixed w-full z-50 transition-all duration-500"
    style="background: linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02)); backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px); box-shadow: 0 8px 30px rgba(2,6,23,0.06); border-bottom: 1px solid rgba(255,255,255,0.06);">
    <div class="container mx-auto px-4 lg:px-6 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo Section -->
            <div class="flex items-center space-x-4 group cursor-pointer">
                <!-- Clean rounded logo (larger, responsive) -->
                <img src="{{ asset('image/logo10.png') }}" alt="Logo E-Agenda"
                    class="w-14 h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 rounded-full object-cover shadow-md transform transition-all duration-300 group-hover:scale-105"
                    loading="eager" decoding="async">

                <div class="flex flex-col">
                    <span id="brand-text"
                        class="text-2xl md:text-3xl font-black text-white leading-tight tracking-tight drop-shadow-sm">
                        E-Agenda
                    </span>
                    <span id="subtitle-text"
                        class="text-[11px] md:text-[12px] font-semibold text-white/90 tracking-wider drop-shadow-sm">
                        SMKN 1 KAWALI
                    </span>
                </div>

            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="#beranda"
                    class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Beranda</span>
                    <div
                        class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full">
                    </div>
                </a>
                <a href="#fitur"
                    class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Fitur</span>
                    <div
                        class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full">
                    </div>
                </a>
                <a href="#manfaat"
                    class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Manfaat</span>
                    <div
                        class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full">
                    </div>
                </a>
                <a href="#tim"
                    class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Tim Kami</span>
                    <div
                        class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full">
                    </div>
                </a>
                <a href="#kontak"
                    class="nav-link group relative px-5 py-2.5 text-gray-800 hover:text-sky-700 font-semibold text-sm rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 drop-shadow-sm">
                    <span class="relative z-10">Kontak</span>
                    <div
                        class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-0 h-0.5 bg-gradient-to-r from-sky-500 to-cyan-500 group-hover:w-3/4 transition-all duration-300 rounded-full">
                    </div>
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('login') }}"
                    class="hidden sm:flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-500/90 via-cyan-500/90 to-blue-600/90 rounded-xl hover:shadow-lg hover:shadow-sky-300/50 hover:scale-105 transition-all duration-300 group backdrop-blur-sm">
                    <span>Masuk</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>

                <!-- Mobile menu button -->
                <button
                    class="lg:hidden relative p-2.5 rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group backdrop-blur-sm"
                    id="mobile-menu-button">
                    <div class="w-6 h-5 flex flex-col justify-between">
                        <span
                            class="w-full h-0.5 bg-sky-600 rounded-full transform transition-all duration-300 group-hover:bg-cyan-600"></span>
                        <span
                            class="w-full h-0.5 bg-sky-600 rounded-full transform transition-all duration-300 group-hover:bg-cyan-600"></span>
                        <span
                            class="w-full h-0.5 bg-sky-600 rounded-full transform transition-all duration-300 group-hover:bg-cyan-600"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Premium Mobile Menu -->
    <div class="lg:hidden hidden bg-white/40 backdrop-blur-2xl border-t border-sky-100/30 shadow-2xl" id="mobile-menu">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="#beranda"
                class="mobile-nav-link flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Beranda</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#fitur"
                class="mobile-nav-link flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Fitur</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#manfaat"
                class="mobile-nav-link flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Manfaat</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#tim"
                class="mobile-nav-link flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Tim Kami</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#kontak"
                class="mobile-nav-link flex items-center justify-between px-5 py-3.5 text-gray-800 hover:text-sky-700 font-semibold rounded-xl hover:bg-gradient-to-r hover:from-sky-50/70 hover:to-cyan-50/70 transition-all duration-300 group drop-shadow-sm">
                <span>Kontak</span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform text-sky-400"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>

            <div class="pt-4 border-t border-sky-100/30">
                <a href="{{ route('login') }}"
                    class="flex items-center justify-center gap-2 w-full px-5 py-3.5 text-center text-white font-bold bg-gradient-to-r from-sky-500/90 via-cyan-500/90 to-blue-600/90 rounded-xl hover:shadow-lg hover:shadow-sky-300/50 hover:scale-105 transition-all duration-300 backdrop-blur-sm">
                    <span>Masuk Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar scrolled: slightly stronger glass + shadow (still transparent) */
    #navbar.scrolled {
        background: linear-gradient(180deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04));
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 14px 40px rgba(2,6,23,0.09);
        border-bottom: 1px solid rgba(255,255,255,0.08);
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

    /* Active state untuk nav link */
    .nav-link.active-nav {
        background: linear-gradient(to right, rgba(14, 165, 233, 0.15), rgba(6, 182, 212, 0.15));
        color: #0369a1;
    }

    .nav-link.active-nav::after {
        width: 75%;
    }

    /* Active state untuk mobile nav link */
    .mobile-nav-link.active-nav {
        background: linear-gradient(to right, rgba(14, 165, 233, 0.2), rgba(6, 182, 212, 0.2));
        color: #0369a1;
        border-left: 3px solid #0ea5e9;
    }

    /* Nav links di section gelap (beranda) */
    .nav-link.on-dark {
        color: white;
    }

    .nav-link.on-dark:hover {
        color: #7dd3fc;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    }

    .nav-link.on-dark.active-nav {
        background: linear-gradient(to right, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.1));
        color: #7dd3fc;
    }

    /* Mobile nav links di section gelap */
    .mobile-nav-link.on-dark {
        color: white;
    }

    .mobile-nav-link.on-dark:hover {
        color: #7dd3fc;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    }

    .mobile-nav-link.on-dark.active-nav {
        background: linear-gradient(to right, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.15));
        color: #7dd3fc;
        border-left-color: #7dd3fc;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const brand = document.getElementById('brand-text');
        const subtitle = document.getElementById('subtitle-text');
        const sections = document.querySelectorAll('[data-bg]');

        if (!brand || !subtitle || sections.length === 0) return;

        // Require section to be at least 40% visible before toggling — avoids early flips
        const REQUIRED_RATIO = 0.4;
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // Only act when a decent portion of the section is visible
                if (entry.intersectionRatio < REQUIRED_RATIO) return;

                if (entry.target.dataset.bg === 'light') {
                    brand.classList.remove('text-white');
                    brand.classList.add('text-sky-600');

                    subtitle.classList.remove('text-white/80');
                    subtitle.classList.add('text-sky-600/80');
                } else {
                    brand.classList.remove('text-sky-600');
                    brand.classList.add('text-white');

                    subtitle.classList.remove('text-sky-600/80');
                    subtitle.classList.add('text-white/80');
                }
            });
        }, {
            threshold: [REQUIRED_RATIO]
        });

        sections.forEach(section => observer.observe(section));

        // Run an initial check to set correct brand color on page load
        (function initialBrandCheck() {
            let found = false;
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (!found && rect.top <= 120 && rect.bottom >= 120) {
                    if (section.dataset.bg === 'light') {
                        brand.classList.remove('text-white');
                        brand.classList.add('text-sky-600');
                        subtitle.classList.remove('text-white/80');
                        subtitle.classList.add('text-sky-600/80');
                    } else {
                        brand.classList.remove('text-sky-600');
                        brand.classList.add('text-white');
                        subtitle.classList.remove('text-sky-600/80');
                        subtitle.classList.add('text-white/80');
                    }
                    found = true;
                }
            });
        })();
    });

    // Function untuk update active nav link berdasarkan scroll position
    function updateActiveNavLink() {
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');

        // Ambil semua section yang ada di halaman
        const sections = ['beranda', 'fitur', 'manfaat', 'tim', 'kontak'];
        let currentSection = '';

        // Cari section mana yang sedang terlihat
        sections.forEach(sectionId => {
            const section = document.getElementById(sectionId);
            if (section) {
                const rect = section.getBoundingClientRect();
                // Section dianggap aktif jika berada di viewport bagian atas
                // Menggunakan offset 150px dari top untuk mendeteksi section aktif
                if (rect.top <= 150 && rect.bottom >= 150) {
                    currentSection = sectionId;
                }
            }
        });

        // Hapus semua active state dan dark mode state
        navLinks.forEach(link => {
            link.classList.remove('active-nav', 'on-dark');
        });
        mobileLinks.forEach(link => {
            link.classList.remove('active-nav', 'on-dark');
        });

        // Jika di section beranda (dark background), tambahkan class on-dark ke semua links
        if (currentSection === 'beranda') {
            navLinks.forEach(link => {
                link.classList.add('on-dark');
            });
            mobileLinks.forEach(link => {
                link.classList.add('on-dark');
            });
        }

        // Tambahkan active state ke link yang sesuai
        if (currentSection) {
            navLinks.forEach(link => {
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('active-nav');
                }
            });
            mobileLinks.forEach(link => {
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('active-nav');
                }
            });
        }
    }

    // Jalankan saat scroll
    window.addEventListener('scroll', () => {
        updateActiveNavLink();

        // Enhanced scroll effect dengan transparansi
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
            navbar.style.padding = '0.5rem 0';
        } else {
            navbar.classList.remove('scrolled');
            navbar.style.padding = '0.75rem 0';
        }
    });

    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', updateActiveNavLink);

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
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>
