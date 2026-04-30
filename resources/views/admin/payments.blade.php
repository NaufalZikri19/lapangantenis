@extends('layouts.admin')

@section('content')
    <div class="w-full space-y-6">

        <!-- HEADER SECTION -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl border border-yellow-100">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Pembayaran</h1>
                    <p class="text-sm text-gray-500">Kelola dan verifikasi pembayaran pelanggan</p>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Info Booking</th>
                            <th class="px-6 py-4 text-center">Metode Pembayaran</th>
                            <th class="px-6 py-4 text-center">Bukti</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($booking->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $booking->user->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-medium text-gray-800">{{ $booking->court->name ?? '-' }}</p>
                                    <div class="text-xs text-gray-500 mt-0.5 flex flex-col gap-0.5">
                                        <span class="flex items-center gap-1"><i data-lucide="calendar" class="w-3 h-3"></i>
                                            {{ $booking->date ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : '-' }}</span>
                                        <span class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3"></i>
                                            {{ $booking->start_time }} - {{ $booking->end_time }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium inline-flex items-center gap-1.5 justify-center
                                            {{ $booking->payment_method == 'qris' ? 'bg-blue-100 text-blue-600' : '' }}
                                            {{ $booking->payment_method == 'transfer' ? 'bg-indigo-100 text-indigo-600' : '' }}
                                            {{ !$booking->payment_method ? 'bg-gray-100 text-gray-500' : '' }}">
                                        @if($booking->payment_method == 'qris') <i data-lucide="qr-code"
                                        class="w-3.5 h-3.5"></i> @endif
                                        @if($booking->payment_method == 'transfer') <i data-lucide="landmark"
                                        class="w-3.5 h-3.5"></i> @endif
                                        {{ $booking->payment_method ? strtoupper($booking->payment_method) : '-' }}
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
                                            {{ $booking->payment_status == 'waiting' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                            {{ $booking->payment_status == 'confirmed' ? 'bg-green-100 text-green-600' : '' }}
                                            {{ $booking->payment_status == 'rejected' ? 'bg-red-100 text-red-600' : '' }}
                                            {{ !$booking->payment_status ? 'bg-gray-100 text-gray-500' : '' }}">
                                        {{ $booking->payment_status ? ucfirst($booking->payment_status) : 'Unpaid' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if ($booking->payment_status == 'waiting')
                                            <a href="{{ route('admin.payments.approve', $booking->id) }}"
                                                onclick="return confirm('Approve pembayaran ini?')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-green-100 text-green-600 hover:bg-green-200 transition duration-200">
                                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Setujui
                                            </a>

                                            <a href="{{ route('admin.payments.reject', $booking->id) }}"
                                                onclick="return confirm('Tolak pembayaran ini?')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition duration-200">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Tolak
                                            </a>
                                        @elseif($booking->payment_status == 'confirmed')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-green-600 bg-green-50 rounded-full border border-green-100">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i> Lunas
                                            </span>
                                        @elseif($booking->payment_status == 'rejected')
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded-full border border-red-100">
                                                <i data-lucide="x" class="w-3.5 h-3.5"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tidak ada aksi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-100">
                                            <i data-lucide="inbox" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-500 font-medium text-sm">Belum ada pembayaran</p>
                                        <p class="text-xs text-gray-400 mt-1">Data pembayaran pelanggan akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION (If applicable) -->
            @if(method_exists($bookings, 'links'))
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection