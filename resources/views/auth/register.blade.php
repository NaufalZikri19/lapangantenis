<x-guest-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Daftar Akun Baru</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Bergabunglah dengan Gumbreg QuickBook dan mulai langkah Anda menuju lapangan hari ini.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="user" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Nama Lengkap Anda"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-750 focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 outline-none transition-all">
            </div>
            @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="mail" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-750 focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 outline-none transition-all">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-750 focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 outline-none transition-all">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="shield-check" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="password" name="password_confirmation" required placeholder="••••••••"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-gray-750 focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 outline-none transition-all">
            </div>
        </div>

        <button type="submit"
            class="w-full bg-primary text-gray-900 py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-all shadow-sm flex justify-center items-center gap-2">
            Daftar Sekarang
            <i data-lucide="user-plus" class="w-5 h-5"></i>
        </button>

        <p class="text-center text-gray-500 dark:text-gray-400 text-sm mt-6">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Masuk</a>
        </p>
    </form>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal',
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