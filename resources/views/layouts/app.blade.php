<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Gumbreg Tennis Court')</title>
</head>

<body class="bg-white">

    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

</body>

</html>
