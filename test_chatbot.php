<?php
/**
 * BLACK-BOX TESTING — MODUL CHATBOT (Versi Nyata)
 * Menguji langsung ChatbotController dan Tools yang sebenarnya.
 *
 * Dijalankan via: php test_chatbot.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\ChatbotController;
use App\Models\User;
use App\Models\Court;
use App\Models\Booking;
use App\Services\AI\PromptService;
use App\Services\AI\GeminiService;
use App\Services\Tools\ToolDispatcher;
use App\Services\Tools\Actions\CheckAvailability;
use App\Services\Tools\Actions\GetBillingDetails;
use App\Services\Tools\Actions\CancelBooking;
use App\Services\Tools\Actions\CreateBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

$results = [];
$pass    = 0;
$fail    = 0;
$skip    = 0;

function tc_chat($id, $nama, $expect, $actual, $jenis) {
    global $results, $pass, $fail;
    $status = ($expect === $actual) ? 'PASS' : 'FAIL';
    if ($status === 'PASS') $pass++; else $fail++;
    $results[] = compact('id', 'nama', 'expect', 'actual', 'jenis', 'status');
    $icon = $status === 'PASS' ? '✅' : '❌';
    echo sprintf("[%s] %s | %s | Expect: %s | Actual: %s\n", $status, $icon, $id, $expect, $actual);
}

function tc_contains($id, $nama, $keyword, $actual, $jenis) {
    global $results, $pass, $fail;
    $matched = str_contains(strtolower((string)$actual), strtolower($keyword));
    $status  = $matched ? 'PASS' : 'FAIL';
    if ($status === 'PASS') $pass++; else $fail++;
    $results[] = ['id'=>$id,'nama'=>$nama,'expect'=>"mengandung '$keyword'",'actual'=>$actual,'jenis'=>$jenis,'status'=>$status];
    $icon = $status === 'PASS' ? '✅' : '❌';
    echo sprintf("[%s] %s | %s | Keyword: '%s' | Actual: %s\n", $status, $icon, $id, $keyword, substr((string)$actual,0,70));
}

function tc_skip($id, $nama, $alasan) {
    global $results, $skip;
    $skip++;
    $results[] = ['id'=>$id,'nama'=>$nama,'expect'=>'-','actual'=>"SKIP: $alasan",'jenis'=>'-','status'=>'SKIP'];
    echo "[SKIP] ⚠️  | $id | $alasan\n";
}

/**
 * Memanggil ChatbotController::handleChat() yang SESUNGGUHNYA,
 * dengan GeminiService di-mock agar tidak butuh API key.
 *
 * @return array ['status_code' => int, 'body' => array, 'exception' => string|null]
 */
function callRealController(array $payload, $user): array
{
    // Bind mock GeminiService ke container — hanya bypass panggilan eksternal Gemini
    app()->bind(\App\Services\AI\GeminiService::class, function() {
        return new class(app(\App\Services\Tools\ToolDispatcher::class)) extends \App\Services\AI\GeminiService {
            public function generateReply(string $systemPrompt, array $history, $user): array {
                return ['reply' => 'Halo! Ini adalah respons mock dari AI.'];
            }
        };
    });

    Auth::login($user);

    // Buat Request dengan JSON content — cara yang benar agar controller bisa baca via $request->input()
    $jsonBody = json_encode($payload);
    $request  = Request::create('/chatbot', 'POST', [], [], [], [
        'HTTP_ACCEPT'    => 'application/json',
        'CONTENT_TYPE'   => 'application/json',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
    ], $jsonBody);
    $request->setJson(new \Symfony\Component\HttpFoundation\InputBag($payload));
    $request->setLaravelSession(app('session.store'));

    try {
        $controller = app(\App\Http\Controllers\ChatbotController::class);
        $response   = $controller->handleChat($request);

        return [
            'status_code' => $response->getStatusCode(),
            'body'        => json_decode($response->getContent(), true) ?? [],
            'exception'   => null,
        ];
    } catch (\Illuminate\Validation\ValidationException $e) {
        return [
            'status_code' => 422,
            'body'        => ['errors' => $e->errors()],
            'exception'   => 'ValidationException',
        ];
    } catch (\Exception $e) {
        return [
            'status_code' => 500,
            'body'        => ['error' => $e->getMessage()],
            'exception'   => get_class($e),
        ];
    }
}

// ----------------------------------------------------------------
$customer = User::where('role', 'customer')->first();
$admin    = User::where('role', 'admin')->first();
$court    = Court::first();

echo "\n================================================================\n";
echo "  BLACK-BOX TESTING — MODUL CHATBOT (Sistem Nyata)\n";
echo "  Sistem Reservasi Lapangan Tenis\n";
echo "================================================================\n\n";

// ================================================================
// MODUL 13A — VALIDASI INPUT (Melewati Controller Asli)
// ================================================================
echo "--- MODUL 13A: VALIDASI INPUT HTTP (via Controller Asli) ---\n";

// TC-CHAT-01: Pesan valid — controller harus menerima & mengembalikan reply
$res = callRealController(['message' => 'Halo, saya ingin booking lapangan'], $customer);
tc_chat('TC-CHAT-01', 'Pesan chatbot valid diterima controller', 'VALID', $res['status_code'] === 200 ? 'VALID' : 'INVALID', 'Valid');

// TC-CHAT-02: Pesan kosong — controller harus mengembalikan 422
$res = callRealController(['message' => ''], $customer);
tc_chat('TC-CHAT-02', 'Pesan kosong ditolak controller (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-CHAT-03: Pesan 501 karakter — batas atas, harus 422
$res = callRealController(['message' => str_repeat('a', 501)], $customer);
tc_chat('TC-CHAT-03', 'Pesan 501 karakter ditolak controller (batas atas)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Batas');

// TC-CHAT-04: Pesan tepat 500 karakter — harus diterima (200)
$res = callRealController(['message' => str_repeat('a', 500)], $customer);
tc_chat('TC-CHAT-04', 'Pesan tepat 500 karakter diterima controller (batas valid)', 'VALID', $res['status_code'] === 200 ? 'VALID' : 'INVALID', 'Batas');

// TC-CHAT-05: History berupa array valid — harus diterima
$res = callRealController([
    'message' => 'Halo',
    'history' => [['role' => 'user', 'content' => 'Tes']]
], $customer);
tc_chat('TC-CHAT-05', 'History berupa array valid diterima controller', 'VALID', $res['status_code'] === 200 ? 'VALID' : 'INVALID', 'Valid');

// TC-CHAT-06: History bukan array — harus 422
$res = callRealController(['message' => 'Halo', 'history' => 'bukan-array'], $customer);
tc_chat('TC-CHAT-06', 'History bukan array ditolak controller (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// ================================================================
// MODUL 13B — INTENT DETECTION (Melewati Controller Asli)
// ================================================================
echo "\n--- MODUL 13B: INTENT DETECTION CEPAT (via Controller Asli) ---\n";

// TC-CHAT-07: Keyword "cara booking" — controller harus langsung reply (bukan error)
$res = callRealController(['message' => 'cara booking lapangan'], $customer);
$reply07 = $res['body']['reply'] ?? '';
tc_chat('TC-CHAT-07', 'Keyword "cara booking" menghasilkan respons dari controller', 'VALID', ($res['status_code'] === 200 && !empty($reply07)) ? 'VALID' : 'INVALID', 'Valid');

// TC-CHAT-08: Respons fast-path "cara booking" mengandung kata "booking"
tc_contains('TC-CHAT-08', 'Respons "cara booking" mengandung kata "booking"', 'booking', $reply07, 'Valid');

// TC-CHAT-09: Keyword "mau booking"
$res = callRealController(['message' => 'saya mau booking besok'], $customer);
$reply09 = $res['body']['reply'] ?? '';
tc_chat('TC-CHAT-09', 'Keyword "mau booking" menghasilkan respons dari controller', 'VALID', ($res['status_code'] === 200 && !empty($reply09)) ? 'VALID' : 'INVALID', 'Valid');

// TC-CHAT-10: Keyword "cara bayar"
$res = callRealController(['message' => 'cara bayar tagihan saya'], $customer);
$reply10 = $res['body']['reply'] ?? '';
tc_chat('TC-CHAT-10', 'Keyword "cara bayar" menghasilkan respons dari controller', 'VALID', ($res['status_code'] === 200 && !empty($reply10)) ? 'VALID' : 'INVALID', 'Valid');

// TC-CHAT-11: Respons "cara bayar" mengandung kata "pembayaran"
tc_contains('TC-CHAT-11', 'Respons "cara bayar" mengandung kata "pembayaran"', 'pembayaran', $reply10, 'Valid');

// TC-CHAT-12: Pertanyaan umum (tanpa keyword khusus) tetap mendapat respons dari AI
$res = callRealController(['message' => 'lapangan apa yang tersedia hari ini?'], $customer);
$reply12 = $res['body']['reply'] ?? '';
tc_chat('TC-CHAT-12', 'Pertanyaan umum tetap menghasilkan respons (via AI mock)', 'VALID', ($res['status_code'] === 200 && !empty($reply12)) ? 'VALID' : 'INVALID', 'Valid');

// ================================================================
// MODUL 13C — TOOL: CEK KETERSEDIAAN LAPANGAN (Kode Asli)
// ================================================================
echo "\n--- MODUL 13C: TOOL CEK KETERSEDIAAN LAPANGAN ---\n";

$dispatcher  = new ToolDispatcher();
$definitions = $dispatcher->getDefinitions();
$toolNames   = array_column($definitions, 'name');

// TC-CHAT-13: Tool terdaftar
tc_chat('TC-CHAT-13', 'Tool cek_ketersediaan_lapangan terdaftar', 'YA', in_array('cek_ketersediaan_lapangan', $toolNames) ? 'YA' : 'TIDAK', 'Valid');

// TC-CHAT-14: Eksekusi dengan tanggal valid
if ($court && $customer) {
    $tool   = new CheckAvailability();
    $result = $tool->execute(['tanggal' => now()->addDays(3)->format('Y-m-d')], $customer);
    tc_chat('TC-CHAT-14', 'Cek ketersediaan tanggal valid — berhasil', 'BERHASIL', !isset($result['error']) ? 'BERHASIL' : 'GAGAL', 'Valid');
    // TC-CHAT-15: Hasil mengandung info lapangan
    tc_chat('TC-CHAT-15', 'Hasil mengandung key info_lapangan', 'YA', isset($result['info_lapangan']) ? 'YA' : 'TIDAK', 'Valid');
    // TC-CHAT-16: Hasil mengandung jadwal_terisi
    tc_chat('TC-CHAT-16', 'Hasil mengandung key jadwal_terisi', 'YA', isset($result['jadwal_terisi']) ? 'YA' : 'TIDAK', 'Valid');
}

// TC-CHAT-17: Tanpa parameter — tool gunakan default hari ini (tidak crash)
if ($customer) {
    $tool   = new CheckAvailability();
    $result = $tool->execute([], $customer);
    tc_chat('TC-CHAT-17', 'Tanpa parameter — tool pakai default hari ini, tidak crash', 'BERHASIL', !isset($result['error']) ? 'BERHASIL' : 'GAGAL', 'Batas');
}

// ================================================================
// MODUL 13D — TOOL: LIHAT TAGIHAN (Kode Asli)
// ================================================================
echo "\n--- MODUL 13D: TOOL LIHAT TAGIHAN ---\n";

// TC-CHAT-18: Tool terdaftar
tc_chat('TC-CHAT-18', 'Tool dapatkan_detail_tagihan terdaftar', 'YA', in_array('dapatkan_detail_tagihan', $toolNames) ? 'YA' : 'TIDAK', 'Valid');

// TC-CHAT-19: Eksekusi untuk customer
if ($customer) {
    $tool   = new GetBillingDetails();
    $result = $tool->execute([], $customer);
    tc_chat('TC-CHAT-19', 'Tool tagihan dieksekusi untuk customer tanpa error', 'BERHASIL', !isset($result['error']) ? 'BERHASIL' : 'GAGAL', 'Valid');
}

// TC-CHAT-20: Struktur hasil valid (mengandung key yang dikenal)
if ($customer) {
    $tool      = new GetBillingDetails();
    $result    = $tool->execute([], $customer);
    $hasKey    = isset($result['daftar_tagihan']) || isset($result['status']);
    tc_chat('TC-CHAT-20', 'Hasil tagihan memiliki struktur key yang valid', 'YA', $hasKey ? 'YA' : 'TIDAK', 'Valid');
}

// ================================================================
// MODUL 13E — TOOL: BUAT BOOKING (Kode Asli)
// ================================================================
echo "\n--- MODUL 13E: TOOL BUAT BOOKING VIA CHATBOT ---\n";

// TC-CHAT-21: Tool terdaftar
tc_chat('TC-CHAT-21', 'Tool create_booking terdaftar', 'YA', in_array('create_booking', $toolNames) ? 'YA' : 'TIDAK', 'Valid');

// TC-CHAT-22: Tanpa court_id — harus FAILED
if ($customer) {
    $tool   = new CreateBooking();
    $result = $tool->execute(['date' => now()->addDays(5)->format('Y-m-d'), 'start_time' => '09:00', 'end_time' => '10:00'], $customer);
    $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
    tc_chat('TC-CHAT-22', 'Tanpa court_id — dikembalikan sebagai FAILED', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// TC-CHAT-23: Tanpa tanggal — harus FAILED
if ($customer && $court) {
    $tool   = new CreateBooking();
    $result = $tool->execute(['court_id' => $court->id, 'start_time' => '09:00', 'end_time' => '10:00'], $customer);
    $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
    tc_chat('TC-CHAT-23', 'Tanpa tanggal — dikembalikan sebagai FAILED', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// TC-CHAT-24: end_time sebelum start_time — harus FAILED (slot kosong => BookingService error)
if ($customer && $court) {
    $tool   = new CreateBooking();
    $result = $tool->execute(['court_id' => $court->id, 'date' => now()->addDays(5)->format('Y-m-d'), 'start_time' => '11:00', 'end_time' => '09:00'], $customer);
    $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
    tc_chat('TC-CHAT-24', 'end_time lebih awal dari start_time — FAILED', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// TC-CHAT-25: court_id tidak ada di DB — harus FAILED
if ($customer) {
    $tool   = new CreateBooking();
    $result = $tool->execute(['court_id' => 99999, 'date' => now()->addDays(5)->format('Y-m-d'), 'start_time' => '09:00', 'end_time' => '10:00'], $customer);
    $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
    tc_chat('TC-CHAT-25', 'court_id tidak ada di DB — FAILED', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// ================================================================
// MODUL 13F — TOOL: BATALKAN BOOKING (Kode Asli)
// ================================================================
echo "\n--- MODUL 13F: TOOL BATALKAN BOOKING ---\n";

// TC-CHAT-26: Tool terdaftar
tc_chat('TC-CHAT-26', 'Tool batalkan_booking_pending terdaftar', 'YA', in_array('batalkan_booking_pending', $toolNames) ? 'YA' : 'TIDAK', 'Valid');

// TC-CHAT-27: Tanpa booking_id — harus error
if ($customer) {
    $tool   = new CancelBooking();
    $result = $tool->execute([], $customer);
    tc_chat('TC-CHAT-27', 'Tanpa booking_id — dikembalikan error', 'GAGAL', isset($result['error']) ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// TC-CHAT-28: booking_id tidak ada di DB — FAILED (bukan milik user)
if ($customer) {
    $tool   = new CancelBooking();
    $result = $tool->execute(['booking_id' => 99999], $customer);
    $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
    tc_chat('TC-CHAT-28', 'booking_id tidak ada di DB — FAILED', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// TC-CHAT-29: Booking milik user lain tidak bisa dibatalkan (proteksi kepemilikan)
if ($customer) {
    $otherBooking = Booking::where('user_id', '!=', $customer->id)
        ->whereIn('status', ['pending_payment', 'pending_verification', 'confirmed'])
        ->first();
    if ($otherBooking) {
        $tool   = new CancelBooking();
        $result = $tool->execute(['booking_id' => $otherBooking->id], $customer);
        $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
        tc_chat('TC-CHAT-29', 'Booking milik user lain tidak bisa dibatalkan (keamanan)', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
    } else {
        tc_skip('TC-CHAT-29', 'Proteksi kepemilikan booking', 'Tidak ada booking milik user lain di DB saat ini');
    }
}

// TC-CHAT-30: Booking berstatus BUKAN pending tidak bisa dibatalkan
if ($customer) {
    // Cari booking confirmed milik customer ini
    $confirmedBooking = Booking::where('user_id', $customer->id)
        ->where('status', 'confirmed')
        ->first();
    if ($confirmedBooking) {
        $tool   = new CancelBooking();
        $result = $tool->execute(['booking_id' => $confirmedBooking->id], $customer);
        $failed = (isset($result['status']) && $result['status'] === 'FAILED') || isset($result['error']);
        tc_chat('TC-CHAT-30', 'Booking confirmed tidak bisa dibatalkan (bukan pending)', 'GAGAL', $failed ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
    } else {
        tc_skip('TC-CHAT-30', 'Pembatalan booking non-pending', 'Tidak ada booking confirmed milik customer saat ini');
    }
}

// ================================================================
// MODUL 13G — KEAMANAN & SYSTEM PROMPT (Kode Asli)
// ================================================================
echo "\n--- MODUL 13G: KEAMANAN TOOL DISPATCHER & SYSTEM PROMPT ---\n";

// TC-CHAT-31: Fungsi tidak terdaftar ditolak (anti-hallucination)
if ($customer) {
    $result = $dispatcher->dispatch('fungsi_tidak_terdaftar', [], $customer);
    tc_chat('TC-CHAT-31', 'Fungsi tidak terdaftar ditolak dispatcher', 'GAGAL', isset($result['error']) ? 'GAGAL' : 'BERHASIL', 'Tidak Valid');
}

// TC-CHAT-32: Total 4 tool terdaftar
tc_chat('TC-CHAT-32', 'Tepat 4 tool AI terdaftar di sistem', '4', (string)count($definitions), 'Valid');

// TC-CHAT-33: System prompt mengandung nama user (PromptService asli)
if ($customer) {
    $promptService = app(PromptService::class);
    $prompt        = $promptService->getSystemInstruction($customer);
    tc_contains('TC-CHAT-33', 'System prompt mengandung nama user aktif', strtolower($customer->name), strtolower($prompt), 'Valid');
}

// TC-CHAT-34: System prompt mengandung instruksi anti-halusinasi
if ($customer) {
    $promptService = app(PromptService::class);
    $prompt        = $promptService->getSystemInstruction($customer);
    tc_contains('TC-CHAT-34', 'System prompt mengandung instruksi "JANGAN"', 'jangan', strtolower($prompt), 'Valid');
}

// TC-CHAT-35: System prompt mengandung tanggal sistem hari ini
if ($customer) {
    $promptService = app(PromptService::class);
    $prompt        = $promptService->getSystemInstruction($customer);
    tc_contains('TC-CHAT-35', 'System prompt mengandung tanggal sistem hari ini', now()->format('Y-m-d'), $prompt, 'Valid');
}

// ================================================================
// RINGKASAN
// ================================================================
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

$output = [
    'timestamp' => now()->format('Y-m-d H:i:s'),
    'modul'     => 'Chatbot — Modul 13 (Sistem Nyata)',
    'total'     => $total,
    'pass'      => $pass,
    'fail'      => $fail,
    'skip'      => $skip,
    'pass_rate' => ($total > 0 ? round(($pass / $total) * 100, 2) : 0) . '%',
    'results'   => $results,
];
file_put_contents(__DIR__ . '/test_chatbot_results.json', json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "📄 Hasil tersimpan di: test_chatbot_results.json\n\n";
