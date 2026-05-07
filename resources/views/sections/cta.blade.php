<section id="chatbot" class="py-20 relative overflow-hidden mt-10 bg-gray-50">
    <!-- Abstract Shapes -->
    <div
        class="absolute top-0 right-0 -mr-20 -mt-20 w-[400px] h-[400px] bg-yellow-200 rounded-full blur-3xl opacity-40 z-0">
    </div>
    <div
        class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[300px] h-[300px] bg-yellow-300 rounded-full blur-3xl opacity-30 z-0">
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Chatbot Text Info -->
            <div class="order-2 lg:order-1">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100 border border-blue-200 text-blue-800 text-xs font-semibold uppercase tracking-wider mb-6 shadow-sm">
                    <i data-lucide="bot" class="w-4 h-4"></i>
                    Dukungan Pintar
                </div>
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900 mb-6">
                    Asisten Chatbot Cerdas <span class="text-primary">24/7</span>
                </h2>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Butuh bantuan seputar booking lapangan? Asisten virtual kami siap membantu Anda kapan saja. Mulai
                    dari cek ketersediaan lapangan, panduan pembayaran, hingga menjawab pertanyaan umum tanpa perlu
                    menunggu lama.
                </p>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3 text-gray-700">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        Tersedia setiap saat (24 Jam)
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        Respon cepat & akurat
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        Terintegrasi langsung di website
                    </li>
                </ul>

                <a href="{{ route('login') }}"
                    class="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-xl text-lg font-bold text-gray-900 bg-primary hover:bg-primaryHover shadow-lg hover:shadow-xl transition-all duration-200 hover:-translate-y-1">
                    <i data-lucide="message-square-plus" class="w-5 h-5"></i>
                    Coba Chat Sekarang
                </a>
            </div>

            <!-- Chatbot Mockup -->
            <div class="order-1 lg:order-2 relative lg:ml-auto w-full max-w-md mx-auto">
                <div
                    class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-transform duration-500 hover:scale-[1.02] flex flex-col h-[500px]">
                    <!-- Chat Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-4 flex items-center gap-4 text-white">
                        <div
                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0">
                            <i data-lucide="bot" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg leading-tight">Gumbreg Bot</h3>
                            <div class="flex items-center gap-1.5 mt-1">
                                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                                <span class="text-xs text-blue-100">Online sedia membantu</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Body -->
                    <div class="flex-1 bg-gray-50 p-5 overflow-y-auto space-y-4 flex flex-col justify-end">
                        <!-- System Message -->
                        <div class="text-center text-xs text-gray-400 mb-4">Hari ini 10:24</div>

                        <!-- Bot Message -->
                        <div class="flex gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="bot" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div
                                class="bg-white p-3.5 rounded-2xl rounded-tl-sm shadow-sm border border-gray-100 text-sm text-gray-700 leading-relaxed">
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
                                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1">
                                <i data-lucide="bot" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div
                                class="bg-white px-4 py-3.5 rounded-2xl rounded-tl-sm shadow-sm border border-gray-100 flex items-center gap-1">
                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 0s;"></div>
                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 0.2s;"></div>
                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 0.4s;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-4 bg-white border-t border-gray-100 flex gap-3 items-center">
                        <button class="p-2 text-gray-400 hover:text-primary transition-colors">
                            <i data-lucide="paperclip" class="w-5 h-5"></i>
                        </button>
                        <div class="flex-1 bg-gray-100 rounded-full px-4 py-2.5 text-sm text-gray-500">
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