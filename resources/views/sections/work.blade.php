<section id="how-it-works" class="py-20 bg-white dark:bg-gray-900">

    <div class="max-w-6xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-sm text-yellow-500 font-semibold uppercase tracking-wide">
                Alur Booking
            </span>

            <h2 class="mt-3 text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                Cara Melakukan Booking & FAQ
            </h2>

            <p class="mt-4 text-gray-500 dark:text-gray-400">
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
                        <h3 class="font-semibold text-gray-800 dark:text-white">Login / Daftar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
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
                        <h3 class="font-semibold text-gray-800 dark:text-white">Pilih Lapangan</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
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
                        <h3 class="font-semibold text-gray-800 dark:text-white">Cek Jadwal</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
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
                        <h3 class="font-semibold text-gray-800 dark:text-white">Booking & Main</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Konfirmasi booking dan nikmati permainan tenis Anda tanpa ribet.
                        </p>
                    </div>
                </div>

            </div>

            <!-- RIGHT: FAQ -->
            <div x-data="{ open: null }" class="space-y-4">

                <!-- Item -->
                <div class="border dark:border-gray-700 rounded-xl p-4 bg-white dark:bg-gray-800">
                    <button @click="open === 1 ? open = null : open = 1"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800 dark:text-white focus:outline-none">
                        Apakah harus login untuk booking?
                        <span x-text="open === 1 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 1" x-transition x-cloak class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Ya, Anda perlu login atau membuat akun terlebih dahulu sebelum melakukan booking lapangan.
                    </p>
                </div>

                <div class="border dark:border-gray-700 rounded-xl p-4 bg-white dark:bg-gray-800">
                    <button @click="open === 2 ? open = null : open = 2"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800 dark:text-white focus:outline-none">
                        Apakah bisa booking mendadak?
                        <span x-text="open === 2 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 2" x-transition x-cloak class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Bisa, selama jadwal masih tersedia Anda dapat langsung melakukan booking secara real-time.
                    </p>
                </div>

                <div class="border dark:border-gray-700 rounded-xl p-4 bg-white dark:bg-gray-800">
                    <button @click="open === 3 ? open = null : open = 3"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800 dark:text-white focus:outline-none">
                        Bagaimana cara cek ketersediaan?
                        <span x-text="open === 3 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 3" x-transition x-cloak class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Anda dapat melihat langsung di sistem untuk mengecek jadwal.
                    </p>
                </div>

                <div class="border dark:border-gray-700 rounded-xl p-4 bg-white dark:bg-gray-800">
                    <button @click="open === 4 ? open = null : open = 4"
                        class="w-full flex justify-between items-center text-left font-semibold text-gray-800 dark:text-white focus:outline-none">
                        Apakah bisa membatalkan booking?
                        <span x-text="open === 4 ? '-' : '+'"></span>
                    </button>

                    <p x-show="open === 4" x-transition x-cloak class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                        Pembatalan dapat dilakukan sesuai dengan kebijakan yang berlaku pada sistem.
                    </p>
                </div>

            </div>

        </div>

    </div>

</section>
