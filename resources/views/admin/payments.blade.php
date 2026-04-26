@extends('layouts.admin')

@section('content')
    <!-- HEADER -->
    <div class="bg-white border rounded-2xl shadow-sm p-5 mb-6">

        <div class="flex items-center gap-3">

            <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                <i data-lucide="credit-card" class="w-5 h-5"></i>
            </div>

            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Pembayaran
                </h1>
                <p class="text-sm text-gray-500">
                    Kelola pembayaran pelanggan
                </p>
            </div>

        </div>

    </div>


    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="p-4 text-center">Pelanggan</th>
                        <th class="p-4 text-center">Lapangan</th>
                        <th class="p-4 text-center">Tanggal</th>
                        <th class="p-4 text-center">Jam</th>
                        <th class="p-4 text-center">Metode Pembayaran</th>
                        <th class="p-4 text-center">Bukti</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">

                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- USER -->
                            <td class="p-4 font-medium text-gray-700 text-center">
                                {{ $booking->user->name ?? '-' }}
                            </td>

                            <!-- COURT -->
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                                    {{ $booking->court->name ?? '-' }}
                                </span>
                            </td>

                            <!-- DATE -->
                            <td class="p-4 text-gray-600 text-center">
                                {{ $booking->date ? \Carbon\Carbon::parse($booking->date)->format('d M Y') : '-' }}
                            </td>

                            <!-- TIME -->
                            <td class="p-4 text-gray-600 text-center">
                                {{ $booking->start_time }} - {{ $booking->end_time }}
                            </td>

                            <!-- METHOD -->
                            <td class="p-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $booking->payment_method == 'qris' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $booking->payment_method == 'transfer' ? 'bg-purple-100 text-purple-600' : '' }}
                            {{ !$booking->payment_method ? 'bg-gray-100 text-gray-400' : '' }}">

                                    {{ $booking->payment_method ? strtoupper($booking->payment_method) : '-' }}
                                </span>
                            </td>

                            <!-- PROOF -->
                            <td class="p-4 text-center">
                                @if ($booking->payment_proof)
                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $booking->payment_proof) }}"
                                            class="w-14 h-14 object-cover rounded-lg mx-auto hover:scale-105 transition">
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">No Proof</span>
                                @endif
                            </td>

                            <!-- STATUS -->
                            <td class="p-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $booking->payment_status == 'waiting' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $booking->payment_status == 'confirmed' ? 'bg-green-100 text-green-600' : '' }}
                            {{ $booking->payment_status == 'rejected' ? 'bg-red-100 text-red-600' : '' }}
                            {{ !$booking->payment_status ? 'bg-gray-100 text-gray-400' : '' }}">

                                    {{ $booking->payment_status ? ucfirst($booking->payment_status) : 'Unpaid' }}
                                </span>
                            </td>

                            <!-- ACTION -->
                            <td class="p-4 text-center">

                                @if ($booking->payment_status == 'waiting')
                                    <a href="{{ route('admin.payments.approve', $booking->id) }}"
                                        onclick="return confirm('Approve pembayaran ini?')"
                                        class="px-3 py-1 text-xs rounded-md bg-green-500 text-white hover:bg-green-400">
                                        Setujui
                                    </a>

                                    <a href="{{ route('admin.payments.reject', $booking->id) }}"
                                        onclick="return confirm('Tolak pembayaran ini?')"
                                        class="px-3 py-1 text-xs rounded-md bg-red-500 text-white hover:bg-red-400">
                                        Tolak
                                    </a>
                                @elseif($booking->payment_status == 'confirmed')
                                    <span class="text-xs text-green-500 font-medium">
                                        Lunas
                                    </span>
                                @elseif($booking->payment_status == 'rejected')
                                    <span class="text-xs text-red-500 font-medium">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">
                                        Tidak Ada Aksi
                                    </span>
                                @endif

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">
                                Belum ada pembayaran
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
@endsection
