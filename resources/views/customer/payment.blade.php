@extends('layouts.customer')

@section('title', 'Payment')

@section('content')

    <div class="max-w-2xl mx-auto space-y-6">

        <!-- BOOKING INFO -->
        <div class="bg-white p-6 rounded-2xl shadow border">
            <h2 class="text-lg font-semibold mb-4">Detail Booking</h2>

            <div class="space-y-1 text-sm text-gray-600">
                <p><span class="font-medium">Lapangan:</span> {{ $booking->court->name }}</p>
                <p><span class="font-medium">Tanggal:</span> {{ $booking->date }}</p>
                <p><span class="font-medium">Jam:</span> {{ $booking->start_time }} - {{ $booking->end_time }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow border text-center">
            <p class="text-sm text-gray-500">Sisa waktu pembayaran</p>
            <p id="countdown" class="text-lg font-semibold text-red-500 mt-1"></p>
        </div>

        <!-- PAYMENT -->
        <form method="POST" action="{{ route('booking.uploadPayment', $booking->id) }}" enctype="multipart/form-data"
            x-data="{ method: '' }" class="bg-white p-6 rounded-2xl shadow border space-y-6">

            @csrf

            <h2 class="text-lg font-semibold">Metode Pembayaran</h2>

            <!-- METHOD SELECT -->
            <div class="grid grid-cols-2 gap-4">

                <!-- QRIS -->
                <label class="cursor-pointer">
                    <input type="radio" name="payment_method" value="qris" class="hidden" x-model="method">
                    <div :class="method === 'qris'
                                            ?
                                            'border-yellow-500 bg-yellow-50' :
                                            'border-gray-200'" class="border p-4 rounded-xl text-center transition">

                        <p class="font-medium">QRIS</p>
                    </div>
                </label>

                <!-- TRANSFER -->
                <label class="cursor-pointer">
                    <input type="radio" name="payment_method" value="transfer" class="hidden" x-model="method">
                    <div :class="method === 'transfer'
                                            ?
                                            'border-yellow-500 bg-yellow-50' :
                                            'border-gray-200'" class="border p-4 rounded-xl text-center transition">

                        <p class="font-medium">Transfer</p>
                    </div>
                </label>

            </div>

            <!-- QRIS SECTION -->
            <div x-show="method === 'qris'" x-transition class="text-center space-y-3">
                <img src="{{ asset('images/qris.png') }}" class="w-48 mx-auto">
                <p class="text-sm text-gray-500">Scan QRIS untuk pembayaran</p>
            </div>

            <!-- TRANSFER SECTION -->
            <div x-show="method === 'transfer'" x-transition class="space-y-2 text-sm text-gray-600">
                <p class="font-medium">Bank Transfer</p>
                <p>BCA - 123456789</p>
                <p>a.n Gumbreg Tennis</p>
            </div>

            <!-- UPLOAD -->
            <div>
                <label class="block text-sm font-medium mb-1">Upload Bukti Bayar</label>
                <input type="file" name="payment_proof" class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <!-- ERROR -->
            @error('payment_method')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            @error('payment_proof')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <!-- SUBMIT -->
            <button id="submitPaymentBtn"
                class="w-full bg-yellow-500 text-white py-3 rounded-xl font-medium hover:bg-yellow-400 transition">
                Bayar Sekarang
            </button>

        </form>

    </div>

    <script>
        const expiredAt = new Date("{{ \Carbon\Carbon::parse($booking->expired_at)->format('Y-m-d H:i:s') }}").getTime();

        const countdownEl = document.getElementById("countdown");
        const submitBtn = document.getElementById("submitPaymentBtn");

        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = expiredAt - now;

            if (distance <= 0) {
                clearInterval(timer);
                countdownEl.innerHTML = "Expired";

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add("opacity-50", "cursor-not-allowed");
                }

                return;
            }

            const minutes = Math.floor(distance / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownEl.innerHTML = minutes + "m " + seconds + "s";
        }, 1000);
    </script>

@endsection