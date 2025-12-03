<!-- Contact Section -->
<section class="py-16 lg:py-24 bg-gray-50" id="kontak">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
            <p class="text-lg text-gray-600">
                Ada pertanyaan? Tim kami siap membantu Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Kirim Pesan</h3>
                <form class="space-y-6" action="send_message.php" method="POST">

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                        <input type="text" id="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                        <textarea id="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"></textarea>
                    </div>
                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Informasi Kontak</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Alamat</h4>
                                <p class="text-gray-600 mt-1">Jl. Poronggol Raya No. 9, Kawali, Kabupaten Ciamis, Jawa Barat.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-phone text-green-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Telepon</h4>
                                <p class="text-gray-600 mt-1">+62-265-791727</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Email</h4>
                                <p class="text-gray-600 mt-1">smkn1kawali@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-clock text-yellow-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Jam Operasional</h4>
                                <p class="text-gray-600 mt-1">Senin - Jumat: 06.30 - 15.05 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Social Media -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Ikuti Kami</h3>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg flex items-center justify-center mr-4 text-white">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Instagram</h4>
                        <a href="https://www.instagram.com/agenda.k_one?igsh=MXJra21pZmR3ZzB3MQ=="
                           class="text-gray-600 mt-1 hover:text-pink-600 transition">
                           @agenda.k_one
                       </a>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</section>
