<x-dashboard-layout>

    <!-- STAT CARDS -->
    <div class="grid md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Total Booking</p>
            <p class="text-3xl font-bold mt-2">12</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Booking Aktif</p>
            <p class="text-3xl font-bold mt-2 text-green-500">2</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <p class="text-gray-500 text-sm">Saldo</p>
            <p class="text-3xl font-bold mt-2">Rp 0</p>
        </div>

    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="text-lg font-semibold mb-6">
            Recent Booking
        </h2>

        <div class="space-y-4 text-sm">

            <div class="flex justify-between border-b pb-3">
                <span>Court A - 12 Juni 2026</span>
                <span class="text-green-500 font-medium">Confirmed</span>
            </div>

            <div class="flex justify-between border-b pb-3">
                <span>Court B - 15 Juni 2026</span>
                <span class="text-yellow-500 font-medium">Pending</span>
            </div>

        </div>

    </div>

</x-dashboard-layout>
