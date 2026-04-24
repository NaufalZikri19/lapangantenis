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
        <h2 class="text-xl font-semibold text-gray-800">Data Pribadi</h2>
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
                    placeholder="08xxxxxxxxxx" required>
            </div>

            {{-- GENDER --}}
            <div>
                <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                <select name="gender"
                    class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400">
                    <option value="">Pilih</option>
                    <option value="pria" {{ old('gender', auth()->user()->gender) == 'pria' ? 'selected' : '' }}>Pria</option>
                    <option value="wanita" {{ old('gender', auth()->user()->gender) == 'wanita' ? 'selected' : '' }}>Wanita</option>
                </select>
            </div>

            {{-- BIRTH DATE --}}
            <div>
                <label class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                <input type="date" name="birth_date"
                    value="{{ old('birth_date', auth()->user()->birth_date) }}"
                    class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400"
                    required>
            </div>

            {{-- BIRTH PLACE --}}
            <div>
                <label class="text-sm font-medium text-gray-600">Tempat Lahir</label>
                <input type="text" name="birth_place"
                    value="{{ old('birth_place', auth()->user()->birth_place) }}"
                    class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400"
                    placeholder="Contoh: Jakarta" required>
            </div>

            {{-- NATIONALITY --}}
            <div>
                <label class="text-sm font-medium text-gray-600">Kewarganegaraan</label>
                <select name="nationality"
                    class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400">
                    <option value="">Pilih</option>
                    <option value="WNI" {{ old('nationality', auth()->user()->nationality) == 'WNI' ? 'selected' : '' }}>WNI</option>
                    <option value="WNA" {{ old('nationality', auth()->user()->nationality) == 'WNA' ? 'selected' : '' }}>WNA</option>
                </select>
            </div>

            {{-- MARITAL --}}
            <div>
                <label class="text-sm font-medium text-gray-600">Status Pernikahan</label>
                <select name="marital_status"
                    class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400">
                    <option value="">Pilih</option>
                    <option value="belum menikah">Belum menikah</option>
                    <option value="menikah">Menikah</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            {{-- RELIGION --}}
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-600">Agama</label>
                <select name="religion"
                    class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400">
                    <option value="">Pilih</option>
                    @foreach(['Islam','Katolik','Kristen','Hindu','Buddha','Lainnya'] as $agama)
                        <option value="{{ $agama }}"
                            {{ old('religion', auth()->user()->religion) == $agama ? 'selected' : '' }}>
                            {{ $agama }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- ALAMAT --}}
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-1">Alamat</h3>
            <p class="text-sm text-gray-500 mb-4">Alamat sesuai KTP dan domisili saat ini</p>

            <div class="grid md:grid-cols-2 gap-5">

                <div>
                    <label class="text-sm text-gray-600">Alamat KTP</label>
                    <textarea name="address_ktp"
                        class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400"
                        rows="3">{{ old('address_ktp', auth()->user()->address_ktp) }}</textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Alamat Domisili</label>
                    <textarea name="address"
                        class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400"
                        rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Kecamatan</label>
                    <input type="text" name="district"
                        value="{{ old('district', auth()->user()->district) }}"
                        class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Provinsi</label>
                    <select id="province" name="province_id"
                        class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400">
                        <option value="">Pilih Provinsi</option>
                        @foreach($provinces as $prov)
                            <option value="{{ $prov->id }}"
                                {{ old('province_id', auth()->user()->province_id) == $prov->id ? 'selected' : '' }}>
                                {{ $prov->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm text-gray-600">Kabupaten / Kota</label>
                    <select id="regency" name="regency_id"
                        class="mt-1 w-full border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-400"
                        disabled>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                </div>

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

    const province = document.getElementById('province');
    const regency = document.getElementById('regency');

    const selectedRegency = "{{ old('regency_id', auth()->user()->regency_id) }}";

    function loadRegencies(provinceId, selected = null) {

        regency.innerHTML = '<option value="">Loading...</option>';
        regency.disabled = true;

        fetch(`/api/regencies/${provinceId}`)
            .then(res => res.json())
            .then(data => {

                regency.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;

                    if (selected && selected == item.id) {
                        opt.selected = true;
                    }

                    regency.appendChild(opt);
                });

                regency.disabled = false;
            })
            .catch(() => {
                regency.innerHTML = '<option value="">Gagal load data</option>';
            });
    }

    province.addEventListener('change', function () {
        loadRegencies(this.value);
    });

    // INIT LOAD (PENTING BANGET)
    if (province.value) {
        loadRegencies(province.value, selectedRegency);
    }
});

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