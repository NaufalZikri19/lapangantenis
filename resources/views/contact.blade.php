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

<!-- CONTACT SECTION -->
<section class="pt-32 pb-24">
  <div class="max-w-6xl mx-auto px-6">

    <div class="text-center mb-16">
      <h1 class="text-4xl font-bold text-gray-900">Contact Us</h1>
      <p class="text-gray-500 mt-4">
        Hubungi kami untuk informasi lebih lanjut atau pertanyaan terkait booking lapangan.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-16">

      <!-- CONTACT INFO -->
      <div>
        <h2 class="text-2xl font-semibold mb-6">Get In Touch</h2>

        <div class="space-y-6 text-gray-600">

          <div>
            <p class="font-semibold text-gray-900">Address</p>
            <p>Jl. Gumbreg Raya No. 10, Indonesia</p>
          </div>

          <div>
            <p class="font-semibold text-gray-900">Phone</p>
            <p>+62 812 3456 7890</p>
          </div>

          <div>
            <p class="font-semibold text-gray-900">Email</p>
            <p>info@gumbreglp.com</p>
          </div>

          <div>
            <p class="font-semibold text-gray-900">Operating Hours</p>
            <p>Mon - Fri : 08.00 - 22.00</p>
            <p>Sat - Sun : 08.00 - 23.00</p>
          </div>

        </div>
      </div>


      <!-- CONTACT FORM -->
      <div class="bg-white p-8 rounded-3xl shadow-lg">
        <form method="POST" action="#">
          @csrf

          <div class="space-y-6">

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Full Name
              </label>
              <input type="text"
                     class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                     placeholder="Your name">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Email
              </label>
              <input type="email"
                     class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                     placeholder="Your email">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Message
              </label>
              <textarea rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        placeholder="Write your message..."></textarea>
            </div>

            <button type="submit"
                    class="w-full bg-yellow-500 text-white py-3 rounded-full font-semibold hover:bg-yellow-400 transition">
              Send Message
            </button>

          </div>
        </form>
      </div>

    </div>

  </div>
</section>

@include('layouts.footer')

</body>
</html>
