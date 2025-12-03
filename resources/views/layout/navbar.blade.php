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



                @if (in_array(auth()->user()->peran, ['admin']))
                    <div x-data="{ open: false }" class="relative">
                        <!-- Dropdown Trigger -->
                        <button @click="open = !open"
                            class="font-medium transition-colors flex items-center gap-1
        {{ request()->routeIs('siswa.*') ? 'text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">

                            {{-- Jika di halaman siswa → tulisan berubah --}}
                            {{ request()->routeIs('siswa.*') ? 'Siswa' : (request()->routeIs('guru.*') ? 'Guru' : 'Users') }}

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.268l3.71-4.04a.75.75 0 111.08 1.04l-4.24 4.62a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute bg-white rounded shadow-md mt-2 w-40 py-2 z-20">

                            <a href="{{ route('siswa.index') }}" @click="open = false"
                                class="block px-4 py-2
            {{ request()->routeIs('siswa.*') ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                Siswa
                            </a>
                            <a href="{{ route('guru.index') }}" @click="open = false"
                                class="block px-4 py-2
            {{ request()->routeIs('guru.*') ? 'text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100' }}">
                                Guru
                            </a>

                        </div>
                    </div>

                    <a href="{{ route('kelas.index') }}"
                        class="{{ request()->is('kelas')
                            ? 'text-blue-600 border-b-2 border-blue-600 pb-1'
                            : 'text-gray-700 hover:text-blue-600' }}
                        font-medium transition-colors">
                        Kelas
                    </a>
                @endif


                @if (in_array(auth()->user()->peran, ['guru']))
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
                @endif






            </div>


            <div class="flex items-center space-x-4">
                <button
                    class="hidden sm:flex items-center space-x-2 px-4 py-2 text-gray-700 hover:text-blue-600 transition-colors relative">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="w-2 h-2 bg-red-500 rounded-full absolute top-3 right-3"></span>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama_lengkap }}</div>
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
