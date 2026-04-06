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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($courts as $court)
                                <div onclick="selectCourt(this, {{ $court->id }}, {{ $court->price }}, '{{ $court->name }}')"
                                    class="court-card border rounded-xl p-3 cursor-pointer hover:shadow transition">

                                    <img src="{{ asset('storage/' . $court->image) }}"
                                        class="w-full h-32 object-cover rounded-lg mb-2">

                                    <p class="font-semibold">{{ $court->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $court->type }} • Rp {{ number_format($court->price) }}/jam
                                    </p>
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

                <h2 class="font-semibold mb-4">Booking Summary</h2>

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

                <button id="submitBtn" form="bookingForm" disabled
                    class="mt-6 w-full bg-yellow-300 text-white py-3 rounded-xl font-semibold cursor-not-allowed transition">
                    Confirm Booking
                </button>

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
            });

            element.classList.add('ring-2', 'ring-yellow-400', 'bg-yellow-50');

            document.getElementById('court_id').value = id;
            selectedCourtPrice = price;

            document.getElementById('summary_court').innerText = name;

            loadSlots();
        }

        // LOAD SLOT
        function loadSlots() {
            selectedSlots = [];

            let courtId = document.getElementById('court_id').value;
            let date = dateInput.value;

            // RESET UI
            resetSummary();
            timeSlots.innerHTML = '';
            document.getElementById('slots').value = '';
            document.getElementById('start_time').value = '';
            document.getElementById('end_time').value = '';

            btnSubmit.disabled = true;
            btnSubmit.classList.remove('bg-yellow-500', 'cursor-pointer');
            btnSubmit.classList.add('bg-yellow-300', 'cursor-not-allowed');

            // VALIDASI STEP BY STEP (JANGAN LANGSUNG RETURN)
            if (!courtId) {
                timeSlots.innerHTML =
                    '<p class="text-gray-400 text-sm col-span-3">Silahkan Pilih Lapangan Terlebih Dahulu</p>';
                return;
            }

            if (!date) {
                timeSlots.innerHTML =
                    '<p class="text-gray-400 text-sm col-span-3">Silahkan Pilih Tanggal Terlebih Dahulu</p>';
                return;
            }

            // LOADING
            timeSlots.innerHTML = `<p class="text-gray-400 text-sm col-span-3">Loading...</p>`;

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

                // CEK SLOT SUDAH DIBOOK
                let isBooked = bookedTimes.some(b =>
                    (b.start_time < end && b.end_time > start)
                );

                // CEK SLOT SUDAH LEWAT
                let isPast = false;

                if (selectedDate === now.toISOString().split('T')[0]) {
                    let currentHour = now.getHours();
                    if (i <= currentHour) {
                        isPast = true;
                    }
                }

                let btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = `${start} - ${end}`;

                // DISABLE CONDITION
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

        // SELECT SLOT
        function selectSlot(start, end, element) {

            let index = selectedSlots.findIndex(s => s.start === start);

            if (index !== -1) {
                // UNSELECT
                selectedSlots.splice(index, 1);
                element.classList.remove('bg-yellow-500', 'text-white');
            } else {

                // VALIDASI BERURUTAN
                if (selectedSlots.length > 0) {

                    // ambil semua jam yang sudah dipilih
                    let times = selectedSlots.map(s => s.start);

                    // ambil jam terkecil & terbesar
                    let min = times.sort()[0];
                    let max = times.sort()[times.length - 1];

                    // slot baru harus nyambung ke min atau max
                    if (!(end === min || start === max)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops!',
                            text: 'Pilih slot harus berurutan ya',
                            confirmButtonColor: '#FBBF24'
                        });
                        return;
                    }
                }

                // TAMBAH SLOT
                selectedSlots.push({
                    start,
                    end
                });
                element.classList.add('bg-yellow-500', 'text-white');
            }

            // RESET kalau kosong
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

            if (selectedSlots.length === 0) return;

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
            document.getElementById('summary_court').innerText = '-';
            document.getElementById('summary_date').innerText = '-';
            document.getElementById('summary_time').innerText = '-';

            document.getElementById('duration').innerText = '0 jam';
            document.getElementById('total_price').innerText = 'Rp 0';

            document.getElementById('price_info').classList.add('hidden');
        }

        // EVENTS
        dateInput.addEventListener('change', loadSlots);
    </script>

@endsection
