<footer class="bg-gray-950 text-gray-300 pt-24 pb-12 relative overflow-hidden border-t border-white/5">
    {{-- Decorative Background --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-primary/50 to-transparent opacity-20">
    </div>
    <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl opacity-50"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">

            <!-- BRAND -->
            <div class="lg:col-span-1">
                <a href="/" class="flex items-center gap-3 mb-8 group">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Gumbreg QuickBook"
                        class="w-12 h-12 rounded-2xl shadow-xl group-hover:scale-105 transition-all duration-300 object-cover bg-white p-1">
                    <span class="text-2xl font-black tracking-tighter text-white">
                        Gumbreg<span class="text-primary">QuickBook</span>
                    </span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed mb-8 max-w-xs">
                    Sistem reservasi lapangan tenis modern di Purwokerto. Menghadirkan kemudahan akses olahraga dalam
                    satu platform digital yang intuitif.
                </p>
                <div class="flex gap-4">
                    {{-- Instagram with Branded Color --}}
                    <a href="https://www.instagram.com/gtc_pwt" target="_blank"
                        class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-white/10 transition-all group/social">
                        <svg class="w-5 h-5 opacity-70 group-hover/social:opacity-100 transition-opacity"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="footer-insta-gradient" x1="0%" y1="100%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#f09433" />
                                    <stop offset="25%" stop-color="#e6683c" />
                                    <stop offset="50%" stop-color="#dc2743" />
                                    <stop offset="75%" stop-color="#cc2366" />
                                    <stop offset="100%" stop-color="#bc1888" />
                                </linearGradient>
                            </defs>
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.332 2.633-1.308 3.608-.975.975-2.242 1.245-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.332-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                                fill="url(#footer-insta-gradient)" />
                        </svg>
                    </a>
                    <a href="https://chat.whatsapp.com/FUQ9QagLxnTIzqtAgWdlPN" target="_blank"
                        class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center hover:bg-white/10 transition-all group/social">
                        <i data-lucide="message-circle"
                            class="w-5 h-5 text-green-500 opacity-70 group-hover/social:opacity-100"></i>
                    </a>
                </div>
            </div>

            <!-- LINKS -->
            <div>
                <h3 class="text-white font-black mb-8 text-xs uppercase tracking-[0.2em]">Navigasi</h3>
                <ul class="space-y-4 text-sm">
                    <li><a href="#about"
                            class="text-gray-400 hover:text-primary transition-all flex items-center gap-2 group/link">
                            <span
                                class="w-1.5 h-px bg-gray-700 group-hover/link:w-3 group-hover/link:bg-primary transition-all"></span>
                            Tentang Kami
                        </a></li>
                    <li><a href="#pricing"
                            class="text-gray-400 hover:text-primary transition-all flex items-center gap-2 group/link">
                            <span
                                class="w-1.5 h-px bg-gray-700 group-hover/link:w-3 group-hover/link:bg-primary transition-all"></span>
                            Daftar Harga
                        </a></li>
                    <li><a href="#cara-booking"
                            class="text-gray-400 hover:text-primary transition-all flex items-center gap-2 group/link">
                            <span
                                class="w-1.5 h-px bg-gray-700 group-hover/link:w-3 group-hover/link:bg-primary transition-all"></span>
                            Cara Booking
                        </a></li>
                    <li><a href="#contact"
                            class="text-gray-400 hover:text-primary transition-all flex items-center gap-2 group/link">
                            <span
                                class="w-1.5 h-px bg-gray-700 group-hover/link:w-3 group-hover/link:bg-primary transition-all"></span>
                            Hubungi Kami
                        </a></li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div class="lg:col-span-2 lg:pl-10">
                <h3 class="text-white font-black mb-8 text-xs uppercase tracking-[0.2em]">Informasi Kontak</h3>
                <div class="grid sm:grid-cols-2 gap-8 text-sm">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center shrink-0">
                                <i data-lucide="map-pin" class="w-5 h-5 text-primary"></i>
                            </div>
                            <span class="text-gray-400 leading-relaxed">Jl. Gumbreg No.12, Kec. Purwokerto Tim.,
                                Kabupaten Banyumas, Jawa Tengah 53111</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center shrink-0">
                                <i data-lucide="mail" class="w-5 h-5 text-primary"></i>
                            </div>
                            <span class="text-gray-400">hello@gtc_pwt.com</span>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4 group/item">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center shrink-0 group-hover/item:bg-green-500/10 transition-colors">
                                <i data-lucide="phone" class="w-5 h-5 text-green-500"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Admin 1
                                </p>
                                <span class="text-gray-400">+62 851-3375-4771</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 group/item">
                            <div
                                class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center shrink-0 group-hover/item:bg-green-500/10 transition-colors">
                                <i data-lucide="phone" class="w-5 h-5 text-green-500"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Admin 2
                                </p>
                                <span class="text-gray-400">+62 815-6566-189</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div
            class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} <span class="text-white font-bold tracking-tight">Gumbreg<span
                        class="text-primary">QuickBook</span></span>. Hak Cipta Dilindungi.</p>
            <div class="flex gap-8">
                <a href="{{ route('terms') ?? '#' }}" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
            </div>
        </div>

    </div>
</footer>