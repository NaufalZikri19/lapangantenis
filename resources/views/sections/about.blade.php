<!-- ABOUT SECTION -->
<section id="about" class="py-24 bg-white dark:bg-gray-900 relative overflow-hidden">
    <div class="absolute top-1/2 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <!-- Section Header -->
        <div class="text-center mb-20">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest mb-4">
                Tentang Kami
            </div>
            <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 sm:text-5xl tracking-tight leading-tight">
                Membangun Komunitas Tenis <br><span class="text-primary italic">Yang Lebih Modern</span>
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-6 max-w-2xl mx-auto text-lg leading-relaxed">
                Gumbreg Tennis Court hadir sebagai solusi cerdas bagi para pecinta olahraga tenis yang menginginkan
                kenyamanan dan kemudahan dalam satu platform.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- Image -->
            <div class="relative group">
                <div
                    class="absolute inset-0 bg-primary/20 rounded-[2.5rem] transform translate-x-6 translate-y-6 transition-transform group-hover:translate-x-4 group-hover:translate-y-4 -z-10">
                </div>
                <img src="{{ asset('image/about.webp') }}"
                    class="relative z-10 rounded-[2.5rem] shadow-2xl w-full object-cover h-[600px] transition-all duration-700 group-hover:scale-[1.02]"
                    alt="Gumbreg Tennis Court" />

                {{-- Floating Badge --}}
                <div
                    class="absolute -bottom-8 -right-8 bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 z-20 animate-float">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center">
                            <i data-lucide="award" class="w-6 h-6 text-gray-900"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Kualitas</p>
                            <p class="text-lg font-black text-gray-900 dark:text-white">Premium Court</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="lg:pl-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Pengalaman Bermain Terbaik di Purwokerto</h3>

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6 text-lg">
                    Kami memahami bahwa kenyamanan adalah prioritas. Itulah sebabnya Gumbreg Tennis Court didesain
                    dengan konsep semi-indoor, memberikan perlindungan maksimal dari sinar UV dan hujan tanpa
                    mengorbankan sirkulasi udara alami.
                </p>

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-8 text-lg">
                    Dengan integrasi teknologi Real-Time Booking, kami mengeliminasi kerumitan reservasi manual,
                    memastikan jadwal Anda tertata dengan sempurna hanya dalam beberapa detik.
                </p>

                 <!-- Amenities List -->
                <div class="mb-12">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-gray-600 dark:text-gray-300">
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <div class="w-5 h-5 rounded-full bg-primary/20 dark:bg-primary/30 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-primary"></i>
                            </div>
                            2 Lapangan Semi-Indoor
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <div class="w-5 h-5 rounded-full bg-primary/20 dark:bg-primary/30 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-primary"></i>
                            </div>
                            Parkir Luas & Aman
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <div class="w-5 h-5 rounded-full bg-primary/20 dark:bg-primary/30 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-primary"></i>
                            </div>
                            Kantin & Istirahat
                        </li>
                        <li class="flex items-center gap-3 text-sm font-medium">
                            <div class="w-5 h-5 rounded-full bg-primary/20 dark:bg-primary/30 flex items-center justify-center shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-primary"></i>
                            </div>
                            LED Standard Turnamen
                        </li>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all duration-500">
                        <p class="text-4xl font-black text-primary mb-1 tracking-tighter">500+</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Pemain</p>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all duration-500">
                        <p class="text-4xl font-black text-primary mb-1 tracking-tighter">2</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Lapangan</p>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl hover:shadow-primary/5 transition-all duration-500 col-span-2 sm:col-span-1">
                        <p
                            class="text-2xl font-black text-primary mb-1 tracking-tighter leading-none h-[40px] flex items-center">
                            Real-Time</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">Booking</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>