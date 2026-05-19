<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'booking_type',
        'court_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'expired_at',
        'payment_method',
        'payment_proof',
        'payment_status',
        'paid_at',
        'total_price',
        'handled_by',
        'verified_by',
        'verified_at',
        'rejection_reason'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    protected $appends = ['status_label', 'status_class'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function syncStatus()
    {
        $now = now();

        // EXPIRED
        $expiredBookings = self::where('status', 'pending_payment')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', $now)
            ->get();

        /** @var \App\Models\Booking $booking */
        foreach ($expiredBookings as $booking) {
            $booking->update(['status' => 'expired']);
            if ($booking->user) {
                $booking->user->notify(new \App\Notifications\BookingExpiredNotification($booking));
            }
        }

        // COMPLETED
        self::where('status', 'confirmed')
            ->whereRaw("TIMESTAMP(date, end_time) < ?", [$now])
            ->update(['status' => 'completed']);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'pending_verification' => 'Menunggu Verifikasi',
            'confirmed' => 'Dikonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status)
        };
    }

    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            'pending_payment' => 'bg-yellow-100 dark:bg-yellow-500/10 text-yellow-600 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-500/20',
            'pending_verification' => 'bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20',
            'confirmed' => 'bg-green-100 dark:bg-green-500/10 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-500/20',
            'completed' => 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20',
            'cancelled' => 'bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/20',
            'expired' => 'bg-gray-200 dark:bg-gray-700/50 text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-600/50',
            'rejected' => 'bg-red-100 dark:bg-red-500/10 text-red-800 dark:text-red-450 border border-red-200 dark:border-red-500/20',
            default => 'bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 border border-gray-200 dark:border-gray-700'
        };
    }

    public function getCustomerNameAttribute()
    {
        if ($this->booking_type === 'block') {
            return 'Sistem (Jadwal Diblokir)';
        }
        
        return $this->user ? $this->user->name : ($this->guest_name ?: 'Tamu Offline');
    }
}
