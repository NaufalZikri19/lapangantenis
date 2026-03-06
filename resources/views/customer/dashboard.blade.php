@extends('layouts.customer')

@section('content')
    <h1 class="text-2xl font-bold mb-6">
        Customer Dashboard
    </h1>

    <div class="grid grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow">
            Booking Aktif
        </div>

        <div class="bg-white p-6 rounded shadow">
            Riwayat Booking
        </div>

        <div class="bg-white p-6 rounded shadow">
            Lapangan Tersedia
        </div>

    </div>
@endsection
