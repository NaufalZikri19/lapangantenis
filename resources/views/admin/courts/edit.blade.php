@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-6">
        Edit Court
    </h1>

    <form method="POST" action="{{ route('courts.update', $court->id) }}">

        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $court->name }}" class="border p-2 w-full mb-4">

        <input type="text" name="type" value="{{ $court->type }}" class="border p-2 w-full mb-4">

        <input type="number" name="price" value="{{ $court->price }}" class="border p-2 w-full mb-4">

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>

    </form>
@endsection
