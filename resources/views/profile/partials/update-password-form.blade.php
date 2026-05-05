<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            {{ __('Keamanan Akun') }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
        @csrf
        @method('put')

        {{-- CURRENT PASSWORD --}}
        <div>
            <label for="update_password_current_password" class="text-sm font-medium text-gray-600 dark:text-gray-300">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                autocomplete="current-password" />
            @if($errors->updatePassword->get('current_password'))
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->get('current_password')[0] }}</p>
            @endif
        </div>

        {{-- NEW PASSWORD --}}
        <div>
            <label for="update_password_password" class="text-sm font-medium text-gray-600 dark:text-gray-300">Kata Sandi Baru</label>
            <input id="update_password_password" name="password" type="password" 
                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                autocomplete="new-password" />
            @if($errors->updatePassword->get('password'))
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->get('password')[0] }}</p>
            @endif
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
            <label for="update_password_password_confirmation" class="text-sm font-medium text-gray-600 dark:text-gray-300">Konfirmasi Kata Sandi Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                autocomplete="new-password" />
            @if($errors->updatePassword->get('password_confirmation'))
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->updatePassword->get('password_confirmation')[0] }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg shadow-sm transition font-medium">
                {{ __('Perbarui Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Kata sandi berhasil diperbarui.') }}</p>
            @endif
        </div>
    </form>
</section>