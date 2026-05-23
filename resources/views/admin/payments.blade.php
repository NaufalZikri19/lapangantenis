@extends('layouts.admin')

@section('content')
    <div x-data="{ showModal: false, imageUrl: '' }" class="w-full space-y-6 relative">

        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-yellow-50 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 rounded-xl border border-yellow-100 dark:border-yellow-500/20">
                    <i data-lucide="wallet" class="w-7 h-7 text-yellow-600 dark:text-yellow-400"></i>
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

                <!-- FILTER STATUS -->
                <form action="{{ route('admin.payments') }}" method="GET" class="w-full sm:w-48"
                    x-data="{ status: '{{ request('status') }}' }">
                    <!-- Preserve search parameter if it exists -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="status" x-model="status" @change="$el.form.submit()"
                        class="w-full py-2 pl-3 pr-8 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 shadow-sm appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="pending_verification">Menunggu Verifikasi</option>
                        <option value="confirmed">Lunas (Confirmed)</option>
                        <option value="rejected">Ditolak</option>
                    </select>
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
                                        class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 justify-center border border-transparent
                                                                                    {{ $booking->payment_method == 'qris' ? 'bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-500/20' : '' }}
                                                                                    {{ $booking->payment_method == 'transfer' ? 'bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-200 dark:border-indigo-500/20' : '' }}
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
                                        <button type="button" @click="imageUrl = '{{ asset('storage/' . $booking->payment_proof) }}'; showModal = true"
                                            class="inline-block group relative cursor-pointer outline-none focus:ring-2 focus:ring-yellow-500 rounded-lg">
                                            <div
                                                class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-200">
                                                <i data-lucide="zoom-in" class="w-4 h-4 text-white"></i>
                                            </div>
                                            <img src="{{ asset('storage/' . $booking->payment_proof) }}"
                                                class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">No Proof</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $booking->status_class }}">
                                        {{ $booking->status_label ?? ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($booking->status == 'pending_verification')
                                            @if (is_null($booking->handled_by))
                                                <a href="{{ route('admin.payments.claim', $booking->id) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-transparent dark:border-blue-500/20 hover:bg-blue-200 dark:hover:bg-blue-500/20 transition duration-200">
                                                    <i data-lucide="lock" class="w-3.5 h-3.5"></i> Proses Verifikasi
                                                </a>
                                            @elseif ($booking->handled_by !== auth()->id())
                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-transparent dark:border-gray-700" title="Diproses oleh {{ $booking->handler->name ?? 'Admin' }}">
                                                    <i data-lucide="lock" class="w-3.5 h-3.5"></i> Diproses {{ explode(' ', $booking->handler->name ?? 'Admin')[0] }}
                                                </span>
                                            @else
                                                <button type="button" onclick="approvePayment('{{ route('admin.payments.approve', $booking->id) }}')"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 border border-transparent dark:border-green-500/20 hover:bg-green-200 dark:hover:bg-green-500/20 transition duration-200">
                                                    <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Setujui
                                                </button>
 
                                                <button type="button" onclick="rejectPayment({{ $booking->id }})"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-transparent dark:border-red-500/20 hover:bg-red-200 dark:hover:bg-red-500/20 transition duration-200">
                                                    <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Tolak
                                                </button>
                                                <form id="reject-form-{{ $booking->id }}" action="{{ route('admin.payments.reject', $booking->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    <input type="hidden" name="rejection_reason" id="rejection-reason-{{ $booking->id }}">
                                                </form>
                                            @endif
                                        @elseif($booking->status == 'confirmed')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-500/10 rounded-full border border-green-100 dark:border-green-500/20">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Lunas
                                            </span>
                                        @elseif($booking->status == 'rejected')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 rounded-full border border-red-100 dark:border-red-500/20">
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

        <!-- IMAGE MODAL -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
            @keydown.escape.window="showModal = false">
            
            <!-- BACKDROP -->
            <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/80 backdrop-blur-sm"
                @click="showModal = false"></div>
            
            <!-- MODAL CONTENT -->
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-transparent w-full max-w-4xl mx-auto flex flex-col items-center justify-center z-10 pointer-events-none">
                
                <div class="relative pointer-events-auto">
                    <!-- CLOSE BUTTON -->
                    <button @click="showModal = false" type="button" class="absolute -top-10 right-0 sm:-right-10 p-2 text-white/70 hover:text-white bg-black/20 hover:bg-black/50 rounded-full transition-colors backdrop-blur-md">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                    
                    <!-- IMAGE -->
                    <img :src="imageUrl" alt="Bukti Pembayaran" class="max-h-[85vh] max-w-full object-contain rounded-lg shadow-2xl ring-1 ring-white/10">
                </div>
            </div>
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

        function approvePayment(url) {
            Alert.fire({
                title: 'Setujui Pembayaran?',
                text: 'Pastikan dana sudah masuk ke rekening Anda.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981', // Green for approve
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
    @endpush
@endsection