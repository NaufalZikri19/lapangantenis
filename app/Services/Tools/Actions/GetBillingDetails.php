<?php

namespace App\Services\Tools\Actions;

use App\Services\Tools\Contracts\AIToolInterface;
use App\Models\Booking;

class GetBillingDetails implements AIToolInterface
{
    public function getName(): string
    {
        return 'dapatkan_detail_tagihan';
    }

    public function getDescription(): string
    {
        return 'Mendapatkan daftar booking milik user saat ini yang berstatus pending beserta nominal tagihan dan ID booking-nya.';
    }

    public function getParametersSchema(): array
    {
        return [
            'type' => 'OBJECT',
            'properties' => (object)[] // no parameters needed
        ];
    }

    public function execute(array $args, $user): array
    {
        $bookings = Booking::with('court')
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        if ($bookings->isEmpty()) {
            return ['status' => 'User tidak memiliki tagihan pending saat ini.'];
        }

        $tagihan = [];
        foreach ($bookings as $b) {
            $tagihan[] = [
                'booking_id' => $b->id,
                'lapangan' => $b->court ? $b->court->name : 'Unknown',
                'tanggal' => $b->date,
                'jam' => $b->start_time . ' - ' . $b->end_time,
                'total_harga' => 'Rp ' . number_format($b->total_price, 0, ',', '.'),
                'batas_pembayaran' => $b->expired_at ? $b->expired_at->format('Y-m-d H:i') : 'Tidak diketahui'
            ];
        }

        return ['daftar_tagihan' => $tagihan];
    }
}
