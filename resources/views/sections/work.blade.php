<section id="how-it-works" class="py-20 bg-white">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-sm text-yellow-500 font-semibold uppercase tracking-wide">
                How It Works
            </span>

            <h2 class="mt-3 text-3xl md:text-4xl font-bold text-gray-900">
                Cara Booking & Informasi Penting
            </h2>

            <p class="mt-4 text-gray-500">
                Ikuti langkah mudah untuk booking lapangan, dan temukan jawaban dari pertanyaan yang sering diajukan.
            </p>
        </div>

        <!-- Content Grid -->
        <div class="mt-12 grid md:grid-cols-2 gap-10 items-start">

            <!-- LEFT: STEPS -->
            <div class="space-y-6">

                <!-- Step -->
                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-yellow-500 text-white rounded-full font-bold">
                        1
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Login / Daftar</h3>
                        <p class="text-sm text-gray-500">
                            Masuk atau buat akun untuk mulai menggunakan sistem booking.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-yellow-500 text-white rounded-full font-bold">
                        2
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Pilih Lapangan</h3>
                        <p class="text-sm text-gray-500">
                            Pilih lapangan sesuai kebutuhan dan waktu bermain Anda.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-yellow-500 text-white rounded-full font-bold">
                        3
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Cek Jadwal</h3>
                        <p class="text-sm text-gray-500">
                            Setelah pilih lapangan, silahkan untuk melihat ketersediaan jadwal.
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div
                        class="w-10 h-10 flex items-center justify-center bg-yellow-500 text-white rounded-full font-bold">
                        4
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Booking & Main</h3>
                        <p class="text-sm text-gray-500">
                            Konfirmasi booking dan nikmati permainan tenis Anda tanpa ribet.
                        </p>
                    </div>
                </div>

            </div>

            <!-- RIGHT: FAQ -->
            <div x-data="{ open: null }" class="space-y-4">

                <!-- Item -->
                <div class="border rounded-xl p-4">
                    <button @click="open === 1 ? open = null : open = 1"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800">
                        Apakah harus login untuk booking?
                        <span x-text="open === 1 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 1" x-transition x-cloak class="mt-3 text-sm text-gray-500">
                        Ya, Anda perlu login atau membuat akun terlebih dahulu sebelum melakukan booking lapangan.
                    </p>
                </div>

                <div class="border rounded-xl p-4">
                    <button @click="open === 2 ? open = null : open = 2"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800">
                        Apakah bisa booking mendadak?
                        <span x-text="open === 2 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 2" x-transition x-cloak class="mt-3 text-sm text-gray-500">
                        Bisa, selama jadwal masih tersedia Anda dapat langsung melakukan booking secara real-time.
                    </p>
                </div>

                <div class="border rounded-xl p-4">
                    <button @click="open === 3 ? open = null : open = 3"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800">
                        Bagaimana cara cek ketersediaan?
                        <span x-text="open === 3 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 3" x-transition x-cloak class="mt-3 text-sm text-gray-500">
                        Anda dapat melihat langsung di sistem untuk mengecek jadwal.
                    </p>
                </div>

                <div class="border rounded-xl p-4">
                    <button @click="open === 4 ? open = null : open = 4"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800">
                        Apakah bisa membatalkan booking?
                        <span x-text="open === 4 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 4" x-transition x-cloak class="mt-3 text-sm text-gray-500">
                        Pembatalan dapat dilakukan sesuai dengan kebijakan yang berlaku pada sistem.
                    </p>
                </div>

            </div>

        </div>

    </div>

</section>
