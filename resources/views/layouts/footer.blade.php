<footer id="site-footer" class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-16 pb-8">

    <div class="max-w-7xl mx-auto px-6">

        <!-- TOP GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            <!-- BRAND -->
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Gumbreg<span class="text-yellow-400">QuickBook</span>
                </h2>

                <p class="text-gray-400 mt-4 leading-relaxed text-sm">
                    Platform booking lapangan tenis yang cepat, akurat, dan terintegrasi untuk pengalaman reservasi
                    terbaik.
                </p>

                <!-- CTA -->
                <a href="https://wa.me/6282198487319" target="_blank"
                    class="inline-flex items-center gap-2 mt-6 bg-yellow-500 hover:bg-yellow-400 text-black px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-lg">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    Hubungi Kami
                </a>
            </div>

            <!-- NAVIGATION -->
            <div>
                <h4 class="text-white font-semibold mb-5 text-sm uppercase tracking-wider">
                    Navigasi
                </h4>

                <ul class="space-y-3 text-sm">
                    <li><a href="#about" class="hover:text-yellow-400 transition">Tentang Kami</a></li>
                    <li><a href="#court" class="hover:text-yellow-400 transition">Lapangan</a></li>
                    <li><a href="#pricing" class="hover:text-yellow-400 transition">Harga</a></li>
                    <li><a href="#how-it-works" class="hover:text-yellow-400 transition">Cara Booking</a></li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div>
                <h4 class="text-white font-semibold mb-5 text-sm uppercase tracking-wider">
                    Kontak
                </h4>

                <ul class="space-y-4 text-sm">

                    <li class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-yellow-400 mt-0.5"></i>
                        <span>Purwokerto Timur, Banyumas</span>
                    </li>

                    <li class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-yellow-400"></i>
                        <span>+62 812 3456 7890</span>
                    </li>

                    <li class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-yellow-400"></i>
                        <span>info@gumbreg.com</span>
                    </li>

                </ul>
            </div>

            <!-- EXTRA / SYSTEM -->
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">
                    Kenapa Kami?
                </h4>

                <div class="space-y-4 text-sm text-gray-400">

                    <div class="flex gap-3">
                        <i data-lucide="zap" class="w-5 h-5 text-yellow-400"></i>
                        <span>Booking instan tanpa ribet</span>
                    </div>

                    <div class="flex gap-3">
                        <i data-lucide="calendar" class="w-5 h-5 text-yellow-400"></i>
                        <span>Jadwal real-time</span>
                    </div>

                </div>
            </div>

        </div>

        <!-- DIVIDER -->
        <div class="border-t border-gray-800 mt-12 pt-6 text-center text-sm text-gray-500">

            <p>
                © {{ date('Y') }} Gumbreg Tennis Court. All rights reserved.
            </p>

        </div>

    </div>

    <!-- BACK TO TOP -->
    <button onclick="scrollToTop()" id="backToTopBtn"
        class="fixed bottom-6 right-6 bg-yellow-500 hover:bg-yellow-400 w-12 h-12 rounded-full shadow-xl flex items-center justify-center transition-all duration-300 hover:scale-110 opacity-0 translate-y-4 z-50">
        <i data-lucide="arrow-up" class="w-5 h-5 text-white"></i>
    </button>

</footer>

<script>
    const btn = document.getElementById("backToTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            btn.classList.remove("opacity-0", "translate-y-4");
            btn.classList.add("opacity-100", "translate-y-0");
        } else {
            btn.classList.add("opacity-0", "translate-y-4");
            btn.classList.remove("opacity-100", "translate-y-0");
        }
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }
</script>
