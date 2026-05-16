<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
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
            'type' => 'action',
            'title' => 'Booking Berhasil!',
            'message' => 'Booking untuk tanggal ' . $this->booking->date . ' jam ' . $this->booking->start_time . ' berhasil dibuat. Segera lakukan pembayaran dalam 15 menit.',
            'action_url' => route('booking.payment', $this->booking->id),
        ];
    }
}
