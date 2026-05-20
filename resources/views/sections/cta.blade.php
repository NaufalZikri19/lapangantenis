<section id="chatbot" class="py-20 relative overflow-hidden mt-10 bg-gray-50 dark:bg-gray-900">
    <!-- Abstract Shapes -->
    <div
        class="absolute top-0 right-0 -mr-20 -mt-20 w-[400px] h-[400px] bg-yellow-200 dark:bg-yellow-900/30 rounded-full blur-3xl opacity-40 z-0">
    </div>
    <div
        class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[300px] h-[300px] bg-yellow-300 dark:bg-yellow-800/30 rounded-full blur-3xl opacity-30 z-0">
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Chatbot Text Info -->
            <div class="order-2 lg:order-1">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-50 dark:bg-yellow-900/50 border border-yellow-100 dark:border-yellow-900/30 text-yellow-600 dark:text-yellow-400 text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
                    <i data-lucide="bot" class="w-4 h-4"></i>
                    Dukungan Pintar AI
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8 leading-tight">
                    Asisten Virtual <span class="text-yellow-600 dark:text-yellow-400 italic">Siap Sedia</span> <br>Membantu Anda 24/7
                </h2>
                <p class="text-lg text-gray-500 dark:text-gray-400 mb-10 leading-relaxed max-w-xl">
                    Bingung soal jadwal atau cara bayar? Asisten virtual kami siap menjawab pertanyaan Anda kapan saja
                    tanpa perlu menunggu respon admin.
                </p>

                <div class="grid sm:grid-cols-2 gap-6 mb-10">
                    <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300 group">
                        <div
                            class="w-10 h-10 rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <i data-lucide="clock" class="w-5 h-5 text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <span class="font-bold text-sm">Respon Instan 24 Jam</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-700 dark:text-gray-300 group">
                        <div
                            class="w-10 h-10 rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <i data-lucide="shield-check" class="w-5 h-5 text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <span class="font-bold text-sm">Aman & Terpercaya</span>
                    </div>
                </div>

                <a href="{{ route('login') }}"
                    class="inline-flex justify-center items-center gap-3 px-8 py-4 rounded-2xl text-lg font-black text-gray-900 bg-primary hover:bg-primaryHover shadow-xl shadow-yellow-500/20 transition-all duration-300 hover:-translate-y-1 hover:scale-[1.02] active:scale-95 group">
                    Coba Chat Sekarang
                    <i data-lucide="sparkles" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                </a>
            </div>

            <!-- Chatbot Mockup -->
            <div class="order-1 lg:order-2 relative lg:ml-auto w-full max-w-md mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-transform duration-500 hover:scale-[1.02] flex flex-col h-[500px]">
                    <!-- Chat Header -->
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 dark:from-yellow-600 dark:to-yellow-500 p-4 flex items-center gap-4 text-gray-900 dark:text-white">
                        <div
                            class="w-12 h-12 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm shrink-0 border border-transparent dark:border-gray-700">
                            <i data-lucide="bot" class="w-6 h-6 text-yellow-500 dark:text-yellow-400"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg leading-tight">Gumbreg Bot</h3>
                            <div class="flex items-center gap-1.5 mt-1">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                <span class="text-xs text-gray-800 font-medium">Online sedia membantu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Body -->
                    <div class="flex-1 bg-gray-50 dark:bg-gray-900 p-5 overflow-y-auto space-y-4 flex flex-col justify-end">
                        <!-- System Message -->
                        <div class="text-center text-xs text-gray-400 dark:text-gray-500 mb-4">Hari ini 10:24</div>

                        <!-- Bot Message -->
                        <div class="flex gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/50 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="bot" class="w-4 h-4 text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div
                                class="bg-white dark:bg-gray-800 p-3.5 rounded-2xl rounded-tl-sm shadow-sm border border-gray-100 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-200 leading-relaxed">
                                Halo! Saya asisten GumbregQuickBook. Ada yang bisa saya bantu hari ini? 😊
                            </div>
                        </div>

                        <!-- User Message -->
                        <div class="flex gap-3 flex-row-reverse">
                            <div
                                class="bg-primary p-3.5 rounded-2xl rounded-tr-sm shadow-sm text-sm text-gray-900 font-medium leading-relaxed">
                                Jadwal kosong untuk hari Jumat jam 16:00 ada?
                            </div>
                        </div>

                        <!-- Bot Message Typing -->
                        <div class="flex gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/50 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="bot" class="w-4 h-4 text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div
                                class="bg-white dark:bg-gray-800 px-4 py-3.5 rounded-2xl rounded-tl-sm shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-1">
                                <div class="w-1.5 h-1.5 bg-gray-400 dark:bg-gray-500 rounded-full animate-bounce"
                                    style="animation-delay: 0s;"></div>
                                <div class="w-1.5 h-1.5 bg-gray-400 dark:bg-gray-500 rounded-full animate-bounce"
                                    style="animation-delay: 0.2s;"></div>
                                <div class="w-1.5 h-1.5 bg-gray-400 dark:bg-gray-500 rounded-full animate-bounce"
                                    style="animation-delay: 0.4s;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex gap-3 items-center">
                        <button class="p-2 text-gray-400 dark:text-gray-500 hover:text-primary transition-colors">
                            <i data-lucide="paperclip" class="w-5 h-5"></i>
                        </button>
                        <div class="flex-1 bg-gray-100 dark:bg-gray-900 rounded-full px-4 py-2.5 text-sm text-gray-500 dark:text-gray-400">
                            Ketik pesan...
                        </div>
                        <button
                            class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-gray-900 shadow-sm hover:scale-105 transition-transform shrink-0">
                            <i data-lucide="send" class="w-4 h-4 ml-0.5"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>