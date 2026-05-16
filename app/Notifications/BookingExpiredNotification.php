<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingExpiredNotification extends Notification
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
        $isAdmin = $notifiable->role === 'admin';
        
        return [
            'type' => 'error',
            'title' => 'Booking Expired',
            'message' => $isAdmin 
                ? 'Booking #' . $this->booking->id . ' otomatis dibatalkan karena melewati batas waktu bayar.'
                : 'Waktu pembayaran (15 menit) untuk jadwal ' . $this->booking->date . ' habis. Booking dibatalkan otomatis.',
            'action_url' => $isAdmin ? route('admin.dashboard') : route('customer.dashboard'),
        ];
    }
}
