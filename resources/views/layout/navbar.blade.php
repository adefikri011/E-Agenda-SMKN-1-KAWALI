<nav class="fixed w-full bg-white/95 backdrop-blur-lg shadow-sm z-50">
    <div class="container mx-auto px-4 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('image/logoo.png') }}" alt="Logo E-Agenda" class="w-9 h-9 object-contain">
                <span class="text-xl font-bold text-gray-900">E-Agenda</span>
            </div>

            <div class="hidden md:flex items-center space-x-8">
                <a href="/dashboard-{{ auth()->user()->role }}"
                    class="{{ request()->is('dashboard-' . auth()->user()->peran)
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
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div
                            class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform group-hover:translate-y-0 translate-y-1 z-10">
                            <a href="{{ route('siswa.index') }}"
                                class="{{ request()->routeIs('siswa.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
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
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Kelas
                                </div>
                            </a>
                            <a href="{{ route('guru.index') }}"
                             class="{{ request()->routeIs('guru.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                            1.79-4 4 1.79 4 4 4zm6 10v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1h12z"/>
                                    </svg>
                                    Guru
                             </div>
                            </a>
                            <a href="{{ route('sekretaris.index') }}"
                             class="{{ request()->routeIs('sekretaris.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-2 text-sm font-medium transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                            1.79-4 4 1.79 4 4 4zm6 10v-1a4 4 0 00-4-4H10a4 4 0 00-4 4v1h12z"/>
                                    </svg>
                                    Sekretaris
                             </div>
                            </a>
                        </div>
                    </div>
                @endif


                {{-- @if (in_array(auth()->user()->peran, ['guru']))
                    <a href="{{ route('agenda.index') }}"
                        class="{{ request()->routeIs('agenda.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Agenda
                    </a>

                    <a href="{{ route('absensi.index') }}"
                        class="{{ request()->routeIs('absensi.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Absensi
                    </a>

                    <a href="#"
                        class="{{ request()->is('tugas') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Tugas
                    </a>

                    <a href="#"
                        class="{{ request()->is('nilai') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors">
                        Nilai
                    </a>
                @endif --}}

            </div>


            <div class="flex items-center space-x-4">
                <button
                    class="hidden sm:flex items-center space-x-2 px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="w-2 h-2 bg-red-500 rounded-full absolute top-3 right-3"></span>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                        @if (auth()->user()->peran == 'admin')
                            <div class="text-xs text-gray-600">Admin Sekolah</div>
                        @else
                            <div class="text-xs text-gray-600">Guru Matematika</div>
                        @endif

                    </div>
                    <div x-data="{ open: false }" class="relative">
                        <!-- BUTTON PROFIL -->
                        <button @click="open = !open"
                            class="w-12 h-12 cursor-pointer transform transition-transform duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-full overflow-hidden shadow-md">
                            <img src="{{ asset('image/default_pp.jpg') }}" class="w-full h-full object-cover"
                                alt="Profile">
                        </button>

                        <!-- MENU -->
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
                                    <p class="text-sm font-medium text-gray-900">Admin User</p>
                                    <p class="text-xs text-gray-500 truncate">admin@example.com</p>
                                </div>
                                <div class="py-1">
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Profile
                                    </a>
                                    <a href="#"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
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
            </div>
        </div>
    </div>
</nav>
