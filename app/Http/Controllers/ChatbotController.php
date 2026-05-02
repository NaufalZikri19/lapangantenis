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

        // 2. Context Awareness (Advanced)
        $pendingCount = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
        $confirmedCount = Booking::where('user_id', $user->id)->whereIn('status', ['confirmed'])->count();
        $completedCount = Booking::where('user_id', $user->id)->where('status', 'completed')->count();

        $contextString = "Konteks Data User:\nNama: {$user->name}\n";
        $contextString .= "User ini memiliki {$pendingCount} booking yang belum dibayar (pending).\n";
        $contextString .= "User ini memiliki {$confirmedCount} booking aktif (confirmed).\n";
        $contextString .= "User ini memiliki {$completedCount} riwayat booking selesai (completed).\n";

        // 3. System Prompt (Upgraded)
        $systemPrompt = "Kamu adalah asisten untuk aplikasi booking lapangan tenis.\n";
        $systemPrompt .= "Jawab dengan singkat, jelas, dan membantu user melakukan aksi.\n";
        $systemPrompt .= "Jika user ingin booking, arahkan langkahnya.\n";
        $systemPrompt .= "Jika user memiliki booking pending, ingatkan untuk pembayaran.\n";
        $systemPrompt .= "Gunakan bahasa Indonesia yang santai tapi sopan.\n\n";
        $systemPrompt .= $contextString;

        $apiKey = env('GOOGLE_AI_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API Key belum dikonfigurasi.'], 500);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$apiKey}";

        // 4. Chat Memory Handling
        $contents = [];

        // Load history if exists
        if ($request->has('history') && is_array($request->history)) {
            // Limit to last 10 messages to save tokens
            $recentHistory = array_slice($request->history, -10);
            foreach ($recentHistory as $msg) {
                // Ignore empty or invalid messages
                if (!isset($msg['role']) || !isset($msg['content']))
                    continue;

                $role = $msg['role'] === 'bot' ? 'model' : 'user';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $msg['content']]]
                ];
            }
        }

        // Ensure alternating roles if there are bugs in frontend history (Gemini requires alternating roles)
        // For safety, we just append the new message. Gemini is robust enough.
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $messageText]]
        ];

        try {
            $response = Http::withoutVerifying()->post($url, [
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ],
                'contents' => $contents
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    $reply = $responseData['candidates'][0]['content']['parts'][0]['text'];
                    return response()->json(['reply' => $reply]);
                } else {
                    return response()->json(['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'], 500);
                }
            } else {
                // Log actual API error for debugging
                \Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Chatbot System Error: ' . $e->getMessage());
            return response()->json(['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'], 500);
        }
    }
}
