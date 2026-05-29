@extends('layouts.customer')

@section('title', 'Voucher Saya')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i data-lucide="ticket" class="w-6 h-6 text-yellow-500"></i>
                Voucher Saya
            </h1>
            <a href="{{ route('booking.create') }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors duration-200">
                Pesan Lapangan
            </a>
        </div>

        @if (session('success'))
            <div
                class="bg-green-50 border border-green-200 text-green-600 p-4 rounded-xl mb-6 shadow-sm flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-5 rounded-2xl mb-6 flex gap-4 items-start">
            <div class="p-2 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-lg shrink-0">
                <i data-lucide="info" class="w-5 h-5"></i>
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 dark:text-blue-300 mb-1">Informasi Penggunaan Voucher</h3>
                <p class="text-sm text-blue-700 dark:text-blue-400 leading-relaxed">
                    Voucher didapatkan secara otomatis saat Anda membatalkan pesanan (maksimal H-1). 
                    Salin <strong>Kode Voucher</strong> yang berstatus <span class="text-green-600 dark:text-green-400 font-semibold">Aktif</span> dan masukkan pada halaman pemesanan lapangan. 
                    Nilai voucher akan memotong total tagihan secara otomatis. Jika nilai voucher menutupi seluruh tagihan, pesanan akan langsung berstatus lunas.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vouchers as $voucher)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border {{ $voucher->status == 'active' ? 'border-yellow-200 dark:border-yellow-900/50 shadow-md' : 'border-gray-200 dark:border-gray-700 shadow-sm opacity-75' }} relative overflow-hidden group">

                    <!-- Decoration -->
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl group-hover:bg-yellow-500/20 transition-all">
                    </div>

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kode
                                Voucher</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100 mt-1 flex items-center gap-2">
                                <span id="code-{{ $voucher->id }}">{{ $voucher->code }}</span>
                                @if($voucher->status == 'active')
                                    <button onclick="copyCode('{{ $voucher->code }}')"
                                        class="text-gray-400 hover:text-yellow-500 transition-colors" title="Salin Kode">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        @if($voucher->status == 'active')
                            <span
                                class="px-2.5 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-full">Aktif</span>
                        @elseif($voucher->status == 'used')
                            <span
                                class="px-2.5 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-bold rounded-full">Terpakai</span>
                        @else
                            <span
                                class="px-2.5 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-bold rounded-full">Expired</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nilai
                            Voucher</span>
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-500">
                            Rp {{ number_format($voucher->amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 dark:border-gray-700 pt-4 mt-2">
                        <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                            <span>Berlaku hingga:</span>
                            <span
                                class="font-semibold">{{ \Carbon\Carbon::parse($voucher->expired_at)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full flex flex-col items-center justify-center p-12 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="ticket" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Belum ada Voucher</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-center text-sm max-w-sm">Anda belum memiliki voucher aktif.
                        Voucher didapatkan ketika Anda membatalkan pesanan (H-1).</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function copyCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Kode Voucher ' + code + ' disalin.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    customClass: {
                        popup: 'rounded-xl dark:bg-slate-800 dark:text-white'
                    }
                });
            });
        }
    </script>
@endsection