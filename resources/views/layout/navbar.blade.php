<nav class="fixed w-full bg-white/95 backdrop-blur-lg shadow-sm z-50">
    <div class="container mx-auto px-4 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <img src="{{ asset('image/smk.png') }}" alt="Logo E-Agenda" class="w-9 h-9 object-contain">
                <span class="text-xl font-bold text-gray-900">E-Agenda</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="/dashboard-{{ auth()->user()->role }}"
                    class="{{ request()->is('dashboard-' . auth()->user()->role)
                        ? 'text-blue-600 border-b-2 border-blue-600 pb-1'
                        : 'text-gray-700 hover:text-blue-600' }}
                        font-medium transition-colors">
                    Dashboard
                </a>

                @if (auth()->user()->role == 'admin')
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-1 {{ request()->routeIs('siswa.*') || request()->routeIs('kelas.*') || request()->routeIs('guru.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors focus:outline-none">
                            <span>Data Master</span>
                            <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-1 z-10">
                            <a href="{{ route('siswa.index') }}"
                                class="{{ request()->routeIs('siswa.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Siswa
                                </div>
                            </a>
                            <a href="{{ route('kelas.index') }}"
                                class="{{ request()->routeIs('kelas.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 5h16a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM8 21h8M12 16v5" />
                                    </svg>
                                    Kelas
                                </div>
                            </a>
                            <a href="{{ route('guru.index') }}"
                                class="{{ request()->routeIs('guru.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3l9 4.5-9 4.5L3 7.5 12 3zm0 9v6m-6-3v3c0 1.66 2.69 3 6 3s6-1.34 6-3v-3" />
                                    </svg>
                                    Guru
                                </div>
                            </a>
                            <a href="{{ route('sekretaris.index') }}"
                                class="{{ request()->routeIs('sekretaris.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                    </svg>
                                    Sekretaris
                                </div>
                            </a>
                            <a href="{{ route('mapel.index') }}"
                                class="{{ request()->routeIs('mapel.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v12m8-10v10a2 2 0 01-2 2h-6a2 2 0 00-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h6a2 2 0 002-2h4a2 2 0 012 2z" />
                                    </svg>
                                    Mata Pelajaran
                                </div>
                            </a>
                            <a href="{{ route('wali_kelas.index') }}"
                                class="{{ request()->routeIs('wali_kelas.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 8v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1M4 4h16v6H4z"/>
                                    </svg>
                                    Wali Kelas
                                </div>
                            </a>
                            <a href="{{ route('guru-mapel.index') }}"
                                class="{{ request()->routeIs('guru-mapel.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 8v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1m11-9l1 2 2 .3-1.5 1.4.4 2-1.9-1-1.9 1 .4-2L14 13.3l2-.3z" />
                                    </svg>
                                    Guru Mapel (Legacy)
                                </div>
                            </a>
                            <a href="{{ route('admin.guru-schedule') }}"
                                class="{{ request()->routeIs('admin.guru-schedule') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    📚 Kelola Jadwal Guru
                                </div>
                            </a>
                        </div>
                    </div>
                @endif

                @if (in_array(auth()->user()->role, ['guru', 'sekretaris']))
                    <div class="relative group">
                        <a href="{{ route('agenda.index') }}"
                            class="{{ request()->routeIs('agenda.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors flex items-center gap-1">
                            Agenda
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                        <div
                            class="absolute left-0 mt-0 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                            <a href="{{ route('agenda.index') }}"
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 first:rounded-t-lg last:rounded-b-lg font-medium transition-colors">
                                📋 Daftar Agenda
                            </a>
                        </div>
                    </div>
                @endif

                @if (auth()->user()->role == 'guru')
                    <a href="{{ route('guru.jadwal-saya') }}"
                        class="{{ request()->routeIs('guru.jadwal-saya') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Jadwal Saya
                    </a>
                    <a href="{{ route('absensi.index') }}"
                        class="{{ request()->routeIs('absensi.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Absensi
                    </a>
                @endif

                @if (auth()->user()->role == 'walikelas')
                    <a href="{{ route('rekap.index') }}"
                        class="{{ request()->routeIs('rekap.index') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Rekap
                    </a>
                @endif
            </div>

            <!-- Right Side: Profile & Mobile Menu Button -->
            <div class="flex items-center space-x-3">
                <!-- Profile Section (Hidden on mobile, visible on tablet+) -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-600">{{ auth()->user()->role }}</div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="w-10 h-10 cursor-pointer transform transition-transform duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-full overflow-hidden shadow-md">
                            <img src="{{ asset('image/default_pp.jpg') }}" class="w-full h-full object-cover"
                                alt="Profile">
                        </button>

                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-[999] overflow-hidden">
                            <div class="py-1">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-1">
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Profile
                                    </a>
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Settings
                                    </a>
                                </div>
                                <div class="py-1 border-t border-gray-100">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-3 text-red-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button x-data @click="$dispatch('toggle-mobile-menu')"
                    class="lg:hidden p-2 text-gray-700 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-data="{ mobileMenuOpen: false, dataMasterOpen: false }" @toggle-mobile-menu.window="mobileMenuOpen = !mobileMenuOpen"
        x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="lg:hidden border-t border-gray-100 bg-white">

        <div class="container mx-auto px-4 py-4 space-y-2 max-h-[calc(100vh-80px)] overflow-y-auto">
            <!-- Profile Section (Mobile Only) -->
            <div class="md:hidden flex items-center space-x-3 p-3 bg-gray-50 rounded-lg mb-4">
                <img src="{{ asset('image/default_pp.jpg') }}" class="w-12 h-12 rounded-full object-cover shadow-md"
                    alt="Profile">
                <div>
                    <div class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                    @if (auth()->user()->role == 'admin')
                        <div class="text-xs text-gray-600">Admin Sekolah</div>
                    @else
                        <div class="text-xs text-gray-600">Guru Matematika</div>
                    @endif
                </div>
            </div>

            <!-- Dashboard Link -->
            <a href="/dashboard-{{ auth()->user()->role }}"
                class="{{ request()->is('dashboard-' . auth()->user()->role)
                    ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600'
                    : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}
                    block px-4 py-3 rounded-lg font-medium transition-colors">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </div>
            </a>

            <!-- Data Master (Admin Only) -->
            @if (auth()->user()->role == 'admin')
                <div>
                    <button @click="dataMasterOpen = !dataMasterOpen"
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-lg font-medium transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Data Master
                        </div>
                        <svg class="w-4 h-4 transform transition-transform duration-200"
                            :class="{ 'rotate-180': dataMasterOpen }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <div x-show="dataMasterOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="mt-2 ml-4 space-y-1 border-l-2 border-gray-200 pl-4">
                        <a href="{{ route('siswa.index') }}"
                            class="{{ request()->routeIs('siswa.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Siswa
                            </div>
                        </a>
                        <a href="{{ route('kelas.index') }}"
                            class="{{ request()->routeIs('kelas.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 5h16a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM8 21h8M12 16v5" />
                                </svg>
                                Kelas
                            </div>
                        </a>
                        <a href="{{ route('guru.index') }}"
                            class="{{ request()->routeIs('guru.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3l9 4.5-9 4.5L3 7.5 12 3zm0 9v6m-6-3v3c0 1.66 2.69 3 6 3s6-1.34 6-3v-3" />
                                </svg>
                                Guru
                            </div>
                        </a>
                        <a href="{{ route('sekretaris.index') }}"
                            class="{{ request()->routeIs('sekretaris.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                </svg>
                                Sekretaris
                            </div>
                        </a>
                        <a href="{{ route('mapel.index') }}"
                            class="{{ request()->routeIs('mapel.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v12m8-10v10a2 2 0 01-2 2h-6a2 2 0 00-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h6a2 2 0 002-2h4a2 2 0 012 2z" />
                                </svg>
                                Mata Pelajaran
                            </div>
                        </a>
                        <a href="{{ route('wali_kelas.index') }}"
                            class="{{ request()->routeIs('wali_kelas.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 8v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1m11-9l1 2 2 .3-1.5 1.4.4 2-1.9-1-1.9 1 .4-2L14 13.3l2-.3z" />
                                </svg>
                                Wali Kelas
                            </div>
                        </a>
                        <a href="{{ route('guru-mapel.index') }}"
                            class="{{ request()->routeIs('guru-mapel.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 8v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1m11-9l1 2 2 .3-1.5 1.4.4 2-1.9-1-1.9 1 .4-2L14 13.3l2-.3z" />
                                </svg>
                                Guru Mapel
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Agenda Link (Guru & Sekretaris) -->
            @if (in_array(auth()->user()->role, ['guru', 'sekretaris']))
                <div class="space-y-1">
                    <a href="{{ route('agenda.index') }}"
                        class="{{ request()->routeIs('agenda.index') ? 'bg-blue-50 text-blue-600 border-l-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }} block px-4 py-3 rounded-lg font-medium transition-colors">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            📋 Daftar Agenda
                        </div>
                    </a>
                </div>
            @endif


            <!-- Divider -->
            <div class="md:hidden border-t border-gray-200 my-4"></div>

            <!-- Profile Actions (Mobile Only) -->
            <div class="md:hidden space-y-1">
                <a href="#"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                        </path>
                    </svg>
                    <span class="font-medium">Profile</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Settings</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
