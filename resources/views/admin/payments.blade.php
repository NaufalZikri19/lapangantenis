@extends('layouts.admin')

@section('content')
    <div class="w-full space-y-6">

        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl border border-yellow-100">
                    <i data-lucide="wallet" class="w-7 h-7 text-gray-900"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-100">Pembayaran</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan verifikasi pembayaran pelanggan</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <!-- SEARCH -->
                <form action="{{ route('admin.payments') }}" method="GET" class="relative w-full sm:w-64 group"
                    x-data="{ search: '{{ request('search') }}' }">
                    <input type="text" name="search" x-model="search" @input.debounce.500ms="$el.form.submit()"
                        placeholder="Cari Pembayaran..."
                        class="w-full pl-9 pr-10 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all shadow-sm"
                        value="{{ request('search') }}">
                    <i data-lucide="search"
                        class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>

                    <template x-if="search">
                        <button type="button" @click="search = ''; $nextTick(() => $el.form.submit())"
                            class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-red-500 transition-colors">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                        </button>
                    </template>
                </form>

                <div class="hidden sm:flex items-center gap-2">
                    <span
                        class="px-3 py-1.5 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-sm font-medium rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                        Total: <span class="text-gray-900 dark:text-gray-100 font-bold">{{ $bookings->total() }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-sm text-left">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Info Booking</th>
                            <th class="px-6 py-4 text-center">Metode Pembayaran</th>
                            <th class="px-6 py-4 text-center">Total Bayar</th>
                            <th class="px-6 py-4 text-center">Bukti</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($booking->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $booking->user->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-medium text-gray-800 dark:text-gray-100">{{ $booking->court->name ?? '-' }}
                                    </p>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex flex-col gap-0.5">
                                        <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i>
                                            {{ $booking->date ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : '-' }}</span>
                                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i>
                                            {{ $booking->start_time }} - {{ $booking->end_time }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium inline-flex items-center gap-1.5 justify-center
                                                                                    {{ $booking->payment_method == 'qris' ? 'bg-blue-100 text-blue-600' : '' }}
                                                                                    {{ $booking->payment_method == 'transfer' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                                                                    {{ !$booking->payment_method ? 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300' : '' }}">
                                        @if($booking->payment_method == 'qris') <i data-lucide="qr-code"
                                        class="w-3.5 h-3.5"></i> @endif
                                        @if($booking->payment_method == 'transfer') <i data-lucide="landmark"
                                        class="w-3.5 h-3.5"></i> @endif
                                        {{ $booking->payment_method ? strtoupper($booking->payment_method) : '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="font-bold text-gray-900 dark:text-gray-100">
                                        Rp
                                        {{ number_format($booking->total_price ?: ($booking->court->price * (\Carbon\Carbon::parse($booking->start_time)->diffInHours(\Carbon\Carbon::parse($booking->end_time)) ?: 1)), 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($booking->payment_proof)
                                        <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank"
                                            class="inline-block group relative">
                                            <div
                                                class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-200">
                                                <i data-lucide="external-link" class="w-4 h-4 text-white"></i>
                                            </div>
                                            <img src="{{ asset('storage/' . $booking->payment_proof) }}"
                                                class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No Proof</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                                    {{ $booking->status == 'pending_payment' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                                    {{ $booking->status == 'pending_verification' ? 'bg-blue-100 text-blue-600' : '' }}
                                                    {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-600' : '' }}
                                                    {{ $booking->status == 'rejected' ? 'bg-red-100 text-red-600' : '' }}
                                                    {{ $booking->status == 'expired' ? 'bg-gray-200 text-gray-500' : '' }}">
                                        {{ $booking->status_label ?? ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($booking->status == 'pending_verification')
                                            @if (is_null($booking->handled_by))
                                                <a href="{{ route('admin.payments.claim', $booking->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition duration-200">
                                                    <i data-lucide="lock" class="w-3.5 h-3.5"></i> Proses Verifikasi
                                                </a>
                                            @elseif ($booking->handled_by !== auth()->id())
                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-500" title="Diproses oleh {{ $booking->handler->name ?? 'Admin' }}">
                                                    <i data-lucide="lock" class="w-3.5 h-3.5"></i> Diproses {{ explode(' ', $booking->handler->name ?? 'Admin')[0] }}
                                                </span>
                                            @else
                                                <a href="{{ route('admin.payments.approve', $booking->id) }}"
                                                    onclick="return confirm('Approve pembayaran ini?')"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition duration-200">
                                                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Setujui
                                                </a>

                                                <button type="button" onclick="rejectPayment({{ $booking->id }})"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition duration-200">
                                                    <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Tolak
                                                </button>
                                                <form id="reject-form-{{ $booking->id }}" action="{{ route('admin.payments.reject', $booking->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    <input type="hidden" name="rejection_reason" id="rejection-reason-{{ $booking->id }}">
                                                </form>
                                            @endif
                                        @elseif($booking->status == 'confirmed')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-green-600 bg-green-50 rounded-full border border-green-100">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Lunas
                                            </span>
                                        @elseif($booking->status == 'rejected')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-full border border-red-100">
                                                <i data-lucide="x" class="w-3.5 h-3.5"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 dark:text-gray-500 italic">Tidak ada aksi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4 border border-gray-100 dark:border-gray-600 shadow-sm">
                                                        <i data-lucide="{{ request('search') ? 'search-x' : 'inbox' }}"
                                                            class="w-8 h-8 text-gray-400 dark:text-gray-500"></i>
                                                    </div>
                                                    <h3 class="text-gray-800 dark:text-gray-100 font-bold text-lg">
                                                        {{ request('search') ? 'Data tidak ditemukan' : 'Belum ada pembayaran' }}
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 mt-1 max-w-xs mx-auto text-sm">
                                                        {{ request('search')
                            ? 'Tidak ada pembayaran yang cocok dengan kata kunci "' . request('search') . '".'
                            : 'Data pembayaran pelanggan akan muncul secara otomatis di sini.' }}
                                                    </p>
                                                    @if(request('search'))
                                                        <a href="{{ route('admin.payments') }}"
                                                            class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold text-sm rounded-xl transition-all shadow-sm">
                                                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Reset Pencarian
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION (If applicable) -->
            @if(method_exists($bookings, 'links'))
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function rejectPayment(id) {
            Alert.fire({
                title: 'Tolak Pembayaran',
                text: 'Masukkan alasan penolakan (misal: Bukti buram, Dana belum masuk)',
                input: 'text',
                icon: 'warning',
                confirmButtonColor: '#EF4444', // Red for reject
                confirmButtonText: 'Ya, Tolak',
                inputValidator: (value) => {
                    if (!value || value.trim() === '') {
                        return 'Alasan penolakan wajib diisi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    document.getElementById('rejection-reason-' + id).value = result.value;
                    document.getElementById('reject-form-' + id).submit();
                }
            });
        }
    </script>
    @endpush
@endsection