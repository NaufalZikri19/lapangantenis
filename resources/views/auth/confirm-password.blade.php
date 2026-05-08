<x-guest-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Password</h1>
        <p class="text-gray-500 text-sm">Ini adalah area aman. Silakan konfirmasi kata sandi Anda sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i>
                </div>
                <input type="password" name="password" required
                    placeholder="••••••••"
                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-primary text-gray-900 py-3.5 rounded-xl font-bold hover:bg-primaryHover transition-all shadow-sm flex justify-center items-center gap-2">
            Konfirmasi
            <i data-lucide="check-circle" class="w-5 h-5"></i>
        </button>
    </form>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Konfirmasi Gagal',
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

