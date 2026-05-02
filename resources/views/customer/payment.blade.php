@extends('layouts.customer')

@section('title', 'Selesaikan Pembayaran')

@section('content')

    <div class="w-full max-w-4xl mx-auto flex flex-col md:flex-row gap-6">

        <!-- KIRI: DETAIL BOOKING & COUNTDOWN -->
        <div class="w-full md:w-1/3 space-y-6">

            <!-- COUNTDOWN -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 text-center space-y-2 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-red-500"></div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center justify-center gap-1.5">
                    <i data-lucide="timer" class="w-4 h-4 text-red-500"></i>
                    Batas Waktu Pembayaran
                </p>
                <p id="countdown" class="text-3xl font-bold text-gray-800 dark:text-gray-100 tracking-tight"></p>
            </div>

            <!-- BOOKING INFO -->
            <div
                class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                <h2
                    class="text-base font-bold text-gray-800 dark:text-gray-100 border-b border-gray-100 dark:border-gray-700 pb-3 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5 text-gray-400 dark:text-gray-500"></i> Detail Pesanan
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-start">
                        <span class="text-gray-500 dark:text-gray-400">Lapangan</span>
                        <span
                            class="font-semibold text-gray-800 dark:text-gray-100 text-right">{{ $booking->court->name }}</span>
                    </div>

                    <div class="flex justify-between items-start">
                        <span class="text-gray-500 dark:text-gray-400">Tanggal</span>
                        <span
                            class="font-semibold text-gray-800 dark:text-gray-100 text-right">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</span>
                    </div>

                    <div class="flex justify-between items-start">
                        <span class="text-gray-500 dark:text-gray-400">Jam Main</span>
                        <span class="font-semibold text-gray-800 dark:text-gray-100 text-right">{{ $booking->start_time }} -
                            {{ $booking->end_time }}</span>
                    </div>

                    <div
                        class="pt-3 border-t border-dashed border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <span class="text-gray-500 dark:text-gray-400">Total Harga</span>
                        <span class="text-lg font-bold text-yellow-600">Rp
                            {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- KANAN: METODE & UPLOAD -->
        <div class="w-full md:w-2/3">
            <form method="POST" action="{{ route('booking.uploadPayment', $booking->id) }}" enctype="multipart/form-data"
                x-data="{ method: '' }"
                class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-8">

                @csrf

                <!-- HEADER -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-1">Metode Pembayaran</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pilih metode pembayaran yang Anda inginkan.</p>
                </div>

                <!-- METHOD OPTIONS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- QRIS -->
                    <label class="cursor-pointer group relative">
                        <input type="radio" name="payment_method" value="qris" class="hidden" x-model="method">
                        <div :class="method === 'qris'
                                                ? 'border-yellow-500 bg-yellow-50/50 dark:bg-yellow-900/20 ring-1 ring-yellow-400'
                                                : 'border-gray-200 dark:border-gray-700'"
                            class="border p-4 rounded-xl transition-all duration-200 flex items-center gap-4 group-hover:border-yellow-400">

                            <div class="absolute top-3 right-3" x-show="method === 'qris'">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-yellow-500"></i>
                            </div>

                            <div
                                class="w-12 h-12 bg-white dark:bg-gray-700 rounded-xl border border-gray-100 dark:border-gray-600 flex items-center justify-center shrink-0 shadow-sm">
                                <i data-lucide="qr-code" class="w-6 h-6 text-yellow-600"></i>
                            </div>

                            <div>
                                <p class="font-bold text-gray-800 dark:text-gray-100">QRIS</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Scan dari aplikasi e-wallet</p>
                            </div>
                        </div>
                    </label>

                    <!-- TRANSFER -->
                    <label class="cursor-pointer group relative">
                        <input type="radio" name="payment_method" value="transfer" class="hidden" x-model="method">
                        <div :class="method === 'transfer'
                                                ? 'border-yellow-500 bg-yellow-50/50 dark:bg-yellow-900/20 ring-1 ring-yellow-400'
                                                : 'border-gray-200 dark:border-gray-700'"
                            class="border p-4 rounded-xl transition-all duration-200 flex items-center gap-4 group-hover:border-yellow-400">

                            <div class="absolute top-3 right-3" x-show="method === 'transfer'">
                                <i data-lucide="check-circle-2" class="w-5 h-5 text-yellow-500"></i>
                            </div>

                            <div
                                class="w-12 h-12 bg-white dark:bg-gray-700 rounded-xl border border-gray-100 dark:border-gray-600 flex items-center justify-center shrink-0 shadow-sm">
                                <i data-lucide="landmark" class="w-6 h-6 text-yellow-600"></i>
                            </div>

                            <div>
                                <p class="font-bold text-gray-800 dark:text-gray-100">Transfer Bank</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Transfer manual via ATM/M-Banking</p>
                            </div>
                        </div>
                    </label>

                </div>

                <!-- INSTRUCTIONS -->
                <div x-show="method === 'qris'" x-transition x-cloak
                    class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center border border-gray-100 dark:border-gray-600">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-4">Scan QR Code di bawah ini</p>
                    <img src="{{ asset('images/qris.png') }}"
                        class="w-48 mx-auto rounded-xl shadow-sm border border-gray-200 bg-white p-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">Pastikan nominal sesuai dengan total harga
                        pesanan.</p>
                </div>

                <div x-show="method === 'transfer'" x-transition x-cloak
                    class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 border border-gray-100 dark:border-gray-600 flex flex-col items-center text-center space-y-3">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mb-2">
                        <i data-lucide="credit-card" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Transfer ke rekening BCA</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-gray-100 tracking-wider">123 456 7890</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">a.n Gumbreg Tennis Court</p>
                    </div>
                </div>

                <!-- UPLOAD PROOF -->
                <div class="space-y-3 border-t border-gray-100 dark:border-gray-700 pt-6">
                    <label class="text-sm font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i data-lucide="upload-cloud" class="w-4 h-4 text-gray-500 dark:text-gray-400"></i>
                        Upload Bukti Pembayaran
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Format: JPG, PNG, JPEG. Max: 2MB.</p>

                    <div class="relative group">
                        <input type="file" name="payment_proof" accept="image/*"
                            class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 dark:file:bg-yellow-900/30 file:text-yellow-600 dark:file:text-yellow-400 hover:file:bg-yellow-100 dark:hover:file:bg-yellow-900/50 cursor-pointer border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    </div>
                </div>

                <!-- ERRORS -->
                @if($errors->any())
                    <div class="bg-red-50 text-red-600 text-sm p-3 rounded-lg border border-red-100">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- SUBMIT -->
                <button id="submitPaymentBtn" type="submit"
                    class="w-full bg-yellow-500 text-white py-3.5 rounded-xl font-bold hover:bg-yellow-600 transition-all shadow-sm disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                    Konfirmasi Pembayaran
                </button>

            </form>
        </div>

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
                countdownEl.innerHTML = "Waktu Habis";
                countdownEl.classList.remove("text-gray-800", "dark:text-gray-100");
                countdownEl.classList.add("text-red-500");

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i data-lucide="x-circle" class="w-5 h-5"></i> Waktu Expired';
                    lucide.createIcons();
                }

                return;
            }

            const minutes = Math.floor(distance / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownEl.innerHTML = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }, 1000);
    </script>

@endsection