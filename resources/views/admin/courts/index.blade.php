@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">
            Courts Management
        </h1>

        <a href="{{ route('courts.create') }}"
            class="bg-yellow-500 hover:bg-yellow-400 text-white px-5 py-2 rounded-lg shadow">
            + Add Court
        </a>
    </div>


    <div class="bg-white rounded-2xl shadow-md p-6">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-left text-gray-400 border-b">
                        <th class="py-3">Court Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($courts as $court)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="py-4 font-medium">
                                {{ $court->name }}
                            </td>

                            <td>
                                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs">
                                    {{ ucfirst($court->type) }}
                                </span>
                            </td>

                            <td class="font-semibold">
                                Rp {{ number_format($court->price) }}
                            </td>

                            <td>
                                @if ($court->status == 1)
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
                                        Available
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">
                                        Unavailable
                                    </span>
                                @endif
                            </td>

                            <td class="text-right space-x-3">

                                <a href="{{ route('courts.edit', $court->id) }}"
                                    class="text-blue-500 hover:underline text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('courts.destroy', $court->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus?')"
                                        class="text-red-500 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">
                                Belum ada data court
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
@endsection
