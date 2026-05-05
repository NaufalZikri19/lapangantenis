<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Informasi Akun
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Perbarui informasi profil dan alamat email Anda untuk menjaga keakuratan data.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
        @csrf
        @method('patch')

        {{-- NAMA --}}
        <div>
            <label for="name" class="text-sm font-medium text-gray-600 dark:text-gray-300">Nama Lengkap</label>
            <input id="name" name="name" type="text" 
                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->get('name')[0] }}</p>
            @endif
        </div>

        {{-- EMAIL --}}
        <div>
            <label for="email" class="text-sm font-medium text-gray-600 dark:text-gray-300">Alamat Email</label>
            <input id="email" name="email" type="email" 
                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if($errors->get('email'))
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $errors->get('email')[0] }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-300">
                        {{ __('Alamat email Anda belum terverifikasi.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-yellow-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            {{ __('Klik disini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Email verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg shadow-sm transition font-medium">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>