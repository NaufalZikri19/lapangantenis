@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 md:py-20">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl tracking-tight">
                    Syarat & Ketentuan
                </h1>
                <p class="mt-4 text-lg text-gray-500">
                    Harap baca dengan teliti aturan penggunaan layanan Gumbreg Tennis Court.
                </p>
                <div class="mt-6 flex justify-center">
                    <div class="h-1.5 w-20 bg-yellow-500 rounded-full"></div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12 space-y-12">

                    <!-- Section 1: Aturan Booking -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                                <i data-lucide="calendar-check" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">1. Aturan Booking</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>User dapat melakukan pemesanan lapangan sesuai dengan slot waktu yang tersedia di sistem
                                secara real-time.</p>
                            <p>Sistem kami mencegah terjadinya double booking pada slot waktu dan lapangan yang sama.</p>
                            <p>Satu akun user dapat melakukan beberapa booking selama slot masih tersedia.</p>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 2: Aturan Pembayaran -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">2. Aturan Pembayaran</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Setiap pemesanan memiliki batas waktu pembayaran selama <strong>10 menit</strong> sejak
                                booking dibuat.</p>
                            <p>Pembayaran harus dikonfirmasi dengan mengunggah bukti transfer atau melalui sistem QRIS yang
                                tersedia.</p>
                            <p>Jika pembayaran tidak dilakukan dalam batas waktu tersebut, sistem akan secara otomatis
                                membatalkan pesanan (Expired).</p>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 3: Pembatalan & Refund -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-red-50 rounded-lg text-red-600">
                                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">3. Pembatalan & Refund</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Pemesanan yang sudah dibayar dan dikonfirmasi <strong>tidak dapat dibatalkan</strong> oleh
                                pengguna.</p>
                            <p>Gumbreg Tennis Court tidak memberikan pengembalian dana (No Refund) untuk pembatalan sepihak
                                oleh pengguna.</p>
                            <p>Perubahan jadwal (Reschedule) hanya dapat dilakukan melalui koordinasi langsung dengan admin
                                minimal 24 jam sebelum jadwal main.</p>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 4: Ketidakhadiran (No-Show) -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                                <i data-lucide="user-x" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">4. Ketidakhadiran (No-Show)</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Jika pengguna tidak hadir pada jadwal yang telah dipesan, maka booking dianggap hangus.</p>
                            <p>Tidak ada kompensasi waktu atau pengembalian dana bagi pengguna yang terlambat hadir.</p>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 5: Tanggung Jawab -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <i data-lucide="shield-check" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">5. Tanggung Jawab</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Pengguna wajib menjaga kebersihan dan ketertiban di area lapangan.</p>
                            <p>Segala bentuk kerusakan fasilitas lapangan yang disebabkan oleh kelalaian pengguna menjadi
                                tanggung jawab penuh pengguna yang bersangkutan.</p>
                            <p>Pihak pengelola tidak bertanggung jawab atas kehilangan barang pribadi di area Gumbreg Tennis
                                Court.</p>
                        </div>
                    </section>

                </div>

                <!-- Footer Section -->
                <div class="bg-gray-50 p-8 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-500 italic">
                        Syarat & ketentuan ini dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya. Dengan melakukan
                        booking, Anda dianggap telah menyetujui seluruh poin di atas.
                    </p>
                    <div class="mt-6">
                        <a href="{{ url('/') }}"
                            class="inline-flex items-center gap-2 text-yellow-600 font-bold hover:underline">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-gray-400 text-sm">
                &copy; {{ date('Y') }} Gumbreg Tennis Court. All rights reserved.
            </div>
        </div>
    </div>
@endsection