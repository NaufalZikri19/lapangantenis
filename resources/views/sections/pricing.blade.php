<section id="pricing" class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-20">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest mb-4">
                Pricelist Terjangkau
            </div>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 sm:text-5xl tracking-tight leading-tight">
                Paket Sewa <span class="text-primary italic">Lapangan</span>
            </h2>
            <p class="mt-6 text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
                Pilih jenis lapangan sesuai preferensi Anda. Harga terjangkau dengan fasilitas terbaik untuk pengalaman
                bermain yang maksimal.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">

            <!-- Lapangan A -->
            <div
                class="bg-white dark:bg-gray-800 rounded-[2rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:shadow-gray-200/50 dark:hover:shadow-black/50 hover:-translate-y-2 transition-all duration-500 relative group flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <span class="text-primary text-xs font-bold uppercase tracking-widest mb-1 block">Standar</span>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white">Lapangan A</h3>
                    </div>
                    <div
                        class="w-14 h-14 bg-neutralBg dark:bg-gray-700 rounded-2xl flex items-center justify-center group-hover:bg-primary/10 transition-all duration-500 shadow-inner">
                        <i data-lucide="sun"
                            class="w-7 h-7 text-gray-400 group-hover:text-primary transition-colors"></i>
                    </div>
                </div>

                <div class="mb-8 flex-grow">
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black text-gray-900 dark:text-white tracking-tighter">Rp50rb</span>
                        <span class="text-gray-400 font-bold">/jam</span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 mt-4 leading-relaxed">
                        Lapangan semi-indoor dengan lantai material <span class="text-gray-900 dark:text-white font-semibold">rubber
                            cushion</span> berkualitas.
                    </p>
                </div>

                <div class="border-t border-gray-50 dark:border-gray-700 pt-8 mb-10">
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 group/item">
                            <div
                                class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-950/55 flex items-center justify-center group-hover/item:scale-110 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-green-600 dark:text-green-400"></i>
                            </div>
                            <span class="text-gray-600 dark:text-gray-300 font-medium text-sm">Material Rubber Cushion</span>
                        </li>
                        <li class="flex items-center gap-3 group/item">
                            <div
                                class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-950/55 flex items-center justify-center group-hover/item:scale-110 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-green-600 dark:text-green-400"></i>
                            </div>
                            <span class="text-gray-600 dark:text-gray-300 font-medium text-sm">Atap Kanopi Anti Tampyas</span>
                        </li>
                        <li class="flex items-center gap-3 group/item">
                            <div
                                class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-950/55 flex items-center justify-center group-hover/item:scale-110 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-green-600 dark:text-green-400"></i>
                            </div>
                            <span class="text-gray-600 dark:text-gray-300 font-medium text-sm">Lampu LED 400W (6 Titik)</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('register') ?? '#' }}"
                    class="w-full inline-flex justify-center items-center py-4 px-6 rounded-2xl text-base font-bold text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white transition-all active:scale-95 border border-gray-100 dark:border-gray-650">
                    Pilih Lapangan A
                </a>
            </div>

            <!-- Lapangan B (Recommended) -->
            <div
                class="bg-gray-900 rounded-[2rem] p-10 shadow-2xl shadow-gray-900/20 hover:-translate-y-2 transition-all duration-500 relative flex flex-col group overflow-hidden border border-transparent dark:border-gray-800">
                {{-- Branded Glow --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 blur-3xl rounded-full -mr-16 -mt-16"></div>

                <div class="absolute top-6 right-6">
                    <span
                        class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-gray-900 text-[10px] px-3 py-1 rounded-full font-black uppercase tracking-widest shadow-lg shadow-yellow-500/20">
                        Paling Diminati
                    </span>
                </div>

                <div class="flex items-center justify-between mb-8 mt-2">
                    <div>
                        <span class="text-primary text-xs font-bold uppercase tracking-widest mb-1 block">Premium</span>
                        <h3 class="text-3xl font-black text-white">Lapangan B</h3>
                    </div>
                    <div
                        class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center shadow-inner group-hover:bg-primary/20 transition-all duration-500">
                        <i data-lucide="sparkles" class="w-7 h-7 text-primary"></i>
                    </div>
                </div>

                <div class="mb-8 flex-grow">
                    <div class="flex items-baseline gap-1">
                        <span class="text-5xl font-black text-white tracking-tighter">Rp50rb</span>
                        <span class="text-gray-400 font-bold">/jam</span>
                    </div>
                    <p class="text-gray-400 mt-4 leading-relaxed">
                        Lapangan semi-indoor premium dengan <span class="text-white font-semibold">sirkulasi udara
                            optimal</span> & area luas.
                    </p>
                </div>

                <div class="border-t border-white/10 pt-8 mb-10">
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 group/item">
                            <div
                                class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center group-hover/item:scale-110 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-primary"></i>
                            </div>
                            <span class="text-gray-300 font-medium text-sm">Material Rubber Cushion Premium</span>
                        </li>
                        <li class="flex items-center gap-3 group/item">
                            <div
                                class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center group-hover/item:scale-110 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-primary"></i>
                            </div>
                            <span class="text-gray-300 font-medium text-sm">Lampu LED 600W (8 Titik)</span>
                        </li>
                        <li class="flex items-center gap-3 group/item">
                            <div
                                class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center group-hover/item:scale-110 transition-transform">
                                <i data-lucide="check" class="w-3.5 h-3.5 text-primary"></i>
                            </div>
                            <span class="text-gray-300 font-medium text-sm">Area Tribun Penonton</span>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('register') ?? '#' }}"
                    class="w-full inline-flex justify-center items-center py-4 px-6 rounded-2xl text-base font-black text-gray-900 bg-primary hover:bg-primaryHover shadow-xl shadow-yellow-500/40 transition-all hover:scale-[1.02] active:scale-95 group/btn">
                    Booking Lapangan B
                    <i data-lucide="arrow-right"
                        class="w-5 h-5 ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                </a>
            </div>

        </div>
    </div>
</section>