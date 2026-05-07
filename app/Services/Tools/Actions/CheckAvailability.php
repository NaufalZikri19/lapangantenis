<?php

namespace App\Services\Tools\Actions;

use App\Services\Tools\Contracts\AIToolInterface;
use App\Models\Booking;
use App\Models\Court;

class CheckAvailability implements AIToolInterface
{
    public function getName(): string
    {
        return 'cek_ketersediaan_lapangan';
    }

    public function getDescription(): string
    {
        return 'Mengecek jadwal lapangan tenis yang sudah terisi (dibooking) pada tanggal tertentu. Jika jadwal tidak ada di hasil ini, berarti kosong. Mengembalikan juga daftar ID lapangan untuk pembuatan booking.';
    }

    public function getParametersSchema(): array
    {
        return [
            'type' => 'OBJECT',
            'properties' => [
                'tanggal' => [
                    'type' => 'STRING',
                    'description' => 'Tanggal yang ingin dicek dalam format YYYY-MM-DD (contoh: 2026-05-10)'
                ]
            ],
            'required' => ['tanggal']
        ];
    }

    public function execute(array $args, $user): array
    {
        $tanggal = $args['tanggal'] ?? date('Y-m-d');

        // Get courts info
        $courts = Court::where('status', 'active')->orWhere('status', 'available')->get();
        if ($courts->isEmpty()) {
            $courts = Court::all(); // Fallback if status field differs
        }

        $courtInfo = [];
        foreach ($courts as $c) {
            $courtInfo[] = "ID: {$c->id} | Nama: {$c->name} | Harga: Rp " . number_format($c->price ?? 50000, 0, ',', '.') . "/jam";
        }

        // Get bookings
        $bookings = Booking::with('court')
            ->where('date', $tanggal)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $terisi = [];
        foreach ($bookings as $b) {
            $courtName = $b->court ? $b->court->name : 'Unknown';
            $terisi[] = "Lapangan {$courtName} terisi jam {$b->start_time} - {$b->end_time}";
        }

        return [
            'tanggal_cek' => $tanggal,
            'info_lapangan' => $courtInfo,
            'jadwal_terisi' => empty($terisi) ? 'Semua lapangan kosong (08:00 - 22:00)' : $terisi,
            'catatan' => 'Untuk membuat booking, gunakan fungsi create_booking dan berikan court_id dari info_lapangan.'
        ];
    }
}
