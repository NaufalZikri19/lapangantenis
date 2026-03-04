<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>{{ config('app.name') }}</title>
</head>

<body class="min-h-screen">

    <div class="grid md:grid-cols-2 min-h-screen">

        <!-- LEFT SIDE -->
        <div class="relative hidden md:block">
            <img src="{{ asset('image/image1.jpg') }}" class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 p-16 text-white h-full flex flex-col justify-between">

                <h2 class="text-2xl font-bold">
                    Gumbreg Court
                </h2>

                <div>
                    <h3 class="text-4xl font-bold leading-snug">
                        The Best Place To Play Tennis
                    </h3>
                    <p class="mt-4 text-gray-200">
                        Booking lapangan tenis online dengan sistem real-time dan terintegrasi.
                    </p>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex items-center justify-center bg-gray-50 px-10">

            <div class="w-full max-w-md">
                {{ $slot }}
            </div>

        </div>

    </div>

</body>

</html>
