@extends('layouts.admin')

@section('content')
    <h1 class="text-xl font-bold mb-6">
        Add Court
    </h1>

    <form method="POST" action="{{ route('courts.store') }}">

        @csrf

        <input type="text" name="name" placeholder="Court Name" class="border p-2 w-full mb-4">

        <input type="text" name="type" placeholder="Court Type" class="border p-2 w-full mb-4">

        <input type="number" name="price" placeholder="Price" class="border p-2 w-full mb-4">

        <button class="bg-green-500 text-white px-4 py-2 rounded">
            Save
        </button>

    </form>
@endsection
