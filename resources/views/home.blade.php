<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Home</title>
</head>
<div class="min-h-screen bg-white">
@include('layouts.header')
  <section id="home" class="grid md:grid-cols h-screen">

 <section
  class="relative h-screen w-full bg-cover bg-center flex items-center justify-center text-center"
  style="background-image: url('{{ asset('image/court.jpg') }}');"
>

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black/60"></div>

  <!-- Content -->
  <div class="relative z-10 max-w-3xl px-6 text-white">

    <h1 class="text-5xl md:text-7xl font-bold leading-tight">
      Discover The Best
      <span class="text-yellow-400">Tennis Experience</span>
    </h1>

    <p class="mt-6 text-lg md:text-xl text-gray-200">
      Booking lapangan tenis online, daftar turnamen,
      dan kelola jadwal dengan sistem digital terintegrasi.
    </p>

    <div class="mt-8 flex justify-center gap-4">
      <a href="#"
         class="bg-yellow-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-yellow-400 transition">
         Learn More
      </a>

      <a href=""
         class="border border-white px-6 py-3 rounded-full font-semibold hover:bg-white hover:text-black transition">
         View Schedule
      </a>
    </div>

  </div>

</section>

<!-- ABOUT SECTION -->
<section id="about" class="py-28 bg-white">
  <div class="max-w-6xl mx-auto px-6">

    <div class="grid md:grid-cols-2 gap-16 items-center">

      <!-- Image -->
      <div>
        <img src="{{ asset('image/about.jpg') }}"
             class="rounded-3xl shadow-lg w-full object-cover h-[420px]" />
      </div>

      <!-- Content -->
      <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-6">
          About Gumbreg Tennis Court
        </h2>

        <p class="text-gray-600 leading-relaxed mb-6">
          Gumbreg Tennis Court merupakan fasilitas penyewaan lapangan tenis
          yang menyediakan sistem booking online untuk memudahkan pelanggan
          dalam melakukan reservasi secara cepat dan efisien.
        </p>

        <p class="text-gray-600 leading-relaxed mb-8">
          Website ini dilengkapi dengan fitur manajemen jadwal real-time
          serta integrasi AI chatbot yang membantu pengguna dalam
          mengecek ketersediaan dan melakukan reservasi.
        </p>

        <div class="grid grid-cols-2 gap-6 text-sm text-gray-700">

          <div>
            <p class="text-2xl font-bold text-yellow-500">+500</p>
            <p>Pelanggan Terdaftar</p>
          </div>

          <div>
            <p class="text-2xl font-bold text-yellow-500">2</p>
            <p>Lapangan Aktif</p>
          </div>

          <div>
            <p class="text-2xl font-bold text-yellow-500">Real-Time</p>
            <p>Booking System</p>
          </div>

          <div>
            <p class="text-2xl font-bold text-yellow-500">AI</p>
            <p>Chatbot Assistant</p>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>

  <!-- COURT SECTION -->
<section id="court" class="py-24 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 text-center">

    <h2 class="text-3xl font-bold text-gray-900 mb-14">
      Discover Our Courts
    </h2>

    <div class="grid md:grid-cols-2 gap-50 max-w-4xl mx-auto">

      <!-- Court A -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
        <img src="{{ asset('image/court.jpg') }}"
             class="h-64 w-full object-cover" />
        <div class="p-6">
          <h3 class="font-semibold text-xl">Court A</h3>
          <p class="text-gray-500 mt-2">Outdoor Hard Court</p>
        </div>
      </div>

      <!-- Court B -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition duration-300">
        <img src="{{ asset('image/tenis.jpg') }}"
             class="h-64 w-full object-cover" />
        <div class="p-6">
          <h3 class="font-semibold text-xl">Court B</h3>
          <p class="text-gray-500 mt-2">Indoor Court</p>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- PRICING SECTION CLEAN VERSION -->
<section id="pricing" class="py-28 bg-gradient-to-b from-white to-gray-50">
  <div class="max-w-5xl mx-auto px-6 text-center">

    <h2 class="text-3xl font-bold text-gray-900">
      Pricing Plans
    </h2>
    <p class="text-gray-500 mt-3 mb-16">
      Pilih paket sewa lapangan sesuai kebutuhan Anda.
    </p>

    <div class="grid md:grid-cols-3 gap-8">

      <!-- WEEKDAY -->
      <div class="bg-white rounded-3xl p-10 shadow-md hover:shadow-lg transition duration-300">
        <h3 class="text-lg font-semibold text-gray-700">Weekday</h3>

        <div class="mt-6">
          <p class="text-4xl font-bold text-gray-900">Rp100.000</p>
          <p class="text-sm text-gray-500 mt-2">per jam</p>
        </div>

        <ul class="mt-8 space-y-3 text-sm text-gray-600">
          <li>Senin - Jumat</li>
          <li>08.00 - 16.00</li>
          <li>Outdoor / Indoor</li>
        </ul>

        <a href="#"
           class="mt-10 inline-block w-full bg-gray-900 text-white py-3 rounded-full font-medium hover:bg-gray-800 transition">
          Book Now
        </a>
      </div>


      <!-- WEEKEND (HIGHLIGHTED CLEAN) -->
      <div class="relative bg-white rounded-3xl p-10 shadow-lg border border-yellow-400 transition duration-300">

        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-yellow-400 text-white text-xs px-4 py-1 rounded-full font-semibold">
          Most Popular
        </div>

        <h3 class="text-lg font-semibold text-gray-700">Weekend</h3>

        <div class="mt-6">
          <p class="text-4xl font-bold text-gray-900">Rp150.000</p>
          <p class="text-sm text-gray-500 mt-2">per jam</p>
        </div>

        <ul class="mt-8 space-y-3 text-sm text-gray-600">
          <li>Sabtu - Minggu</li>
          <li>08.00 - 18.00</li>
          <li>All Courts</li>
        </ul>

        <a href="#"
           class="mt-10 inline-block w-full bg-yellow-500 text-white py-3 rounded-full font-medium hover:bg-yellow-400 transition">
          Book Now
        </a>
      </div>


      <!-- NIGHT -->
      <div class="bg-white rounded-3xl p-10 shadow-md hover:shadow-lg transition duration-300">
        <h3 class="text-lg font-semibold text-gray-700">Night Session</h3>

        <div class="mt-6">
          <p class="text-4xl font-bold text-gray-900">Rp180.000</p>
          <p class="text-sm text-gray-500 mt-2">per jam</p>
        </div>

        <ul class="mt-8 space-y-3 text-sm text-gray-600">
          <li>18.00 - 22.00</li>
          <li>Lampu Stadion</li>
          <li>Premium Court</li>
        </ul>

        <a href="#"
           class="mt-10 inline-block w-full bg-gray-900 text-white py-3 rounded-full font-medium hover:bg-gray-800 transition">
          Book Now
        </a>
      </div>

    </div>

  </div>
</section>
    @include('layouts.footer')
</div>
</body>

    <script>
    window.addEventListener("scroll", function () {
    const navbar = document.getElementById("navbar");

    if (window.scrollY > 50) {
        navbar.classList.add("shadow-md");
    } else {
        navbar.classList.remove("shadow-md");
    }
    });
    </script>
</html>
