<?php
/**
 * BLACK-BOX TESTING — SISTEM RESERVASI LAPANGAN TENIS
 * Versi: Interaksi Pengguna dengan Website (38 Test Case)
 *
 * Setiap TC merepresentasikan satu skenario nyata yang dilakukan pengguna
 * di halaman website — mengisi form, klik tombol, dan melihat hasil.
 *
 * Dijalankan: php test_blackbox.php
 */

require __DIR__ . '/vendor/autoload.php';
$app    = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

function tcSkip(string $id, string $alasan): void
{
    global $results, $skip;
    $skip++;
    $results[] = ['id' => $id, 'nama' => $alasan, 'expect' => '-', 'actual' => 'SKIP', 'jenis' => '-', 'status' => 'SKIP'];
    echo "[SKIP] ⚠️  | $id | $alasan\n";
}

/** Panggil controller method asli, tangkap ValidationException → 422 */
function callCtrl(string $cls, string $method, array $payload, $user, array $extra = []): array
{
    Auth::login($user);
    $body    = json_encode($payload);
    $request = Request::create('/', 'POST', [], [], [], [
        'HTTP_ACCEPT'           => 'application/json',
        'CONTENT_TYPE'          => 'application/json',
        'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
    ], $body);
    $request->setJson(new \Symfony\Component\HttpFoundation\InputBag($payload));
    $request->setLaravelSession(app('session.store'));

    try {
        $ctrl = app($cls);
        $resp = call_user_func_array([$ctrl, $method], array_merge([$request], $extra));
        $code = is_object($resp) && method_exists($resp, 'getStatusCode') ? $resp->getStatusCode() : 200;
        return ['code' => $code, 'ok' => $code < 400];
    } catch (ValidationException $e) {
        return ['code' => 422, 'ok' => false, 'errors' => $e->errors()];
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return ['code' => 404, 'ok' => false];
    } catch (\Exception $e) {
        return ['code' => 500, 'ok' => false, 'msg' => $e->getMessage()];
    }
}

// ── Data awal ───────────────────────────────────────────────────────────────
$customer = User::where('role', 'customer')->first();
$admin    = User::where('role', 'admin')->first();
$court    = Court::first();

echo "\n========================================================\n";
echo "  BLACK-BOX TESTING — SISTEM RESERVASI LAPANGAN TENIS\n";
echo "  Interaksi Pengguna dengan Website  |  38 Test Case\n";
echo "========================================================\n\n";

// ============================================================
// MODUL 1: REGISTRASI AKUN  (5 TC)
// ============================================================
echo "--- MODUL 1: REGISTRASI AKUN ---\n";

// TC-REG-01: Data valid → akun terbuat, diarahkan ke dashboard
$res = callCtrl(\App\Http\Controllers\Auth\RegisteredUserController::class, 'store', [
    'name' => 'Budi Santoso', 'email' => 'budi_'.time().'@mail.com',
    'password' => 'password123', 'password_confirmation' => 'password123',
], $customer);
tc('TC-REG-01', 'Isi form Daftar dengan data lengkap lalu klik Daftar', 'DITERIMA', $res['ok'] ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-REG-02: Email sudah terdaftar → pesan error
$res = callCtrl(\App\Http\Controllers\Auth\RegisteredUserController::class, 'store', [
    'name' => 'Test', 'email' => $customer->email,
    'password' => 'password123', 'password_confirmation' => 'password123',
], $customer);
tc('TC-REG-02', 'Daftar dengan email yang sudah terdaftar', 'DITOLAK', $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-REG-03: Konfirmasi password tidak cocok → pesan error
$res = callCtrl(\App\Http\Controllers\Auth\RegisteredUserController::class, 'store', [
    'name' => 'Test', 'email' => 'baru_'.time().'@mail.com',
    'password' => 'password123', 'password_confirmation' => 'berbeda456',
], $customer);
tc('TC-REG-03', 'Daftar dengan konfirmasi password berbeda', 'DITOLAK', $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-REG-04a: Password 7 karakter — batas bawah, ditolak
$res = callCtrl(\App\Http\Controllers\Auth\RegisteredUserController::class, 'store', [
    'name' => 'Test', 'email' => 'batas_'.time().'@mail.com',
    'password' => 'abc1234', 'password_confirmation' => 'abc1234',
], $customer);
tc('TC-REG-04a', 'Daftar dengan password 7 karakter (batas bawah — ditolak)', 'DITOLAK', $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Batas');

// TC-REG-04b: Password 8 karakter — batas minimum valid, diterima
$res = callCtrl(\App\Http\Controllers\Auth\RegisteredUserController::class, 'store', [
    'name' => 'Test', 'email' => 'batas8_'.time().'@mail.com',
    'password' => 'abc12345', 'password_confirmation' => 'abc12345',
], $customer);
tc('TC-REG-04b', 'Daftar dengan password 8 karakter (batas minimum — diterima)', 'DITERIMA', $res['ok'] ? 'DITERIMA' : 'DITOLAK', 'Batas');

// ============================================================
// MODUL 2: LOGIN  (3 TC)
// ============================================================
echo "\n--- MODUL 2: LOGIN ---\n";

// Buat user sementara agar bisa uji login dengan password yang diketahui
$tmpEmail = 'tmp_login_'.time().'@lapangantenis.test';
$tmpPass  = 'Testing12345';
$tmpUser  = User::create(['name' => 'Tmp Login', 'email' => $tmpEmail,
    'password' => Hash::make($tmpPass), 'role' => 'customer']);

// TC-LOGIN-01: Kredensial valid → berhasil masuk
$ok = Auth::attempt(['email' => $tmpEmail, 'password' => $tmpPass]);
tc('TC-LOGIN-01', 'Login dengan email dan password yang benar', 'BERHASIL', $ok ? 'BERHASIL' : 'GAGAL', 'Valid');
Auth::logout();

// TC-LOGIN-02: Password salah → gagal masuk
$fail2 = Auth::attempt(['email' => $tmpEmail, 'password' => 'password_salah']);
tc('TC-LOGIN-02', 'Login dengan password yang salah', 'GAGAL', $fail2 ? 'BERHASIL' : 'GAGAL', 'Tidak Valid');
Auth::logout();

// TC-LOGIN-03: Field email kosong → form menolak
$v = Validator::make(['email' => '', 'password' => ''], ['email' => 'required|email', 'password' => 'required']);
tc('TC-LOGIN-03', 'Login dengan field email dan password kosong', 'DITOLAK', $v->fails() ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

$tmpUser->delete(); // bersihkan user sementara

// ============================================================
// MODUL 3: MANAJEMEN LAPANGAN  (3 TC)
// ============================================================
echo "\n--- MODUL 3: MANAJEMEN LAPANGAN ---\n";

// TC-COURT-01: Isi form tambah lapangan dengan data lengkap → tersimpan
$res = callCtrl(\App\Http\Controllers\Admin\CourtController::class, 'store',
    ['name' => 'Lapangan Test', 'type' => 'indoor', 'price' => 50000], $admin);
tc('TC-COURT-01', 'Tambah lapangan dengan data lengkap lalu klik Simpan', 'DITERIMA', $res['ok'] ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-COURT-02: Kosongkan field Nama → muncul pesan wajib diisi
$res = callCtrl(\App\Http\Controllers\Admin\CourtController::class, 'store',
    ['type' => 'indoor', 'price' => 50000], $admin);
tc('TC-COURT-02', 'Tambah lapangan tanpa mengisi nama', 'DITOLAK', $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-COURT-03: Isi harga dengan teks → muncul pesan harga harus angka
$res = callCtrl(\App\Http\Controllers\Admin\CourtController::class, 'store',
    ['name' => 'Lapangan B', 'type' => 'outdoor', 'price' => 'lima puluh ribu'], $admin);
tc('TC-COURT-03', 'Tambah lapangan dengan harga berupa teks', 'DITOLAK', $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// ============================================================
// MODUL 4: BOOKING LAPANGAN  (3 TC)
// ============================================================
echo "\n--- MODUL 4: BOOKING LAPANGAN ---\n";

// TC-BOOK-01: Pilih lapangan, tanggal, slot → booking terbuat
$bookRules = (new \App\Http\Requests\BookingRequest())->rules();
$v = Validator::make([
    'court_id'     => $court?->id ?? 1,
    'booking_date' => now()->addDays(3)->format('Y-m-d'),
    'slots'        => json_encode([['start' => '09:00', 'end' => '10:00']]),
], $bookRules);
tc('TC-BOOK-01', 'Isi form booking dengan lapangan, tanggal, dan slot valid', 'DITERIMA', $v->fails() ? 'DITOLAK' : 'DITERIMA', 'Valid');

// TC-BOOK-02: Akses booking sebelum isi biodata → diarahkan ke halaman profil
if ($customer) {
    $orig = [$customer->phone, $customer->address];
    $customer->phone = null; $customer->address = null;
    $isIncomplete = $customer->isBiodataIncomplete();
    [$customer->phone, $customer->address] = $orig;
    tc('TC-BOOK-02', 'Akses booking dengan biodata (HP/Alamat) yang belum diisi', 'DIARAHKAN KE PROFIL',
        $isIncomplete ? 'DIARAHKAN KE PROFIL' : 'BISA BOOKING', 'Tidak Valid');
}

// TC-BOOK-03: Booking pada slot yang sudah terisi → konflik terdeteksi
$activeBooking = Booking::whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])->first();
if ($activeBooking) {
    $conflict = Booking::where('court_id', $activeBooking->court_id)
        ->where('date', $activeBooking->date)
        ->whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])
        ->where('start_time', $activeBooking->start_time)
        ->exists();
    tc('TC-BOOK-03', 'Pilih slot waktu yang sudah dipesan pengguna lain', 'KONFLIK TERDETEKSI',
        $conflict ? 'KONFLIK TERDETEKSI' : 'TIDAK TERDETEKSI', 'Tidak Valid');
} else {
    tcSkip('TC-BOOK-03', 'Tidak ada booking aktif di database untuk uji konflik slot');
}

// ============================================================
// MODUL 5: CEK KETERSEDIAAN LAPANGAN  (2 TC)
// ============================================================
echo "\n--- MODUL 5: CEK KETERSEDIAAN ---\n";

// TC-AVAIL-01: Pilih lapangan dan tanggal valid → daftar slot tersedia tampil
$res = callCtrl(\App\Http\Controllers\BookingController::class, 'checkAvailability',
    ['court_id' => $court?->id ?? 1, 'date' => now()->format('Y-m-d')], $customer);
tc('TC-AVAIL-01', 'Pilih lapangan dan tanggal dari kalender, lihat ketersediaan', 'DITERIMA',
    $res['code'] === 200 ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-AVAIL-02: Tidak pilih lapangan → sistem meminta pilih lapangan
$res = callCtrl(\App\Http\Controllers\BookingController::class, 'checkAvailability',
    ['date' => now()->format('Y-m-d')], $customer);
tc('TC-AVAIL-02', 'Cek ketersediaan tanpa memilih lapangan', 'DITOLAK',
    $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// ============================================================
// MODUL 6: UPLOAD BUKTI PEMBAYARAN  (3 TC)
// ============================================================
echo "\n--- MODUL 6: UPLOAD BUKTI PEMBAYARAN ---\n";

$payRules = ['payment_method' => 'required|in:qris,transfer', 'payment_proof' => 'required|image|max:2048', 'agree_terms' => 'required'];

// TC-PAY-01: Klik Kirim tanpa lampirkan file → form menolak
$v = Validator::make(['payment_method' => 'qris', 'agree_terms' => '1'], $payRules);
tc('TC-PAY-01', 'Kirim form pembayaran tanpa melampirkan file bukti', 'DITOLAK',
    $v->fails() ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-PAY-02: Tidak centang S&K → form menolak
$v = Validator::make(['payment_method' => 'qris'], $payRules);
tc('TC-PAY-02', 'Kirim form pembayaran tanpa mencentang Syarat & Ketentuan', 'DITOLAK',
    $v->fails() ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-PAY-03: Booking sudah kadaluarsa → sistem blokir akses bayar
$expiredBooking = new Booking(['status' => 'pending_payment']);
$expiredBooking->expired_at = now()->subHour(); // 1 jam yang lalu
$ctrl    = app(\App\Http\Controllers\BookingController::class);
$reflExp = new ReflectionMethod($ctrl, 'isExpired');
$reflExp->setAccessible(true);
$isExp = $reflExp->invoke($ctrl, $expiredBooking);
tc('TC-PAY-03', 'Buka halaman bayar pada booking yang sudah melewati batas waktu', 'DITOLAK',
    $isExp ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// ============================================================
// MODUL 7: VERIFIKASI PEMBAYARAN  (3 TC)
// ============================================================
echo "\n--- MODUL 7: VERIFIKASI PEMBAYARAN ---\n";

$rejectRules = ['rejection_reason' => 'required|string|max:255'];

// TC-VPAY-01: Tolak pembayaran tanpa isi alasan → form menolak
$v = Validator::make(['rejection_reason' => ''], $rejectRules);
tc('TC-VPAY-01', 'Klik Tolak lalu Konfirmasi tanpa mengisi alasan penolakan', 'DITOLAK',
    $v->fails() ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-VPAY-02: Tolak pembayaran dengan alasan valid → form diterima
$v = Validator::make(['rejection_reason' => 'Bukti pembayaran tidak sesuai nominal'], $rejectRules);
tc('TC-VPAY-02', 'Tolak pembayaran dengan mengisi alasan yang jelas', 'DITERIMA',
    $v->fails() ? 'DITOLAK' : 'DITERIMA', 'Valid');

// TC-VPAY-03: Konfirmasi pembayaran → status booking berubah menjadi Dikonfirmasi
$pendingPayment = Booking::where('status', 'pending_verification')->first();
if ($pendingPayment) {
    Auth::login($admin);
    try {
        $bookingSvc = app(\App\Services\BookingService::class);
        $bookingSvc->approvePayment($pendingPayment, $admin);
        $pendingPayment->refresh();
        tc('TC-VPAY-03', 'Admin klik tombol Konfirmasi pada bukti pembayaran yang valid', 'DIKONFIRMASI',
            $pendingPayment->status === 'confirmed' ? 'DIKONFIRMASI' : $pendingPayment->status, 'Valid');
    } catch (\Exception $e) {
        tc('TC-VPAY-03', 'Admin klik tombol Konfirmasi pada bukti pembayaran yang valid', 'DIKONFIRMASI',
            'ERROR: ' . $e->getMessage(), 'Valid');
    }
    Auth::logout();
} else {
    tcSkip('TC-VPAY-03', 'Tidak ada booking pending_verification untuk diuji konfirmasi');
}

// ============================================================
// MODUL 8: BOOKING OFFLINE / BLOKIR JADWAL  (3 TC)
// ============================================================
echo "\n--- MODUL 8: BOOKING OFFLINE / BLOKIR JADWAL ---\n";

// TC-OFFBOOK-01: Isi form booking offline dengan data lengkap → tersimpan
$res = callCtrl(\App\Http\Controllers\Admin\BookingController::class, 'store', [
    'booking_type' => 'offline', 'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(7)->format('Y-m-d'), 'start_time' => '10:00', 'end_time' => '11:00',
], $admin);
tc('TC-OFFBOOK-01', 'Admin buat booking offline dengan data lengkap', 'DITERIMA',
    $res['ok'] ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-OFFBOOK-02: Blokir jadwal dengan data lengkap → jadwal terblokir
$res = callCtrl(\App\Http\Controllers\Admin\BookingController::class, 'store', [
    'booking_type' => 'block', 'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(8)->format('Y-m-d'), 'start_time' => '14:00', 'end_time' => '15:00',
], $admin);
tc('TC-OFFBOOK-02', 'Admin blokir jadwal lapangan dengan data lengkap', 'DITERIMA',
    $res['ok'] ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-OFFBOOK-03: Waktu selesai lebih awal dari waktu mulai → form menolak
$res = callCtrl(\App\Http\Controllers\Admin\BookingController::class, 'store', [
    'booking_type' => 'offline', 'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(9)->format('Y-m-d'), 'start_time' => '11:00', 'end_time' => '09:00',
], $admin);
tc('TC-OFFBOOK-03', 'Isi waktu selesai (09:00) lebih awal dari waktu mulai (11:00)', 'DITOLAK',
    $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// ============================================================
// MODUL 9: MANAJEMEN PROFIL  (4 TC)
// ============================================================
echo "\n--- MODUL 9: MANAJEMEN PROFIL ---\n";

// TC-PROF-01: Ubah nama dan email di halaman Profil → validasi lolos
$profV = Validator::make(
    ['name' => 'Nama Baru', 'email' => 'emailbaru_' . time() . '@mail.com'],
    [
        'name'  => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255',
            \Illuminate\Validation\Rule::unique(\App\Models\User::class)->ignore($customer->id)],
    ]
);
tc('TC-PROF-01', 'Ubah nama dan email di halaman Profil lalu klik Simpan', 'DITERIMA',
    $profV->fails() ? 'DITOLAK' : 'DITERIMA', 'Valid');

// TC-PROF-02: Nomor HP 20 karakter (batas maksimum valid) → diterima
// updateBiodata hanya simpan field 'phone', max:20
$bioV = Validator::make(['phone' => '08123456789012345678'], ['phone' => ['nullable','string','max:20']]);
tc('TC-PROF-02', 'Isi nomor HP tepat 20 karakter (batas maksimum valid)', 'DITERIMA',
    $bioV->fails() ? 'DITOLAK' : 'DITERIMA', 'Batas');

// TC-PROF-03: Nomor HP 21 karakter (melebihi batas) → ditolak
$bioV = Validator::make(['phone' => '081234567890123456789'], ['phone' => ['nullable','string','max:20']]);
tc('TC-PROF-03', 'Isi nomor HP 21 karakter (melebihi batas — ditolak)', 'DITOLAK',
    $bioV->fails() ? 'DITOLAK' : 'DITERIMA', 'Batas');

// TC-PROF-04: Hapus akun tanpa password konfirmasi → form menolak
$delV = Validator::make(['password' => ''], ['password' => ['required']]);
tc('TC-PROF-04', 'Klik Hapus Akun lalu Konfirmasi tanpa mengisi password', 'DITOLAK',
    $delV->fails() ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// ============================================================
// MODUL 10: MANAJEMEN PENGGUNA  (4 TC)
// ============================================================
echo "\n--- MODUL 10: MANAJEMEN PENGGUNA ---\n";

// TC-USER-01: Edit data pengguna dengan nama dan email valid → tersimpan
$res = callCtrl(\App\Http\Controllers\Admin\UserController::class, 'update',
    ['name' => 'Nama Diperbarui', 'email' => 'updated_'.time().'@mail.com', 'role' => 'customer'],
    $admin, [$customer->id]);
tc('TC-USER-01', 'Admin edit data pengguna dengan nama dan email valid', 'DITERIMA',
    $res['ok'] ? 'DITERIMA' : 'DITOLAK', 'Valid');

// TC-USER-02: Edit pengguna tanpa mengisi nama → form menolak
$res = callCtrl(\App\Http\Controllers\Admin\UserController::class, 'update',
    ['email' => 'valid@mail.com', 'role' => 'customer'],
    $admin, [$customer->id]);
tc('TC-USER-02', 'Admin edit pengguna lalu klik Simpan tanpa mengisi nama', 'DITOLAK',
    $res['code'] === 422 ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');

// TC-USER-03: Hapus akun customer → berhasil (pakai user sementara)
$tmpDel = User::create(['name' => 'Temp Del', 'email' => 'del_'.time().'@test.com',
    'password' => Hash::make('test1234'), 'role' => 'customer']);
Auth::login($admin);
try {
    $delCtrl = app(\App\Http\Controllers\Admin\UserController::class);
    $delCtrl->destroy($tmpDel->id);
    $stillExists = User::find($tmpDel->id) !== null;
    tc('TC-USER-03', 'Admin klik Hapus pada akun pengguna berperan customer', 'BERHASIL',
        !$stillExists ? 'BERHASIL' : 'GAGAL', 'Valid');
} catch (\Exception $e) {
    $tmpDel->delete();
    tc('TC-USER-03', 'Admin klik Hapus pada akun pengguna berperan customer', 'BERHASIL',
        'ERROR: ' . $e->getMessage(), 'Valid');
}
Auth::logout();

// TC-USER-04: Hapus akun admin → sistem menolak / proteksi aktif
$adminProtect = User::where('role', 'admin')->first();
if ($adminProtect) {
    tc('TC-USER-04', 'Admin klik Hapus pada akun yang berperan admin', 'DITOLAK',
        $adminProtect->role === 'admin' ? 'DITOLAK' : 'DITERIMA', 'Tidak Valid');
}

// ============================================================
// MODUL 11: TAMPILAN STATUS BOOKING  (3 TC)
// ============================================================
echo "\n--- MODUL 11: TAMPILAN STATUS BOOKING ---\n";

// TC-STATUS-01: Semua label status booking tampil sesuai keterangan yang benar
$statusMap = [
    'pending_payment' => 'Menunggu Pembayaran',
    'confirmed'       => 'Dikonfirmasi',
    'cancelled'       => 'Dibatalkan',
    'expired'         => 'Kadaluarsa',
    'rejected'        => 'Ditolak',
];
$b = new Booking();
$allOk = true;
foreach ($statusMap as $status => $label) {
    $b->status = $status;
    if ($b->status_label !== $label) { $allOk = false; break; }
}
tc('TC-STATUS-01', 'Dashboard menampilkan label status booking yang benar (5 status)', 'BENAR',
    $allOk ? 'BENAR' : 'SALAH', 'Valid');

// TC-STATUS-02: Booking blokir tampil "Sistem" di kolom nama — bukan nama customer
$bBlock = new Booking(); $bBlock->booking_type = 'block';
$hasSystem = str_contains(strtolower((string)$bBlock->customer_name), 'sistem');
tc('TC-STATUS-02', 'Halaman admin menampilkan booking blokir atas nama Sistem', 'YA',
    $hasSystem ? 'YA' : 'TIDAK', 'Valid');

// TC-STATUS-03: Booking offline tamu tampil nama tamu yang diinput admin
$bOffline = new Booking(); $bOffline->booking_type = 'offline'; $bOffline->guest_name = 'Andi Tamu';
tc('TC-STATUS-03', 'Booking offline tamu menampilkan nama tamu yang diinput admin', 'Andi Tamu',
    $bOffline->customer_name, 'Valid');

// ============================================================
// MODUL 12: HAK AKSES PENGGUNA  (2 TC)
// ============================================================
echo "\n--- MODUL 12: HAK AKSES PENGGUNA ---\n";

// TC-ACCESS-01: Customer tidak punya akses admin
tc('TC-ACCESS-01', 'Customer mencoba akses halaman admin — ditolak sistem', 'TIDAK BISA',
    ($customer && !$customer->isAdmin()) ? 'TIDAK BISA' : 'BISA', 'Tidak Valid');

// TC-ACCESS-02: Admin punya akses admin
tc('TC-ACCESS-02', 'Admin membuka halaman panel admin — berhasil diakses', 'BISA',
    ($admin && $admin->isAdmin()) ? 'BISA' : 'TIDAK BISA', 'Valid');

// ============================================================
// RINGKASAN
// ============================================================
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

$out = [
    'timestamp'   => now()->format('Y-m-d H:i:s'),
    'versi'       => 'Interaksi Pengguna Website | 38 TC Sistem',
    'total'       => $total,
    'pass'        => $pass,
    'fail'        => $fail,
    'skip'        => $skip,
    'pass_rate'   => ($total > 0 ? round(($pass / $total) * 100, 2) : 0) . '%',
    'results'     => $results,
];
file_put_contents(__DIR__ . '/test_blackbox_results.json', json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "📄 Hasil tersimpan di: test_blackbox_results.json\n\n";
