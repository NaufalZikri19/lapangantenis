<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Contact Us</title>
</head>

<body class="bg-gray-50">
@include('layouts.header')

<section class="pt-32 pb-28 bg-gray-50">

  <div class="max-w-6xl mx-auto px-6">

    <!-- Header -->
    <div class="text-center mb-20">
      <h1 class="text-4xl font-bold text-gray-900">
        Contact Us
      </h1>
      <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
        Hubungi kami untuk informasi seputar booking, jadwal, atau fasilitas lapangan.
      </p>
    </div>

    <!-- Contact Info Cards -->
    <div class="grid md:grid-cols-3 gap-10 mb-24">

      <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <div class="text-yellow-500 text-4xl mb-4">📍</div>
        <h3 class="font-semibold text-lg">Alamat</h3>
        <p class="text-gray-500 mt-2">
          Jl. Gumbreg Raya No. 10, Indonesia
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <div class="text-yellow-500 text-4xl mb-4">📞</div>
        <h3 class="font-semibold text-lg">Telepon</h3>
        <p class="text-gray-500 mt-2">
          +62 812 3456 7890
        </p>
      </div>

      <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
        <div class="text-yellow-500 text-4xl mb-4">⏰</div>
        <h3 class="font-semibold text-lg">Jam Operasional</h3>
        <p class="text-gray-500 mt-2">
          Senin - Minggu<br>
          08.00 - 23.00
        </p>
      </div>

    </div>

    <!-- FAQ Section -->
<div class="max-w-4xl mx-auto">

  <h2 class="text-3xl font-bold text-center mb-12">
    Frequently Asked Questions
  </h2>

  <div class="space-y-6">

    <!-- FAQ 1 -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden transition hover:shadow-lg">

      <button onclick="toggleFaq(1)"
        class="w-full flex justify-between items-center p-6 text-left font-semibold text-gray-900">
        Bagaimana cara melakukan booking?
        <span id="icon-1" class="transition-transform duration-300">+</span>
      </button>

      <div id="faq-1"
        class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6">
        <p class="pb-6 text-gray-600">
          Anda dapat melakukan booking melalui halaman jadwal, pilih slot waktu yang tersedia,
          lalu lakukan konfirmasi setelah login ke akun Anda.
        </p>
      </div>

    </div>


    <!-- FAQ 2 -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden transition hover:shadow-lg">

      <button onclick="toggleFaq(2)"
        class="w-full flex justify-between items-center p-6 text-left font-semibold text-gray-900">
        Apakah harus login sebelum booking?
        <span id="icon-2" class="transition-transform duration-300">+</span>
      </button>

      <div id="faq-2"
        class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6">
        <p class="pb-6 text-gray-600">
          Ya, sistem mewajibkan login untuk menjaga keamanan data dan memastikan
          reservasi tercatat atas nama pengguna yang valid.
        </p>
      </div>

    </div>


    <!-- FAQ 3 -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden transition hover:shadow-lg">

      <button onclick="toggleFaq(3)"
        class="w-full flex justify-between items-center p-6 text-left font-semibold text-gray-900">
        Apakah tersedia booking malam hari?
        <span id="icon-3" class="transition-transform duration-300">+</span>
      </button>

      <div id="faq-3"
        class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6">
        <p class="pb-6 text-gray-600">
          Ya, tersedia sesi malam dengan pencahayaan stadion hingga pukul 23.00
          untuk memastikan kenyamanan bermain.
        </p>
      </div>

    </div>

  </div>

</div>

  </div>

</section>

<script>
function toggleFaq(id) {
    const content = document.getElementById('faq-' + id);
    const icon = document.getElementById('icon-' + id);

    if (content.style.maxHeight) {
        content.style.maxHeight = null;
        icon.style.transform = "rotate(0deg)";
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
        icon.style.transform = "rotate(45deg)";
    }
}
</script>

@include('layouts.footer')

</body>
</html>
