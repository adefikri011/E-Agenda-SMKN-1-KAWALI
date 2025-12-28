<!-- Sky Blue Professional Contact Section with Map -->
<section data-bg="light" class="py-20 lg:py-32 bg-gradient-to-br from-sky-50 via-cyan-50 to-blue-50 relative overflow-hidden" id="kontak">
    <!-- Animated Wave Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <svg class="absolute top-0 left-0 w-full h-64 opacity-30" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#0ea5e9" fill-opacity="0.2" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
        </svg>
        <div class="absolute top-40 -left-20 w-80 h-80 bg-sky-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 -right-20 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full mb-6 border border-sky-200/50 shadow-lg">
                <span class="text-sm font-bold text-sky-700 tracking-wider uppercase">Contacts</span>
            </div>

            <h2 class="text-4xl lg:text-6xl font-black text-gray-900 mb-6 leading-tight">
                Hubungi Kami
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            <!-- Left Side - Contact Form -->
            <div class="order-2 lg:order-1">
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-sky-200/50 p-8 lg:p-10 border border-sky-100">
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h3 class="text-3xl font-black text-gray-900 mb-2">Contact Form</h3>
                    </div>

                    <form class="space-y-6" action="{{ route('kirim.pesan') }}" method="POST">
                        @csrf

                        <!-- Name Input -->
                        <div class="group">
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-sky-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="name" name="name" required
                                    class="w-full pl-12 pr-5 py-4 bg-sky-50/50 border-2 border-sky-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all duration-300 outline-none placeholder:text-gray-400"
                                    placeholder="Masukkan nama lengkap">
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="group">
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-sky-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" required
                                    class="w-full pl-12 pr-5 py-4 bg-sky-50/50 border-2 border-sky-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all duration-300 outline-none placeholder:text-gray-400"
                                    placeholder="nama@email.com">
                            </div>
                        </div>

                        <!-- Subject Input -->
                        <div class="group">
                            <div class="relative">
                                <div class="absolute left-4 top-5 text-sky-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="subject" name="subject" required
                                    class="w-full pl-12 pr-5 py-4 bg-sky-50/50 border-2 border-sky-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all duration-300 outline-none placeholder:text-gray-400"
                                    placeholder="Subjek pesan">
                            </div>
                        </div>

                        <!-- Message Textarea -->
                        <div class="group">
                            <div class="relative">
                                <div class="absolute left-4 top-5 text-sky-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <textarea id="message" name="message" rows="5" required
                                    class="w-full pl-12 pr-5 py-4 bg-sky-50/50 border-2 border-sky-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:bg-white transition-all duration-300 outline-none resize-none placeholder:text-gray-400"
                                    placeholder="Tulis pesan Anda..."></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full px-8 py-4 bg-gradient-to-r from-sky-500 via-cyan-500 to-blue-600 text-white font-bold rounded-xl shadow-lg shadow-sky-300/50 hover:shadow-xl hover:shadow-sky-400/60 transition-all duration-300 transform hover:scale-[1.02]">
                            <span class="flex items-center justify-center gap-2 text-lg">
                                Kirim Pesan
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side - Map & Contact Info -->
            <div class="order-1 lg:order-2 space-y-8">

                <!-- Map with Location Pin -->
                <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-sky-200/50 border border-sky-100 h-96 overflow-hidden">
                    <!-- Map Background with transparency -->
                    <div class="absolute inset-0 bg-gradient-to-br from-sky-100/50 to-cyan-100/50">
                        <!-- Map Grid Pattern -->
                        <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M0 0h60v60H0z&quot; fill=&quot;none&quot;/%3E%3Cpath d=&quot;M0 30h60M30 0v60&quot; stroke=&quot;%230ea5e9&quot; stroke-width=&quot;0.5&quot; opacity=&quot;0.3&quot;/%3E%3Ccircle cx=&quot;30&quot; cy=&quot;30&quot; r=&quot;1&quot; fill=&quot;%230ea5e9&quot; opacity=&quot;0.4&quot;/%3E%3C/svg%3E'); background-size: 60px 60px;"></div>

                        <!-- Map Roads Pattern -->
                        <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 400 400" preserveAspectRatio="none">
                            <path d="M0,100 Q100,150 200,100 T400,100" stroke="#0ea5e9" stroke-width="2" fill="none"/>
                            <path d="M0,200 Q100,250 200,200 T400,200" stroke="#06b6d4" stroke-width="2" fill="none"/>
                            <path d="M100,0 Q150,100 100,200 T100,400" stroke="#0ea5e9" stroke-width="2" fill="none"/>
                            <path d="M200,0 Q250,100 200,200 T200,400" stroke="#06b6d4" stroke-width="2" fill="none"/>
                            <path d="M300,0 Q350,100 300,200 T300,400" stroke="#0ea5e9" stroke-width="2" fill="none"/>
                        </svg>
                    </div>

                    <!-- Location Pin -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                        <div class="relative">
                            <!-- Pulse Effect -->
                            <div class="absolute inset-0 bg-sky-400 rounded-full animate-ping opacity-75 w-16 h-16"></div>
                            <!-- Pin -->
                            <div class="relative w-16 h-16 bg-gradient-to-br from-sky-400 to-cyan-500 rounded-full shadow-xl flex items-center justify-center border-4 border-white">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Location Details Card -->
                    <div class="absolute bottom-6 right-6 bg-white/95 backdrop-blur-xl rounded-2xl p-5 shadow-xl border border-sky-200 max-w-xs z-20">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-cyan-600 rounded-lg flex items-center justify-center shrink-0 shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-gray-900 font-bold mb-1 text-sm">SMKN 1 Kawali</h4>
                                <p class="text-sky-700 text-xs font-semibold">Ciamis, Jawa Barat</p>
                                <p class="text-gray-600 text-xs mt-1">Jl. Poronggol Raya No. 9</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl shadow-sky-200/50 p-8 border border-sky-100">
                    <div class="space-y-5">
                        <!-- Address -->
                        <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-sky-50 to-cyan-50 rounded-xl border border-sky-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-sky-500 to-cyan-600 rounded-xl flex items-center justify-center shrink-0 shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Alamat Sekolah</h4>
                                <p class="text-gray-600 text-sm">Jl. Poronggol Raya No. 9, Kawali</p>
                                <p class="text-gray-600 text-sm">Kabupaten Ciamis, Jawa Barat</p>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-sky-50 to-cyan-50 rounded-xl border border-sky-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shrink-0 shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <div class="flex gap-3">
                                <a href="https://www.instagram.com/agenda.k_one?igsh=MTAyeTM2NWoyb3luNg==" target="_blank" class="w-11 h-11 bg-white hover:bg-gradient-to-br hover:from-pink-500 hover:to-purple-600 rounded-xl flex items-center justify-center transition-all duration-300 border-2 border-sky-200 hover:border-pink-500 shadow-sm hover:shadow-lg group">
                                    <i class="fab fa-instagram text-sky-600 group-hover:text-white text-xl transition-colors"></i>
                                </a>
                                <a href="mailto:smkn1kawali@gmail.com" class="w-11 h-11 bg-white hover:bg-gradient-to-br hover:from-sky-500 hover:to-cyan-600 rounded-xl flex items-center justify-center transition-all duration-300 border-2 border-sky-200 hover:border-sky-500 shadow-sm hover:shadow-lg group">
                                    <svg class="w-5 h-5 text-sky-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                                <a href="tel:+62265791727" class="w-11 h-11 bg-white hover:bg-gradient-to-br hover:from-emerald-500 hover:to-green-600 rounded-xl flex items-center justify-center transition-all duration-300 border-2 border-sky-200 hover:border-emerald-500 shadow-sm hover:shadow-lg group">
                                    <svg class="w-5 h-5 text-sky-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="pt-4 border-t border-sky-200">
                            <div class="flex items-center gap-3 mb-3">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <a href="mailto:smkn1kawali@gmail.com" class="text-gray-700 hover:text-sky-600 transition-colors font-medium">smkn1kawali@gmail.com</a>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <a href="tel:+62265791727" class="text-gray-700 hover:text-sky-600 transition-colors font-medium">+62-265-791727</a>
                            </div>
                            <div class="flex items-center gap-3 mt-3">
                                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-700 font-medium">Senin - Jumat: 06.30 - 15.05 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }

    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    input:focus, textarea:focus {
        background: white;
    }
</style>
