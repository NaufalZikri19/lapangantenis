@extends('layouts.admin')

@section('content')
<div class="w-full max-w-4xl mx-auto space-y-6">

    <!-- HEADER SECTION -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.bookings') }}" class="p-2.5 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl border border-yellow-100">
            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
        </div>
        <div>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800 dark:text-gray-100">Tambah Booking / Blokir Jadwal</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan data pemesanan offline atau blokir lapangan</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="{ bookingType: 'offline', userType: 'guest' }">
        <form action="{{ route('admin.bookings.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Tipe Entri -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tipe Tindakan</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer p-3 border rounded-xl flex-1 transition-colors" :class="bookingType === 'offline' ? 'border-yellow-500 bg-yellow-50/50 text-yellow-700' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                        <input type="radio" name="booking_type" value="offline" x-model="bookingType" class="hidden">
                        <i data-lucide="user-plus" class="w-5 h-5"></i> Booking Offline / Walk-in
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer p-3 border rounded-xl flex-1 transition-colors" :class="bookingType === 'block' ? 'border-red-500 bg-red-50/50 text-red-700' : 'border-gray-200 text-gray-600 hover:bg-gray-50'">
                        <input type="radio" name="booking_type" value="block" x-model="bookingType" class="hidden">
                        <i data-lucide="lock" class="w-5 h-5"></i> Blokir Jadwal Lapangan
                    </label>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-gray-700">

            <div x-show="bookingType === 'offline'" x-transition class="space-y-6">
                <!-- Pilihan Pelanggan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Data Pelanggan</label>
                    <select x-model="userType" class="w-full mb-3 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="guest">Tamu (Walk-in tanpa akun)</option>
                        <option value="registered">Pilih dari User Terdaftar</option>
                    </select>

                    <div x-show="userType === 'guest'">
                        <input type="text" name="guest_name" placeholder="Masukkan nama pelanggan..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" :required="bookingType === 'offline' && userType === 'guest'">
                    </div>

                    <div x-show="userType === 'registered'">
                        <select name="user_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400" :required="bookingType === 'offline' && userType === 'registered'">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="border-gray-100 dark:border-gray-700">
            </div>

            <!-- Lapangan & Jadwal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Pilih Lapangan</label>
                    <select name="court_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="">-- Pilih Lapangan --</option>
                        @foreach($courts as $court)
                            <option value="{{ $court->id }}">{{ $court->name }} (Rp {{ number_format($court->price, 0, ',', '.') }}/jam)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jam Mulai</label>
                    <input type="time" name="start_time" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jam Selesai</label>
                    <input type="time" name="end_time" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="bg-blue-50 p-4 rounded-xl text-sm text-blue-700 flex items-start gap-3 border border-blue-100">
                <i data-lucide="info" class="w-5 h-5 shrink-0 mt-0.5"></i>
                <p x-show="bookingType === 'offline'">Pemesanan offline ini akan otomatis berstatus <strong>Dikonfirmasi (Lunas via Cash)</strong> dan jadwal akan langsung dikunci di sistem.</p>
                <p x-show="bookingType === 'block'" x-cloak>Jadwal yang dipilih akan dikunci dan <strong>tidak bisa dipesan oleh pelanggan</strong> di website. Total biaya akan diset Rp 0.</p>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-gray-700">
                <button type="submit" class="px-6 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Data
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
