<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
        protected $fillable = [
            'name',
            'type',
            'price',
            'status',
            'image',
        ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
