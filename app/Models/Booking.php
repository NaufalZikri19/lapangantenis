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
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public static function autoComplete()
    {
        return self::where('status', 'confirmed')
            ->whereRaw("TIMESTAMP(date, end_time) < ?", [now()])
            ->update(['status' => 'completed']);
    }
}
