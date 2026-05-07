<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AI\PromptService;
use App\Services\AI\GeminiService;
use App\Services\Tools\ToolDispatcher;

class ChatbotController extends Controller
{
    protected PromptService $promptService;
    protected GeminiService $geminiService;

    public function __construct()
    {
        // Secara ideal, ini di-inject via Laravel Dependency Injection (DI)
        $this->promptService = new PromptService();
        $this->geminiService = new GeminiService(new ToolDispatcher());
    }

    /**
     * Entry point utama HTTP Request dari Frontend Chatbot
     */
    public function handleChat(Request $request)
    {
        // 1. HTTP Validation Layer
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array',
        ]);

        $messageText = $request->message;
        $user = Auth::user();

        // 2. Intent Detection Cepat (Optional Optimization untuk Bypass AI)
        $messageLower = strtolower($messageText);
        if (str_contains($messageLower, 'cara booking') || str_contains($messageLower, 'mau booking')) {
            return response()->json([
                'reply' => "Untuk melakukan booking, Anda bisa langsung sebutkan tanggal dan jam yang Anda inginkan kepada saya, atau klik tombol 'Booking Sekarang' di layar."
            ]);
        }

        if (str_contains($messageLower, 'cara bayar') || str_contains($messageLower, 'pembayaran')) {
            return response()->json([
                'reply' => "Pembayaran dapat dilakukan melalui halaman detail booking Anda. Jika ada tagihan pending, tombol bayar akan muncul di riwayat jadwal Anda."
            ]);
        }

        // 3. Persiapkan Memory / History Chat
        $contents = [];
        if ($request->has('history') && is_array($request->history)) {
            // Membatasi context window agar hemat token
            $recentHistory = array_slice($request->history, -10);
            foreach ($recentHistory as $msg) {
                if (!isset($msg['role']) || !isset($msg['content']))
                    continue;

                // Map role Frontend (bot) ke role Gemini (model)
                $role = $msg['role'] === 'bot' ? 'model' : 'user';
                $contents[] = [
                    'role' => $role,
                    'parts' => [['text' => $msg['content']]]
                ];
            }
        }

        // Tambahkan pesan user saat ini
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $messageText]]
        ];

        // 4. Generate System Prompt
        $systemPrompt = $this->promptService->getSystemInstruction($user);

        // 5. Lempar ke Service Utama untuk di-handle oleh Agent
        $result = $this->geminiService->generateReply($systemPrompt, $contents, $user);

        // 6. Return response HTTP ke client
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json(['reply' => $result['reply']]);
    }
}
