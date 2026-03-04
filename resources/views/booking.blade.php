<x-dashboard-layout>

    <div class="space-y-8">

        <!-- PAGE TITLE -->
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Booking Lapangan
            </h1>
            <p class="text-gray-500 mt-1">
                Pilih lapangan, tanggal, dan jam yang tersedia.
            </p>
        </div>


        <!-- FILTER CARD -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="grid md:grid-cols-3 gap-6">

                <div>
                    <label class="text-sm text-gray-600 mb-2 block">
                        Lapangan
                    </label>
                    <select
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400">
                        <option>Court A</option>
                        <option>Court B</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600 mb-2 block">
                        Tanggal
                    </label>
                    <input type="date"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400">
                </div>

            </div>
        </div>


        <!-- MAIN CONTENT -->
        <div class="grid lg:grid-cols-4 gap-8">

            <!-- TIME SLOT -->
            <div class="lg:col-span-3 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold">
                        Pilih Jam
                    </h2>

                    <!-- LEGEND -->
                    <div class="flex gap-4 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-400 rounded-full"></span>
                            Tersedia
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-gray-300 rounded-full"></span>
                            Terbooking
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 md:grid-cols-6 gap-4">

                    <button
                        class="py-3 rounded-xl bg-green-100 text-green-700 hover:bg-green-200 transition font-medium">
                        08:00
                    </button>

                    <button
                        class="py-3 rounded-xl bg-green-100 text-green-700 hover:bg-green-200 transition font-medium">
                        09:00
                    </button>

                    <button disabled class="py-3 rounded-xl bg-gray-200 text-gray-400 cursor-not-allowed font-medium">
                        10:00
                    </button>

                    <button
                        class="py-3 rounded-xl bg-green-100 text-green-700 hover:bg-green-200 transition font-medium">
                        11:00
                    </button>

                    <button
                        class="py-3 rounded-xl bg-green-100 text-green-700 hover:bg-green-200 transition font-medium">
                        12:00
                    </button>

                    <button disabled class="py-3 rounded-xl bg-gray-200 text-gray-400 cursor-not-allowed font-medium">
                        13:00
                    </button>

                </div>
            </div>


            <!-- BOOKING SUMMARY -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

                <h3 class="text-lg font-semibold mb-6">
                    Ringkasan Booking
                </h3>

                <div class="space-y-4 text-sm">

                    <div>
                        <p class="text-gray-500">Lapangan</p>
                        <p class="font-medium">Court A</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Tanggal</p>
                        <p class="font-medium">-</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Jam</p>
                        <p class="font-medium">-</p>
                    </div>

                    <div class="pt-4 border-t">
                        <p class="text-gray-500">Total</p>
                        <p class="text-xl font-bold text-yellow-500">
                            Rp 0
                        </p>
                    </div>

                </div>

                <button
                    class="mt-8 w-full bg-yellow-500 text-white py-3 rounded-xl hover:bg-yellow-400 transition font-semibold">
                    Konfirmasi Booking
                </button>

            </div>

        </div>

    </div>

</x-dashboard-layout>
