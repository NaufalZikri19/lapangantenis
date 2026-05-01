<section id="pricing" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-primary text-sm font-semibold tracking-wide uppercase">
                Daftar Harga
            </span>
            <h2 class="text-3xl font-bold text-gray-900 mt-2 sm:text-4xl tracking-tight">
                Paket Sewa Lapangan
            </h2>
            <p class="mt-4 text-lg text-gray-500">
                Pilih jenis lapangan sesuai preferensi Anda. Harga terjangkau dengan fasilitas terbaik untuk pengalaman
                bermain yang maksimal.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            <!-- Lapangan A -->
            <div
                class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1 transition-all duration-300 relative group flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Lapangan A</h3>
                    <div
                        class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                        <i data-lucide="sun" class="w-6 h-6 text-gray-400 group-hover:text-primary"></i>
                    </div>
                </div>

                <div class="mb-6 flex-grow">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold text-gray-900">Rp110rb</span>
                        <span class="text-gray-500 font-medium">/ jam</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Lapangan outdoor standar kompetisi, cocok untuk sesi latihan
                        pagi atau sore hari.</p>
                </div>

                <div class="border-t border-gray-100 pt-6 mb-8">
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-primary shrink-0"></i>
                            <span class="text-gray-600">Material Flexi Pave</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-primary shrink-0"></i>
                            <span class="text-gray-600">Terbuka (Outdoor)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-primary shrink-0"></i>
                            <span class="text-gray-600">Pencahayaan LED Terang</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('register') ?? '#' }}"
                    class="w-full inline-flex justify-center items-center py-3.5 px-6 rounded-xl text-base font-bold text-gray-700 bg-gray-50 hover:bg-gray-100 transition-colors">
                    Booking Lap. A
                </a>
            </div>

            <!-- Lapangan B (Recommended) -->
            <div
                class="bg-gray-900 rounded-3xl p-8 shadow-xl hover:-translate-y-1 transition-transform duration-300 relative flex flex-col">
                <div
                    class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 text-xs px-4 py-1.5 rounded-full font-bold uppercase tracking-wider shadow-sm">
                    Paling Diminati
                </div>

                <div class="flex items-center justify-between mb-6 mt-2">
                    <h3 class="text-2xl font-bold text-white">Lapangan B</h3>
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                        <i data-lucide="cloud-rain" class="w-6 h-6 text-yellow-400"></i>
                    </div>
                </div>

                <div class="mb-6 flex-grow">
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-extrabold text-white">Rp120rb</span>
                        <span class="text-gray-400 font-medium">/ jam</span>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Lapangan semi-indoor premium, bebas cuaca hujan maupun terik
                        matahari ekstrem.</p>
                </div>

                <div class="border-t border-gray-800 pt-6 mb-8">
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-primary shrink-0"></i>
                            <span class="text-gray-300">Material Rubber Cushion</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-primary shrink-0"></i>
                            <span class="text-gray-300">Atap Kanopi Penuh (Semi-Indoor)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-primary shrink-0"></i>
                            <span class="text-gray-300">Sirkulasi Udara Maksimal</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('register') ?? '#' }}"
                    class="w-full inline-flex justify-center items-center py-3.5 px-6 rounded-xl text-base font-bold text-gray-900 bg-primary hover:bg-primaryHover shadow-lg shadow-yellow-500/20 transition-all hover:-translate-y-0.5">
                    Booking Lap. B
                </a>
            </div>

        </div>
    </div>
</section>