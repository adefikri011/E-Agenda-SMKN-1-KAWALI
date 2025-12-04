<nav class="fixed w-full bg-white/95 backdrop-blur-lg shadow-sm z-50">
    <div class="container mx-auto px-4 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('asset/logoo.png') }}" alt="Logo E-Agenda" class="w-9 h-9 object-contain">
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
                            class="flex items-center space-x-1 {{ request()->routeIs('siswa.*') || request()->routeIs('kelas.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-700 hover:text-blue-600' }} font-medium transition-colors focus:outline-none">
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
                    <div x-data="{ open: false }" class="dropdown dropdown-end">

                        <!-- BUTTON FOTO PROFIL -->
                        <div tabindex="0" @click="open = !open" class="w-10 h-10 cursor-pointer">
                            <img src="{{ asset('asset/profileD.png') }}" class="w-10 h-10 object-cover rounded-full"
                                alt="Profile">
                        </div>

                        <!-- MENU DROPDOWN -->
                        <ul x-show="open" @click.outside="open = false" tabindex="-1"
                            class="dropdown-content menu bg-white rounded-box z-[999] w-40 p-2 shadow-md border">

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-red-600 font-medium">
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>



                </div>
            </div>
        </div>
    </div>
</nav>
