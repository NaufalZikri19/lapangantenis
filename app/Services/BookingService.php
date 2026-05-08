<?php

namespace App\Services;

use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    /**
     * @throws Exception
     */
    public function processBooking($user_id, $court_id, $booking_date, array $slots): Booking
    {
        if (empty($slots)) {
            throw new Exception('Pilih slot terlebih dahulu');
        }

        if (!$this->validateSlots($slots)) {
            throw new Exception('Format slot tidak valid');
        }

        usort($slots, fn($a, $b) => strcmp($a['start'], $b['start']));

        if (!$this->validateSequentialSlots($slots)) {
            throw new Exception('Slot harus berurutan');
        }

        if (!$this->validateOperationalHours($slots)) {
            throw new Exception('Di luar jam operasional atau bukan jam bulat');
        }

        DB::beginTransaction();

        try {
            foreach ($slots as $slot) {
                if ($this->hasConflict($court_id, $booking_date, $slot)) {
                    DB::rollBack();
                    throw new Exception('Slot sudah dibooking orang lain!');
                }
            }

            $court = Court::findOrFail($court_id);
            $basePrice = count($slots) * $court->price;
            $uniqueCode = rand(100, 999);
            $totalPrice = $basePrice + $uniqueCode;

            $booking = Booking::create([
                'user_id' => $user_id,
                'court_id' => $court_id,
                'date' => $booking_date,
                'start_time' => $slots[0]['start'],
                'end_time' => $slots[count($slots) - 1]['end'],
                'status' => 'pending_payment',
                'total_price' => $totalPrice,
                'expired_at' => now()->addMinutes(15)
            ]);

            DB::commit();
            return $booking;

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            throw $e;
        }
    }

    public function validateSlots(array $slots): bool
    {
        foreach ($slots as $slot) {
            if (!isset($slot['start']) || !isset($slot['end'])) {
                return false;
            }
        }
        return true;
    }

    public function validateSequentialSlots(array $slots): bool
    {
        for ($i = 0; $i < count($slots) - 1; $i++) {
            if ($slots[$i]['end'] !== $slots[$i + 1]['start']) {
                return false;
            }
        }
        return true;
    }

    public function validateOperationalHours(array $slots): bool
    {
        $open = 8;
        $close = 22;

        foreach ($slots as $slot) {
            $start = strtotime($slot['start']);
            $end = strtotime($slot['end']);

            if ((int) date('H', $start) < $open || (int) date('H', $end) > $close) {
                return false;
            }

            if (date('i', $start) != '00' || date('i', $end) != '00') {
                return false;
            }
        }

        return true;
    }

    public function hasConflict($court_id, $booking_date, $slot): bool
    {
        return Booking::where('court_id', $court_id)
            ->where('date', $booking_date)
            ->whereIn('status', ['pending_payment', 'pending_verification', 'confirmed'])
            ->where(function ($query) use ($slot) {
                $query->where('start_time', '<', $slot['end'])
                    ->where('end_time', '>', $slot['start']);
            })
            ->lockForUpdate()
            ->exists();
    }
}
