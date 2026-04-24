@extends('layouts.admin')

@section('content')

    <div class="max-w-6xl mx-auto">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-gray-800">
                Detail User
            </h1>

            <div class="flex gap-2">
                <!-- BACK -->
                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm shadow">

                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali
                </a>

                <!-- EXPORT -->
                <a href="{{ route('admin.users.export.bookings', $user->id) }}"
                    class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm shadow">

                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    Export Booking
                </a>
            </div>
        </div>


        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow p-6 border">

            <!-- PROFILE HEADER -->
            <div class="flex items-center gap-4 mb-6">

                <!-- AVATAR -->
                <div
                    class="w-14 h-14 rounded-full bg-yellow-400 flex items-center justify-center text-lg font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <!-- NAME -->
                <div>
                    <p class="font-semibold text-lg text-gray-800">
                        {{ $user->name }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $user->email }}
                    </p>
                </div>

                <!-- PROGRESS -->
                <div class="ml-auto">
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $user->biodata_completion == 100 ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">

                        {{ $user->biodata_completion }}% Lengkap
                    </span>
                </div>

            </div>


            <!-- BIODATA GRID -->
            <div class="grid md:grid-cols-2 gap-6 text-sm">

                <div class="space-y-3">

                    <div class="flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                        <span class="text-gray-500">Nomor HP:</span>
                        <span class="font-medium">{{ $user->phone ?? '-' }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                        <span class="text-gray-500">Gender:</span>
                        <span class="font-medium">{{ ucfirst($user->gender) ?? '-' }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                        <span class="text-gray-500">Tanggal Lahir:</span>
                        <span class="font-medium">
                            {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '-' }}
                        </span>
                    </div>

                </div>


                <div class="space-y-3">

                    <div class="flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-gray-400"></i>
                        <span class="text-gray-500">Alamat:</span>
                    </div>

                    <div class="pl-6 text-gray-700 leading-relaxed">
                        {{ $user->address_full ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection