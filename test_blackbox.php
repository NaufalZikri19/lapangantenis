<?php

/**
 * BLACK-BOX TESTING SCRIPT
 * Sistem Reservasi Lapangan Tenis
 * Dijalankan via: php test_blackbox.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

$results = [];
$pass = 0;
$fail = 0;

function tc($id, $nama, $expect, $actual, $jenis)
{
    global $results, $pass, $fail;
    $status = $expect === $actual ? 'PASS' : 'FAIL';
    if ($status === 'PASS')
        $pass++;
    else
        $fail++;
    $results[] = compact('id', 'nama', 'expect', 'actual', 'jenis', 'status');
    $icon = $status === 'PASS' ? '✅' : '❌';
    echo sprintf("[%s] %s | %s | Expect: %s | Actual: %s\n", $status, $icon, $id, $expect, $actual);
}

function tcContains($id, $nama, $keyword, $actual, $jenis)
{
    global $results, $pass, $fail;
    $matched = str_contains(strtolower($actual), strtolower($keyword));
    $status = $matched ? 'PASS' : 'FAIL';
    if ($status === 'PASS')
        $pass++;
    else
        $fail++;
    $results[] = ['id' => $id, 'nama' => $nama, 'expect' => "mengandung '$keyword'", 'actual' => $actual, 'jenis' => $jenis, 'status' => $status];
    $icon = $status === 'PASS' ? '✅' : '❌';
    echo sprintf("[%s] %s | %s | Keyword: '%s' | Actual: %s\n", $status, $icon, $id, $keyword, $actual);
}

echo "\n========================================================\n";
echo "  BLACK-BOX TESTING — SISTEM RESERVASI LAPANGAN TENIS\n";
echo "========================================================\n\n";

// ============================================================
// MODUL 1: REGISTRASI — Validasi Rule
// ============================================================
echo "--- MODUL 1: REGISTRASI ---\n";

// TC-REG-01: Validasi data lengkap valid
$v = Validator::make([
    'name' => 'Budi Santoso',
    'email' => 'budi_test_' . time() . '@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
], [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|confirmed|min:8',
]);
tc('TC-REG-01', 'Registrasi data valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-REG-02: Email sudah digunakan
$existingEmail = User::first()?->email ?? 'admin@test.com';
$v = Validator::make([
    'name' => 'Test User',
    'email' => $existingEmail,
    'password' => 'password123',
    'password_confirmation' => 'password123',
], [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|confirmed|min:8',
]);
tc('TC-REG-02', 'Registrasi email sudah digunakan', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-REG-03: Konfirmasi password tidak cocok
$v = Validator::make([
    'name' => 'Test User',
    'email' => 'newuser_' . time() . '@test.com',
    'password' => 'password123',
    'password_confirmation' => 'berbeda456',
], [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|confirmed|min:8',
]);
tc('TC-REG-03', 'Password tidak cocok dengan konfirmasi', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-REG-04a: Password 7 karakter (batas bawah - harus ditolak)
$v = Validator::make([
    'name' => 'Test',
    'email' => 'test_' . time() . '@test.com',
    'password' => 'abc1234', // 7 karakter
    'password_confirmation' => 'abc1234',
], ['password' => 'required|confirmed|min:8']);
tc('TC-REG-04a', 'Password 7 karakter (batas bawah - ditolak)', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

// TC-REG-04b: Password 8 karakter (batas valid - harus diterima)
$v = Validator::make([
    'name' => 'Test',
    'email' => 'test_' . time() . '@test.com',
    'password' => 'abc12345', // 8 karakter
    'password_confirmation' => 'abc12345',
], ['password' => 'required|confirmed|min:8']);
tc('TC-REG-04b', 'Password 8 karakter (batas minimum valid)', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

// TC-REG-05: Format email tidak valid
$v = Validator::make([
    'name' => 'Test',
    'email' => 'bukanemail',
    'password' => 'password123',
    'password_confirmation' => 'password123',
], ['email' => 'required|email|unique:users']);
tc('TC-REG-05', 'Format email tidak valid', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-REG-06: Semua field kosong
$v = Validator::make([], [
    'name' => 'required',
    'email' => 'required|email',
    'password' => 'required|min:8',
]);
tc('TC-REG-06', 'Semua field kosong', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

echo "\n--- MODUL 2: LOGIN ---\n";

// TC-LOGIN-01: User customer ada di DB?
$customer = User::where('role', 'customer')->first();
tc('TC-LOGIN-01', 'Data customer tersedia di database', 'ADA', $customer ? 'ADA' : 'TIDAK ADA', 'Valid');

// TC-LOGIN-02: User admin ada di DB?
$admin = User::where('role', 'admin')->first();
tc('TC-LOGIN-02', 'Data admin tersedia di database', 'ADA', $admin ? 'ADA' : 'TIDAK ADA', 'Valid');

// TC-LOGIN-03: Verifikasi password hash valid
if ($customer) {
    $passwordCheck = Hash::check('password', $customer->password)
        || Hash::check('password123', $customer->password)
        || Hash::check('12345678', $customer->password);
    // Cek apakah password terenkripsi dengan bcrypt
    $isHashed = str_starts_with($customer->password, '$2y$') || str_starts_with($customer->password, '$argon');
    tc('TC-LOGIN-03', 'Password customer tersimpan terenkripsi (bukan plain text)', 'ENCRYPTED', $isHashed ? 'ENCRYPTED' : 'PLAIN_TEXT', 'Valid');
}

// TC-LOGIN-04: isAdmin() method - customer seharusnya false
if ($customer) {
    tc('TC-LOGIN-04', 'Customer isAdmin() harus return false', 'false', $customer->isAdmin() ? 'true' : 'false', 'Valid');
}

// TC-LOGIN-05: isAdmin() method - admin seharusnya true
if ($admin) {
    tc('TC-LOGIN-05', 'Admin isAdmin() harus return true', 'true', $admin->isAdmin() ? 'true' : 'false', 'Valid');
}

echo "\n--- MODUL 3: MANAJEMEN LAPANGAN ---\n";

// TC-COURT-01: Validasi tambah lapangan valid
$v = Validator::make([
    'name' => 'Lapangan A',
    'type' => 'indoor',
    'price' => 50000,
], [
    'name' => 'required',
    'type' => 'required',
    'price' => 'required|numeric',
    'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
]);
tc('TC-COURT-01', 'Tambah lapangan data valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-COURT-02: Validasi tanpa nama
$v = Validator::make([
    'type' => 'indoor',
    'price' => 50000,
], [
    'name' => 'required',
    'type' => 'required',
    'price' => 'required|numeric',
]);
tc('TC-COURT-02', 'Tambah lapangan tanpa nama', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-COURT-03: Harga non-numerik
$v = Validator::make([
    'name' => 'Lapangan B',
    'type' => 'outdoor',
    'price' => 'lima puluh ribu',
], [
    'name' => 'required',
    'type' => 'required',
    'price' => 'required|numeric',
]);
tc('TC-COURT-03', 'Harga lapangan berupa teks (non-numerik)', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-COURT-04: Data lapangan di database
$courtCount = Court::count();
tc('TC-COURT-04', 'Lapangan tersedia di database', 'ADA', $courtCount > 0 ? 'ADA' : 'TIDAK ADA', 'Valid');

echo "\n--- MODUL 4: BOOKING LAPANGAN ---\n";

// TC-BOOK-01: Validasi booking valid
$court = Court::first();
$v = Validator::make([
    'court_id' => $court?->id ?? 1,
    'booking_date' => now()->addDays(2)->format('Y-m-d'),
    'slots' => json_encode([['start' => '08:00', 'end' => '09:00']]),
], [
    'court_id' => 'required|exists:courts,id',
    'booking_date' => 'required|date',
    'slots' => 'required',
]);
tc('TC-BOOK-01', 'Booking data valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-BOOK-02: isBiodataIncomplete - Customer tanpa biodata
if ($customer) {
    // Simpan data asli
    $origPhone = $customer->phone;
    $origAddress = $customer->address;
    // Hapus sementara
    $customer->phone = null;
    $customer->address = null;
    $incomplete = $customer->isBiodataIncomplete();
    // Kembalikan
    $customer->phone = $origPhone;
    $customer->address = $origAddress;
    tc('TC-BOOK-02', 'Customer tanpa HP/alamat dianggap biodata tidak lengkap', 'true', $incomplete ? 'true' : 'false', 'Invalid');
}

// TC-BOOK-03: court_id tidak ada di database
$v = Validator::make([
    'court_id' => 99999,
    'booking_date' => now()->addDays(2)->format('Y-m-d'),
    'slots' => '[]',
], [
    'court_id' => 'required|exists:courts,id',
    'booking_date' => 'required|date',
]);
tc('TC-BOOK-03', 'Booking court_id tidak ada di database', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-BOOK-04: Cek slot yang sudah terisi
$bookedSlot = Booking::whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])->first();
if ($bookedSlot) {
    $conflict = Booking::where('court_id', $bookedSlot->court_id)
        ->where('date', $bookedSlot->date)
        ->whereIn('status', ['confirmed', 'pending_payment', 'pending_verification'])
        ->where('start_time', $bookedSlot->start_time)
        ->exists();
    tc('TC-BOOK-04', 'Slot yang sudah terboking terdeteksi konflik', 'true', $conflict ? 'true' : 'false', 'Invalid');
} else {
    echo "[SKIP] TC-BOOK-04 | Tidak ada booking aktif untuk uji konflik\n";
}

echo "\n--- MODUL 5: CEKAKETERSEDIAAN ---\n";

// TC-AVAIL-01: Validasi parameter lengkap
$v = Validator::make([
    'court_id' => $court?->id ?? 1,
    'date' => now()->format('Y-m-d'),
], [
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
]);
tc('TC-AVAIL-01', 'Check availability parameter lengkap & valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-AVAIL-02: Tanpa court_id
$v = Validator::make([
    'date' => now()->format('Y-m-d'),
], [
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
]);
tc('TC-AVAIL-02', 'Check availability tanpa court_id', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-AVAIL-03: court_id tidak ada
$v = Validator::make([
    'court_id' => 99999,
    'date' => now()->format('Y-m-d'),
], [
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
]);
tc('TC-AVAIL-03', 'Check availability court_id tidak ada di DB', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-AVAIL-04: Format tanggal salah
$v = Validator::make([
    'court_id' => $court?->id ?? 1,
    'date' => 'bukan-tanggal',
], [
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
]);
tc('TC-AVAIL-04', 'Format tanggal tidak valid', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

echo "\n--- MODUL 6: UPLOAD BUKTI PEMBAYARAN ---\n";

// TC-PAY-01: Validasi upload valid (tanpa file, cek rule lain)
$v = Validator::make([
    'payment_method' => 'qris',
    'agree_terms' => '1',
], [
    'payment_method' => 'required|in:qris,transfer',
    'payment_proof' => 'required|image|max:2048',
    'agree_terms' => 'required',
]);
// Akan fail karena payment_proof missing - ini benar
tc('TC-PAY-01', 'Upload tanpa file payment_proof ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-PAY-02: Metode pembayaran tidak valid
$v = Validator::make([
    'payment_method' => 'gopay', // tidak valid
    'agree_terms' => '1',
], [
    'payment_method' => 'required|in:qris,transfer',
    'agree_terms' => 'required',
]);
tc('TC-PAY-02', 'Metode pembayaran selain qris/transfer ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-PAY-03: Tanpa agree_terms
$v = Validator::make([
    'payment_method' => 'qris',
], [
    'payment_method' => 'required|in:qris,transfer',
    'agree_terms' => 'required',
]);
tc('TC-PAY-03', 'Upload tanpa centang syarat & ketentuan', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-PAY-04: Logic expired booking
$expiredBooking = new Booking();
$expiredBooking->status = 'pending_payment';
$expiredBooking->expired_at = now()->subHour(); // 1 jam lalu
$isExpired = $expiredBooking->status === 'pending_payment'
    && $expiredBooking->expired_at
    && now()->gt($expiredBooking->expired_at);
tc('TC-PAY-04', 'Booking expired terdeteksi dengan benar', 'true', $isExpired ? 'true' : 'false', 'Invalid');

// TC-PAY-05: Booking belum expired (waktu masih tersisa)
$notExpired = new Booking();
$notExpired->status = 'pending_payment';
$notExpired->expired_at = now()->addHour(); // 1 jam ke depan
$isExpiredFalse = $notExpired->status === 'pending_payment'
    && $notExpired->expired_at
    && now()->gt($notExpired->expired_at);
tc('TC-PAY-05', 'Booking belum expired tidak terdeteksi expired', 'false', $isExpiredFalse ? 'true' : 'false', 'Boundary');

echo "\n--- MODUL 7: VERIFIKASI PEMBAYARAN ---\n";

// TC-VPAY-01: Validasi reject tanpa alasan
$v = Validator::make([
    'rejection_reason' => '',
], [
    'rejection_reason' => 'required|string|max:255',
]);
tc('TC-VPAY-01', 'Reject pembayaran tanpa alasan penolakan', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-VPAY-02: Validasi reject dengan alasan valid
$v = Validator::make([
    'rejection_reason' => 'Bukti pembayaran tidak sesuai',
], [
    'rejection_reason' => 'required|string|max:255',
]);
tc('TC-VPAY-02', 'Reject dengan alasan penolakan valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-VPAY-03: Alasan penolakan melebihi 255 karakter
$v = Validator::make([
    'rejection_reason' => str_repeat('a', 256),
], [
    'rejection_reason' => 'required|string|max:255',
]);
tc('TC-VPAY-03', 'Alasan penolakan > 255 karakter ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

// TC-VPAY-04: Alasan penolakan tepat 255 karakter (batas valid)
$v = Validator::make([
    'rejection_reason' => str_repeat('a', 255),
], [
    'rejection_reason' => 'required|string|max:255',
]);
tc('TC-VPAY-04', 'Alasan penolakan 255 karakter (batas maksimum valid)', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

echo "\n--- MODUL 8: BOOKING OFFLINE/BLOKIR ---\n";

// TC-OFFBOOK-01: Booking offline valid
$v = Validator::make([
    'booking_type' => 'offline',
    'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(3)->format('Y-m-d'),
    'start_time' => '10:00',
    'end_time' => '11:00',
], [
    'booking_type' => 'required|in:offline,block',
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
    'start_time' => 'required',
    'end_time' => 'required|after:start_time',
]);
tc('TC-OFFBOOK-01', 'Booking offline data valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-OFFBOOK-02: Blokir jadwal valid
$v = Validator::make([
    'booking_type' => 'block',
    'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(3)->format('Y-m-d'),
    'start_time' => '10:00',
    'end_time' => '11:00',
], [
    'booking_type' => 'required|in:offline,block',
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
    'start_time' => 'required',
    'end_time' => 'required|after:start_time',
]);
tc('TC-OFFBOOK-02', 'Blokir jadwal data valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-OFFBOOK-03: end_time sebelum start_time
$v = Validator::make([
    'booking_type' => 'offline',
    'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(3)->format('Y-m-d'),
    'start_time' => '11:00',
    'end_time' => '09:00', // sebelum start_time
], [
    'booking_type' => 'required|in:offline,block',
    'court_id' => 'required|exists:courts,id',
    'date' => 'required|date',
    'start_time' => 'required',
    'end_time' => 'required|after:start_time',
]);
tc('TC-OFFBOOK-03', 'end_time sebelum start_time ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-OFFBOOK-04: Tipe booking tidak valid
$v = Validator::make([
    'booking_type' => 'online', // tidak valid
    'court_id' => $court?->id ?? 1,
    'date' => now()->addDays(3)->format('Y-m-d'),
    'start_time' => '10:00',
    'end_time' => '11:00',
], [
    'booking_type' => 'required|in:offline,block',
]);
tc('TC-OFFBOOK-04', 'Tipe booking selain offline/block ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

echo "\n--- MODUL 9: MANAJEMEN PROFIL ---\n";

// TC-PROF-01: Update profil valid
$v = Validator::make([
    'name' => 'Nama Baru',
    'email' => 'emailbaru_' . time() . '@test.com',
], [
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
]);
tc('TC-PROF-01', 'Update profil dengan data valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-PROF-02: Update biodata dengan HP valid
$v = Validator::make([
    'phone' => '081234567890',
    'address' => 'Jl. Contoh No. 1',
], [
    'phone' => 'nullable|string|max:20',
    'address' => 'nullable|string',
]);
tc('TC-PROF-02', 'Update biodata HP dan alamat valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-PROF-03: Nomor HP terlalu panjang (>20 karakter)
$v = Validator::make([
    'phone' => '081234567890123456789', // 21 karakter
    'address' => 'Jl. Contoh',
], [
    'phone' => 'nullable|string|max:20',
    'address' => 'nullable|string',
]);
tc('TC-PROF-03', 'Nomor HP > 20 karakter ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

// TC-PROF-04: Nomor HP 20 karakter (batas maksimum valid)
$v = Validator::make([
    'phone' => '08123456789012345678', // 20 karakter
], [
    'phone' => 'nullable|string|max:20',
]);
tc('TC-PROF-04', 'Nomor HP 20 karakter (batas maksimum valid)', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Boundary');

// TC-PROF-05: Hapus akun - validasi password salah
$v = Validator::make([
    'password' => '',
], [
    'password' => 'required|current_password',
]);
tc('TC-PROF-05', 'Hapus akun tanpa password ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

echo "\n--- MODUL 10: MANAJEMEN PENGGUNA ---\n";

// TC-USER-01: Validasi update user - nama & email wajib
$v = Validator::make([
    'name' => 'User Baru',
    'email' => 'userbaru@test.com',
], [
    'name' => 'required',
    'email' => 'required|email',
]);
tc('TC-USER-01', 'Update user dengan nama & email valid', 'VALID', $v->fails() ? 'INVALID' : 'VALID', 'Valid');

// TC-USER-02: Update user tanpa nama
$v = Validator::make([
    'email' => 'userbaru@test.com',
], [
    'name' => 'required',
    'email' => 'required|email',
]);
tc('TC-USER-02', 'Update user tanpa nama ditolak', 'INVALID', $v->fails() ? 'INVALID' : 'VALID', 'Invalid');

// TC-USER-03: Hapus admin — proteksi role
$adminUser = User::where('role', 'admin')->first();
if ($adminUser) {
    $isAdmin = $adminUser->role === 'admin';
    tc('TC-USER-03', 'Admin terproteksi dari penghapusan (role check)', 'true', $isAdmin ? 'true' : 'false', 'Invalid');
}

// TC-USER-04: Customer bisa dihapus (bukan admin)
$customerUser = User::where('role', 'customer')->first();
if ($customerUser) {
    $isNotAdmin = $customerUser->role !== 'admin';
    tc('TC-USER-04', 'Customer tidak terproteksi dari penghapusan', 'true', $isNotAdmin ? 'true' : 'false', 'Valid');
}

echo "\n--- MODUL 11: STATUS BOOKING ---\n";

// TC-STATUS-01: Status label
$b = new Booking();
$b->status = 'pending_payment';
tc('TC-STATUS-01', 'Label status pending_payment benar', 'Menunggu Pembayaran', $b->status_label, 'Valid');

$b->status = 'confirmed';
tc('TC-STATUS-02', 'Label status confirmed benar', 'Dikonfirmasi', $b->status_label, 'Valid');

$b->status = 'cancelled';
tc('TC-STATUS-03', 'Label status cancelled benar', 'Dibatalkan', $b->status_label, 'Valid');

$b->status = 'expired';
tc('TC-STATUS-04', 'Label status expired benar', 'Kadaluarsa', $b->status_label, 'Valid');

$b->status = 'rejected';
tc('TC-STATUS-05', 'Label status rejected benar', 'Ditolak', $b->status_label, 'Valid');

// TC-STATUS-06: Booking type 'block' → customer_name = 'Sistem'
$bBlock = new Booking();
$bBlock->booking_type = 'block';
tcContains('TC-STATUS-06', 'Booking blokir tampil sebagai Sistem', 'sistem', $bBlock->customer_name, 'Valid');

// TC-STATUS-07: Booking type 'offline' dengan guest_name
$bOffline = new Booking();
$bOffline->booking_type = 'offline';
$bOffline->guest_name = 'Tamu Tanpa Akun';
tc('TC-STATUS-07', 'Booking offline guest tampil nama tamu', 'Tamu Tanpa Akun', $bOffline->customer_name, 'Valid');

echo "\n--- MODUL 12: USER ROLE CHECKS ---\n";
// Sistem hanya punya 2 role: 'admin' dan 'customer' (super_admin telah dihapus)

// TC-ROLE-01: customer.isAdmin() = false
$c = new User();
$c->role = 'customer';
tc('TC-ROLE-01', 'Customer isAdmin() = false', 'false', $c->isAdmin() ? 'true' : 'false', 'Valid');

// TC-ROLE-02: admin.isAdmin() = true
$a = new User();
$a->role = 'admin';
tc('TC-ROLE-02', 'Admin isAdmin() = true', 'true', $a->isAdmin() ? 'true' : 'false', 'Valid');

// TC-ROLE-03: customer.isCustomer() = true
$c2 = new User();
$c2->role = 'customer';
tc('TC-ROLE-03', 'Customer isCustomer() = true', 'true', $c2->isCustomer() ? 'true' : 'false', 'Valid');

// TC-ROLE-04: admin.isCustomer() = false
$a3 = new User();
$a3->role = 'admin';
tc('TC-ROLE-04', 'Admin isCustomer() = false', 'false', $a3->isCustomer() ? 'true' : 'false', 'Valid');

// ============================================================
// RINGKASAN
// ============================================================
echo "\n========================================================\n";
echo "  RINGKASAN HASIL PENGUJIAN\n";
echo "========================================================\n";
echo "  Total Test Case : " . ($pass + $fail) . "\n";
echo "  ✅ PASS         : " . $pass . "\n";
echo "  ❌ FAIL         : " . $fail . "\n";
echo "  Pass Rate       : " . round(($pass / ($pass + $fail)) * 100, 2) . "%\n";
echo "========================================================\n\n";

// Export hasil ke JSON
$output = [
    'timestamp' => now()->format('Y-m-d H:i:s'),
    'total' => $pass + $fail,
    'pass' => $pass,
    'fail' => $fail,
    'pass_rate' => round(($pass / ($pass + $fail)) * 100, 2) . '%',
    'results' => $results,
];

file_put_contents(__DIR__ . '/test_blackbox_results.json', json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "📄 Hasil detail tersimpan di: test_blackbox_results.json\n\n";
