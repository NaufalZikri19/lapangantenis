@extends('layouts.customer')

@section('title', 'Invoice Pembayaran')

@section('content')
    <div class="w-full max-w-4xl mx-auto px-4 py-8 print:py-0 print:px-0">

        <!-- ACTIONS (Not printed) -->
        <div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 print:hidden">
            <a href="{{ route('customer.dashboard') }}"
                class="w-full sm:w-auto px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold transition-all flex items-center justify-center gap-2 text-sm shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Dashboard
            </a>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                @if($booking->payment_proof)
                    <button onclick="window.open('{{ asset('storage/' . $booking->payment_proof) }}', '_blank')"
                        class="w-full sm:w-auto px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-xl font-bold transition-all flex items-center justify-center gap-2 text-sm shadow-sm">
                        <i data-lucide="image" class="w-4 h-4 text-blue-500"></i> Bukti Transfer
                    </button>
                @endif

                <button onclick="window.print()"
                    class="w-full sm:w-auto px-6 py-2.5 bg-gray-900 dark:bg-yellow-500 hover:bg-black dark:hover:bg-yellow-600 text-white rounded-xl font-bold transition-all shadow-md flex items-center justify-center gap-2 text-sm">
                    <i data-lucide="printer" class="w-4 h-4"></i> Cetak PDF
                </button>
            </div>
        </div>

        @if(session('success'))
            <div
                class="mb-8 bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800 p-6 rounded-2xl flex items-start gap-4 animate-fade-in-up print:hidden">
                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center shrink-0">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-800 dark:text-green-400 mb-1">Berhasil!</h3>
                    <p class="text-sm text-green-700/80 dark:text-green-500/80">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- INVOICE DOCUMENT -->
        <div id="invoice-document"
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden print:shadow-none print:rounded-none border border-gray-100 dark:border-none">

            <!-- Top Colored Bar -->
            <div class="h-3 bg-yellow-500 print:bg-yellow-500"
                style="-webkit-print-color-adjust: exact; print-color-adjust: exact;"></div>

            <div class="p-8 md:p-12 print:p-0">
                <!-- INVOICE HEADER -->
                <div
                    class="flex flex-col md:flex-row justify-between items-start mb-10 border-b border-gray-100 dark:border-gray-700 pb-8 print:border-b-2 print:border-gray-200">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-12 h-12 bg-white rounded-xl overflow-hidden flex items-center justify-center">
                                <img src="{{ asset('image/logo.webp') }}" alt="Gumbreg Tennis Logo"
                                    class="w-full h-full object-cover">
                            </div>
                            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Gumbreg Tennis</h1>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Jl. Gumbreg No.12, Kec. Purwokerto Tim.,
                            Kabupaten Banyumas, Jawa Tengah 53111<br>Telp: +62 851-3375-4771</p>
                    </div>

                    <div class="text-left md:text-right">
                        <h2
                            class="text-4xl font-black text-gray-200 dark:text-gray-700 uppercase tracking-widest mb-2 print:text-gray-300">
                            INVOICE</h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Terbit:
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                        </p>

                        <div class="mt-4 inline-block">
                            <div class="px-4 py-1.5 rounded-full border-2 
                                    {{ $booking->status === 'pending_verification' ? 'border-blue-500 text-blue-600 bg-blue-50 print:border-blue-500 print:text-blue-600' :
        ($booking->status === 'confirmed' || $booking->status === 'completed' ? 'border-green-500 text-green-600 bg-green-50 print:border-green-500 print:text-green-600' :
            'border-gray-500 text-gray-600 bg-gray-50 print:border-gray-500 print:text-gray-600') }}"
                                style="-webkit-print-color-adjust: exact; print-color-adjust: exact;">
                                <span class="text-xs font-black uppercase tracking-widest">
                                    @if($booking->status === 'pending_verification')
                                        MENUNGGU VERIFIKASI
                                    @elseif($booking->status === 'confirmed' || $booking->status === 'completed')
                                        LUNAS
                                    @elseif($booking->status === 'expired')
                                        KADALUARSA
                                    @else
                                        {{ strtoupper($booking->status) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BILLING INFO -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div>
                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">
                            Ditagihkan Kepada:</p>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $booking->user->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->user->email ?? '-' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->user->phone ?? '-' }}</p>
                    </div>
                    <div class="md:text-right">
                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">
                            Informasi Pembayaran:</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium mb-1">
                            Metode: <span class="font-bold uppercase">{{ $booking->payment_method ?: 'N/A' }}</span>
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Transaksi:
                            {{ $booking->paid_at ? \Carbon\Carbon::parse($booking->paid_at)->translatedFormat('d F Y, H:i') : '-' }}
                        </p>
                    </div>
                </div>

                <!-- INVOICE ITEMS -->
                <div class="mb-10">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-900 dark:border-white print:border-black">
                                <th
                                    class="py-3 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest print:text-black">
                                    Deskripsi</th>
                                <th
                                    class="py-3 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest print:text-black text-center">
                                    Tanggal & Waktu</th>
                                <th
                                    class="py-3 text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest print:text-black text-right">
                                    Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 dark:border-gray-700 print:border-gray-300">
                                <td class="py-5">
                                    <p class="font-bold text-gray-900 dark:text-white print:text-black">Sewa Lapangan Tenis
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 print:text-gray-600">
                                        {{ $booking->court->name }}
                                    </p>
                                </td>
                                <td class="py-5 text-center">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white print:text-black">
                                        {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 print:text-gray-600">
                                        {{ $booking->start_time }} - {{ $booking->end_time }}
                                    </p>
                                </td>
        @php
            $totalPrice = $booking->total_price ?: ($booking->court->price * (\Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time)) ?: 1));
        @endphp
                                <td class="py-5 text-right font-bold text-gray-900 dark:text-white print:text-black">
                                    Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TOTALS -->
                <div class="flex justify-end mb-12">
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <div class="flex justify-between py-2 text-sm text-gray-600 dark:text-gray-400 print:text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between py-2 text-sm text-gray-600 dark:text-gray-400 print:text-gray-600">
                            <span>Pajak (0%)</span>
                            <span class="font-medium">Rp 0</span>
                        </div>
                        <div
                            class="flex justify-between py-4 border-t-2 border-gray-900 dark:border-white print:border-black mt-2">
                            <span class="text-lg font-black text-gray-900 dark:text-white print:text-black uppercase">Total
                                Bayar</span>
                            <span class="text-xl font-black text-yellow-600 dark:text-yellow-500 print:text-yellow-600">Rp
                                {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- FOOTER INFO -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-8 print:border-gray-300">
                    <p class="text-center font-bold text-gray-900 dark:text-white mb-2 print:text-black">Terima Kasih Atas
                        Kepercayaan Anda!</p>
                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 leading-relaxed print:text-gray-500">
                        Ini adalah bukti pembayaran yang sah dan diterbitkan secara otomatis oleh sistem.<br>
                        Jika Anda memiliki pertanyaan terkait tagihan ini, silakan hubungi kami di +62 851-3375-4771
                    </p>
                </div>

            </div>
        </div>

    </div>

    <style>
        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                background-color: white !important;
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Hide Navbar, Sidebar, Footer from layout if they exist */
            nav,
            header,
            footer,
            aside,
            .sidebar {
                display: none !important;
            }

            /* Make invoice fill the page properly */
            #invoice-document {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 2cm !important;
                box-shadow: none !important;
                border: none !important;
            }

            /* Ensure text colors are sharp */
            * {
                color: black;
            }

            .text-gray-500,
            .text-gray-400 {
                color: #4b5563 !important;
            }

            .text-yellow-600,
            .text-yellow-500 {
                color: #d97706 !important;
            }

            .bg-yellow-500 {
                background-color: #f59e0b !important;
            }
        }
    </style>
@endsection