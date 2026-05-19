<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'phone',
        'address',
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
        return $this->address ?: '-';
    }

    public function getBiodataCompletionAttribute()
    {
        $fields = [
            $this->name,
            $this->phone,
            $this->address,
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
            $this->address,
        ])->contains(fn($value) => empty($value));
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    //ambil semua biodata (buat export / debug)
    public function getFullBiodata(): array
    {
        return [
            'name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone_number,
            'address' => $this->address_full,
        ];
    }

    // Relasi ke booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}