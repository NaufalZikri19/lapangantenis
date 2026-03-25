<footer id="site-footer" class="bg-gray-900 text-gray-300 pt-20 pb-10">

    <div class="max-w-6xl mx-auto px-6">

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-12">

            <!-- BRAND -->
            <div>
                <h3 class="text-2xl font-bold text-white mb-4">
                    Gumbreg<span class="text-yellow-500">Court</span>
                </h3>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Booking lapangan tenis jadi lebih mudah dengan sistem online.
                    Pilih jadwal, pesan, dan main tanpa ribet.
                </p>
            </div>

            <!-- NAV -->
            <div>
                <h4 class="text-white font-semibold mb-4">Navigation</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-yellow-400">Home</a></li>
                    <li><a href="{{ url('/#court') }}" class="hover:text-yellow-400">Courts</a></li>
                    <li><a href="{{ url('/#pricing') }}" class="hover:text-yellow-400">Pricing</a></li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div>
                <h4 class="text-white font-semibold mb-4">Contact</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        Gg. Peger Desa, Mersi, Kec. Purwokerto Timur
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        +62 812 3456 7890
                    </li>
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        info@gumbreg.com
                    </li>
                </ul>
            </div>

            <!-- CTA -->
            <div>
                <h4 class="text-white font-semibold mb-4">Butuh Bantuan?</h4>

                <div class="space-y-3">

                    <button onclick="window.location='/courts'"
                        class="w-full bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-sm">
                        Booking Lapangan
                    </button>

                    <button onclick="window.open('https://wa.me/6282198487319')"
                        class="w-full bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-sm">
                        Chat WhatsApp
                    </button>

                    <button onclick="alert('Jam buka: 08.00 - 23.00')"
                        class="w-full bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-sm">
                        Jam Operasional
                    </button>

                </div>

            </div>

        </div>

        <!-- COPYRIGHT -->
        <div class="border-t border-gray-700 mt-16 pt-8 text-center text-sm text-gray-500">
            © {{ date('Y') }} Gumbreg Tennis Court. All rights reserved.
        </div>

    </div>

    <!-- FLOATING WHATSAPP -->
    <a href="https://wa.me/6282198487319" target="_blank"
        class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-400 w-14 h-14 rounded-full shadow-xl flex items-center justify-center transition duration-300 z-50">

        <i data-lucide="message-circle" class="w-6 h-6 text-white"></i>
    </a>

</footer>
