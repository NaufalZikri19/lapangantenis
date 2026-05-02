@extends('layouts.customer')

@section('title', 'Pilih Lapangan')

@section('content')

    <div class="w-full">

        <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
            <i data-lucide="calendar-plus" class="w-6 h-6 text-yellow-500"></i>
            Booking Lapangan Tenis
        </h1>

        {{-- ALERT --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl mb-6 shadow-sm">
                <div class="flex gap-2 font-medium mb-1"><i data-lucide="alert-circle" class="w-5 h-5"></i> Ada kesalahan:</div>
                <ul class="list-disc list-inside text-sm ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6 lg:gap-8">

            <!-- LEFT -->
            <div
                class="md:col-span-2 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl p-5 md:p-8">

                <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                    @csrf

                    <!-- COURT -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">
                            1. Pilih Lapangan
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            @foreach ($courts as $court)
                                <div onclick="selectCourt(this, {{ $court->id }}, {{ $court->price }}, '{{ $court->name }}')"
                                    class="court-card group relative cursor-pointer bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm hover:border-yellow-400 hover:shadow-md transition-all duration-200 overflow-hidden">

                                    <!-- BADGE -->
                                    <div class="absolute top-3 right-3 hidden selected-badge z-10">
                                        <span
                                            class="bg-yellow-500 text-white text-xs font-medium px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1">
                                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Terpilih
                                        </span>
                                    </div>

                                    <!-- IMAGE -->
                                    <div class="overflow-hidden relative">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity z-0">
                                        </div>
                                        <img src="{{ asset('storage/' . $court->image) }}"
                                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>

                                    <!-- CONTENT -->
                                    <div class="p-4 relative bg-white dark:bg-gray-800">
                                        <div class="flex justify-between items-start mb-1">
                                            <h3
                                                class="font-semibold text-gray-800 dark:text-gray-100 text-base group-hover:text-yellow-600 transition-colors">
                                                {{ $court->name }}
                                            </h3>
                                            <span
                                                class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-[10px] font-medium rounded uppercase tracking-wide">
                                                {{ $court->type }}
                                            </span>
                                        </div>

                                        <div
                                            class="mt-3 text-sm font-semibold text-yellow-600 bg-yellow-50 dark:bg-yellow-900/30 inline-block px-2.5 py-1 rounded-lg">
                                            Rp {{ number_format($court->price, 0, ',', '.') }} <span
                                                class="text-yellow-600/70 text-xs font-normal">/ jam</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <input type="hidden" name="court_id" id="court_id">
                    </div>

                    <!-- DATE -->
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">
                            2. Tentukan Tanggal Main
                        </label>

                        <div class="relative w-full sm:w-64">
                            <i data-lucide="calendar"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-500"></i>
                            <input type="date" id="booking_date" name="booking_date" min="{{ date('Y-m-d') }}"
                                class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-xl pl-10 pr-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all shadow-sm">
                        </div>
                    </div>

                    <!-- TIME SLOT -->
                    <div class="mb-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">
                            3. Pilih Jam Main
                        </label>

                        <div id="time_slots" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic col-span-full">Silakan pilih lapangan
                                dan tanggal
                                terlebih dahulu.</p>
                        </div>

                        <input type="hidden" name="start_time" id="start_time">
                        <input type="hidden" name="end_time" id="end_time">
                        <input type="hidden" name="slots" id="slots">
                    </div>

                </form>
            </div>

            <!-- RIGHT / SUMMARY -->
            <div class="h-fit sticky top-24 space-y-6">

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-5">

                    <!-- TITLE -->
                    <h2
                        class="font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2 border-b border-gray-100 dark:border-gray-700 pb-4">
                        <i data-lucide="receipt" class="w-5 h-5 text-gray-400 dark:text-gray-500"></i>
                        Ringkasan Booking
                    </h2>

                    <!-- INFO -->
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1.5"><i
                                    data-lucide="map-pin" class="w-4 h-4"></i> Lapangan</span>
                            <span id="summary_court"
                                class="font-semibold text-gray-800 dark:text-gray-100 text-right">-</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1.5"><i
                                    data-lucide="calendar-days" class="w-4 h-4"></i> Tanggal</span>
                            <span id="summary_date"
                                class="font-semibold text-gray-800 dark:text-gray-100 text-right">-</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1.5"><i data-lucide="clock"
                                    class="w-4 h-4"></i> Jam Main</span>
                            <span id="summary_time"
                                class="font-semibold text-gray-800 dark:text-gray-100 text-right">-</span>
                        </div>
                    </div>

                    <!-- PRICE -->
                    <div id="price_info"
                        class="hidden bg-gray-50 dark:bg-gray-700 border border-gray-100 dark:border-gray-600 rounded-xl p-4 space-y-3 mt-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Durasi</span>
                            <span id="duration" class="font-semibold text-gray-800 dark:text-gray-100">0 jam</span>
                        </div>

                        <div class="h-px bg-gray-200 dark:bg-gray-600 w-full my-1"></div>

                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800 dark:text-gray-100">Total Harga</span>
                            <span id="total_price" class="text-lg font-bold text-yellow-600">
                                Rp 0
                            </span>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button id="submitBtn" form="bookingForm" type="submit"
                        class="w-full flex justify-center items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white py-3.5 rounded-xl font-bold transition-all duration-200 shadow-sm disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed mt-4"
                        disabled>
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Pesan Sekarang
                    </button>
                </div>

            </div>

        </div>

    </div>

    <script>
        let selectedSlots = [];
        let bookedTimes = [];
        let openTime = 8;
        let closeTime = 22;
        let selectedCourtPrice = 0;

        const dateInput = document.getElementById('booking_date');
        const timeSlots = document.getElementById('time_slots');
        const btnSubmit = document.getElementById('submitBtn');

        // SELECT COURT
        function selectCourt(element, id, price, name) {

            document.querySelectorAll('.court-card').forEach(card => {
                card.classList.remove('ring-2', 'ring-yellow-400', 'bg-yellow-50/30', 'border-yellow-400');
                card.classList.add('border-gray-200');

                let badge = card.querySelector('.selected-badge');
                if (badge) badge.classList.add('hidden');
            });

            element.classList.remove('border-gray-200');
            element.classList.add('ring-2', 'ring-yellow-400', 'bg-yellow-50/30', 'border-yellow-400');

            let badge = element.querySelector('.selected-badge');
            if (badge) badge.classList.remove('hidden');

            document.getElementById('court_id').value = id;
            selectedCourtPrice = price;

            let courtEl = document.getElementById('summary_court');
            if (courtEl) {
                courtEl.innerText = name;
            }

            loadSlots();
        }

        // LOAD SLOT
        function loadSlots() {
            selectedSlots = [];

            let courtId = document.getElementById('court_id').value;
            let date = dateInput.value;

            resetSummary();
            timeSlots.innerHTML = '';

            document.getElementById('slots').value = '';
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';

            btnSubmit.disabled = true;
            btnSubmit.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
            btnSubmit.classList.add('bg-gray-200', 'text-gray-400');

            if (!courtId) {
                timeSlots.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 italic col-span-full">Silakan pilih lapangan terlebih dahulu</p>';
                return;
            }

            if (!date) {
                timeSlots.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 italic col-span-full">Silakan pilih tanggal terlebih dahulu</p>';
                return;
            }

            timeSlots.innerHTML = '<div class="col-span-full flex justify-center py-4"><i data-lucide="loader-2" class="w-6 h-6 text-yellow-500 animate-spin"></i></div>';
            lucide.createIcons();

            fetch(`/customer/check-availability?court_id=${courtId}&date=${date}`)
                .then(res => res.json())
                .then(data => {
                    bookedTimes = data;
                    generateSlots();
                });
        }

        // GENERATE SLOT
        function generateSlots() {
            timeSlots.innerHTML = '';

            let selectedDate = dateInput.value;
            let now = new Date();

            for (let i = openTime; i < closeTime; i++) {

                let start = String(i).padStart(2, '0') + ':00';
                let end = String(i + 1).padStart(2, '0') + ':00';

                function toMinutes(time) {
                    let [h, m] = time.split(':').map(Number);
                    return h * 60 + m;
                }

                let isBooked = bookedTimes.some(b => {
                    let bStart = toMinutes(b.start_time);
                    let bEnd = toMinutes(b.end_time);
                    let sStart = toMinutes(start);
                    let sEnd = toMinutes(end);

                    return sStart < bEnd && sEnd > bStart;
                });

                let isPast = false;

                if (selectedDate === now.toISOString().split('T')[0]) {
                    if (i <= now.getHours()) isPast = true;
                }

                let btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = `${start} - ${end}`;
                btn.className = 'font-medium py-3 px-2 rounded-xl border text-sm transition-all duration-200';

                if (isBooked) {
                    btn.classList.add('bg-red-50', 'dark:bg-red-900/30', 'text-red-400', 'dark:text-red-500', 'border-red-100', 'dark:border-red-800/50', 'cursor-not-allowed', 'line-through');
                    btn.disabled = true;

                } else if (isPast) {
                    btn.classList.add('bg-gray-100', 'dark:bg-gray-800', 'text-gray-400', 'dark:text-gray-500', 'border-gray-200', 'dark:border-gray-700', 'cursor-not-allowed');
                    btn.disabled = true;

                } else {
                    btn.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600', 'hover:border-yellow-400', 'dark:hover:border-yellow-500', 'hover:text-yellow-600', 'dark:hover:text-yellow-500', 'cursor-pointer');
                    btn.onclick = () => selectSlot(start, end, btn);
                }

                timeSlots.appendChild(btn);
            }
        }

        // SELECT SLOT (SMART MULTI SELECT)
        function selectSlot(start, end, element) {

            let index = selectedSlots.findIndex(s => s.start === start);

            // UNSELECT
            if (index !== -1) {
                selectedSlots.splice(index, 1);
                element.classList.remove('bg-yellow-500', 'text-white', 'border-yellow-500');
                element.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
            } else {

                if (selectedSlots.length === 0) {
                    selectedSlots.push({ start, end });
                    element.classList.remove('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
                    element.classList.add('bg-yellow-500', 'text-white', 'border-yellow-500');
                } else {
                    let last = selectedSlots[selectedSlots.length - 1];

                    // BERURUTAN
                    if (last.end === start) {
                        selectedSlots.push({ start, end });
                        element.classList.remove('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
                        element.classList.add('bg-yellow-500', 'text-white', 'border-yellow-500');
                    } else {
                        // RESET OTOMATIS
                        document.querySelectorAll('#time_slots button:not(:disabled)').forEach(btn => {
                            btn.classList.remove('bg-yellow-500', 'text-white', 'border-yellow-500');
                            btn.classList.add('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
                        });

                        selectedSlots = [{ start, end }];
                        element.classList.remove('bg-white', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'border-gray-200', 'dark:border-gray-600');
                        element.classList.add('bg-yellow-500', 'text-white', 'border-yellow-500');
                    }
                }
            }

            // KOSONG
            if (selectedSlots.length === 0) {
                resetSummary();

                btnSubmit.disabled = true;
                btnSubmit.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
                btnSubmit.classList.add('bg-gray-200', 'text-gray-400');

                return;
            }

            updateSelectedTime();
        }

        // UPDATE
        function updateSelectedTime() {

            selectedSlots.sort((a, b) => a.start.localeCompare(b.start));

            let start = selectedSlots[0].start;
            let end = selectedSlots[selectedSlots.length - 1].end;

            document.getElementById('start_time').value = start;
            document.getElementById('end_time').value = end;

            document.getElementById('slots').value = JSON.stringify(selectedSlots);

            btnSubmit.disabled = false;
            btnSubmit.classList.remove('bg-gray-200', 'text-gray-400');
            btnSubmit.classList.add('bg-yellow-500', 'hover:bg-yellow-600', 'text-white');

            updateSummary();
            updatePrice();
        }

        // SUMMARY
        function updateSummary() {
            let dateVal = new Date(dateInput.value);
            let options = { day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('summary_date').innerText = dateVal.toLocaleDateString('id-ID', options);

            let start = selectedSlots[0].start;
            let end = selectedSlots[selectedSlots.length - 1].end;

            document.getElementById('summary_time').innerText = `${start} - ${end}`;
        }

        // PRICE
        function updatePrice() {
            let totalHours = selectedSlots.length;
            let total = totalHours * selectedCourtPrice;

            document.getElementById('duration').innerText = totalHours + ' jam';
            document.getElementById('total_price').innerText =
                'Rp ' + Number(total).toLocaleString('id-ID');

            document.getElementById('price_info').classList.remove('hidden');
        }

        // RESET SUMMARY
        function resetSummary() {
            document.getElementById('summary_date').innerText = '-';
            document.getElementById('summary_time').innerText = '-';
            document.getElementById('duration').innerText = '0 jam';
            document.getElementById('total_price').innerText = 'Rp 0';
            document.getElementById('price_info').classList.add('hidden');
        }

        // EVENT
        dateInput.addEventListener('change', loadSlots);

        document.getElementById('bookingForm').addEventListener('submit', function (e) {
            if (!selectedSlots.length) {
                alert('Pilih jam main terlebih dahulu!');
                e.preventDefault();
                return;
            }
            document.getElementById('slots').value = JSON.stringify(selectedSlots);
        });
    </script>
@endsection