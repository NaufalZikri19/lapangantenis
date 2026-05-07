<?php

namespace App\Services\Tools\Actions;

use App\Services\Tools\Contracts\AIToolInterface;
use App\Models\Booking;
use App\Models\Court;
use Carbon\Carbon;

class CreateBooking implements AIToolInterface
{
    public function getName(): string
    {
        return 'create_booking';
    }

    public function getDescription(): string
    {
        return 'Membuat pesanan lapangan tenis (booking) baru. Selalu panggil cek_ketersediaan_lapangan terlebih dahulu untuk mendapatkan court_id dan memastikan jadwal kosong. Jika parameter tidak lengkap, tanyakan ke user terlebih dahulu.';
    }

    public function getParametersSchema(): array
    {
        return [
            'type' => 'OBJECT',
            'properties' => [
                'court_id' => [
                    'type' => 'INTEGER',
                    'description' => 'ID lapangan yang dipilih (didapat dari hasil cek_ketersediaan_lapangan)'
                ],
                'date' => [
                    'type' => 'STRING',
                    'description' => 'Tanggal booking dalam format YYYY-MM-DD'
                ],
                'start_time' => [
                    'type' => 'STRING',
                    'description' => 'Jam mulai dalam format HH:MM (contoh: 08:00)'
                ],
                'end_time' => [
                    'type' => 'STRING',
                    'description' => 'Jam selesai dalam format HH:MM (contoh: 10:00)'
                ]
            ],
            'required' => ['court_id', 'date', 'start_time', 'end_time']
        ];
    }

    public function execute(array $args, $user): array
    {
        // 1. Parameter Validation
        if (empty($args['court_id']) || empty($args['date']) || empty($args['start_time']) || empty($args['end_time'])) {
            return ['status' => 'FAILED', 'reason' => 'Parameter tidak lengkap. Pastikan ada court_id, date, start_time, dan end_time.'];
        }

        // Convert start_time and end_time to hourly slots
        $slots = [];
        $current = Carbon::parse($args['start_time']);
        $end = Carbon::parse($args['end_time']);

        while ($current < $end) {
            $next = $current->copy()->addHour();
            $slots[] = [
                'start' => $current->format('H:i'),
                'end' => $next->format('H:i')
            ];
            $current = $next;
        }

        try {
            $bookingService = new \App\Services\BookingService();
            $booking = $bookingService->processBooking(
                $user->id,
                $args['court_id'],
                $args['date'],
                $slots
            );

            return [
                'status' => 'SUCCESS',
                'message' => 'Booking berhasil dibuat dengan status pending.',
                'booking_id' => $booking->id,
                'total_tagihan' => 'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                'instruksi_lanjutan' => 'Beri tahu user bahwa pesanan berhasil dan arahkan mereka untuk melakukan pembayaran (bisa cek riwayat tagihan).'
            ];
        } catch (\Exception $e) {
            return ['status' => 'FAILED', 'reason' => $e->getMessage()];
        }
    }
}
