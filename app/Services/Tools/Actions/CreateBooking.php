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

        $court = Court::find($args['court_id']);
        if (!$court) {
            return ['status' => 'FAILED', 'reason' => 'Court ID tidak valid.'];
        }

        // 2. Conflict Validation
        $conflict = Booking::where('court_id', $args['court_id'])
            ->where('date', $args['date'])
            ->where(function ($query) use ($args) {
                // Check if new booking time overlaps with existing booking
                // new_start < exist_end AND new_end > exist_start
                $query->where('start_time', '<', $args['end_time'])
                    ->where('end_time', '>', $args['start_time']);
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return ['status' => 'FAILED', 'reason' => 'Jadwal bertabrakan dengan pesanan lain. Mohon sarankan jam lain.'];
        }

        // 3. Price Calculation
        $start = strtotime($args['date'] . ' ' . $args['start_time']);
        $end = strtotime($args['date'] . ' ' . $args['end_time']);
        $durationHours = ($end - $start) / 3600;

        if ($durationHours <= 0) {
            return ['status' => 'FAILED', 'reason' => 'Waktu selesai harus lebih besar dari waktu mulai.'];
        }

        $pricePerHour = $court->price ?? 50000; // fallback
        $basePrice = $durationHours * $pricePerHour;
        $uniqueCode = rand(100, 999);
        $totalPrice = $basePrice + $uniqueCode;

        // 4. Create Booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'court_id' => $court->id,
            'date' => $args['date'],
            'start_time' => $args['start_time'],
            'end_time' => $args['end_time'],
            'status' => 'pending',
            'total_price' => $totalPrice,
            'expired_at' => Carbon::now()->addMinutes(10), // 10 minutes payment window
            'payment_method' => null,
            'payment_status' => 'unpaid',
        ]);

        return [
            'status' => 'SUCCESS',
            'message' => 'Booking berhasil dibuat dengan status pending.',
            'booking_id' => $booking->id,
            'total_tagihan' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
            'instruksi_lanjutan' => 'Beri tahu user bahwa pesanan berhasil dan arahkan mereka untuk melakukan pembayaran (bisa cek riwayat tagihan).'
        ];
    }
}
