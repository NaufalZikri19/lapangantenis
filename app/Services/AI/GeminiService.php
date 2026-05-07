<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use App\Services\Tools\ToolDispatcher;

class GeminiService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected ToolDispatcher $dispatcher;

    public function __construct(ToolDispatcher $dispatcher)
    {
        $this->apiKey = env('GOOGLE_AI_API_KEY', '');
        // Menggunakan Gemini Flash
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key={$this->apiKey}";
        $this->dispatcher = $dispatcher;
    }

    /**
     * Memproses percakapan dengan AI, mendukung Automatic Reasoning & Tool-Use
     */
    public function generateReply(string $systemPrompt, array $history, $user): array
    {
        if (empty($this->apiKey)) {
            return ['error' => 'API Key Gemini belum dikonfigurasi.'];
        }

        // Ambil definisi tool dari ToolDispatcher
        $tools = [
            [
                'functionDeclarations' => $this->dispatcher->getDefinitions()
            ]
        ];

        // Reasoning Loop (Max Turns untuk mencegah infinite loop)
        $maxTurns = 5;
        $turn = 0;

        $contents = $history;

        while ($turn < $maxTurns) {
            $payload = [
                'systemInstruction' => [
                    'parts' => [['text' => $systemPrompt]]
                ],
                'contents' => $contents,
                'tools' => $tools
            ];

            try {
                // Request ke API Gemini
                $response = Http::withoutVerifying()->post($this->apiUrl, $payload);

                if (!$response->successful()) {
                    \Log::error('Gemini API HTTP Error: ' . $response->body());
                    return ['error' => 'Maaf, sistem sedang sibuk. Coba lagi sebentar.'];
                }

                $responseData = $response->json();
                $candidate = $responseData['candidates'][0] ?? null;

                if (!$candidate) {
                    return ['error' => 'Format respons AI tidak valid.'];
                }

                $parts = $candidate['content']['parts'] ?? [];

                // Cari apakah ada instruksi functionCall di dalam parts
                $functionCall = null;
                foreach ($parts as $part) {
                    if (isset($part['functionCall'])) {
                        $functionCall = $part['functionCall'];
                        break;
                    }
                }

                // Perbaikan bug PHP JSON encode: pastikan empty array menjadi empty object {}
                foreach ($parts as &$p) {
                    if (isset($p['functionCall']['args']) && empty($p['functionCall']['args'])) {
                        $p['functionCall']['args'] = new \stdClass();
                    }
                }
                unset($p);

                if ($functionCall) {
                    // 1. Tambahkan seluruh respons Model (termasuk thought_signature) ke history
                    $contents[] = [
                        'role' => 'model',
                        'parts' => $parts
                    ];

                    // 2. Dispatch Tool (Eksekusi fungsi lokal)
                    $functionName = $functionCall['name'];
                    $args = $functionCall['args'] ?? [];
                    $functionResult = $this->dispatcher->dispatch($functionName, $args, $user);

                    // 3. Tambahkan hasil fungsi ke history agar dibaca AI di turn berikutnya
                    $contents[] = [
                        'role' => 'function', // Role yang diterima oleh REST API Gemini untuk response fungsi
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

                    $turn++; // Loop berjalan lagi untuk mengirim hasil ke AI
                } else {
                    // Jika tidak ada functionCall, AI memberikan jawaban akhir berupa teks
                    $finalText = '';
                    foreach ($parts as $part) {
                        if (isset($part['text'])) {
                            $finalText .= $part['text'];
                        }
                    }
                    return ['reply' => $finalText];
                }

            } catch (\Exception $e) {
                \Log::error('Gemini Service Exception: ' . $e->getMessage());
                return ['error' => 'Terjadi kesalahan sistem saat menghubungi AI.'];
            }
        }

        return ['reply' => 'Maaf, tugas ini terlalu kompleks bagi saya saat ini. Silakan coba instruksi yang lebih sederhana.'];
    }
}
