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
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight tracking-tight">Tambah
                        Lapangan Baru</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftarkan unit lapangan baru ke dalam sistem
                        reservasi</p>
                </div>
            </div>
        </div>

        <!-- FORM CARD -->
        <div
            class="bg-white dark:bg-gray-900 rounded-[2rem] shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">

            <form method="POST" action="{{ route('courts.store') }}" enctype="multipart/form-data"
                class="divide-y divide-gray-100 dark:divide-gray-800">
                @csrf

                <!-- CONTENT AREA -->
                <div class="p-6 lg:p-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                        <!-- LEFT COLUMN: CORE INFORMATION -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1 h-4 bg-yellow-500 rounded-full"></div>
                                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                    Detail Lapangan</h3>
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
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        placeholder="Misal: Lapangan 1 (Semi Indoor)"
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
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i data-lucide="layout"
                                            class="w-4 h-4 text-gray-400 group-focus-within:text-yellow-500 transition-colors"></i>
                                    </div>
                                    <select name="type" required
                                        class="w-full pl-11 pr-4 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 transition-all outline-none shadow-sm cursor-pointer">
                                        <option value="" disabled selected>Pilih Jenis Lapangan</option>
                                        <option value="Indoor" {{ old('type') == 'Indoor' ? 'selected' : '' }}>Indoor (Dalam
                                            Ruangan)</option>
                                        <option value="Outdoor" {{ old('type') == 'Outdoor' ? 'selected' : '' }}>Outdoor (Luar
                                            Ruangan)</option>
                                        <option value="Semi-Indoor" {{ old('type') == 'Semi-Indoor' ? 'selected' : '' }}>
                                            Semi-Indoor (Beratap)</option>
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
                                    <input type="number" name="price" value="{{ old('price') }}" required placeholder="0"
                                        class="w-full pl-12 pr-4 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:bg-white dark:focus:bg-gray-900 focus:ring-4 focus:ring-yellow-500/10 focus:border-yellow-500 transition-all outline-none shadow-sm">
                                </div>
                                <p
                                    class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 ml-1 italic font-medium opacity-80">
                                    Gunakan angka bulat (contoh: 120000).</p>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: MEDIA UPLOAD -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1 h-4 bg-yellow-500 rounded-full"></div>
                                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-gray-500">
                                    Visual Display</h3>
                            </div>

                            <!-- IMAGE UPLOAD -->
                            <div class="space-y-3">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Unggah Foto
                                    Lapangan</label>

                                <div
                                    class="relative group overflow-hidden rounded-[1.5rem] bg-gray-50 dark:bg-gray-800/50 border-2 border-dashed border-gray-200 dark:border-gray-700 aspect-[4/3] flex flex-col items-center justify-center p-3 transition-all hover:border-yellow-500/50">

                                    <!-- PREVIEW AREA -->
                                    <div id="no-image"
                                        class="flex flex-col items-center gap-4 transition-all duration-300 group-hover:scale-105">
                                        <div
                                            class="w-16 h-16 rounded-2xl bg-white dark:bg-gray-700 shadow-sm flex items-center justify-center text-gray-400 group-hover:text-yellow-500 transition-colors">
                                            <i data-lucide="image-plus" class="w-8 h-8"></i>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-300">Klik atau seret
                                                gambar</p>
                                            <p class="text-[10px] text-gray-400 mt-1 font-medium">PNG, JPG atau WEBP (Max.
                                                2MB)</p>
                                        </div>
                                    </div>

                                    <!-- ACTUAL PREVIEW -->
                                    <img id="preview"
                                        class="absolute inset-0 w-full h-full object-cover rounded-2xl hidden z-10 transition-all duration-500" />

                                    <!-- CHANGE OVERLAY -->
                                    <div id="change-overlay"
                                        class="absolute inset-0 z-20 flex flex-col items-center justify-center gap-3 bg-gray-900/40 backdrop-blur-sm opacity-0 transition-opacity pointer-events-none hidden">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-yellow-600 shadow-xl">
                                            <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                                        </div>
                                        <span class="text-xs font-bold text-white uppercase tracking-widest">Ganti
                                            Gambar</span>
                                    </div>

                                    <input type="file" name="image" id="image-input" accept="image/*" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-30"
                                        onchange="previewImage(event)">
                                </div>
                            </div>

                            <div
                                class="bg-blue-50 dark:bg-blue-500/5 p-4 rounded-2xl border border-blue-100 dark:border-blue-500/10 flex gap-3">
                                <i data-lucide="help-circle" class="w-5 h-5 text-blue-500 shrink-0"></i>
                                <p class="text-[11px] text-blue-600 dark:text-blue-400 leading-relaxed font-medium">
                                    Tips: Gunakan foto dengan pencahayaan yang baik untuk menarik minat penyewa. Ukuran yang
                                    disarankan adalah rasio 4:3.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER / ACTIONS -->
                <div class="bg-gray-50/80 dark:bg-gray-800/50 px-6 lg:px-10 py-8 flex items-center justify-end gap-4">
                    <a href="{{ route('courts.index') }}"
                        class="px-8 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                        Batalkan
                    </a>

                    <button type="submit"
                        class="flex items-center gap-2.5 bg-yellow-500 hover:bg-yellow-600 active:scale-95 text-white px-10 py-3.5 rounded-2xl font-bold shadow-lg shadow-yellow-500/20 transition-all">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        Simpan Lapangan
                    </button>
                </div>

            </form>

        </div>

    </div>

    <!-- PREVIEW SCRIPT -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const input = event.target;
            const previewImg = document.getElementById('preview');
            const noImage = document.getElementById('no-image');
            const overlay = document.getElementById('change-overlay');

            reader.onload = function () {
                previewImg.src = reader.result;
                previewImg.classList.remove('hidden');
                noImage.classList.add('hidden');
                overlay.classList.remove('hidden');

                // Add hover effect to overlay once image is present
                previewImg.parentElement.addEventListener('mouseenter', () => overlay.classList.add('opacity-100'));
                previewImg.parentElement.addEventListener('mouseleave', () => overlay.classList.remove('opacity-100'));
            }

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection