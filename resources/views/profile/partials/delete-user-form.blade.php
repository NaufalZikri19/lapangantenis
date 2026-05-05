<section class="space-y-6">
    <header>
        <h2 class="text-xl font-semibold text-red-600 dark:text-red-400">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.') }}
        </p>
    </header>

    <button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow-sm transition font-medium">
        {{ __('Hapus Akun Saya') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 dark:bg-gray-800">
            @csrf
            @method('delete')

            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                    {{ __('Konfirmasi Penghapusan Akun') }}
                </h2>
    
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Apakah Anda yakin ingin menghapus akun Anda? Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
                </p>
            </div>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Kata Sandi') }}</label>

                <input id="password" name="password" type="password" 
                    class="w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="{{ __('Masukkan Kata Sandi Anda') }}" />

                @if($errors->userDeletion->get('password'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->userDeletion->get('password')[0] }}</p>
                @endif
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-6 py-2 rounded-lg transition font-medium">
                    {{ __('Batal') }}
                </button>

                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow-sm transition font-medium">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>