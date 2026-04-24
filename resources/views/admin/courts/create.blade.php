@extends('layouts.admin')

@section('content')
    <div class="w-full">

        <!-- TITLE -->
        <h1 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-yellow-500"></i>
            Tambah Lapangan
        </h1>

        <!-- CARD -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow border">

            <form method="POST" action="{{ route('courts.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- COURT NAME -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lapangan
                    </label>
                    <input type="text" name="name"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                        placeholder="Contoh: Lapangan 1">
                </div>

                <!-- COURT TYPE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Jenis Lapangan
                    </label>
                    <input type="text" name="type"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                        placeholder="Contoh: Indoor / Outdoor">
                </div>

                <!-- PRICE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga (per jam)
                    </label>
                    <input type="number" name="price"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                        placeholder="Contoh: 100000">
                </div>

                <!-- IMAGE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Lapangan
                    </label>

                    <input type="file" name="image" accept="image/*"
                        class="w-full border rounded-lg p-2 cursor-pointer" onchange="previewImage(event)">

                    <!-- PREVIEW -->
                    <img id="preview" class="mt-3 w-full max-h-48 object-cover rounded-lg hidden shadow" />
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3 pt-4">

                    <a href="{{ route('courts.index') }}"
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-2 rounded-lg shadow transition">
                        <i data-lucide="save" class="w-4 h-4"></i>
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
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
