@extends('layouts.customer')

@section('content')

    <div class="w-full max-w-5xl mx-auto px-4">

        <h1 class="text-2xl font-bold mb-6">
            Book Tennis Court
        </h1>

        {{-- ALERT --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6">

            <!-- LEFT -->
            <div class="md:col-span-2 bg-white shadow rounded-2xl p-5 sm:p-6">

                <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                    @csrf

                    <!-- COURT -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-600 mb-3">
                            Select Court
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            @foreach ($courts as $court)
                                <div onclick="selectCourt(this, {{ $court->id }}, {{ $court->price }}, '{{ $court->name }}')"
                                    class="court-card group relative cursor-pointer bg-white rounded-2xl border shadow-sm hover:shadow-md transition duration-200 overflow-hidden">

                                    <!-- BADGE -->
                                    <div class="absolute top-3 right-3 hidden selected-badge">
                                        <span class="bg-yellow-400 text-white text-xs px-3 py-1 rounded-full shadow">
                                            ✓ Selected
                                        </span>
                                    </div>

                                    <!-- IMAGE -->
                                    <div class="overflow-hidden">
                                        <img src="{{ asset('storage/' . $court->image) }}"
                                            class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">
                                    </div>

                                    <!-- CONTENT -->
                                    <div class="p-4 space-y-2">
                                        <h3 class="font-semibold text-gray-800 text-base">
                                            {{ $court->name }}
                                        </h3>

                                        <p class="text-xs text-gray-500">
                                            {{ $court->type }}
                                        </p>

                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-sm font-semibold text-yellow-500">
                                                Rp {{ number_format($court->price, 0, ',', '.') }}
                                                / jam
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        <input type="hidden" name="court_id" id="court_id">
                    </div>

                    <!-- DATE -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Booking Date
                        </label>

                        <input type="date" id="booking_date" name="booking_date" min="{{ date('Y-m-d') }}"
                            class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-400">
                    </div>

                    <!-- TIME SLOT -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Select Time Slot
                        </label>

                        <div id="time_slots" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>

                        <input type="hidden" name="start_time" id="start_time">
                        <input type="hidden" name="end_time" id="end_time">
                        <input type="hidden" name="slots" id="slots">
                    </div>

                </form>
            </div>

            <!-- RIGHT -->
            <div class="bg-white shadow rounded-2xl p-5 sm:p-6 h-fit">

                <div class="bg-white rounded-2xl shadow p-5 space-y-4">


                    <!-- TITLE -->
                    <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-yellow-500"></i>
                        Booking Summary
                    </h2>

                    <!-- INFO -->
                    <div class="space-y-2 text-sm">

                        <div class="flex justify-between">
                            <span class="text-gray-500">Court</span>
                            <span id="summary_court" class="font-medium text-gray-800">-</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Date</span>
                            <span id="summary_date" class="font-medium text-gray-800">-</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Time</span>
                            <span id="summary_time" class="font-medium text-gray-800">-</span>
                        </div>

                    </div>

                    <!-- PRICE -->
                    <div id="price_info" class="hidden bg-yellow-50 border border-yellow-200 rounded-xl p-4 space-y-2">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Duration</span>
                            <span id="duration" class="font-medium">0 jam</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-800">Total</span>
                            <span id="total_price" class="text-lg font-bold text-yellow-600">
                                Rp 0
                            </span>
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <button id="submitBtn"
                        class="w-full bg-yellow-400 hover:bg-yellow-500 text-white py-3 rounded-xl font-semibold transition disabled:bg-yellow-200 cursor-not-allowed"
                        disabled>
                        Confirm Booking
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
                card.classList.remove('ring-2', 'ring-yellow-400', 'bg-yellow-50');

                let badge = card.querySelector('.selected-badge');
                if (badge) badge.classList.add('hidden');
            });

            element.classList.add('ring-2', 'ring-yellow-400', 'bg-yellow-50');

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
            btnSubmit.classList.remove('bg-yellow-500', 'cursor-pointer');
            btnSubmit.classList.add('bg-yellow-300', 'cursor-not-allowed');

            if (!courtId) {
                timeSlots.innerHTML = '<p class="text-gray-400">Pilih lapangan dulu</p>';
                return;
            }

            if (!date) {
                timeSlots.innerHTML = '<p class="text-gray-400">Pilih tanggal dulu</p>';
                return;
            }

            timeSlots.innerHTML = '<p class="text-gray-400">Loading...</p>';

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

                let isBooked = bookedTimes.some(b =>
                    (b.start_time < end && b.end_time > start)
                );

                let isPast = false;

                if (selectedDate === now.toISOString().split('T')[0]) {
                    if (i <= now.getHours()) isPast = true;
                }

                let btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = `${start} - ${end}`;

                if (isBooked) {
                    btn.className = 'p-3 rounded-xl border text-sm bg-red-100 text-red-400 cursor-not-allowed';
                    btn.disabled = true;

                } else if (isPast) {
                    btn.className = 'p-3 rounded-xl border text-sm bg-gray-200 text-gray-400 cursor-not-allowed';
                    btn.disabled = true;

                } else {
                    btn.className = 'p-3 rounded-xl border text-sm bg-white hover:bg-yellow-100 cursor-pointer';
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
                element.classList.remove('bg-yellow-500', 'text-white');
            } else {

                if (selectedSlots.length === 0) {
                    selectedSlots.push({
                        start,
                        end
                    });
                    element.classList.add('bg-yellow-500', 'text-white');
                } else {
                    let last = selectedSlots[selectedSlots.length - 1];

                    // BERURUTAN
                    if (last.end === start) {
                        selectedSlots.push({
                            start,
                            end
                        });
                        element.classList.add('bg-yellow-500', 'text-white');
                    } else {
                        // RESET OTOMATIS (tanpa alert)
                        document.querySelectorAll('#time_slots button').forEach(btn => {
                            btn.classList.remove('bg-yellow-500', 'text-white');
                        });

                        selectedSlots = [{
                            start,
                            end
                        }];
                        element.classList.add('bg-yellow-500', 'text-white');
                    }
                }
            }

            // KOSONG
            if (selectedSlots.length === 0) {
                resetSummary();

                btnSubmit.disabled = true;
                btnSubmit.classList.remove('bg-yellow-500', 'cursor-pointer');
                btnSubmit.classList.add('bg-yellow-300', 'cursor-not-allowed');

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
            btnSubmit.classList.remove('bg-yellow-300', 'cursor-not-allowed');
            btnSubmit.classList.add('bg-yellow-500', 'cursor-pointer');

            updateSummary();
            updatePrice();
        }

        // SUMMARY
        function updateSummary() {
            document.getElementById('summary_date').innerText = dateInput.value;

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
            //

            document.getElementById('summary_date').innerText = '-';
            document.getElementById('summary_time').innerText = '-';

            document.getElementById('duration').innerText = '0 jam';
            document.getElementById('total_price').innerText = 'Rp 0';

            document.getElementById('price_info').classList.add('hidden');
        }

        // EVENT
        dateInput.addEventListener('change', loadSlots);
    </script>

@endsection
