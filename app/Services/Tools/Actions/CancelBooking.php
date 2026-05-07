<?php

namespace App\Services\Tools\Actions;

use App\Services\Tools\Contracts\AIToolInterface;
use App\Models\Booking;

class CancelBooking implements AIToolInterface
{
    public function getName(): string
    {
        return 'batalkan_booking_pending';
    }

    public function getDescription(): string
    {
        return 'Membatalkan pesanan/booking milik user yang masih berstatus pending. Harap konfirmasi user sebelum memanggil tool ini.';
    }

    public function getParametersSchema(): array
    {
        return [
            'type' => 'OBJECT',
            'properties' => [
                'booking_id' => [
                    'type' => 'INTEGER',
                    'description' => 'ID dari booking yang ingin dibatalkan'
                ]
            ],
            'required' => ['booking_id']
        ];
    }

    public function execute(array $args, $user): array
    {
        if (!isset($args['booking_id']) || !is_numeric($args['booking_id'])) {
            return ['error' => 'Parameter booking_id tidak valid atau hilang.'];
        }

        $bookingId = $args['booking_id'];

        $booking = Booking::where('id', $bookingId)
            ->where('user_id', $user->id)
            ->first();

        if (!$booking) {
            return ['status' => 'FAILED', 'reason' => 'Booking ID tidak ditemukan atau bukan milik Anda.'];
        }

        if ($booking->status !== 'pending') {
            return ['status' => 'FAILED', 'reason' => "Booking berstatus {$booking->status}. Hanya booking pending yang bisa dibatalkan."];
        }

        $booking->update(['status' => 'cancelled']);

        return ['status' => 'SUCCESS', 'message' => "Booking dengan ID {$bookingId} telah berhasil dibatalkan."];
    }
}
