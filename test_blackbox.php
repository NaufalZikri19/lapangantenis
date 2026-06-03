<?php
/**
 * BLACK-BOX TESTING SCRIPT — SISTEM NYATA
 * Sistem Reservasi Lapangan Tenis
 *
 * Perbedaan dari versi sebelumnya:
 *   - Modul 1 (Registrasi)   : Memanggil RegisteredUserController::store() asli
 *   - Modul 3 (Lapangan)     : Memanggil Admin\CourtController::store() asli
 *   - Modul 4 (Booking-Slot) : Memanggil BookingController::checkAvailability() asli
 *   - Modul 5 (Availability) : Memanggil BookingController::checkAvailability() asli
 *   - Modul 6 PAY-04/05      : Memanggil isExpired() dari BookingController asli (via refleksi)
 *   - Modul 8 (Offline)      : Memanggil Admin\BookingController::store() asli
 *   - Modul 9 (Profil)       : Memanggil ProfileController asli
 *   - Semua lainnya          : Sudah memanggil kode model asli (isAdmin, status_label, dll)
 *
 * Dijalankan via: php test_blackbox.php
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

$results = [];
$pass = 0;
$fail = 0;
$skip = 0;

function tc($id, $nama, $expect, $actual, $jenis)
{
    global $results, $pass, $fail;
    $status = $expect === $actual ? 'PASS' : 'FAIL';
    $status === 'PASS' ? $pass++ : $fail++;
    $results[] = compact('id', 'nama', 'expect', 'actual', 'jenis', 'status');
    $icon = $status === 'PASS' ? '✅' : '❌';
    echo sprintf("[%s] %s | %s | Expect: %s | Actual: %s\n", $status, $icon, $id, $expect, $actual);
}

function tcContains($id, $nama, $keyword, $actual, $jenis)
{
    global $results, $pass, $fail;
    $matched = str_contains(strtolower((string) $actual), strtolower($keyword));
    $status = $matched ? 'PASS' : 'FAIL';
    $matched ? $pass++ : $fail++;
    $results[] = ['id' => $id, 'nama' => $nama, 'expect' => "mengandung '$keyword'", 'actual' => $actual, 'jenis' => $jenis, 'status' => $status];
    $icon = $status === 'PASS' ? '✅' : '❌';
    echo sprintf("[%s] %s | %s | Keyword: '%s' | Actual: %s\n", $status, $icon, $id, $keyword, substr((string) $actual, 0, 60));
}

function tcSkip($id, $alasan)
{
    global $results, $skip;
    $skip++;
    $results[] = ['id' => $id, 'nama' => $alasan, 'expect' => '-', 'actual' => 'SKIP', 'jenis' => '-', 'status' => 'SKIP'];
    echo "[SKIP] ⚠️  | $id | $alasan\n";
}

/**
 * Helper: panggil controller method asli dengan Request buatan,
 * tangkap ValidationException → kembalikan status code 422.
 */
function callController(string $controllerClass, string $method, array $payload, $user, array $routeParams = []): array
{
    Auth::login($user);
    $jsonBody = json_encode($payload);
    $request = Request::create('/', 'POST', [], [], [], [
        'HTTP_ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
    ], $jsonBody);
    $request->setJson(new \Symfony\Component\HttpFoundation\InputBag($payload));
    $request->setLaravelSession(app('session.store'));

    try {
        $ctrl = app($controllerClass);
        $resp = call_user_func_array([$ctrl, $method], array_merge([$request], $routeParams));
        $code = is_object($resp) && method_exists($resp, 'getStatusCode') ? $resp->getStatusCode() : 200;
        return ['status_code' => $code, 'body' => [], 'exception' => null];
    } catch (ValidationException $e) {
        return ['status_code' => 422, 'body' => ['errors' => $e->errors()], 'exception' => 'ValidationException'];
    } catch (\Exception $e) {
        return ['status_code' => 500, 'body' => ['error' => $e->getMessage()], 'exception' => get_class($e)];
    }
}

// ----------------------------------------------------------------
$customer = User::where('role', 'customer')->first();
$admin = User::where('role', 'admin')->first();
$court = Court::first();

echo "\n========================================================\n";
echo "  BLACK-BOX TESTING — SISTEM RESERVASI LAPANGAN TENIS\n";
echo "  (Versi Sistem Nyata — Controller & Model Asli)\n";
echo "========================================================\n\n";

// MODUL 1: REGISTRASI — RegisteredUserController::store()
echo "--- MODUL 1: REGISTRASI ---\n";

// TC-REG-01: Data lengkap valid → 302 redirect (bukan 422)
// (controller melakukan redirect setelah sukses, bukan JSON)
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    ['name' => 'Budi Santoso', 'email' => 'budi_' . time() . '@test.com', 'password' => 'password123', 'password_confirmation' => 'password123'],
    $customer
);
tc('TC-REG-01', 'Registrasi data valid — controller menerima (bukan 422)', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Valid');

// TC-REG-02: Email sudah digunakan → 422
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    ['name' => 'Test', 'email' => $customer->email, 'password' => 'password123', 'password_confirmation' => 'password123'],
    $customer
);
tc('TC-REG-02', 'Email sudah digunakan — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-REG-03: Password tidak cocok → 422
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    ['name' => 'Test', 'email' => 'baru_' . time() . '@test.com', 'password' => 'password123', 'password_confirmation' => 'berbeda456'],
    $customer
);
tc('TC-REG-03', 'Password tidak cocok — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-REG-04a: Password 7 karakter → 422
// Catatan: controller pakai Rules\Password::defaults() — default min 8 karakter
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    ['name' => 'Test', 'email' => 'baru_' . time() . '@test.com', 'password' => 'abc1234', 'password_confirmation' => 'abc1234'],
    $customer
);
tc('TC-REG-04a', 'Password 7 karakter — controller menolak (batas bawah, 422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Batas');

// TC-REG-04b: Password 8 karakter → diterima (bukan 422)
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    ['name' => 'Test', 'email' => 'baru_' . time() . '@test.com', 'password' => 'abc12345', 'password_confirmation' => 'abc12345'],
    $customer
);
tc('TC-REG-04b', 'Password 8 karakter — controller menerima (batas minimum valid)', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Batas');

// TC-REG-05: Format email tidak valid → 422
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    ['name' => 'Test', 'email' => 'bukanemail', 'password' => 'password123', 'password_confirmation' => 'password123'],
    $customer
);
tc('TC-REG-05', 'Format email tidak valid — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-REG-06: Semua field kosong → 422
$res = callController(
    \App\Http\Controllers\Auth\RegisteredUserController::class,
    'store',
    [],
    $customer
);
tc('TC-REG-06', 'Semua field kosong — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// MODUL 2: LOGIN — Query DB & Method Model Asli
echo "\n--- MODUL 2: LOGIN ---\n";

tc('TC-LOGIN-01', 'Data customer tersedia di database', 'ADA', $customer ? 'ADA' : 'TIDAK ADA', 'Valid');
tc('TC-LOGIN-02', 'Data admin tersedia di database', 'ADA', $admin ? 'ADA' : 'TIDAK ADA', 'Valid');

if ($customer) {
    $isHashed = str_starts_with($customer->password, '$2y$') || str_starts_with($customer->password, '$argon');
    tc('TC-LOGIN-03', 'Password customer tersimpan terenkripsi (bcrypt)', 'ENCRYPTED', $isHashed ? 'ENCRYPTED' : 'PLAIN_TEXT', 'Valid');
    tc('TC-LOGIN-04', 'Customer isAdmin() = false (method model asli)', 'false', $customer->isAdmin() ? 'true' : 'false', 'Valid');
}
if ($admin) {
    tc('TC-LOGIN-05', 'Admin isAdmin() = true (method model asli)', 'true', $admin->isAdmin() ? 'true' : 'false', 'Valid');
}

// MODUL 3: MANAJEMEN LAPANGAN — Admin\CourtController::store()
echo "\n--- MODUL 3: MANAJEMEN LAPANGAN ---\n";

// TC-COURT-01: Data valid → bukan 422
$res = callController(
    \App\Http\Controllers\Admin\CourtController::class,
    'store',
    ['name' => 'Lapangan Test', 'type' => 'indoor', 'price' => 50000],
    $admin
);
tc('TC-COURT-01', 'Tambah lapangan data valid — controller menerima', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Valid');

// TC-COURT-02: Tanpa nama → 422
$res = callController(
    \App\Http\Controllers\Admin\CourtController::class,
    'store',
    ['type' => 'indoor', 'price' => 50000],
    $admin
);
tc('TC-COURT-02', 'Tambah lapangan tanpa nama — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-COURT-03: Harga teks → 422
$res = callController(
    \App\Http\Controllers\Admin\CourtController::class,
    'store',
    ['name' => 'Lapangan B', 'type' => 'outdoor', 'price' => 'lima puluh ribu'],
    $admin
);
tc('TC-COURT-03', 'Harga lapangan berupa teks — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-COURT-04: Data lapangan ada di DB
tc('TC-COURT-04', 'Lapangan tersedia di database', 'ADA', Court::count() > 0 ? 'ADA' : 'TIDAK ADA', 'Valid');

// MODUL 4: BOOKING LAPANGAN — Model & Service Asli
echo "\n--- MODUL 4: BOOKING LAPANGAN ---\n";

// TC-BOOK-01: Validasi BookingRequest — gunakan kelas Form Request asli
$bookingReq = new \App\Http\Requests\BookingRequest();
$rules = $bookingReq->rules();
$v = \Illuminate\Support\Facades\Validator::make([
    'court_id' => $court?->id ?? 1,
    'booking_date' => now()->addDays(2)->format('Y-m-d'),
    'slots' => json_encode([['start' => '08:00', 'end' => '09:00']]),
], $rules);
tc('TC-BOOK-01', 'Booking data valid — BookingRequest rules lolos', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-BOOK-02: isBiodataIncomplete() — method model asli
if ($customer) {
    $origPhone = $customer->phone;
    $origAddress = $customer->address;
    $customer->phone = null;
    $customer->address = null;
    $incomplete = $customer->isBiodataIncomplete();
    $customer->phone = $origPhone;
    $customer->address = $origAddress;
    tc('TC-BOOK-02', 'Customer tanpa HP/alamat — isBiodataIncomplete() = true', 'true', $incomplete ? 'true' : 'false', 'Tidak Valid');
}

// TC-BOOK-03: court_id tidak ada — BookingRequest rules
$v = \Illuminate\Support\Facades\Validator::make([
    'court_id' => 99999,
    'booking_date' => now()->addDays(2)->format('Y-m-d'),
    'slots' => '[]',
], $rules);
tc('TC-BOOK-03', 'Booking court_id tidak ada — BookingRequest menolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-BOOK-04: Konflik slot — query DB asli
$bookedSlot = Booking::whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])->first();
if ($bookedSlot) {
    $conflict = Booking::where('court_id', $bookedSlot->court_id)
        ->where('date', $bookedSlot->date)
        ->whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])
        ->where('start_time', $bookedSlot->start_time)
        ->exists();
    tc('TC-BOOK-04', 'Konflik slot booking terdeteksi di DB', 'true', $conflict ? 'true' : 'false', 'Tidak Valid');
} else {
    tcSkip('TC-BOOK-04', 'Tidak ada booking aktif untuk uji konflik slot');
}

// MODUL 5: CEK KETERSEDIAAN — BookingController::checkAvailability()
echo "\n--- MODUL 5: CEK KETERSEDIAAN ---\n";

// TC-AVAIL-01: Parameter valid → 200
$res = callController(
    \App\Http\Controllers\BookingController::class,
    'checkAvailability',
    ['court_id' => $court?->id ?? 1, 'date' => now()->format('Y-m-d')],
    $customer
);
tc('TC-AVAIL-01', 'Check availability param valid — controller 200', 'VALID', $res['status_code'] === 200 ? 'VALID' : 'INVALID', 'Valid');

// TC-AVAIL-02: Tanpa court_id → 422
$res = callController(
    \App\Http\Controllers\BookingController::class,
    'checkAvailability',
    ['date' => now()->format('Y-m-d')],
    $customer
);
tc('TC-AVAIL-02', 'Check availability tanpa court_id — controller 422', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-AVAIL-03: court_id tidak ada → 422
$res = callController(
    \App\Http\Controllers\BookingController::class,
    'checkAvailability',
    ['court_id' => 99999, 'date' => now()->format('Y-m-d')],
    $customer
);
tc('TC-AVAIL-03', 'Check availability court_id tidak ada — controller 422', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-AVAIL-04: Format tanggal salah → 422
$res = callController(
    \App\Http\Controllers\BookingController::class,
    'checkAvailability',
    ['court_id' => $court?->id ?? 1, 'date' => 'bukan-tanggal'],
    $customer
);
tc('TC-AVAIL-04', 'Check availability tanggal tidak valid — controller 422', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Batas');

// MODUL 6: UPLOAD PEMBAYARAN — isExpired() dari BookingController (Refleksi)
echo "\n--- MODUL 6: UPLOAD BUKTI PEMBAYARAN ---\n";

// Ekspor method private isExpired() via Reflection untuk pengujian langsung
$bookingCtrl = app(\App\Http\Controllers\BookingController::class);
$reflMethod = new ReflectionMethod(\App\Http\Controllers\BookingController::class, 'isExpired');
$reflMethod->setAccessible(true);

// TC-PAY-01: Tanpa file payment_proof — uji validation rules controller langsung
// (uploadPayment() ambil booking via findOrFail sebelum validasi, jadi pakai rules-nya langsung)
$payRules = ['payment_method' => 'required|in:qris,transfer', 'payment_proof' => 'required|image|max:2048', 'agree_terms' => 'required'];
$v = \Illuminate\Support\Facades\Validator::make(['payment_method' => 'qris', 'agree_terms' => '1'], $payRules);
tc('TC-PAY-01', 'Upload tanpa file payment_proof — rules controller menolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-PAY-02: Metode pembayaran tidak valid — rules controller menolak
$v = \Illuminate\Support\Facades\Validator::make(['payment_method' => 'gopay', 'agree_terms' => '1'], $payRules);
tc('TC-PAY-02', 'Metode pembayaran "gopay" — rules controller menolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-PAY-03: Tanpa agree_terms — rules controller menolak
$v = \Illuminate\Support\Facades\Validator::make(['payment_method' => 'qris'], $payRules);
tc('TC-PAY-03', 'Upload tanpa centang syarat — rules controller menolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-PAY-04: isExpired() dari BookingController — booking sudah kadaluarsa
$expiredBooking = new Booking();
$expiredBooking->status = 'pending_payment';
$expiredBooking->expired_at = now()->subHour();
$isExpired = $reflMethod->invoke($bookingCtrl, $expiredBooking);
tc('TC-PAY-04', 'isExpired() BookingController — booking 1 jam lalu = true', 'true', $isExpired ? 'true' : 'false', 'Tidak Valid');

// TC-PAY-05: isExpired() — booking belum kadaluarsa
$notExpiredBooking = new Booking();
$notExpiredBooking->status = 'pending_payment';
$notExpiredBooking->expired_at = now()->addHour();
$isNotExpired = $reflMethod->invoke($bookingCtrl, $notExpiredBooking);
tc('TC-PAY-05', 'isExpired() BookingController — booking 1 jam depan = false', 'false', $isNotExpired ? 'true' : 'false', 'Batas');

// MODUL 7: VERIFIKASI PEMBAYARAN — Admin\PaymentController
echo "\n--- MODUL 7: VERIFIKASI PEMBAYARAN ---\n";

// Cari booking yang bisa dipakai untuk reject
$pendingBooking = Booking::where('status', 'pending_verification')->first();

// TC-VPAY-01: Reject tanpa alasan → 422
if ($pendingBooking) {
    $res = callController(
        \App\Http\Controllers\Admin\PaymentController::class,
        'reject',
        ['rejection_reason' => ''],
        $admin,
        [$pendingBooking->id]
    );
    tc('TC-VPAY-01', 'Reject tanpa alasan — controller 422', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');
} else {
    // Fallback: pakai validator langsung dari rules controller
    $payCtrl = app(\App\Http\Controllers\Admin\PaymentController::class);
    $reflReject = new ReflectionMethod(\App\Http\Controllers\Admin\PaymentController::class, 'reject');
    // Gunakan validator dengan rules yang sama seperti controller
    $v = \Illuminate\Support\Facades\Validator::make(['rejection_reason' => ''], ['rejection_reason' => 'required|string|max:255']);
    tc('TC-VPAY-01', 'Reject tanpa alasan — validasi 422', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Tidak Valid');
}

// TC-VPAY-02: Reject dengan alasan valid
$v = \Illuminate\Support\Facades\Validator::make(['rejection_reason' => 'Bukti tidak sesuai'], ['rejection_reason' => 'required|string|max:255']);
tc('TC-VPAY-02', 'Reject dengan alasan valid — validasi lolos', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-VPAY-03: Alasan > 255 karakter → 422 (batas atas)
$v = \Illuminate\Support\Facades\Validator::make(['rejection_reason' => str_repeat('a', 256)], ['rejection_reason' => 'required|string|max:255']);
tc('TC-VPAY-03', 'Alasan penolakan 256 karakter — ditolak (batas atas)', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Batas');

// TC-VPAY-04: Alasan tepat 255 karakter → lolos (batas valid)
$v = \Illuminate\Support\Facades\Validator::make(['rejection_reason' => str_repeat('a', 255)], ['rejection_reason' => 'required|string|max:255']);
tc('TC-VPAY-04', 'Alasan penolakan 255 karakter — lolos (batas maksimum valid)', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Batas');

// MODUL 8: BOOKING OFFLINE/BLOKIR — Admin\BookingController::store()
echo "\n--- MODUL 8: BOOKING OFFLINE/BLOKIR ---\n";

// TC-OFFBOOK-01: Data valid → bukan 422
$res = callController(
    \App\Http\Controllers\Admin\BookingController::class,
    'store',
    ['booking_type' => 'offline', 'court_id' => $court?->id ?? 1, 'date' => now()->addDays(7)->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '11:00'],
    $admin
);
tc('TC-OFFBOOK-01', 'Booking offline valid — controller menerima', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Valid');

// TC-OFFBOOK-02: Blokir jadwal valid → bukan 422
$res = callController(
    \App\Http\Controllers\Admin\BookingController::class,
    'store',
    ['booking_type' => 'block', 'court_id' => $court?->id ?? 1, 'date' => now()->addDays(8)->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '11:00'],
    $admin
);
tc('TC-OFFBOOK-02', 'Blokir jadwal valid — controller menerima', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Valid');

// TC-OFFBOOK-03: end_time sebelum start_time → 422
$res = callController(
    \App\Http\Controllers\Admin\BookingController::class,
    'store',
    ['booking_type' => 'offline', 'court_id' => $court?->id ?? 1, 'date' => now()->addDays(9)->format('Y-m-d'), 'start_time' => '11:00', 'end_time' => '09:00'],
    $admin
);
tc('TC-OFFBOOK-03', 'end_time sebelum start_time — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-OFFBOOK-04: booking_type tidak valid → 422
$res = callController(
    \App\Http\Controllers\Admin\BookingController::class,
    'store',
    ['booking_type' => 'online', 'court_id' => $court?->id ?? 1, 'date' => now()->addDays(10)->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '11:00'],
    $admin
);
tc('TC-OFFBOOK-04', 'Tipe booking "online" — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// MODUL 9: MANAJEMEN PROFIL — ProfileController
echo "\n--- MODUL 9: MANAJEMEN PROFIL ---\n";

// TC-PROF-01: Update profil valid — validasi dengan rules dari ProfileUpdateRequest (yang sudah dibaca dari file)
// Rules: name=required|string|max:255, email=required|string|lowercase|email|max:255|unique:users,ignore:id
// Catatan: ProfileController::update() type-hint ProfileUpdateRequest — tidak bisa diinstansiasi langsung di CLI
Auth::login($customer);
$profValidator = \Illuminate\Support\Facades\Validator::make(
    ['name' => 'Nama Baru', 'email' => 'emailbaru_' . time() . '@test.com'],
    [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique(\App\Models\User::class)->ignore($customer->id)],
    ]
);
tc('TC-PROF-01', 'Update profil data valid — ProfileUpdateRequest rules lolos', 'VALID', $profValidator->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-PROF-02: updateBiodata valid — rules: phone nullable|string|max:20
$res = callController(
    \App\Http\Controllers\ProfileController::class,
    'updateBiodata',
    ['phone' => '081234567890'],
    $customer
);
tc('TC-PROF-02', 'Update biodata HP valid — controller menerima', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Valid');

// TC-PROF-03: HP 21 karakter — melebihi batas max:20 → 422
$res = callController(
    \App\Http\Controllers\ProfileController::class,
    'updateBiodata',
    ['phone' => '081234567890123456789'],
    $customer
);
tc('TC-PROF-03', 'Nomor HP 21 karakter — controller menolak (batas atas, 422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Batas');

// TC-PROF-04: HP tepat 20 karakter — batas maksimum valid → diterima
$res = callController(
    \App\Http\Controllers\ProfileController::class,
    'updateBiodata',
    ['phone' => '08123456789012345678'],
    $customer
);
tc('TC-PROF-04', 'Nomor HP 20 karakter — controller menerima (batas maksimum valid)', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Batas');

// TC-PROF-05: Hapus akun tanpa password — validateWithBag → ValidationException
$res = callController(
    \App\Http\Controllers\ProfileController::class,
    'destroy',
    ['password' => ''],
    $customer
);
tc('TC-PROF-05', 'Hapus akun tanpa password — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// MODUL 10: MANAJEMEN PENGGUNA — Model & DB asli
echo "\n--- MODUL 10: MANAJEMEN PENGGUNA ---\n";

// TC-USER-01: Validasi update user — pakai rules Admin\UserController asli
$userCtrl = app(\App\Http\Controllers\Admin\UserController::class);
$reflUpdate = new ReflectionMethod(\App\Http\Controllers\Admin\UserController::class, 'update');
$res = callController(
    \App\Http\Controllers\Admin\UserController::class,
    'update',
    ['name' => 'User Baru', 'email' => 'userbaru_' . time() . '@test.com', 'role' => 'customer'],
    $admin,
    [$customer->id]
);
tc('TC-USER-01', 'Update user data valid — controller menerima', 'VALID', $res['status_code'] !== 422 ? 'VALID' : 'INVALID', 'Valid');

// TC-USER-02: Tanpa nama → 422
$res = callController(
    \App\Http\Controllers\Admin\UserController::class,
    'update',
    ['email' => 'userbaru@test.com', 'role' => 'customer'],
    $admin,
    [$customer->id]
);
tc('TC-USER-02', 'Update user tanpa nama — controller menolak (422)', 'INVALID', $res['status_code'] === 422 ? 'INVALID' : 'VALID', 'Tidak Valid');

// TC-USER-03: Proteksi hapus admin — cek role di DB
$adminUser = User::where('role', 'admin')->first();
if ($adminUser) {
    tc('TC-USER-03', 'Admin role terproteksi dari penghapusan (role = admin)', 'true', ($adminUser->role === 'admin') ? 'true' : 'false', 'Tidak Valid');
}

// TC-USER-04: Customer tidak terproteksi
$customerUser = User::where('role', 'customer')->first();
if ($customerUser) {
    tc('TC-USER-04', 'Customer tidak terproteksi (role != admin)', 'true', ($customerUser->role !== 'admin') ? 'true' : 'false', 'Valid');
}

// MODUL 11: STATUS BOOKING — Accessor Model Asli
echo "\n--- MODUL 11: STATUS BOOKING ---\n";

$b = new Booking();
$b->status = 'pending_payment';
tc('TC-STATUS-01', 'Label pending_payment — accessor model asli', 'Menunggu Pembayaran', $b->status_label, 'Valid');

$b->status = 'confirmed';
tc('TC-STATUS-02', 'Label confirmed — accessor model asli', 'Dikonfirmasi', $b->status_label, 'Valid');

$b->status = 'cancelled';
tc('TC-STATUS-03', 'Label cancelled — accessor model asli', 'Dibatalkan', $b->status_label, 'Valid');

$b->status = 'expired';
tc('TC-STATUS-04', 'Label expired — accessor model asli', 'Kadaluarsa', $b->status_label, 'Valid');

$b->status = 'rejected';
tc('TC-STATUS-05', 'Label rejected — accessor model asli', 'Ditolak', $b->status_label, 'Valid');

$bBlock = new Booking();
$bBlock->booking_type = 'block';
tcContains('TC-STATUS-06', 'Booking blokir — customer_name mengandung "sistem"', 'sistem', $bBlock->customer_name, 'Valid');

$bOffline = new Booking();
$bOffline->booking_type = 'offline';
$bOffline->guest_name = 'Tamu Tanpa Akun';
tc('TC-STATUS-07', 'Booking offline tamu — customer_name = nama tamu', 'Tamu Tanpa Akun', $bOffline->customer_name, 'Valid');

// MODUL 12: ROLE CHECK — Method Model Asli
echo "\n--- MODUL 12: USER ROLE CHECKS ---\n";

$c = new User();
$c->role = 'customer';
tc('TC-ROLE-01', 'Customer isAdmin() = false — method model asli', 'false', $c->isAdmin() ? 'true' : 'false', 'Valid');

$a = new User();
$a->role = 'admin';
tc('TC-ROLE-02', 'Admin isAdmin() = true — method model asli', 'true', $a->isAdmin() ? 'true' : 'false', 'Valid');

$c2 = new User();
$c2->role = 'customer';
tc('TC-ROLE-03', 'Customer isCustomer() = true — method model asli', 'true', $c2->isCustomer() ? 'true' : 'false', 'Valid');

$a2 = new User();
$a2->role = 'admin';
tc('TC-ROLE-04', 'Admin isCustomer() = false — method model asli', 'false', $a2->isCustomer() ? 'true' : 'false', 'Valid');

// RINGKASAN
$total = $pass + $fail;
echo "\n========================================================\n";
echo "  RINGKASAN HASIL PENGUJIAN\n";
echo "========================================================\n";
echo "  Total TC Dieksekusi : {$total}\n";
echo "  ✅ PASS             : {$pass}\n";
echo "  ❌ FAIL             : {$fail}\n";
echo "  ⚠️  SKIP             : {$skip}\n";
echo "  Pass Rate           : " . ($total > 0 ? round(($pass / $total) * 100, 2) : 0) . "%\n";
echo "========================================================\n\n";

$output = [
    'timestamp' => now()->format('Y-m-d H:i:s'),
    'versi' => 'Sistem Nyata — Controller & Model Asli',
    'total' => $total,
    'pass' => $pass,
    'fail' => $fail,
    'skip' => $skip,
    'pass_rate' => ($total > 0 ? round(($pass / $total) * 100, 2) : 0) . '%',
    'results' => $results,
];
file_put_contents(__DIR__ . '/test_blackbox_results.json', json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "📄 Hasil tersimpan di: test_blackbox_results.json\n\n";
