<x-guest-layout>

    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 text-yellow-600 mb-6">
            <i data-lucide="mail-check" class="w-8 h-8"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi Email</h1>
        <p class="text-gray-500 text-sm">Terima kasih telah mendaftar! Sebelum memulai, harap verifikasi alamat email
            Anda dengan mengeklik tautan yang baru saja kami kirimkan.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-sm text-green-600 font-medium text-center">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                class="w-full bg-primary text-gray-900 py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-all shadow-sm flex justify-center items-center gap-2">
                Kirim Ulang Email Verifikasi
                <i data-lucide="send" class="w-5 h-5"></i>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit"
                class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors flex items-center justify-center gap-2 mx-auto">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                Keluar
            </button>
        </form>
    </div>

</x-guest-layout>