<x-guest-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
        <p class="text-gray-500 text-sm">Silakan masuk ke akun Anda untuk melanjutkan booking lapangan tenis.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
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
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm font-medium text-primary hover:text-primaryHover">Lupa sandi?</a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary focus:ring-offset-0 bg-gray-50 transition-colors cursor-pointer">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                Ingat saya di perangkat ini
            </label>
        </div>

        <button type="submit"
            class="w-full bg-primary text-gray-900 py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-all shadow-sm flex justify-center items-center gap-2">
            Masuk
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </button>

        <p class="text-center text-gray-500 text-sm mt-6">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Daftar Gratis</a>
        </p>
    </form>

    @if ($errors->has('email'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Email atau password salah!',
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