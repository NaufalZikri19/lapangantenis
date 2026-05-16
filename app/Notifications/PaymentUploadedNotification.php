<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentUploadedNotification extends Notification
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
            'type' => 'info',
            'title' => 'Pembayaran Baru',
            'message' => 'Ada pembayaran baru dari ' . $this->booking->user->name . ' menunggu verifikasi.',
            'action_url' => route('admin.payments', ['highlight' => $this->booking->id]),
        ];
    }
}
