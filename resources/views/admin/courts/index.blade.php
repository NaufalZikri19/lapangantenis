@extends('layouts.admin')

@section('content')
    <div class="flex justify-between mb-6">

        <h1 class="text-2xl font-bold">
            Courts
        </h1>

        <a href="{{ route('courts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Add Court
        </a>

    </div>

    <table class="w-full bg-white rounded shadow">

        <thead class="border-b">

            <tr>
                <th class="p-3">Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($courts as $court)
                <tr class="border-b">

                    <td class="p-3">{{ $court->name }}</td>
                    <td>{{ $court->type }}</td>
                    <td>Rp {{ number_format($court->price) }}</td>

                    <td class="space-x-2">

                        <a href="{{ route('courts.edit', $court->id) }}" class="text-blue-500">
                            Edit
                        </a>

                        <form action="{{ route('courts.destroy', $court->id) }}" method="POST" class="inline">

                            @csrf
                            @method('DELETE')

                            <button class="text-red-500">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
@endsection
