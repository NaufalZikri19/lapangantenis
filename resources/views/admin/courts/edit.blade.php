@extends('layouts.admin')

@section('content')
    <div class="w-full mx-auto lg:mx-0">

        <!-- HEADER SECTION -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('courts.index') }}"
                    class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-500 hover:text-yellow-600 dark:hover:text-yellow-500 transition-all shadow-sm group">
                    <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight tracking-tight">Edit Data
                        Lapangan</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Perbarui informasi, jenis, dan tarif sewa
                        lapangan</p>
                </div>
            </div>
        </div>

        <!-- FORM CARD -->
        <div
            class="bg-white dark:bg-gray-900 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

            <form method="POST" action="{{ route('courts.update', $court->id) }}" enctype="multipart/form-data"
                class="divide-y divide-gray-100 dark:divide-gray-800">
                @csrf
                @method('PUT')

                <!-- CONTENT AREA -->
                <div class="p-6 lg:p-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                        <!-- LEFT COLUMN: CORE INFORMATION -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1 h-4 bg-yellow-500 rounded-full"></div>
                                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                    Informasi Utama</h3>
                            </div>

                            <!-- COURT NAME -->
                            <div class="space-y-2.5">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                    Nama Lapangan
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="tag"
                                            class="w-4 h-4 text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name', $court->name) }}" required
                                        placeholder="Contoh: Lapangan A (Indoor)"
                                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 transition-all outline-none shadow-sm">
                                </div>
                                @error('name') <p class="text-xs text-red-500 mt-1 ml-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- COURT TYPE -->
                            <div class="space-y-2.5">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                    Jenis Lapangan
                                </label>
                                <div class="relative group" x-data="{ type: '{{ old('type', $court->type) }}' }">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="layout"
                                            class="w-4 h-4 text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>
                                    </div>
                                    <select name="type" required
                                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 transition-all outline-none shadow-sm cursor-pointer">
                                        <option value="Indoor" {{ old('type', $court->type) == 'Indoor' ? 'selected' : '' }}>
                                            Indoor (Dalam Ruangan)</option>
                                        <option value="Outdoor" {{ old('type', $court->type) == 'Outdoor' ? 'selected' : '' }}>Outdoor (Luar Ruangan)</option>
                                        <option value="Semi-Indoor" {{ old('type', $court->type) == 'Semi-Indoor' ? 'selected' : '' }}>Semi-Indoor (Beratap)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- PRICE -->
                            <div class="space-y-2.5">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">
                                    Harga Sewa <span class="text-gray-400 font-normal">(per jam)</span>
                                </label>
                                <div class="relative group">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-bold text-gray-400 dark:text-gray-500 group-focus-within:text-yellow-500 transition-colors">
                                        Rp
                                    </div>
                                    <input type="text" inputmode="numeric"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="price"
                                        value="{{ old('price', $court->price) }}" required
                                        class="w-full pl-12 pr-4 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 transition-all outline-none shadow-sm">
                                </div>
                                <p
                                    class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 ml-1 italic font-medium opacity-80">
                                    Masukkan angka saja tanpa titik atau koma.</p>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: MEDIA MANAGEMENT -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1 h-4 bg-yellow-500 rounded-full"></div>
                                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                    Media Visual</h3>
                            </div>

                            <!-- IMAGE UPLOAD -->
                            <div class="space-y-3">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Foto
                                    Lapangan</label>

                                <div
                                    class="relative group overflow-hidden rounded-[1.5rem] bg-gray-50 dark:bg-gray-800/50 border-2 border-dashed border-gray-200 dark:border-gray-700 aspect-[4/3] flex flex-col items-center justify-center p-3 transition-all hover:border-yellow-500/50">

                                    <!-- CURRENT IMAGE -->
                                    @if ($court->image)
                                        <img id="image-current" src="{{ asset('storage/' . $court->image) }}"
                                            class="absolute inset-0 w-full h-full object-cover rounded-2xl transition-all duration-500 group-hover:scale-105 group-hover:opacity-30">
                                    @else
                                        <div id="no-image" class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                                <i data-lucide="image" class="w-8 h-8"></i>
                                            </div>
                                            <p class="text-xs text-gray-500 font-medium">Belum ada foto</p>
                                        </div>
                                    @endif

                                    <!-- NEW PREVIEW -->
                                    <img id="preview"
                                        class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden z-10 transition-all duration-500" />

                                    <!-- OVERLAY UI -->
                                    <div
                                        class="relative z-20 flex flex-col items-center gap-3 transition-all duration-300 opacity-0 group-hover:opacity-100 pointer-events-none">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-white dark:bg-gray-700 shadow-xl flex items-center justify-center text-yellow-500">
                                            <i data-lucide="upload-cloud" class="w-7 h-7"></i>
                                        </div>
                                        <span
                                            class="px-4 py-2 bg-gray-900/80 dark:bg-gray-800 text-white text-[11px] font-bold rounded-xl backdrop-blur-sm shadow-xl">
                                            Ganti Foto Baru
                                        </span>
                                    </div>

                                    <input type="file" name="image" id="image-input" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30"
                                        onchange="previewImage(event)">
                                </div>
                                <div class="flex items-center justify-center gap-4 mt-2">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-green-500"></i>
                                        <span
                                            class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">High
                                            Quality</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-green-500"></i>
                                        <span
                                            class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Max
                                            2MB</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTer / ACTIONS -->
                <div
                    class="bg-gray-50/80 dark:bg-gray-800/50 px-6 lg:px-10 py-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-white dark:bg-gray-700 flex items-center justify-center border border-gray-100 dark:border-gray-600 shadow-sm text-gray-400">
                            <i data-lucide="history" class="w-4 h-4"></i>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Terakhir
                                Diperbarui</p>
                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-300 mt-1">
                                {{ $court->updated_at->format('d M Y \• H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <a href="{{ route('courts.index') }}"
                            class="flex-1 sm:flex-none text-center px-6 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-all font-bold">
                            Batalkan
                        </a>

                        <button type="submit"
                            class="flex-1 sm:flex-none flex items-center justify-center gap-2.5 bg-yellow-500 hover:bg-yellow-600 active:scale-95 text-white px-10 py-3.5 rounded-2xl font-bold shadow-lg shadow-yellow-500/20 transition-all">
                            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>

    <!-- PREVIEW SCRIPT -->
    <script>
        function previewImage(event) {
            const input = event.target;

            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Ukuran gambar tidak boleh lebih dari 2MB',
                        confirmButtonColor: '#eab308'
                    });
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                const currentImg = document.getElementById('image-current');
                const previewImg = document.getElementById('preview');
                const noImage = document.getElementById('no-image');

                reader.onload = function () {
                    previewImg.src = reader.result;
                    previewImg.classList.remove('hidden');
                    previewImg.classList.add('block');

                    if (currentImg) {
                        currentImg.classList.add('opacity-0');
                        currentImg.classList.add('scale-95');
                    }
                    if (noImage) {
                        noImage.classList.add('hidden');
                    }
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection