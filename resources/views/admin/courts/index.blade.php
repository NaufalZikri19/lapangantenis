@extends('layouts.admin')

@section('content')
    <!-- HEADER -->
    <div class="bg-white border rounded-2xl shadow-sm p-5 mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <!-- TITLE -->
            <div class="flex items-center gap-3">

                <div class="p-2 bg-gray-100 text-gray-600 rounded-lg">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">
                        Courts
                    </h1>
                    <p class="text-sm text-gray-500">
                        Manage available courts and pricing
                    </p>
                </div>
            </div>

            <!-- ACTION -->
            <a href="{{ route('courts.create') }}"
                class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition">

                <i data-lucide="plus" class="w-4 h-4"></i>
                Add Court
            </a>

        </div>

    </div>


    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="p-4 text-left">Court</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">

                    @forelse($courts as $court)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- NAME -->
                            <td class="p-4 font-medium text-gray-700">
                                {{ $court->name }}
                            </td>

                            <!-- TYPE -->
                            <td class="p-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $court->type == 'indoor' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                    {{ ucfirst($court->type) }}
                                </span>
                            </td>

                            <!-- PRICE -->
                            <td class="p-4 text-center font-semibold text-gray-700">
                                Rp {{ number_format($court->price) }}
                            </td>

                            <!-- STATUS -->
                            <td class="p-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $court->status == 1 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">

                                    {{ $court->status == 1 ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>

                            <!-- ACTION -->
                            <td class="p-4 text-right space-x-2">

                                <a href="{{ route('courts.edit', $court->id) }}"
                                    class="px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-400">
                                    Edit
                                </a>

                                <form action="{{ route('courts.destroy', $court->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus?')"
                                        class="px-3 py-1 text-xs rounded-md bg-red-500 text-white hover:bg-red-400">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">
                                No courts available
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
@endsection
