@extends('layouts.customer')

@section('title', 'Payment')

@section('content')

    <div class="w-full max-w-3xl mx-auto space-y-6">

        <!-- BOOKING INFO -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border space-y-4">

            <h2 class="text-lg font-semibold text-gray-800">
                Detail Booking
            </h2>

            <div class="grid grid-cols-2 gap-y-2 text-sm text-gray-600">
                <span class="text-gray-500">Lapangan</span>
                <span class="font-medium text-gray-800">{{ $booking->court->name }}</span>

                <span class="text-gray-500">Tanggal</span>
                <span class="font-medium text-gray-800">{{ $booking->date }}</span>

                <span class="text-gray-500">Jam</span>
                <span class="font-medium text-gray-800">
                    {{ $booking->start_time }} - {{ $booking->end_time }}
                </span>
            </div>

        </div>


        <!-- COUNTDOWN -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border text-center space-y-1">

            <p class="text-sm text-gray-500">
                Sisa waktu pembayaran
            </p>

            <p id="countdown" class="text-2xl font-bold text-red-500 tracking-wide"></p>

        </div>


        <!-- PAYMENT -->
        <form method="POST" action="{{ route('booking.uploadPayment', $booking->id) }}" enctype="multipart/form-data"
            x-data="{ method: '' }" class="bg-white p-6 rounded-2xl shadow-sm border space-y-6">

            @csrf

            <h2 class="text-lg font-semibold text-gray-800">
                Metode Pembayaran
            </h2>


            <!-- METHOD -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- QRIS -->
                <label class="cursor-pointer group">
                    <input type="radio" name="payment_method" value="qris" class="hidden" x-model="method">

                    <div :class="method === 'qris'
                                ? 'border-yellow-500 bg-yellow-50 ring-1 ring-yellow-300'
                                : 'border-gray-200'"
                        class="border p-4 rounded-xl transition-all flex items-center gap-3 group-hover:border-yellow-400">

                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="qr-code" class="w-5 h-5 text-yellow-600"></i>
                        </div>

                        <div>
                            <p class="font-medium text-gray-800">QRIS</p>
                            <p class="text-xs text-gray-400">Scan & bayar cepat</p>
                        </div>

                    </div>
                </label>

                <!-- TRANSFER -->
                <label class="cursor-pointer group">
                    <input type="radio" name="payment_method" value="transfer" class="hidden" x-model="method">

                    <div :class="method === 'transfer'
                                ? 'border-yellow-500 bg-yellow-50 ring-1 ring-yellow-300'
                                : 'border-gray-200'"
                        class="border p-4 rounded-xl transition-all flex items-center gap-3 group-hover:border-yellow-400">

                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="building-2" class="w-5 h-5 text-yellow-600"></i>
                        </div>

                        <div>
                            <p class="font-medium text-gray-800">Transfer</p>
                            <p class="text-xs text-gray-400">Manual via bank</p>
                        </div>

                    </div>
                </label>

            </div>


            <!-- QRIS -->
            <div x-show="method === 'qris'" x-transition class="text-center space-y-3">
                <img src="{{ asset('images/qris.png') }}" class="w-48 mx-auto rounded-lg shadow">
                <p class="text-sm text-gray-500">Scan QRIS untuk pembayaran</p>
            </div>

            <!-- TRANSFER -->
            <div x-show="method === 'transfer'" x-transition
                class="bg-gray-50 p-4 rounded-xl text-sm text-gray-600 space-y-1">

                <div class="flex items-center gap-2 font-medium text-gray-800">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    Bank Transfer
                </div>

                <p>BCA - 123456789</p>
                <p>a.n Gumbreg Tennis</p>
            </div>


            <!-- UPLOAD -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700 flex items-center gap-2">
                    <i data-lucide="upload" class="w-4 h-4"></i>
                    Upload Bukti Bayar
                </label>

                <input type="file" name="payment_proof"
                    class="w-full border rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none">
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
                class="w-full bg-yellow-500 text-white py-3 rounded-xl font-semibold text-sm hover:bg-yellow-400 transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">

                <i data-lucide="wallet" class="w-4 h-4"></i>
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