<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Province;
use App\Models\Regency;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address_ktp',
        'address',
        'district',
        'province_id',
        'regency_id',
        'phone',
        'nationality',
        'birth_date',
        'birth_place',
        'gender',
        'marital_status',
        'religion'
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /*
    | ACCESSORS
    */

    // Nama lengkap
    public function getFullNameAttribute()
    {
        return trim($this->name) ?: '-';
    }

    // Nomor HP
    public function getPhoneNumberAttribute()
    {
        return $this->phone ?: '-';
    }

    // Alamat lengkap
    public function getAddressFullAttribute()
    {
        return collect([
            $this->address,
            $this->district,
            $this->regency?->name,
            $this->province?->name
        ])->filter()->implode(', ');
    }
    // Umur (pakai Carbon otomatis dari cast)
    public function getAgeAttribute()
    {
        return $this->birth_date?->age;
    }

    public function getBiodataCompletionAttribute()
    {
        $fields = [
            $this->name,
            $this->phone,
            $this->gender,
            $this->birth_date,
            $this->birth_place,
            $this->address_ktp,
            $this->address,
            $this->district,
            $this->regency_id,
            $this->province_id,
            $this->nationality,
            $this->marital_status,
            $this->religion,
        ];

        $filled = collect($fields)->filter()->count();
        $total = count($fields);

        return intval(($filled / $total) * 100);
    }

    /*
    HELPER METHOD
    */

    // Cek apakah biodata belum lengkap
    public function isBiodataIncomplete(): bool
    {
        return collect([
            $this->name,
            $this->phone,
            $this->gender,
            $this->birth_date,
            $this->birth_place,
            $this->address_ktp,
            $this->address,
            $this->district,
            $this->regency_id,
            $this->province_id,
            $this->nationality,
            $this->marital_status,
            $this->religion,
        ])->contains(fn($value) => empty($value));
    }

    //ambil semua biodata (buat export / debug)
    public function getFullBiodata(): array
    {
        return [
            'name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone_number,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'birth_place' => $this->birth_place,
            'age' => $this->age,
            'address_ktp' => $this->address_ktp,
            'address_full' => $this->address_full,
            'nationality' => $this->nationality,
            'marital_status' => $this->marital_status,
            'religion' => $this->religion,
            'regency_id' => $this->regency_id,
            'province_id' => $this->province_id,
        ];
    }

    // Relasi ke booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    public function getProvinceNameAttribute()
    {
        return $this->province?->name;
    }

    public function getRegencyNameAttribute()
    {
        return $this->regency?->name;
    }
}