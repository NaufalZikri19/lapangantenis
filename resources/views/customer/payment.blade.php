@extends('layouts.customer')

@section('title', 'Selesaikan Pembayaran')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-4 py-4 md:py-8" x-data="{ 
                method: 'qris', 
                agree: false, 
                showTerms: false, 
                expired: false,
                previewUrl: null,
                isLoading: false,
                handleFileChange(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.previewUrl = URL.createObjectURL(file);
                    }
                }
             }" x-on:booking-expired.window="expired = true">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: SUMMARY & DETAILS -->
            <div class="lg:col-span-5 space-y-6">

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 p-4 rounded-2xl">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- COUNTDOWN TIMER -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transition-all duration-300"
                    :class="expired ? 'ring-2 ring-red-500' : 'ring-1 ring-gray-100 dark:ring-gray-700'">
                    <div class="p-6 text-center space-y-4">
                        <div class="flex items-center justify-center gap-2">
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
                                    :class="expired ? 'bg-red-400' : 'bg-amber-400'"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3"
                                    :class="expired ? 'bg-red-500' : 'bg-amber-500'"></span>
                            </span>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Sisa
                                Waktu Pembayaran</p>
                        </div>
                        <div id="countdown"
                            class="text-5xl font-black tracking-tighter text-gray-900 dark:text-white tabular-nums">00:00
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-3 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-[10px] text-center text-gray-500 dark:text-gray-400 font-medium">Segera selesaikan
                            agar jadwal tidak diambil orang lain.</p>
                    </div>
                </div>

                <!-- BOOKING DETAILS CARD -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="flex items-center gap-3 border-b border-gray-50 dark:border-gray-700 pb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center">
                                <i data-lucide="calendar-check" class="w-5 h-5 text-yellow-600"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-800 dark:text-white">Detail Booking</h2>
                        </div>

                        <div class="space-y-5">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center shrink-0">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Lapangan</p>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                        {{ $booking->court->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center shrink-0">
                                    <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Tanggal</p>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                        {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center shrink-0">
                                    <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400">Waktu</p>
                                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $booking->start_time }}
                                        - {{ $booking->end_time }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- TOTAL PAYMENT HIGHLIGHT -->
                        <div class="pt-6 border-t border-dashed border-gray-200 dark:border-gray-700">
                            <div class="flex items-end justify-between mb-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pembayaran</p>
                                <span
                                    class="px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-tight">Termasuk
                                    kode unik</span>
                            </div>
                            @php
                                $totalPrice = $booking->total_price ?: ($booking->court->price * (\Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time)) ?: 1));
                                $formattedPrice = number_format($totalPrice, 0, ',', '.');
                                $mainPrice = substr($formattedPrice, 0, -3);
                                $uniqueDigits = substr($formattedPrice, -3);
                            @endphp
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xl font-bold text-gray-400">Rp</span>
                                    <span class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $mainPrice }}<span class="text-yellow-500">{{ $uniqueDigits }}</span></span>
                                </div>
                                <button type="button" @click="navigator.clipboard.writeText('{{ $totalPrice }}'); Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Nominal disalin!', showConfirmButton: false, timer: 2000})" 
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-yellow-500 hover:text-white dark:hover:bg-yellow-500 dark:hover:text-white transition-all text-[10px] font-bold uppercase tracking-widest shrink-0">
                                    <i data-lucide="copy" class="w-3.5 h-3.5"></i> Salin
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ALERT BOX -->
                <div
                    class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 p-6 rounded-3xl flex gap-4">
                    <i data-lucide="info" class="w-6 h-6 text-blue-500 shrink-0"></i>
                    <div>
                        <p class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-1">Penting!</p>
                        <p class="text-xs text-blue-800/70 dark:text-blue-400/70 leading-relaxed">
                            Pembayaran akan diverifikasi oleh admin. Pastikan nominal transfer **SAMA PERSIS** hingga 3
                            digit terakhir.
                            <br><span class="font-bold">Estimasi Verifikasi: 1 - 5 Menit.</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: PAYMENT PROCESS -->
            <div class="lg:col-span-7">
                <form method="POST" action="{{ route('booking.uploadPayment', $booking->id) }}"
                    enctype="multipart/form-data" @submit="isLoading = true"
                    class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    @csrf

                    <div class="p-6 md:p-10 space-y-8">

                        <!-- METHOD SELECTION -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">Pilih Metode Pembayaran</h3>
                                <div
                                    class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-[10px] font-black uppercase tracking-widest text-gray-500 dark:text-gray-400">
                                    Step 1/3</div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="payment_method" value="qris" class="hidden" x-model="method">
                                    <div :class="method === 'qris' ? 'border-yellow-500 ring-2 ring-yellow-500/20 bg-yellow-50/30 dark:bg-yellow-900/10' : 'border-gray-100 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'"
                                        class="border-2 p-5 rounded-2xl transition-all duration-300 flex flex-col items-center text-center gap-3">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-white dark:bg-gray-700 shadow-sm flex items-center justify-center">
                                            <i data-lucide="qr-code" class="w-6 h-6"
                                                :class="method === 'qris' ? 'text-yellow-600' : 'text-gray-400'"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">QRIS</p>
                                            <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">Semua
                                                E-Wallet & Mobile Banking</p>
                                        </div>
                                        <div x-show="method === 'qris'" class="absolute top-3 right-3 text-yellow-500">
                                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative group">
                                    <input type="radio" name="payment_method" value="transfer" class="hidden"
                                        x-model="method">
                                    <div :class="method === 'transfer' ? 'border-yellow-500 ring-2 ring-yellow-500/20 bg-yellow-50/30 dark:bg-yellow-900/10' : 'border-gray-100 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'"
                                        class="border-2 p-5 rounded-2xl transition-all duration-300 flex flex-col items-center text-center gap-3">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-white dark:bg-gray-700 shadow-sm flex items-center justify-center">
                                            <i data-lucide="landmark" class="w-6 h-6"
                                                :class="method === 'transfer' ? 'text-yellow-600' : 'text-gray-400'"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">Transfer Bank</p>
                                            <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium">BCA (Manual
                                                Verification)</p>
                                        </div>
                                        <div x-show="method === 'transfer'" class="absolute top-3 right-3 text-yellow-500">
                                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- QRIS SECTION -->
                        <div x-show="method === 'qris'" x-transition:enter="transition ease-out duration-300 delay-100"
                            x-transition:enter-start="opacity-0 translate-y-4" class="space-y-8">
                            <div class="flex flex-col items-center justify-center space-y-6">
                                <div
                                    class="bg-white p-4 rounded-[2.5rem] shadow-2xl border-4 border-gray-50 ring-1 ring-gray-100 relative group overflow-hidden">
                                    <img src="{{ asset('images/qris.png') }}"
                                        class="w-[200px] md:w-[250px] h-auto rounded-[2rem] transition-transform duration-500 group-hover:scale-110"
                                        alt="QRIS">
                                    <div
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                        <button type="button"
                                            @click="Swal.fire({imageUrl: '{{ asset('images/qris.png') }}', imageWidth: 500, showConfirmButton: false, background: 'white', padding: '20px'})"
                                            class="w-10 h-10 rounded-full bg-white text-gray-900 flex items-center justify-center hover:scale-110 transition-transform">
                                            <i data-lucide="zoom-in" class="w-5 h-5"></i>
                                        </button>
                                        <a href="{{ asset('images/qris.png') }}" download="QRIS-Gumbreg.png"
                                            class="w-10 h-10 rounded-full bg-white text-gray-900 flex items-center justify-center hover:scale-110 transition-transform">
                                            <i data-lucide="download" class="w-5 h-5"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <button type="button"
                                        @click="Swal.fire({imageUrl: '{{ asset('images/qris.png') }}', imageWidth: 500, showConfirmButton: false})"
                                        class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center gap-1.5 transition-colors">
                                        <i data-lucide="maximize" class="w-3.5 h-3.5"></i> Perbesar QR
                                    </button>
                                    <span class="text-gray-200">|</span>
                                    <a href="{{ asset('images/qris.png') }}" download
                                        class="text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center gap-1.5 transition-colors">
                                        <i data-lucide="download" class="w-3.5 h-3.5"></i> Download QR
                                    </a>
                                </div>
                            </div>

                            <!-- STEPS -->
                            <div class="space-y-6">
                                <h4 class="text-sm font-black text-gray-900 dark:text-white flex items-center gap-2">
                                    <i data-lucide="list-checks" class="w-5 h-5 text-yellow-500"></i> Instruksi Pembayaran
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                            1</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">Scan QRIS</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mt-1">Gunakan
                                                GoPay, OVO, Dana, ShopeePay, atau Mobile Banking.</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                            2</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">Input Nominal Tepat
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mt-1">
                                                Masukkan nominal hingga 3 digit terakhir. <span
                                                    class="text-red-500 font-bold">JANGAN DIBULATKAN!</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TRANSFER SECTION -->
                        <div x-show="method === 'transfer'" x-transition:enter="transition ease-out duration-300 delay-100"
                            x-transition:enter-start="opacity-0 translate-y-4" class="space-y-8">
                            <div
                                class="bg-gradient-to-br from-gray-900 to-black dark:from-gray-800 dark:to-gray-950 p-8 rounded-[2.5rem] text-white relative overflow-hidden shadow-2xl">
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/10 rounded-full -mr-10 -mt-10 blur-3xl">
                                </div>
                                <div class="relative z-10 space-y-6">
                                    <div class="flex justify-between items-center">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">Bank
                                            Transfer Account</p>
                                        <i data-lucide="landmark" class="w-8 h-8 text-yellow-500"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-3xl font-black tracking-[0.1em] font-mono">123 456 7890</p>
                                        <p class="text-sm font-bold text-gray-300">Bank BCA <span
                                                class="mx-2 text-gray-600">•</span> a.n Gumbreg Tennis Court</p>
                                    </div>
                                    <button type="button"
                                        @click="navigator.clipboard.writeText('1234567890'); Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Rekening disalin!', showConfirmButton: false, timer: 2000})"
                                        class="w-full py-4 bg-white/5 hover:bg-white/10 border border-white/10 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all flex items-center justify-center gap-2 backdrop-blur-md group">
                                        <i data-lucide="copy"
                                            class="w-4 h-4 transition-transform group-hover:scale-110"></i> Salin Nomor
                                        Rekening
                                    </button>
                                </div>
                            </div>

                            <!-- STEPS -->
                            <div class="space-y-6">
                                <h4 class="text-sm font-black text-gray-900 dark:text-white flex items-center gap-2">
                                    <i data-lucide="list-checks" class="w-5 h-5 text-yellow-500"></i> Instruksi Pembayaran
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                            1</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">Transfer Manual</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mt-1">Lakukan
                                                transfer ke rekening BCA di atas via ATM atau Mobile Banking.</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-900 dark:bg-gray-700 text-white flex items-center justify-center text-xs font-bold shrink-0">
                                            2</div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">Input Nominal Tepat
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mt-1">Gunakan
                                                nominal yang tertera di ringkasan (termasuk kode unik).</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- UPLOAD PROOF -->
                        <div class="space-y-4 pt-8 border-t border-gray-50 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-black text-gray-900 dark:text-white">Upload Bukti Pembayaran</h3>
                                <div
                                    class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-[10px] font-black uppercase tracking-widest text-gray-500 dark:text-gray-400">
                                    Step 2/3</div>
                            </div>

                            <div class="relative group">
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
                                    @change="handleFileChange"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                <div
                                    class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-[2rem] p-8 transition-all duration-300 group-hover:border-yellow-500 group-hover:bg-yellow-50/10 flex flex-col items-center justify-center text-center gap-4 bg-gray-50/50 dark:bg-gray-900/20">

                                    <template x-if="!previewUrl">
                                        <div class="space-y-4">
                                            <div
                                                class="w-16 h-16 rounded-3xl bg-white dark:bg-gray-800 shadow-sm flex items-center justify-center mx-auto transition-transform group-hover:scale-110">
                                                <i data-lucide="image-plus" class="w-8 h-8 text-yellow-600"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900 dark:text-white">Klik atau seret
                                                    file ke sini</p>
                                                <p
                                                    class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-widest font-bold">
                                                    PNG, JPG, JPEG (Max 2MB)</p>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="previewUrl">
                                        <div class="relative">
                                            <img :src="previewUrl"
                                                class="max-h-[200px] rounded-2xl shadow-lg border-4 border-white dark:border-gray-700">
                                            <button type="button"
                                                @click.prevent="previewUrl = null; document.getElementById('payment_proof').value = ''"
                                                class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center shadow-lg hover:scale-110 transition-transform z-20">
                                                <i data-lucide="x" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- TERMS & SUBMIT -->
                        <div class="space-y-6 pt-4">
                            <div
                                class="flex items-start gap-4 bg-gray-50/50 dark:bg-gray-900/50 p-5 rounded-2xl border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center h-5">
                                    <input id="agree_terms" name="agree_terms" type="checkbox" x-model="agree" required
                                        class="w-5 h-5 text-yellow-500 border-gray-300 rounded-lg focus:ring-yellow-500 cursor-pointer">
                                </div>
                                <label for="agree_terms"
                                    class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed cursor-pointer font-medium">
                                    Saya menyetujui <button type="button" @click="showTerms = true"
                                        class="text-yellow-600 font-black hover:underline">Syarat & Ketentuan</button> yang
                                    berlaku. Saya bertanggung jawab atas kebenaran bukti pembayaran ini.
                                </label>
                            </div>

                            <button type="submit" :disabled="!agree || expired || isLoading"
                                class="w-full relative overflow-hidden bg-yellow-500 hover:bg-yellow-600 disabled:bg-gray-100 dark:disabled:bg-gray-700 disabled:text-gray-400 text-white h-16 rounded-[2rem] font-black text-lg transition-all shadow-xl shadow-yellow-500/20 active:scale-[0.98] group flex items-center justify-center gap-3">
                                <template x-if="!isLoading && !expired">
                                    <div class="flex items-center gap-3">
                                        <span>Konfirmasi Pembayaran</span>
                                        <i data-lucide="arrow-right"
                                            class="w-6 h-6 transition-transform group-hover:translate-x-1"></i>
                                    </div>
                                </template>

                                <template x-if="isLoading">
                                    <div class="flex items-center gap-3">
                                        <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span>Memproses...</span>
                                    </div>
                                </template>

                                <template x-if="expired">
                                    <div class="flex items-center gap-3 text-red-500">
                                        <i data-lucide="x-circle" class="w-6 h-6"></i>
                                        <span>Booking Expired</span>
                                    </div>
                                </template>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- TERMS MODAL (Same as before but stylized) -->
        <div x-show="showTerms" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md" @click="showTerms = false"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"></div>

            <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl w-full max-w-xl relative overflow-hidden flex flex-col max-h-[85vh] border border-gray-100 dark:border-gray-700"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                <div class="p-8 border-b border-gray-50 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-5 h-5 text-yellow-600"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white">Syarat & Ketentuan</h3>
                    </div>
                    <button @click="showTerms = false"
                        class="w-10 h-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                        <i data-lucide="x" class="w-5 h-5 text-gray-400"></i>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto text-sm text-gray-600 dark:text-gray-400 space-y-6">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 flex gap-4">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-green-500 shrink-0"></i>
                            <p class="font-medium">Booking bersifat final setelah pembayaran dikonfirmasi oleh admin.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 flex gap-4">
                            <i data-lucide="timer" class="w-5 h-5 text-amber-500 shrink-0"></i>
                            <p class="font-medium">Batas waktu pembayaran adalah 10 menit sejak pesanan dibuat.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 flex gap-4">
                            <i data-lucide="x-circle" class="w-5 h-5 text-red-500 shrink-0"></i>
                            <p class="font-medium">Tidak ada pengembalian dana (No Refund) untuk pembatalan atau
                                ketidakhadiran.</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 flex gap-4">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-orange-500 shrink-0"></i>
                            <p class="font-medium">Pihak pengelola berhak membatalkan booking jika ditemukan penyalahgunaan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-50 dark:border-gray-700">
                    <button @click="showTerms = false"
                        class="w-full h-14 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-2xl font-black transition-transform active:scale-95">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const expiredAt = new Date("{{ \Carbon\Carbon::parse($booking->expired_at)->format('Y-m-d H:i:s') }}").getTime();
        const countdownEl = document.getElementById("countdown");

        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = expiredAt - now;

            if (distance <= 0) {
                clearInterval(timer);
                countdownEl.innerHTML = "EXPIRED";
                countdownEl.classList.remove("text-gray-900", "dark:text-white");
                countdownEl.classList.add("text-red-500");
                window.dispatchEvent(new CustomEvent('booking-expired'));
                lucide.createIcons();
                return;
            }

            const minutes = Math.floor(distance / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownEl.innerHTML = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            // Add urgency color
            if (minutes < 2) {
                countdownEl.classList.add("text-red-500", "animate-pulse");
            }
        }, 1000);
    </script>
@endsection