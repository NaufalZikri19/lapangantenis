<section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">

    <!-- Background Decoration -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-primary/10 rounded-full blur-3xl opacity-60">
        </div>
        <div
            class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[500px] h-[500px] bg-gray-200/50 dark:bg-gray-800/30 rounded-full blur-3xl opacity-60">
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">

            <!-- Text Content -->
            <div class="max-w-2xl">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-yellow-100 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-400 text-xs font-semibold uppercase tracking-wider mb-6 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                    </span>
                    Tersedia 2 Lapangan
                </div>

                <h1
                    class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tighter text-gray-900 dark:text-white leading-[1.1] mb-8">
                    Booking Lapangan <span class="relative inline-block">
                        <span
                            class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-600 italic">Tenis</span>
                        <span class="absolute bottom-2 left-0 w-full h-3 bg-yellow-400/20 -z-0"></span>
                    </span> Jadi <span class="text-gray-900 dark:text-white">Lebih Mudah</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-10 leading-relaxed max-w-xl">
                    Main tenis kapan saja tanpa takut hujan atau panas terik. Cek ketersediaan jadwal secara real-time
                    dan amankan lapangan favoritmu dalam hitungan detik.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') ?? '#' }}"
                        class="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-2xl text-base font-bold text-gray-900 bg-primary hover:bg-primaryHover shadow-xl shadow-yellow-500/20 transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02] active:scale-95 group">
                        <i data-lucide="calendar-check" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                        Booking Sekarang
                    </a>
                    <a href="{{ route('login') ?? '#' }}"
                        class="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-2xl text-base font-bold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border-2 border-gray-100 dark:border-gray-700 hover:border-gray-200 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                        Masuk ke Akun
                    </a>
                </div>

                <div class="mt-10 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex -space-x-2">
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-gray-900"
                            src="https://ui-avatars.com/api/?name=U+1&background=EAB308&color=fff" alt="" />
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-gray-900"
                            src="https://ui-avatars.com/api/?name=U+2&background=111827&color=fff" alt="" />
                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-gray-900"
                            src="https://ui-avatars.com/api/?name=U+3&background=EAB308&color=fff" alt="" />
                    </div>
                    <p>Dipercaya oleh <span class="font-semibold text-gray-900 dark:text-white">1000+</span> pemain tenis</p>
                </div>
            </div>

            <!-- Illustration / Mockup -->
            <div class="relative lg:ml-auto w-full max-w-lg">
                <!-- Abstract Dashboard Mockup Frame -->
                <div
                    class="relative rounded-2xl bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-transform duration-500 hover:scale-[1.02]">

                    <!-- Browser Header -->
                    <div class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 px-4 py-3 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                    </div>

                    <!-- Dashboard Content Mockup -->
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <div class="h-4 w-32 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                                <div class="h-3 w-24 bg-gray-100 dark:bg-gray-600 rounded"></div>
                            </div>
                            <div class="h-10 w-10 bg-primary/20 rounded-full flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-primary"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700">
                                <i data-lucide="calendar" class="w-6 h-6 text-primary mb-2"></i>
                                <div class="h-3 w-16 bg-gray-200 dark:bg-gray-700 rounded mb-1"></div>
                                <div class="h-4 w-12 bg-gray-300 dark:bg-gray-600 rounded"></div>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700">
                                <i data-lucide="clock" class="w-6 h-6 text-primary mb-2"></i>
                                <div class="h-3 w-16 bg-gray-200 dark:bg-gray-700 rounded mb-1"></div>
                                <div class="h-4 w-12 bg-gray-300 dark:bg-gray-600 rounded"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div
                                class="h-12 w-full bg-yellow-50 dark:bg-yellow-900/20 rounded-lg flex items-center px-4 border border-yellow-100 dark:border-yellow-900/30">
                                <div class="w-8 h-8 rounded bg-yellow-200 dark:bg-yellow-900/40 mr-3"></div>
                                <div class="flex-1 h-3 bg-yellow-200 dark:bg-yellow-900/40 rounded"></div>
                                <div class="w-16 h-6 bg-yellow-300 dark:bg-yellow-600 rounded ml-3"></div>
                            </div>
                            <div class="h-12 w-full bg-gray-50 dark:bg-gray-900 rounded-lg flex items-center px-4">
                                <div class="w-8 h-8 rounded bg-gray-200 dark:bg-gray-700 mr-3"></div>
                                <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            </div>
                            <div class="h-12 w-full bg-gray-50 dark:bg-gray-900 rounded-lg flex items-center px-4">
                                <div class="w-8 h-8 rounded bg-gray-200 dark:bg-gray-700 mr-3"></div>
                                <div class="flex-1 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Floating Element -->
                <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 flex items-center gap-4 animate-bounce"
                    style="animation-duration: 3s;">
                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-950/50 flex items-center justify-center">
                        <i data-lucide="check" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Booking Berhasil</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Lap. Indoor A - 15:00</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>