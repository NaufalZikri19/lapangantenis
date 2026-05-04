@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.customer';
@endphp

@extends($layout)

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            @if(auth()->user()->isAdmin())
                Profil Admin
            @else
                Pengaturan Profil
            @endif
        </h1>

        {{-- WARNING --}}
        @if(auth()->user()->isCustomer() && auth()->user()->isBiodataIncomplete())
            <div class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 p-3 rounded">
                Lengkapi data diri Anda untuk melanjutkan booking
            </div>
        @endif


        {{-- BIODATA (Only for Customers) --}}
        @if(auth()->user()->isCustomer())
            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">

                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Data Tambahan</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi informasi diri Anda dengan benar untuk
                        keperluan booking</p>
                </div>

                <form method="POST" action="{{ route('profile.biodata.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid md:grid-cols-2 gap-5">

                        {{-- PHONE --}}
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-300">Nomor HP</label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        {{-- ALAMAT --}}
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-300">Alamat</label>
                            <textarea name="address"
                                class="mt-1 w-full border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-yellow-400"
                                rows="3"
                                placeholder="Masukkan alamat lengkap">{{ old('address', auth()->user()->address) }}</textarea>
                        </div>

                    </div>

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div
                            class="mt-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800/50 text-red-600 dark:text-red-400 p-4 rounded-lg text-sm">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- BUTTON --}}
                    <div class="flex justify-end mt-8">
                        <button type="submit" id="submitBtn"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg shadow-sm transition">
                            Simpan Biodata
                        </button>
                    </div>

                </form>
            </div>
        @else
            {{-- Simple Header for Admins --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Informasi Akun</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola informasi identitas dan keamanan akun Anda
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- DATA AKUN (BREEZE) --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-sm border border-gray-100 dark:border-gray-700">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-sm border border-gray-100 dark:border-gray-700">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-sm border border-gray-100 dark:border-gray-700">
            @include('profile.partials.delete-user-form')
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.querySelector('form');

            form.addEventListener('submit', function () {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

        });
    </script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#facc15',
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: @json($errors->all()),
                confirmButtonColor: '#facc15',
            });
        </script>
    @endif
@endsection