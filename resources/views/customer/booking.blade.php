@extends('layouts.customer')

@section('content')

    <div class="max-w-4xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">
            Book Tennis Court
        </h1>


        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- ERROR BENTROK BOOKING --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                {{ session('error') }}
            </div>
        @endif


        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif



        <div class="bg-white shadow rounded-xl p-6">

            <form method="POST" action="{{ route('booking.store') }}">
                @csrf

                <!-- COURT -->
                <div class="mb-5">

                    <label class="block text-sm text-gray-600 mb-2">
                        Select Court
                    </label>

                    <select name="court_id" class="w-full border rounded-lg p-3">

                        @foreach ($courts as $court)
                            <option value="{{ $court->id }}">

                                {{ $court->name }}
                                - Rp {{ number_format($court->price) }}/jam

                            </option>
                        @endforeach

                    </select>

                </div>



                <!-- DATE -->
                <div class="mb-5">

                    <label class="block text-sm text-gray-600 mb-2">
                        Booking Date
                    </label>

                    <input type="date" name="booking_date" min="{{ date('Y-m-d') }}"
                        class="w-full border rounded-lg p-3">

                </div>



                <!-- START TIME -->
                <div class="mb-5">

                    <label class="block text-sm text-gray-600 mb-2">
                        Start Time
                    </label>

                    <input type="time" name="start_time" class="w-full border rounded-lg p-3">

                </div>



                <!-- END TIME -->
                <div class="mb-6">

                    <label class="block text-sm text-gray-600 mb-2">
                        End Time
                    </label>

                    <input type="time" name="end_time" class="w-full border rounded-lg p-3">

                </div>



                <button class="bg-yellow-500 hover:bg-yellow-400 text-white px-6 py-3 rounded-lg font-semibold w-full">

                    Confirm Booking

                </button>

            </form>

        </div>

    </div>

@endsection
