<?php
/**
 * BLACK-BOX TESTING — MODUL CHATBOT AI ASISTEN
 * Pengujian interaksi pengguna di halaman Chatbot website.
 * GeminiService di-mock agar tidak membutuhkan API key saat testing.
 *
 * Total: 8 Test Case (TC-CHAT-01 s/d TC-CHAT-08)
 * Dijalankan: php test_chatbot.php
 */

require __DIR__ . '/vendor/autoload.php';
$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Court;
use App\Models\Booking;
use App\Services\Tools\ToolDispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$results = [];
$pass    = 0;
$fail    = 0;
$skip    = 0;

function tc(string $id, string $nama, string $expect, string $actual, string $jenis): void
{
    global $results, $pass, $fail;
    $ok = $expect === $actual;
    $ok ? $pass++ : $fail++;
    $results[] = compact('id', 'nama', 'expect', 'actual', 'jenis') + ['status' => $ok ? 'PASS' : 'FAIL'];
    echo sprintf("[%s] %s | %s | Expect: %s | Actual: %s\n",
        $ok ? 'PASS' : 'FAIL', $ok ? '✅' : '❌', $id, $expect, $actual);
}

function tcContains(string $id, string $nama, string $keyword, string $actual, string $jenis): void
{
    global $results, $pass, $fail;
    $matched = str_contains(strtolower($actual), strtolower($keyword));
    $matched ? $pass++ : $fail++;
    $results[] = ['id' => $id, 'nama' => $nama,
        'expect' => "Mengandung '$keyword'", 'actual' => substr($actual, 0, 80),
        'jenis' => $jenis, 'status' => $matched ? 'PASS' : 'FAIL'];
    echo sprintf("[%s] %s | %s | Keyword: '%s' | Actual: %s\n",
        $matched ? 'PASS' : 'FAIL', $matched ? '✅' : '❌', $id, $keyword, substr($actual, 0, 60));
}

function tcSkip(string $id, string $alasan): void
{
    global $results, $skip;
    $skip++;
    $results[] = ['id' => $id, 'nama' => $alasan, 'expect' => '-', 'actual' => 'SKIP',
        'jenis' => '-', 'status' => 'SKIP'];
    echo "[SKIP] ⚠️  | $id | $alasan\n";
}

/**
 * Panggil ChatbotController::handleChat() asli,
 * dengan GeminiService di-mock (tidak butuh API key).
 */
function callChatbot(array $payload, $user): array
{
    // Mock GeminiService — bypass pemanggilan ke Gemini API eksternal
    app()->bind(\App\Services\AI\GeminiService::class, function () {
        return new class(app(ToolDispatcher::class)) extends \App\Services\AI\GeminiService {
            public function generateReply(string $systemPrompt, array $history, $user): array {
                return ['reply' => 'Halo! Ini respons mock dari Chatbot AI.'];
            }
        };
    });

    Auth::login($user);
    $jsonBody = json_encode($payload);
    $request  = Request::create('/chatbot', 'POST', [], [], [], [
        'HTTP_ACCEPT'           => 'application/json',
        'CONTENT_TYPE'          => 'application/json',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
    ], $jsonBody);
    $request->setJson(new \Symfony\Component\HttpFoundation\InputBag($payload));
    $request->setLaravelSession(app('session.store'));

    try {
        $ctrl = app(\App\Http\Controllers\ChatbotController::class);
        $resp = $ctrl->handleChat($request);
        return [
            'status_code' => $resp->getStatusCode(),
            'body'        => json_decode($resp->getContent(), true) ?? [],
            'exception'   => null,
        ];
    } catch (\Illuminate\Validation\ValidationException $e) {
        return ['status_code' => 422, 'body' => ['errors' => $e->errors()], 'exception' => 'ValidationException'];
    } catch (\Exception $e) {
        return ['status_code' => 500, 'body' => ['error' => $e->getMessage()], 'exception' => get_class($e)];
    }
}

// ── Data awal ───────────────────────────────────────────────────────────────
$customer = User::where('role', 'customer')->first();
$court    = Court::first();

echo "\n================================================================\n";
echo "  BLACK-BOX TESTING — MODUL CHATBOT AI ASISTEN\n";
echo "  Sistem Reservasi Lapangan Tenis  |  8 Test Case\n";
echo "================================================================\n\n";

echo "--- MODUL 13: CHATBOT AI ASISTEN ---\n\n";

// ── 13A: Validasi Input Pesan ────────────────────────────────────────────────
echo "  [13A] Validasi Input di Kolom Chat\n";

// TC-CHAT-01: Ketik pesan valid → terkirim, chatbot membalas
$res = callChatbot(['message' => 'Halo, saya ingin tahu jadwal lapangan'], $customer);
tc('TC-CHAT-01', 'Ketik pesan valid di kolom chat lalu klik Kirim', 'DITERIMA',
    $res['status_code'] === 200 ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-CHAT-02: Klik Kirim dengan kolom kosong → pesan tidak terkirim
$res = callChatbot(['message' => ''], $customer);
tc('TC-CHAT-02', 'Klik Kirim dengan kolom pesan dikosongkan', 'DITOLAK',
    $res['status_code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-CHAT-03: Pesan 501 karakter → ditolak (batas atas)
$res = callChatbot(['message' => str_repeat('a', 501)], $customer);
tc('TC-CHAT-03', 'Ketik 501 karakter di kolom chat lalu klik Kirim (batas atas — ditolak)', 'DITOLAK',
    $res['status_code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Batas');

// TC-CHAT-04: Pesan tepat 500 karakter → diterima (batas valid)
$res = callChatbot(['message' => str_repeat('a', 500)], $customer);
tc('TC-CHAT-04', 'Ketik tepat 500 karakter di kolom chat lalu klik Kirim (batas valid — diterima)', 'DITERIMA',
    $res['status_code'] === 200 ? 'DITERIMA' : 'DITOLAK', 'Batas');

// ── 13B: Respons Chatbot Berdasarkan Pesan ───────────────────────────────────
echo "\n  [13B] Respons Chatbot Berdasarkan Pesan\n";

// TC-CHAT-05: Ketik "cara booking" → chatbot langsung balas panduan booking (tanpa AI)
$res = callChatbot(['message' => 'cara booking lapangan tenis'], $customer);
$reply05 = $res['body']['reply'] ?? '';
tcContains('TC-CHAT-05', 'Ketik "cara booking lapangan tenis" → chatbot balas panduan booking',
    'booking', $reply05, 'Valid');

// TC-CHAT-06: Ketik "cara pembayaran" → chatbot langsung balas panduan pembayaran (tanpa AI)
$res = callChatbot(['message' => 'cara pembayaran booking saya'], $customer);
$reply06 = $res['body']['reply'] ?? '';
tcContains('TC-CHAT-06', 'Ketik "cara pembayaran booking saya" → chatbot balas panduan pembayaran',
    'pembayaran', $reply06, 'Valid');

// ── 13C: Fitur Tool via Chatbot ──────────────────────────────────────────────
echo "\n  [13C] Fitur Pintar Chatbot (Tools)\n";

// TC-CHAT-07: Chatbot dapat mengecek ketersediaan lapangan berdasarkan tanggal
$dispatcher = app(ToolDispatcher::class);
Auth::login($customer);
try {
    $avail = $dispatcher->dispatch('cek_ketersediaan_lapangan',
        ['tanggal' => now()->addDays(3)->format('Y-m-d')], $customer);
    $isOk  = is_array($avail) && !isset($avail['error']);
    tc('TC-CHAT-07', 'Tanya ketersediaan lapangan untuk tanggal tertentu via chatbot', 'DITERIMA',
        $isOk ? 'DITERIMA' : 'DITOLAK', 'Valid');
} catch (\Exception $e) {
    tc('TC-CHAT-07', 'Tanya ketersediaan lapangan untuk tanggal tertentu via chatbot', 'DITERIMA',
        'ERROR: ' . $e->getMessage(), 'Valid');
}
Auth::logout();

// TC-CHAT-08: Chatbot memberikan jawaban jujur dan tidak mengarang informasi
// Sistem prompt harus mengandung instruksi anti-halusinasi
Auth::login($customer);
$promptSvc    = app(\App\Services\AI\PromptService::class);
$systemPrompt = $promptSvc->getSystemInstruction($customer);
$hasAntiHallu = str_contains(strtolower($systemPrompt), 'jangan') ||
                str_contains(strtolower($systemPrompt), 'mengarang') ||
                str_contains(strtolower($systemPrompt), 'tidak boleh');
tc('TC-CHAT-08', 'Chatbot tidak mengarang informasi (system prompt mengandung instruksi kejujuran)', 'YA',
    $hasAntiHallu ? 'YA' : 'TIDAK', 'Valid');
Auth::logout();

// ============================================================
// RINGKASAN
// ============================================================
$total = $pass + $fail;
echo "\n================================================================\n";
echo "  RINGKASAN HASIL PENGUJIAN CHATBOT\n";
echo "================================================================\n";
echo "  Total TC Dieksekusi : {$total}\n";
echo "  ✅ PASS             : {$pass}\n";
echo "  ❌ FAIL             : {$fail}\n";
echo "  ⚠️  SKIP             : {$skip}\n";
echo "  Pass Rate           : " . ($total > 0 ? round(($pass / $total) * 100, 2) : 0) . "%\n";
echo "================================================================\n\n";

$out = [
    'timestamp' => now()->format('Y-m-d H:i:s'),
    'versi'     => 'Interaksi Pengguna Website | 8 TC Chatbot',
    'total'     => $total,
    'pass'      => $pass,
    'fail'      => $fail,
    'skip'      => $skip,
    'pass_rate' => ($total > 0 ? round(($pass / $total) * 100, 2) : 0) . '%',
    'results'   => $results,
];
file_put_contents(__DIR__ . '/test_chatbot_results.json', json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "📄 Hasil tersimpan di: test_chatbot_results.json\n\n";
