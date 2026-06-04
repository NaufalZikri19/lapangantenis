@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12 md:py-20">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl tracking-tight">
                    Kebijakan Privasi
                </h1>
                <p class="mt-4 text-lg text-gray-500">
                    Bagaimana kami melindungi dan mengelola data pribadi Anda.
                </p>
                <div class="mt-6 flex justify-center">
                    <div class="h-1.5 w-20 bg-yellow-500 rounded-full"></div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-12 space-y-12">

                    <!-- Section 1: Pengumpulan Data -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                                <i data-lucide="database" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">1. Pengumpulan Data Informasi</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Kami mengumpulkan informasi pribadi yang Anda berikan secara langsung kepada kami saat mendaftar akun, seperti <strong>nama lengkap</strong>, <strong>alamat email</strong>, dan <strong>nomor telepon</strong>.</p>
                            <p>Kami juga menyimpan riwayat pemesanan lapangan dan detail pembayaran Anda untuk keperluan pencatatan transaksi yang sah.</p>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 2: Penggunaan Data -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                <i data-lucide="shield" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">2. Penggunaan Informasi</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Informasi yang kami kumpulkan digunakan semata-mata untuk:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Memproses dan mengonfirmasi pesanan (booking) lapangan Anda.</li>
                                <li>Mengirimkan notifikasi terkait status pesanan, pembayaran, atau jadwal.</li>
                                <li>Meningkatkan layanan dan pengalaman pengguna di sistem kami.</li>
                            </ul>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 3: Keamanan Data -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-green-50 rounded-lg text-green-600">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">3. Keamanan Data</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Keamanan data pribadi Anda sangat penting bagi kami. Kami menerapkan langkah-langkah keamanan teknis standar industri untuk melindungi data dari akses, penggunaan, atau pengungkapan yang tidak sah.</p>
                            <p>Namun perlu diingat, tidak ada metode transmisi di internet atau metode penyimpanan elektronik yang 100% aman.</p>
                        </div>
                    </section>

                    <hr class="border-gray-50">

                    <!-- Section 4: Pembagian Informasi -->
                    <section>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-red-50 rounded-lg text-red-600">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">4. Pembagian Informasi</h2>
                        </div>
                        <div class="text-gray-600 space-y-3 leading-relaxed">
                            <p>Kami <strong>tidak akan pernah menjual, menyewakan, atau menukar</strong> informasi pribadi Anda kepada pihak ketiga untuk tujuan pemasaran.</p>
                            <p>Data hanya dapat dibagikan jika diwajibkan oleh hukum atau untuk keperluan penyelesaian transaksi yang sah (misal: verifikasi dengan gateway pembayaran).</p>
                        </div>
                    </section>

                </div>

                <!-- Footer Section -->
                <div class="bg-gray-50 p-8 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-500 italic">
                        Kebijakan privasi ini dapat diperbarui sewaktu-waktu. Perubahan akan berlaku segera setelah dipublikasikan pada halaman ini.
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
        </div>
    </div>
@endsection
