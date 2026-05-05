<footer class="bg-gray-900 text-gray-300 pt-20 pb-10 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-12 lg:gap-12 mb-16">

            <!-- BRAND -->
            <div class="lg:col-span-1">
                <a href="/" class="flex items-center gap-2 mb-6 group">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Gumbreg QuickBook"
                        class="w-10 h-10 rounded-xl shadow-sm group-hover:scale-105 transition-transform duration-200 object-cover bg-white">
                    <span class="text-xl font-bold tracking-tight text-white">
                        Gumbreg<span class="text-primary">QuickBook</span>
                    </span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed mb-6">
                    Sistem reservasi lapangan tenis modern yang dirancang untuk memudahkan Anda bermain tanpa ribet.
                    Cepat, mudah, dan terpercaya.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                        <i data-lucide="facebook" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <!-- LINKS -->
            <div>
                <h3 class="text-white font-semibold mb-6 text-sm uppercase tracking-wider">Perusahaan</h3>
                <ul class="space-y-4 text-sm">
                    <li><a href="#about" class="text-gray-400 hover:text-primary transition-colors">Tentang Kami</a>
                    </li>
                    <li><a href="#cara-booking" class="text-gray-400 hover:text-primary transition-colors">Panduan
                            Booking</a></li>
                    <li><a href="{{ route('terms') }}" class="text-gray-400 hover:text-primary transition-colors">Syarat
                            & Ketentuan</a></li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div>
                <h3 class="text-white font-semibold mb-6 text-sm uppercase tracking-wider">Hubungi Kami</h3>
                <ul class="space-y-5 text-sm">
                    <li class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-primary shrink-0 mt-0.5"></i>
                        <span class="text-gray-400">Jl. Gumbreg No.12, Purwokerto, Jawa Tengah, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-primary shrink-0"></i>
                        <span class="text-gray-400">+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-primary shrink-0"></i>
                        <span class="text-gray-400">hello@gumbregquickbook.com</span>
                    </li>
                </ul>
            </div>

        </div>

        <div
            class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-center items-center gap-4 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Gumbreg QuickBook. Hak Cipta Dilindungi.</p>
        </div>

    </div>
</footer>