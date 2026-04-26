<section id="court" class="py-28 bg-gradient-to-b from-gray-50 to-white">

    <div class="max-w-6xl mx-auto px-6">

        <!-- HEADER -->
        <div class="text-center mb-20">
            <span class="text-yellow-500 text-sm font-semibold tracking-widest uppercase">
                Lapangan Kami
            </span>
            <h2 class="text-4xl font-bold text-gray-900 mt-3">
                Jenis Lapangan
            </h2>

            <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
                Nikmati pengalaman bermain tenis dengan fasilitas berkualitas tinggi dan standar profesional.
            </p>
        </div>

        <!-- GRID -->
        <div class="grid md:grid-cols-2 gap-12">

            <!-- Court A -->
            <div
                class="group bg-white rounded-3xl shadow-md overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300">

                <!-- IMAGE -->
                <div class="relative overflow-hidden">
                    <img src="{{ asset('image/court.jpg') }}"
                        class="h-72 w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />

                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                    <div
                        class="absolute top-4 left-4 bg-yellow-400/90 backdrop-blur text-black text-xs font-semibold px-3 py-1 rounded-full">
                        Populer
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="p-8">

                    <h3 class="text-2xl font-semibold text-gray-900">
                        Lapangan A
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Indoor
                    </p>

                    <!-- INFO -->
                    <div class="grid grid-cols-2 gap-5 mt-6 text-sm text-gray-600">

                        <div class="flex items-start gap-2">
                            <i data-lucide="clock" class="w-4 h-4 text-yellow-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Jam</p>
                                <p>08.00 – 22.00</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <i data-lucide="users" class="w-4 h-4 text-yellow-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Kapasitas</p>
                                <p>2–4 Pemain</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <i data-lucide="layers" class="w-4 h-4 text-yellow-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Lantai</p>
                                <p>Vinly</p>
                            </div>
                        </div>

                    </div>

                    <div class="border-t my-6"></div>

                    <!-- FACILITIES -->
                    <div>
                        <p class="text-sm font-semibold text-gray-800 mb-3">
                            Fasilitas
                        </p>

                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="bg-gray-100 px-3 py-1 rounded-full">Tersedia Papan Skor</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">Penerangan</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">Area Penonton</span>
                        </div>
                    </div>

                </div>

            </div>


            <!-- Court B -->
            <div
                class="group bg-white rounded-3xl shadow-md overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300">

                <div class="relative overflow-hidden">
                    <img src="{{ asset('image/tenis.jpg') }}"
                        class="h-72 w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105" />

                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

                </div>

                <div class="p-8">

                    <h3 class="text-2xl font-semibold text-gray-900">
                        Lapangan B
                    </h3>

                    <p class="text-gray-500 mt-1">
                        Indoor
                    </p>

                    <div class="grid grid-cols-2 gap-5 mt-6 text-sm text-gray-600">

                        <div class="flex items-start gap-2">
                            <i data-lucide="clock" class="w-4 h-4 text-yellow-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Jam</p>
                                <p>08.00 – 22.00</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <i data-lucide="users" class="w-4 h-4 text-yellow-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Kapasitas</p>
                                <p>2–4 Pemain</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <i data-lucide="layers" class="w-4 h-4 text-yellow-500 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-800">Lantai</p>
                                <p>Vinyl</p>
                            </div>
                        </div>

                    </div>

                    <div class="border-t my-6"></div>

                    <div>
                        <p class="text-sm font-semibold text-gray-800 mb-3">
                            Fasilitas
                        </p>

                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="bg-gray-100 px-3 py-1 rounded-full">Penerangan</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">Ruang Ganti</span>
                            <span class="bg-gray-100 px-3 py-1 rounded-full">Area Parkir</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>