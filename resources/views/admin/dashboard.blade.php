@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Admin Dashboard
</h1>

<div class="grid grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        Total Courts
    </div>

    <div class="bg-white p-6 rounded shadow">
        Today's Booking
    </div>

    <div class="bg-white p-6 rounded shadow">
        Total Customers
    </div>

</div>

@endsection
