<!-- ABOUT SECTION -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="text-primary text-sm font-semibold tracking-wide uppercase">
                Tentang Kami
            </span>
            <h2 class="text-3xl font-bold text-gray-900 mt-2 sm:text-4xl tracking-tight">
                Tentang Gumbreg Tennis Court
            </h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto text-lg">
                Platform penyewaan lapangan tenis berbasis web dengan sistem booking modern
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-16 items-center">

            <!-- Image -->
            <div class="relative group">
                <div
                    class="absolute inset-0 bg-yellow-200 rounded-3xl transform translate-x-4 translate-y-4 transition-transform group-hover:translate-x-2 group-hover:translate-y-2 z-0">
                </div>
                <img src="{{ asset('image/about.jpg') }}"
                    class="relative z-10 rounded-3xl shadow-xl w-full object-cover h-[540px] transition-transform duration-500 group-hover:-translate-y-1"
                    alt="Gumbreg Tennis Court" />
            </div>

            <!-- Content -->
            <div>
                <p class="text-gray-600 leading-relaxed mb-6 text-lg">
                    Gumbreg Tennis Court adalah fasilitas olahraga tenis terkemuka di Purwokerto yang menawarkan
                    pengalaman bermain premium. Dengan struktur semi-indoor, Anda dapat berolahraga dengan nyaman tanpa
                    terganggu kondisi cuaca.
                </p>

                <p class="text-gray-600 leading-relaxed mb-8 text-lg">
                    Kami menghadirkan sistem reservasi online yang transparan dan efisien, memungkinkan Anda
                    merencanakan pertandingan hanya dengan beberapa klik.
                </p>

                <!-- Amenities List -->
                <div class="mb-10">
                    <h4 class="text-gray-900 font-bold mb-4">Fasilitas & Keunggulan:</h4>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-gray-600">
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 text-primary"></i>
                            2 Lapangan Semi-Indoor Berkualitas
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 text-primary"></i>
                            Area Parkir Luas & Aman
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 text-primary"></i>
                            Kantin & Area Istirahat
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 text-primary"></i>
                            Kamar Mandi & Ruang Ganti
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 text-primary"></i>
                            Pencahayaan LED Standar Turnamen
                        </li>
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="check-circle" class="w-4 h-4 text-primary"></i>
                            Sewa Raket & Bola Tersedia
                        </li>
                    </ul>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-8">
                    <div class="bg-neutralBg p-6 rounded-2xl border border-gray-100 text-center">
                        <p class="text-3xl font-bold text-primary mb-2">+500</p>
                        <p class="text-sm text-gray-600 font-medium">Pelanggan Terdaftar</p>
                    </div>

                    <div class="bg-neutralBg p-6 rounded-2xl border border-gray-100 text-center">
                        <p class="text-3xl font-bold text-primary mb-2">2</p>
                        <p class="text-sm text-gray-600 font-medium">Lapangan Aktif</p>
                    </div>

                    <div
                        class="bg-neutralBg p-6 rounded-2xl border border-gray-100 text-center col-span-2 sm:col-span-1">
                        <p class="text-xl font-bold text-primary mb-2 flex items-center justify-center h-[36px]">
                            Real-Time</p>
                        <p class="text-sm text-gray-600 font-medium">Booking System</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>