<section class="py-24 bg-white overflow-hidden relative">
    {{-- Decorative Background --}}
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">

            <div class="order-2 lg:order-1 relative">
                <!-- Abstract Mockup -->
                <div
                    class="relative rounded-[2rem] bg-white shadow-2xl border border-gray-100 overflow-hidden z-10 transform transition-all duration-700 hover:scale-[1.01] hover:shadow-primary/5 group">

                    {{-- Window Header --}}
                    <div
                        class="bg-gray-50/50 backdrop-blur-sm border-b border-gray-100 px-8 py-5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                            </div>
                            <div class="h-4 w-px bg-gray-200 mx-2"></div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-widest">Gumbreg Dashboard
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                            <i data-lucide="user" class="w-5 h-5 text-primary"></i>
                        </div>
                    </div>

                    <div class="p-8 flex gap-8">
                        <!-- Sidebar Mockup -->
                        <div class="w-52 hidden md:block space-y-4 border-r border-gray-50 pr-6">
                            <div
                                class="h-10 bg-primary rounded-xl w-full flex items-center px-4 shadow-lg shadow-primary/20">
                                <div class="w-4 h-4 rounded-md bg-white/30 mr-3"></div>
                                <div class="h-2.5 bg-white/40 rounded w-20"></div>
                            </div>
                            @for ($i = 0; $i < 3; $i++)
                                <div
                                    class="h-10 hover:bg-gray-50 rounded-xl w-full flex items-center px-4 transition-colors">
                                    <div class="w-4 h-4 rounded-md bg-gray-200 mr-3"></div>
                                    <div class="h-2.5 bg-gray-200 rounded w-24"></div>
                                </div>
                            @endfor
                        </div>

                        <!-- Main Content Mockup -->
                        <div class="flex-1 space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="h-5 bg-gray-200 rounded w-1/3"></div>
                                <div class="h-8 w-24 bg-gray-100 rounded-lg"></div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div
                                    class="h-28 bg-gray-50 rounded-2xl p-4 flex flex-col justify-between border border-gray-100">
                                    <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                                        <i data-lucide="calendar" class="w-5 h-5 text-yellow-600"></i>
                                    </div>
                                    <div class="space-y-1.5">
                                        <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-3/4"></div>
                                    </div>
                                </div>
                                <div
                                    class="h-28 bg-gray-50 rounded-2xl p-4 flex flex-col justify-between border border-gray-100">
                                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                                    </div>
                                    <div class="space-y-1.5">
                                        <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-3/4"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="h-44 bg-gray-50 rounded-2xl border border-gray-100 p-6">
                                <div class="h-3 bg-gray-200 rounded w-1/4 mb-6"></div>
                                <div class="space-y-3">
                                    <div class="h-10 bg-white rounded-xl w-full border border-gray-100 shadow-sm"></div>
                                    <div class="h-10 bg-white rounded-xl w-full border border-gray-100 shadow-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating Element --}}
                <div class="absolute -bottom-8 -right-8 bg-white p-5 rounded-[2rem] shadow-2xl border border-gray-100 z-20 animate-bounce"
                    style="animation-duration: 4s;">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-green-500 text-white flex items-center justify-center shadow-lg shadow-green-500/20">
                            <i data-lucide="bell" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Update Baru</p>
                            <p class="text-base font-black text-gray-900">Pembayaran Berhasil</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-1 lg:order-2 lg:pl-10">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-widest mb-6">
                    Antarmuka Modern
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">
                    Manajemen Booking <br><span class="text-primary italic text-3xl md:text-4xl">Dalam Satu
                        Genggaman</span>
                </h2>
                <p class="text-lg text-gray-500 mb-10 leading-relaxed">
                    Nikmati kemudahan memantau jadwal, mengelola pembayaran, hingga melihat riwayat permainan dalam satu
                    dasbor yang intuitif dan responsif.
                </p>

                <div class="space-y-6">
                    <div
                        class="group flex items-start gap-5 p-5 rounded-3xl hover:bg-gray-50 transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-white rounded-2xl shadow-md flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <i data-lucide="layout" class="w-6 h-6 text-primary"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Clean & Intuitive UI</h4>
                            <p class="text-sm text-gray-500">Desain antarmuka yang bersih dan mudah dipahami bahkan
                                untuk pengguna baru.</p>
                        </div>
                    </div>

                    <div
                        class="group flex items-start gap-5 p-5 rounded-3xl hover:bg-gray-50 transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-white rounded-2xl shadow-md flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <i data-lucide="zap" class="w-6 h-6 text-primary"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Real-Time Status</h4>
                            <p class="text-sm text-gray-500">Dapatkan notifikasi instan dan pantau status verifikasi
                                pembayaran secara langsung.</p>
                        </div>
                    </div>

                    <div
                        class="group flex items-start gap-5 p-5 rounded-3xl hover:bg-gray-50 transition-all duration-300">
                        <div
                            class="w-12 h-12 bg-white rounded-2xl shadow-md flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                            <i data-lucide="smartphone" class="w-6 h-6 text-primary"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-1">Responsive Design</h4>
                            <p class="text-sm text-gray-500">Akses dasbor Anda dari perangkat mana saja, mulai dari
                                desktop hingga smartphone.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>