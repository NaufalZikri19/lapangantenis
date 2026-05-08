<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
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
        'total_price'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
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

    public static function syncStatus()
    {
        $now = now();

        // EXPIRED
        self::where('status', 'pending_payment')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<', $now)
            ->update(['status' => 'expired']);

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
            'pending_payment' => 'bg-yellow-100 text-yellow-600',
            'pending_verification' => 'bg-blue-100 text-blue-600',
            'confirmed' => 'bg-green-100 text-green-600',
            'completed' => 'bg-emerald-100 text-emerald-600',
            'cancelled' => 'bg-red-100 text-red-600',
            'expired' => 'bg-gray-200 text-gray-500',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-400'
        };
    }

}
