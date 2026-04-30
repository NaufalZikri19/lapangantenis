<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class ChatbotController extends Controller
{
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $user = Auth::user();

        // Fetch user's active bookings context
        $activeBookings = Booking::with('court')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $bookingContext = "";
        if ($activeBookings->count() > 0) {
            $bookingContext = "\n\nKonteks Data User:\nNama: {$user->name}\nBooking aktif:\n";
            foreach ($activeBookings as $booking) {
                $status = $booking->status;
                $payment = $booking->payment_status;
                $bookingContext .= "- {$booking->court->name} tanggal {$booking->date} jam {$booking->start_time}. Status: {$status}, Pembayaran: {$payment}.\n";
            }
        } else {
            $bookingContext = "\n\nKonteks Data User:\nNama: {$user->name}\nBelum ada booking aktif.";
        }

        $systemPrompt = "Kamu adalah asisten untuk aplikasi booking lapangan tenis. Jawab pertanyaan user dengan singkat, jelas, dan relevan. Jika pertanyaan terkait booking atau pembayaran, arahkan user dengan langkah yang benar. Gunakan bahasa Indonesia, nada ramah, dan jangan terlalu panjang." . $bookingContext;

        $apiKey = env('GOOGLE_AI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API Key belum dikonfigurasi.'], 500);
        }

        // Use gemini-flash-latest
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}";

        try {
            $response = Http::withoutVerifying()->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nPertanyaan User: " . $request->message]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                // Extract text from Gemini response
                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    $reply = $responseData['candidates'][0]['content']['parts'][0]['text'];
                    return response()->json(['reply' => $reply]);
                } else {
                    return response()->json(['error' => 'Maaf, terjadi kesalahan pada format respons AI.'], 500);
                }
            } else {
                return response()->json(['error' => 'Maaf, gagal menghubungi server AI. Coba lagi nanti.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Maaf, terjadi kesalahan sistem.'], 500);
        }
    }
}
