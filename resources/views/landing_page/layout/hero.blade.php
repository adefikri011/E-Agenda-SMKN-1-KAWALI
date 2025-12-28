<!-- Hero Section - SMKN 1 Kawali Ultra Modern -->
<section id="beranda" data-bg="dark" class="relative min-h-screen flex items-center overflow-hidden pt-20">

    <!-- Full Background Image with Students & Building -->
    <div class="absolute inset-0 z-0">
        <!-- School Photo - Nanti ganti dengan foto SMKN 1 Kawali yang ada bangunan dan siswa -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url({{ asset('image/smk1.JPG') }});"></div>

        <!-- Sophisticated Gradient Overlay - Tidak terlalu gelap, biar keliatan foto -->
        <div class="absolute inset-0 bg-gradient-to-r from-sky-900/85 via-cyan-800/75 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/70 via-transparent to-transparent"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 py-24 relative z-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <!-- Left Content -->
                <div class="space-y-8 animate-fade-in">

                    <!-- Premium School Badge -->
                    <div class="inline-flex items-center gap-4 bg-white/15 backdrop-blur-3xl px-6 py-4 rounded-3xl border border-white/30 shadow-2xl">
                        <div class="relative">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-2xl">
                                <!-- Logo SMKN 1 Kawali -->
                                <svg class="w-10 h-10 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                </svg>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-white font-black text-2xl tracking-tight">SMKN 1 KAWALI</h2>
                            <p class="text-white/90 text-sm font-bold">Sekolah Menengah Kejuruan Negeri</p>
                        </div>
                    </div>

                    <!-- Super Bold Headline -->
                    <div class="space-y-6">
                        <h1 class="text-6xl sm:text-7xl lg:text-8xl font-black text-white leading-[0.9] tracking-tighter drop-shadow-2xl">
                            Kelola<br>
                            Agenda &<br>
                            Absensi<br>
                            <span class="relative inline-block">
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-amber-300 to-yellow-400">
                                    Lebih Efisien
                                </span>
                                <svg class="absolute -bottom-4 left-0 w-full h-3 text-yellow-400/60" viewBox="0 0 300 12" fill="none">
                                    <path d="M2 8C60 3 120 1 298 5" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
                                </svg>
                            </span>
                        </h1>

                        <p class="text-2xl text-white/95 font-semibold leading-relaxed max-w-xl drop-shadow-lg">
                            Sistem manajemen pembelajaran digital yang menghubungkan seluruh ekosistem sekolah dalam satu platform modern.
                        </p>


                    </div>

                    <!-- Clean Feature Tags -->
                    <div class="flex flex-wrap gap-3">
                        <div class="bg-white/20 backdrop-blur-2xl px-5 py-3 rounded-2xl border border-white/40 shadow-xl">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                                <span class="text-white font-bold text-sm">Real-time Update</span>
                            </div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-2xl px-5 py-3 rounded-2xl border border-white/40 shadow-xl">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></div>
                                <span class="text-white font-bold text-sm">Cloud Based</span>
                            </div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-2xl px-5 py-3 rounded-2xl border border-white/40 shadow-xl">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></div>
                                <span class="text-white font-bold text-sm">Multi Platform</span>
                            </div>
                        </div>
                    </div>

                    <!-- Elegant Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="text-center lg:text-left space-y-2">
                            <div class="text-5xl lg:text-6xl font-black text-white drop-shadow-2xl">1K+</div>
                            <div class="text-white/90 text-sm font-bold tracking-wide">SISWA AKTIF</div>
                        </div>
                        <div class="text-center lg:text-left space-y-2">
                            <div class="text-5xl lg:text-6xl font-black text-white drop-shadow-2xl">50+</div>
                            <div class="text-white/90 text-sm font-bold tracking-wide">GURU TERDAFTAR</div>
                        </div>
                        <div class="text-center lg:text-left space-y-2">
                            <div class="text-5xl lg:text-6xl font-black text-white drop-shadow-2xl">30+</div>
                            <div class="text-white/90 text-sm font-bold tracking-wide">KELAS AKTIF</div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - TIDAK ADA CONTENT, BIAR KELIATAN FOTO -->
                <div class="hidden lg:block">
                    <!-- Intentionally empty to show background photo of students & building -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Bottom Wave -->
    <div class="absolute bottom-0 left-0 w-full z-20">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 100L48 93.3C96 86.7 192 73.3 288 66.7C384 60 480 60 576 63.3C672 66.7 768 73.3 864 76.7C960 80 1056 80 1152 76.7C1248 73.3 1344 66.7 1392 63.3L1440 60V100H1392C1344 100 1248 100 1152 100C1056 100 960 100 864 100C768 100 672 100 576 100C480 100 384 100 288 100C192 100 96 100 48 100H0Z" fill="white"/>
        </svg>
    </div>

    <!-- Floating Scroll Indicator -->
    <div class="absolute bottom-28 left-1/2 transform -translate-x-1/2 hidden lg:flex flex-col items-center gap-3 z-30 animate-bounce-slow">
        <div class="w-8 h-12 border-3 border-white/40 rounded-full flex justify-center pt-2">
            <div class="w-1.5 h-3 bg-white/60 rounded-full animate-scroll"></div>
        </div>
        <span class="text-white/70 text-xs font-bold tracking-wider">SCROLL</span>
    </div>

    <!-- Decorative Corner Elements -->
    <div class="absolute top-24 right-8 w-20 h-20 border-4 border-white/20 rounded-2xl rotate-12 hidden xl:block"></div>
    <div class="absolute top-40 right-24 w-12 h-12 border-4 border-white/20 rounded-xl -rotate-12 hidden xl:block"></div>
</section>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-15px);
        }
    }

    @keyframes scroll {
        0% {
            transform: translateY(0);
            opacity: 0;
        }
        40% {
            opacity: 1;
        }
        80% {
            transform: translateY(20px);
            opacity: 0;
        }
        100% {
            opacity: 0;
        }
    }

    .animate-fade-in {
        animation: fade-in 1.2s ease-out forwards;
    }

    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }

    .animate-scroll {
        animation: scroll 2s ease-in-out infinite;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        h1 {
            font-size: 4rem;
        }
    }

    @media (max-width: 640px) {
        h1 {
            font-size: 3rem;
        }
    }
</style>
