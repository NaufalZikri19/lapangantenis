@extends('layouts.customer')

@section('content')

    <div class="w-full max-w-4xl mx-auto px-4">

        <h1 class="text-2xl font-bold mb-6">
            Book Tennis Court
        </h1>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- ERROR BENTROK --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                {{ session('error') }}
            </div>
        @endif

        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif


        <div class="grid md:grid-cols-3 gap-6">

            <!-- LEFT (FORM) -->
            <div class="md:col-span-2 bg-white shadow rounded-2xl p-5 sm:p-6">

                <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                    @csrf

                    <!-- COURT -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">
                            Select Court
                        </label>

                        <select id="court_id" name="court_id"
                            class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-yellow-400">
                            @foreach ($courts as $court)
                                <option value="{{ $court->id }}" data-price="{{ $court->price }}">
                                    {{ $court->name }} - Rp {{ number_format($court->price) }}/jam
                                </option>
                            @endforeach
                        </select>
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

                        <div id="time_slots" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        </div>

                        <input type="hidden" name="start_time" id="start_time">
                        <input type="hidden" name="end_time" id="end_time">
                        <input type="hidden" name="slots" id="slots">
                    </div>

                </form>
            </div>


            <!-- RIGHT (SUMMARY) -->
            <div class="bg-white shadow rounded-2xl p-5 sm:p-6 h-fit">

                <h2 class="font-semibold mb-4">📋 Booking Summary</h2>

                <div class="text-sm space-y-2 text-gray-600">

                    <div class="flex justify-between">
                        <span>Court</span>
                        <span id="summary_court">-</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Date</span>
                        <span id="summary_date">-</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Time</span>
                        <span id="summary_time">-</span>
                    </div>

                </div>

                <!-- PRICE -->
                <div id="price_info" class="mt-5 hidden">

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">

                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Duration</span>
                            <span id="duration">0 jam</span>
                        </div>

                        <div class="flex justify-between text-lg font-bold text-gray-800">
                            <span>Total</span>
                            <span id="total_price">Rp 0</span>
                        </div>

                    </div>

                </div>

                <!-- BUTTON -->
                <button id="submitBtn" form="bookingForm" disabled
                    class="mt-6 w-full bg-yellow-300 text-white py-3 rounded-xl font-semibold cursor-not-allowed transition">

                    Confirm Booking

                </button>

            </div>

        </div>

    </div>

    <script>
        let isValidSequence = true;
        let selectedSlots = [];
        let bookedTimes = [];
        let openTime = 8;
        let closeTime = 22;

        const courtSelect = document.getElementById('court_id');
        const dateInput = document.getElementById('booking_date');
        const timeSlots = document.getElementById('time_slots');
        const btnSubmit = document.getElementById('submitBtn');

        // 🔥 LOADING UI
        function showLoading() {
            timeSlots.innerHTML = `
            <div class="col-span-3 flex items-center gap-2 text-gray-500">
                <div class="w-4 h-4 border-2 border-yellow-500 border-t-transparent rounded-full animate-spin"></div>
                <span>Loading available time...</span>
            </div>
        `;
        }

        // RESET STATE
        function resetBookingUI() {

            selectedSlots = [];

            btnSubmit.disabled = true;
            btnSubmit.classList.remove('bg-yellow-500');
            btnSubmit.classList.add('bg-yellow-300', 'cursor-not-allowed');

            document.getElementById('price_info').classList.add('hidden');

            document.getElementById('duration').innerText = '0 jam';
            document.getElementById('total_price').innerText = 'Rp 0';

            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';

            timeSlots.innerHTML = `
        <p class="text-gray-400 text-sm col-span-3">
            Pilih tanggal terlebih dahulu
        </p>
    `;
        }

        // 🔥 LOAD SLOT
        function loadSlots() {
            selectedSlots = [];
            let courtId = courtSelect.value;
            let date = dateInput.value;

            if (!date) {
                resetBookingUI();
                return;
            }

            showLoading();

            fetch(`/customer/check-availability?court_id=${courtId}&date=${date}`)
                .then(res => res.json())
                .then(data => {
                    bookedTimes = data;
                    generateSlots();
                })
                .catch(err => {
                    console.error("ERROR:", err);
                });
        }

        // 🔥 GENERATE SLOT
        function generateSlots() {
            timeSlots.innerHTML = '';

            for (let i = openTime; i < closeTime; i++) {

                let start = String(i).padStart(2, '0') + ':00';
                let end = String(i + 1).padStart(2, '0') + ':00';

                let isBooked = bookedTimes.some(b =>
                    (b.start_time < end && b.end_time > start)
                );

                let isPast = isPastTime(start);

                let btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = `${start} - ${end}`;

                btn.className = `
    w-full
    p-3
    rounded-xl
    border
    text-sm
    font-medium
    transition
    duration-200
    ${isBooked || isPast
        ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
        : 'bg-white hover:bg-yellow-100 hover:border-yellow-400'}
`;

                if (!isBooked && !isPast) {
                    btn.onclick = () => selectSlot(start, end, btn);
                }

                timeSlots.appendChild(btn);
            }
        }

        // PILIH SLOT
        function selectSlot(start, end, element) {

            let slotKey = `${start}-${end}`;
            let index = selectedSlots.findIndex(s => s.key === slotKey);

            if (index !== -1) {

                selectedSlots.splice(index, 1);

                element.classList.remove(
                    'bg-yellow-500',
                    'text-white',
                    'shadow-lg',
                    'scale-105'
                );

                element.classList.add('bg-white');
            } else {

                if (selectedSlots.length > 0) {

                    let allSlots = [...selectedSlots, {
                        start,
                        end
                    }];

                    // sort berdasarkan start time
                    allSlots.sort((a, b) => a.start.localeCompare(b.start));

                    isValidSequence = true;

                    // cek harus nyambung
                    for (let i = 0; i < allSlots.length - 1; i++) {

                        let currentEnd = allSlots[i].end;
                        let nextStart = allSlots[i + 1].start;

                        if (currentEnd !== nextStart) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Slot tidak valid',
                                text: 'Slot harus berurutan (tidak boleh loncat)'
                            });
                            return;
                        }
                    }
                }


                selectedSlots.push({
                    key: slotKey,
                    start,
                    end
                });

                element.classList.add(
                    'bg-yellow-500',
                    'text-white',
                    'shadow-lg',
                    'scale-105'
                );

                element.classList.remove('bg-white');
            }

            updateSelectedTime();
        }

        function updateSelectedTime() {

            if (selectedSlots.length === 0) {

                document.getElementById('start_time').value = '';
                document.getElementById('end_time').value = '';
                document.getElementById('slots').value = '';

                if (!isValidSequence) {
                    btnSubmit.disabled = true;
                    btnSubmit.classList.add('bg-yellow-300', 'cursor-not-allowed');
                    btnSubmit.classList.remove('bg-yellow-500');

                    updatePrice();

                    return;
                }
            }

            // sort slot
            selectedSlots.sort((a, b) => a.start.localeCompare(b.start));

            document.getElementById('slots').value =
                JSON.stringify(selectedSlots);

            let start = selectedSlots[0].start;
            let end = selectedSlots[selectedSlots.length - 1].end;

            document.getElementById('start_time').value = start;
            document.getElementById('end_time').value = end;

            btnSubmit.disabled = false;
            btnSubmit.classList.remove('bg-yellow-300', 'cursor-not-allowed');
            btnSubmit.classList.add('bg-yellow-500');

            updatePrice();
            updateSummary();
        }

        function updateSummary() {

            let court = courtSelect.options[courtSelect.selectedIndex].text;
            let date = dateInput.value;

            document.getElementById('summary_court').innerText = court;
            document.getElementById('summary_date').innerText = date || '-';

            if (selectedSlots.length > 0) {
                let start = selectedSlots[0].start;
                let end = selectedSlots[selectedSlots.length - 1].end;
                document.getElementById('summary_time').innerText = `${start} - ${end}`;
            } else {
                document.getElementById('summary_time').innerText = '-';
            }
        }

        // 🔥 CEK JAM LEWAT
        function isPastTime(time) {
            let date = dateInput.value;
            let now = new Date();
            let selected = new Date(date + ' ' + time);

            return selected < now;
        }

        function updatePrice() {

            let priceBox = document.getElementById('price_info');

            // ❗ kalau tidak ada slot dipilih
            if (!selectedSlots || selectedSlots.length === 0) {
                priceBox.classList.add('hidden');

                // reset text biar bersih
                document.getElementById('duration').innerText = '0 jam';
                document.getElementById('total_price').innerText = 'Rp 0';

                return;
            }

            let pricePerHour = document
                .getElementById('court_id')
                .selectedOptions[0]
                .dataset.price;

            let totalHours = selectedSlots.length;
            let total = totalHours * pricePerHour;

            document.getElementById('duration').innerText = totalHours + ' jam';
            document.getElementById('total_price').innerText =
                'Rp ' + Number(total).toLocaleString('id-ID');

            priceBox.classList.remove('hidden');
        }


        // 🔥 EVENT LISTENER
        courtSelect.addEventListener('change', loadSlots);
        dateInput.addEventListener('change', loadSlots);

        // 🔥 FIX BUG HAPUS TANGGAL
        dateInput.addEventListener('input', function() {
            if (!this.value) {
                resetBookingUI();
                updatePrice(); // 🔥 double safety
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {

            if (!isValidSequence || selectedSlots.length === 0) {
                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Booking tidak valid',
                    text: 'Pilih slot yang benar terlebih dahulu'
                });
            }
        });

        // INIT
        resetBookingUI();
    </script>
@endsection
