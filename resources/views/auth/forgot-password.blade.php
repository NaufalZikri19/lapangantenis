<x-guest-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Lupa Kata Sandi?</h1>
        <p class="text-gray-500 text-sm">Jangan khawatir! Berikan kami alamat email Anda dan kami akan mengirimkan
            tautan untuk mengatur ulang kata sandi Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-primary text-gray-900 py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-all shadow-sm flex justify-center items-center gap-2">
            Kirim Link Reset
            <i data-lucide="send" class="w-5 h-5"></i>
        </button>

        <p class="text-center text-gray-500 text-sm mt-6">
            Ingat kata sandi Anda?
            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Kembali ke Login</a>
        </p>
    </form>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: '{!! implode("<br>", $errors->all()) !!}',
                    confirmButtonColor: '#EAB308',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-2'
                    }
                });
            });
        </script>
    @endif

</x-guest-layout>