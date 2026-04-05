@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl">

        <!-- TITLE -->
        <h1 class="text-xl font-bold mb-6 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-yellow-500"></i>
            Add Court
        </h1>

        <!-- CARD -->
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow border">

            <form method="POST" action="{{ route('courts.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- COURT NAME -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Court Name
                    </label>
                    <input type="text" name="name"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                        placeholder="e.g. Lapangan 1">
                </div>

                <!-- COURT TYPE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Court Type
                    </label>
                    <input type="text" name="type"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                        placeholder="e.g. Indoor / Outdoor">
                </div>

                <!-- PRICE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Price (per hour)
                    </label>
                    <input type="number" name="price"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                        placeholder="e.g. 100000">
                </div>

                <!-- IMAGE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Court Image
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
                        Cancel
                    </a>

                    <button type="submit"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg shadow transition">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Save Court
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
