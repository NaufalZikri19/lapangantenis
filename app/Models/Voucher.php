<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id_origin',
        'code',
        'amount',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function originalBooking()
    {
        return $this->belongsTo(Booking::class, 'booking_id_origin');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'voucher_id');
    }
}
