<footer class="bg-gray-900 text-gray-300 pt-20 pb-10">

  <div class="max-w-6xl mx-auto px-6">

    <div class="grid md:grid-cols-4 gap-12">

      <!-- Brand -->
      <div>
        <h3 class="text-2xl font-bold text-white mb-4">
          Gumbreg<span class="text-yellow-500">LP</span>
        </h3>
        <p class="text-sm text-gray-400 leading-relaxed">
          Sistem penyewaan lapangan tenis berbasis web dengan fitur booking online
          dan integrasi AI chatbot.
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="text-white font-semibold mb-4">Quick Links</h4>
        <ul class="space-y-3 text-sm">
          <li><a href="{{ url('/') }}" class="hover:text-yellow-400">Home</a></li>
          <li><a href="{{ url('/#court') }}" class="hover:text-yellow-400">Courts</a></li>
          <li><a href="{{ url('/#pricing') }}" class="hover:text-yellow-400">Pricing</a></li>
          <li><a href="{{ route('contact') }}" class="hover:text-yellow-400">Contact</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h4 class="text-white font-semibold mb-4">Contact</h4>
        <ul class="space-y-3 text-sm text-gray-400">
          <li>Jl. Gumbreg Raya No. 10</li>
          <li>+62 812 3456 7890</li>
          <li>info@gumbreglp.com</li>
        </ul>
      </div>

      <!-- Hours -->
      <div>
        <h4 class="text-white font-semibold mb-4">Operating Hours</h4>
        <ul class="space-y-3 text-sm text-gray-400">
          <li>Mon - Fri : 08.00 - 22.00</li>
          <li>Sat - Sun : 08.00 - 23.00</li>
        </ul>
      </div>

    </div>

    <div class="border-t border-gray-700 mt-16 pt-8 text-center text-sm text-gray-500">
      © {{ date('Y') }} Gumbreg Tennis Court. All rights reserved.
    </div>

  </div>

</footer>
