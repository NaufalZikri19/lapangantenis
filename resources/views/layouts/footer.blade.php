<footer id="site-footer" class="bg-gradient-to-b from-gray-900 to-black text-gray-300 pt-20 pb-10">

    <div class="max-w-7xl mx-auto px-6">

        <!-- TOP GRID -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-start">

            <!-- LEFT -->
            <div>
                <h2 class="text-xl font-bold text-white">
                    Gumbreg<span class="text-yellow-400">QuickBook</span>
                </h2>

                <p class="text-gray-400 mt-4 leading-relaxed max-w-sm">
                    Booking lapangan tenis kini lebih cepat dan mudah dengan sistem online terintegrasi.
                </p>

                <!-- CTA -->
                <div class="mt-6 flex flex-wrap gap-3">

                    <a href="https://wa.me/6282198487319" target="_blank"
                        class="inline-flex items-center border border-gray-600 hover:border-yellow-400 hover:text-yellow-400 px-5 py-2.5 rounded-full text-sm font-semibold transition">
                        <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                        Hubungi
                    </a>

                </div>
            </div>

            <!-- NAVIGATION -->
            <div class="md:text-center">
                <h4 class="font-semibold text-white mb-5">Navigation</h4>

                <ul class="space-y-3 text-gray-400">

                    <li>
                        <a href="#about" class="hover:text-yellow-400 transition">
                            Tentang Kami
                        </a>
                    </li>

                    <li>
                        <a href="#court" class="hover:text-yellow-400 transition">
                            Lapangan Kami
                        </a>
                    </li>

                    <li>
                        <a href="#pricing" class="hover:text-yellow-400 transition">
                            Harga
                        </a>
                    </li>

                    <li>
                        <a href="#how-it-works" class="hover:text-yellow-400 transition">
                            Cara Booking
                        </a>
                    </li>

                </ul>
            </div>

            <!-- CONTACT -->
            <div class="md:text-right">
                <h4 class="font-semibold text-white mb-5">Contact</h4>

                <div class="space-y-4 text-gray-400">

                    <p class="flex items-start md:justify-end gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 mt-1 text-yellow-400"></i>
                        <span class="max-w-xs">
                            Gg. Peger Desa, Mersi, Kec. Purwokerto Timur
                        </span>
                    </p>

                    <p class="flex items-center md:justify-end gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-yellow-400"></i>
                        <span>+62 812 3456 7890</span>
                    </p>

                    <p class="flex items-center md:justify-end gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-yellow-400"></i>
                        <span>info@gumbreg.com</span>
                    </p>

                </div>
            </div>

        </div>

        <!-- DIVIDER -->
        <div class="border-t border-gray-800 mt-16 pt-8 text-center text-sm text-gray-500">
            © {{ date('Y') }} Gumbreg Tennis Court. All rights reserved.
        </div>

    </div>

    <!-- BACK TO TOP -->
    <button onclick="scrollToTop()" id="backToTopBtn"
        class="fixed bottom-6 right-6 bg-yellow-500 hover:bg-yellow-400 w-14 h-14 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 opacity-0 translate-y-4 z-50">

        <i data-lucide="arrow-up" class="w-7 h-7 text-white"></i>
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
