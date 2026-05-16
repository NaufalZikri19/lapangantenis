<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentRejectedNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'warning',
            'title' => 'Pembayaran Ditolak',
            'message' => 'Maaf, bukti pembayaran untuk jadwal ' . $this->booking->date . ' tidak valid. Silakan upload ulang.',
            'action_url' => route('booking.payment', $this->booking->id),
        ];
    }
}
