<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Court;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array',
        ]);

        $messageText = $request->message;
        $messageLower = strtolower($messageText);

        // 1. Intent Detection (Optimization)
        if (str_contains($messageLower, 'cara booking') || str_contains($messageLower, 'mau booking')) {
            return response()->json([
                'reply' => "Untuk melakukan booking, silakan menuju halaman Booking Lapangan dengan mengklik tombol 'Booking Sekarang' di bawah, atau melalui menu di samping kiri."
            ]);
        }

        if (str_contains($messageLower, 'cara bayar') || str_contains($messageLower, 'pembayaran')) {
            return response()->json([
                'reply' => "Pembayaran dapat dilakukan melalui halaman detail booking Anda. Jika ada tagihan pending, tombol bayar akan muncul di riwayat jadwal Anda."
            ]);
        }

        $user = Auth::user();

        // 2. System Prompt & Context
        $pendingCount = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
        $confirmedCount = Booking::where('user_id', $user->id)->whereIn('status', ['confirmed'])->count();

        $systemPrompt = "Kamu adalah agen AI asisten pintar untuk aplikasi booking lapangan tenis Gumbreg.\n";
        $systemPrompt .= "Kamu BISA dan HARUS memanggil fungsi/tools yang disediakan jika pertanyaan user membutuhkan data tersebut.\n";
        $systemPrompt .= "Jika user bertanya tentang ketersediaan lapangan di hari tertentu, panggil fungsi cek_ketersediaan_lapangan.\n";
        $systemPrompt .= "Jika user bertanya tentang detail tagihannya, panggil fungsi dapatkan_detail_tagihan.\n";
        $systemPrompt .= "Jika user minta membatalkan jadwal yang belum dibayar, panggil fungsi batalkan_booking_pending.\n";
        $currentDate = now()->translatedFormat('l, d F Y');
        $systemDate = now()->format('Y-m-d');

        $systemPrompt .= "PENTING: JANGAN PERNAH MENGARANG JADWAL ATAU STATUS BOOKING. SELALU GUNAKAN FUNGSI JIKA DIMINTA.\n";
        $systemPrompt .= "Gunakan bahasa Indonesia yang santai, sopan, dan jelas.\n\n";
        $systemPrompt .= "Waktu Sistem Saat Ini: {$currentDate} (Gunakan format {$systemDate} jika memanggil fungsi cek ketersediaan lapangan)\n\n";
        $systemPrompt .= "Konteks User Saat Ini:\nNama: {$user->name}\nJumlah Booking Pending: {$pendingCount}\nJumlah Booking Aktif: {$confirmedCount}";

        $apiKey = env('GOOGLE_AI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API Key belum dikonfigurasi.'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        // 3. Chat Memory Handling
        $contents = [];
        if ($request->has('history') && is_array($request->history)) {
            $recentHistory = array_slice($request->history, -10);
            foreach ($recentHistory as $msg) {
                if (!isset($msg['role']) || !isset($msg['content']))
                    continue;
                $role = $msg['role'] === 'bot' ? 'model' : 'user';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $msg['content']]]
                ];
            }
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $messageText]]
        ];

        // 4. Tools Definition
        $tools = [
            [
                'functionDeclarations' => [
                    [
                        'name' => 'cek_ketersediaan_lapangan',
                        'description' => 'Mengecek jadwal lapangan tenis yang sudah terisi (dibooking) pada tanggal tertentu. Jika jadwal tidak ada di hasil ini, berarti kosong.',
                        'parameters' => [
                            'type' => 'OBJECT',
                            'properties' => [
                                'tanggal' => [
                                    'type' => 'STRING',
                                    'description' => 'Tanggal yang ingin dicek dalam format YYYY-MM-DD (contoh: 2026-05-10)'
                                ]
                            ],
                            'required' => ['tanggal']
                        ]
                    ],
                    [
                        'name' => 'dapatkan_detail_tagihan',
                        'description' => 'Mendapatkan daftar booking milik user saat ini yang berstatus pending beserta detail nominal tagihan dan ID-nya.',
                    ],
                    [
                        'name' => 'batalkan_booking_pending',
                        'description' => 'Membatalkan pesanan/booking milik user yang masih berstatus pending.',
                        'parameters' => [
                            'type' => 'OBJECT',
                            'properties' => [
                                'booking_id' => [
                                    'type' => 'INTEGER',
                                    'description' => 'ID dari booking yang ingin dibatalkan'
                                ]
                            ],
                            'required' => ['booking_id']
                        ]
                    ]
                ]
            ]
        ];

        // 5. Execution Loop for ART (max 3 turns)
        $maxTurns = 3;
        $turn = 0;

        while ($turn < $maxTurns) {
            $payload = [
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ],
                'contents' => $contents,
                'tools' => $tools
            ];

            try {
                $response = Http::withoutVerifying()->post($url, $payload);

                if ($response->successful()) {
                    $responseData = $response->json();
                    $candidate = $responseData['candidates'][0] ?? null;

                    if (!$candidate) {
                        return response()->json(['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'], 500);
                    }

                    $part = $candidate['content']['parts'][0] ?? [];

                    // Check if AI wants to call a function
                    if (isset($part['functionCall'])) {
                        $functionCall = $part['functionCall'];
                        $functionName = $functionCall['name'];
                        $args = $functionCall['args'] ?? [];

                        // 1. Append model's request to history (must include all parts, e.g. thought_signature)
                        $contents[] = [
                            'role' => 'model',
                            'parts' => $candidate['content']['parts']
                        ];

                        // 2. Execute local function
                        $functionResult = [];
                        if ($functionName === 'cek_ketersediaan_lapangan') {
                            $functionResult = $this->cekKetersediaanLapangan($args['tanggal'] ?? date('Y-m-d'));
                        } elseif ($functionName === 'dapatkan_detail_tagihan') {
                            $functionResult = $this->dapatkanDetailTagihan($user->id);
                        } elseif ($functionName === 'batalkan_booking_pending') {
                            $functionResult = $this->batalkanBookingPending($args['booking_id'] ?? 0, $user->id);
                        } else {
                            $functionResult = ['error' => 'Fungsi tidak ditemukan.'];
                        }

                        // 3. Append function response to history
                        $contents[] = [
                            'role' => 'function',
                            'parts' => [
                                [
                                    'functionResponse' => [
                                        'name' => $functionName,
                                        'response' => [
                                            'name' => $functionName,
                                            'content' => $functionResult
                                        ]
                                    ]
                                ]
                            ]
                        ];

                        $turn++; // loop again to send the result back to AI
                    } elseif (isset($part['text'])) {
                        // AI provided the final text answer
                        return response()->json(['reply' => $part['text']]);
                    } else {
                        return response()->json(['error' => 'Format respons AI tidak dikenali.'], 500);
                    }
                } else {
                    \Log::error('Gemini API Error: ' . $response->body());
                    return response()->json(['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'], 500);
                }
            } catch (\Exception $e) {
                \Log::error('Chatbot System Error: ' . $e->getMessage());
                return response()->json(['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'], 500);
            }
        }

        return response()->json(['reply' => 'Maaf, proses penalaran saya memakan waktu terlalu lama. Bisakah Anda bertanya dengan cara lain?']);
    }

    // --- Private Tools Methods ---

    private function cekKetersediaanLapangan($tanggal)
    {
        $bookings = Booking::with('court')
            ->where('date', $tanggal)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        if ($bookings->isEmpty()) {
            return ['status' => 'Semua lapangan kosong (tersedia dari 08:00 - 22:00) pada tanggal ' . $tanggal];
        }

        $terisi = [];
        foreach ($bookings as $b) {
            $terisi[] = "Lapangan {$b->court->name} terisi jam {$b->start_time} - {$b->end_time}";
        }

        return [
            'tanggal_cek' => $tanggal,
            'keterangan' => 'Jam operasional lapangan adalah 08:00 - 22:00',
            'jadwal_yang_sudah_dibooking' => $terisi
        ];
    }

    private function dapatkanDetailTagihan($userId)
    {
        $bookings = Booking::with('court')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->get();

        if ($bookings->isEmpty()) {
            return ['status' => 'User tidak memiliki tagihan pending.'];
        }

        $tagihan = [];
        foreach ($bookings as $b) {
            $tagihan[] = [
                'booking_id' => $b->id,
                'lapangan' => $b->court->name,
                'tanggal' => $b->date,
                'jam' => $b->start_time . ' - ' . $b->end_time,
                'total_harga' => 'Rp ' . number_format($b->total_price, 0, ',', '.'),
                'batas_pembayaran' => $b->expired_at ? $b->expired_at->format('Y-m-d H:i') : 'Tidak diketahui'
            ];
        }

        return ['daftar_tagihan' => $tagihan];
    }

    private function batalkanBookingPending($bookingId, $userId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', $userId)
            ->first();

        if (!$booking) {
            return ['status' => 'Gagal. Booking ID tidak ditemukan atau bukan milik user ini.'];
        }

        if ($booking->status !== 'pending') {
            return ['status' => "Gagal. Booking berstatus {$booking->status}, hanya booking berstatus pending yang bisa dibatalkan."];
        }

        $booking->update(['status' => 'cancelled']);

        return ['status' => 'Berhasil. Booking dengan ID ' . $bookingId . ' telah berhasil dibatalkan.'];
    }
}
