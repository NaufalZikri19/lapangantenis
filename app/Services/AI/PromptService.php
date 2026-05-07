<?php

namespace App\Services\AI;

use App\Models\Booking;

class PromptService
{
    /**
     * Membuat System Prompt (Instruksi Dasar AI)
     */
    public function getSystemInstruction($user): string
    {
        $pendingCount = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
        $confirmedCount = Booking::where('user_id', $user->id)->whereIn('status', ['confirmed'])->count();

        $currentDate = now()->translatedFormat('l, d F Y');
        $systemDate = now()->format('Y-m-d');

        $prompt = "Kamu adalah agen AI asisten pintar untuk aplikasi booking lapangan tenis Gumbreg.\n";
        $prompt .= "Kamu BISA dan HARUS memanggil fungsi/tools yang disediakan jika pertanyaan user membutuhkan interaksi dengan database.\n";
        $prompt .= "PENTING: JANGAN PERNAH MENGARANG JADWAL, NAMA LAPANGAN, ATAU STATUS BOOKING. SELALU GUNAKAN FUNGSI UNTUK MEMASTIKAN FAKTA.\n";
        $prompt .= "Jika user bertanya jadwal kosong, panggil fungsi cek_ketersediaan_lapangan.\n";
        $prompt .= "Jika user ingin booking, panggil fungsi create_booking (pastikan data lengkap: court_id, tanggal, jam mulai, jam selesai).\n";
        $prompt .= "Gunakan bahasa Indonesia yang santai, sopan, dan ramah (menggunakan emoji secukupnya).\n\n";

        // Konteks Waktu
        $prompt .= "--- WAKTU SISTEM SAAT INI ---\n";
        $prompt .= "Hari/Tanggal: {$currentDate}\n";
        $prompt .= "Format Tanggal Standar Database: {$systemDate}\n";
        $prompt .= "(Gunakan Format {$systemDate} jika ingin memanggil fungsi terkait hari ini)\n\n";

        // Konteks User
        $prompt .= "--- DATA USER SAAT INI ---\n";
        $prompt .= "Nama: {$user->name}\n";
        $prompt .= "Jumlah Tagihan Belum Dibayar: {$pendingCount}\n";
        $prompt .= "Jumlah Jadwal Aktif: {$confirmedCount}\n";

        return $prompt;
    }
}
