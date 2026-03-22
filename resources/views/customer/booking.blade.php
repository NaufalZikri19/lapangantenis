@extends('layouts.customer')

@section('content')

    <div class="max-w-4xl mx-auto">

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


        <div class="bg-white shadow rounded-xl p-6">

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf

                <!-- COURT -->
                <div class="mb-5">
                    <label class="block text-sm text-gray-600 mb-2">
                        Select Court
                    </label>

                    <select id="court_id" name="court_id" class="w-full border rounded-lg p-3">
                        @foreach ($courts as $court)
                            <option value="{{ $court->id }}">
                                {{ $court->name }} - Rp {{ number_format($court->price) }}/jam
                            </option>
                        @endforeach
                    </select>
                </div>


                <!-- DATE -->
                <div class="mb-5">
                    <label class="block text-sm text-gray-600 mb-2">
                        Booking Date
                    </label>

                    <input type="date" id="booking_date" name="booking_date" min="{{ date('Y-m-d') }}"
                        class="w-full border rounded-lg p-3">
                </div>


                <!-- TIME SLOT -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-600 mb-2">
                        Select Time Slot
                    </label>

                    <div id="time_slots" class="grid grid-cols-3 gap-3">
                        <!-- slot akan muncul di sini -->
                    </div>

                    <!-- hidden input -->
                    <input type="hidden" name="start_time" id="start_time">
                    <input type="hidden" name="end_time" id="end_time">
                </div>

                <button id="submitBtn" disabled
                    class="bg-yellow-300 text-white px-6 py-3 rounded-lg font-semibold w-full cursor-not-allowed">

                    Confirm Booking

                </button>

            </form>

        </div>

    </div>

    <script>
        window.onload = function() {
            loadSlots();
        };

        let bookedTimes = [];
        let openTime = 8; // 08:00
        let closeTime = 22; // 22:00

        document.getElementById('court_id').addEventListener('change', loadSlots);
        document.getElementById('booking_date').addEventListener('change', loadSlots);
        document.getElementById('time_slots').innerHTML = '<p class="text-gray-400 col-span-3">Loading...</p>';

        function loadSlots() {

            let courtId = document.getElementById('court_id').value;
            let date = document.getElementById('booking_date').value;

            if (!date) {
                document.getElementById('time_slots').innerHTML =
                    '<p class="text-gray-400 text-sm col-span-3">Pilih tanggal terlebih dahulu</p>';
                return;
            }

            fetch(`/customer/check-availability?court_id=${courtId}&date=${date}`)
                .then(res => res.json())
                .then(data => {
                    console.log("DATA:", data);
                    bookedTimes = data;
                    generateSlots();
                })
                .catch(err => {
                    console.error("ERROR:", err);
                });
        }

        function generateSlots() {

            let container = document.getElementById('time_slots');
            container.innerHTML = '';

            for (let i = openTime; i < closeTime; i++) {

                let start = String(i).padStart(2, '0') + ':00';
                let end = String(i + 1).padStart(2, '0') + ':00';

                let isBooked = bookedTimes.some(b => {
                    return (start >= b.start_time && start < b.end_time);
                });

                let isPast = isPastTime(start);

                let btn = document.createElement('button');
                btn.type = 'button';
                btn.innerText = start + ' - ' + end;

                btn.className = `
            p-3 rounded-lg border text-sm
            ${isBooked || isPast
                ? 'bg-gray-200 text-gray-400 cursor-not-allowed'
                : 'bg-white hover:bg-yellow-100'}
        `;

                if (!isBooked && !isPast) {
                    btn.onclick = () => selectSlot(start, end, btn);
                }

                container.appendChild(btn);
            }
        }

        function selectSlot(start, end, element) {

            document.getElementById('start_time').value = start;
            document.getElementById('end_time').value = end;
            const btnSubmit = document.getElementById('submitBtn');
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('bg-yellow-300', 'cursor-not-allowed');
            btnSubmit.classList.add('bg-yellow-500');
            document.querySelectorAll('#time_slots button').forEach(btn => {
                btn.classList.remove('bg-yellow-400', 'text-white');
            });

            element.classList.add('bg-yellow-400', 'text-white');
        }

        function isPastTime(time) {

            let date = document.getElementById('booking_date').value;
            let now = new Date();

            let selected = new Date(date + ' ' + time);

            return selected < now;
        }
    </script>

@endsection
