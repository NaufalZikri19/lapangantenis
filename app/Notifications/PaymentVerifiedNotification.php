<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentVerifiedNotification extends Notification
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
            'type' => 'success',
            'title' => 'Pembayaran Diverifikasi',
            'message' => 'Hore! Pembayaran untuk jadwal ' . $this->booking->date . ' diverifikasi. Jadwal resmi di-booking.',
            'action_url' => route('customer.dashboard'),
        ];
    }
}
