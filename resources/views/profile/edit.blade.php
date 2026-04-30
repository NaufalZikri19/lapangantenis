@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.customer';
@endphp

@extends($layout)

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        <h1 class="text-2xl font-bold">
            Pengaturan Profil
        </h1>

        {{-- WARNING --}}
        @if(auth()->user()->isBiodataIncomplete())
            <div class="bg-yellow-100 text-yellow-700 p-3 rounded">
                Lengkapi data diri Anda untuk melanjutkan booking
            </div>
        @endif


        {{-- BIODATA --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Data Tambahan</h2>
                <p class="text-sm text-gray-500">Lengkapi informasi diri Anda dengan benar</p>
            </div>

            <form method="POST" action="{{ route('profile.biodata.update') }}">
                @csrf
                @method('PATCH')

                <div class="grid md:grid-cols-2 gap-5">

                    {{-- PHONE --}}
                    <div>
                        <label class="text-sm font-medium text-gray-600">Nomor HP</label>
                        <input type="text" name="phone"
                            value="{{ old('phone', auth()->user()->phone) }}"
                            class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400"
                            placeholder="08xxxxxxxxxx">
                    </div>

                    {{-- ALAMAT --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-600">Alamat</label>
                        <textarea name="address"
                            class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400"
                            rows="3" placeholder="Masukkan alamat lengkap">{{ old('address', auth()->user()->address) }}</textarea>
                    </div>

                </div>

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mt-6 bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg text-sm">
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

        {{-- DATA AKUN (BREEZE) --}}
        <div class="bg-white p-6 rounded shadow">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white p-6 rounded shadow">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white p-6 rounded shadow">
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