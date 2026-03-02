<footer id="site-footer" class="bg-gray-900 text-gray-300 pt-20 pb-10">

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
    <!-- CHAT BUTTON -->
<button onclick="toggleChat()"
  class="fixed bottom-6 right-6 bg-gray-900 hover:bg-black w-14 h-14 rounded-full shadow-xl flex items-center justify-center transition duration-300 z-50">

  <img src="{{ asset('image/gemini.svg') }}"
       alt="Gemini AI"
       class="h-6 w-6 brightness-0 invert">

</button>

<!-- CHAT WINDOW -->
<div id="chatbox"
  class="fixed bottom-24 right-6 w-80 bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-0 origin-bottom-right transition duration-300 z-50">

  <!-- Header -->
  <div class="bg-gray-900 text-white p-4 flex justify-between items-center">
    <div class="flex items-center gap-3">
      <img src="{{ asset('image/gemini.svg') }}"
           alt="Gemini"
           class="h-5 w-auto">

      <div>
        <h4 class="font-semibold text-sm">Gumbreg Assistant</h4>
        <p class="text-xs text-gray-400">Powered by Gemini</p>
      </div>
    </div>

    <button onclick="toggleChat()" class="text-gray-300 hover:text-white">
      ✕
    </button>
  </div>

  <!-- Chat Body -->
  <div class="p-4 h-72 overflow-y-auto space-y-3 text-sm">

    <div class="bg-gray-100 p-3 rounded-xl max-w-[80%]">
      👋 Halo! Ada yang bisa kami bantu?
    </div>

    <div class="bg-yellow-500 text-white p-3 rounded-xl max-w-[80%] ml-auto">
      Saya ingin booking lapangan.
    </div>

  </div>

  <!-- Quick Actions -->
  <div class="p-4 border-t border-gray-200 space-y-2">

    <button class="w-full bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-sm">
      Cara Booking
    </button>

    <button class="w-full bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-sm">
      Lihat Harga
    </button>

    <button class="w-full bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-sm">
      Jam Operasional
    </button>

  </div>

</div>

    <div class="border-t border-gray-700 mt-16 pt-8 text-center text-sm text-gray-500">
      © {{ date('Y') }} Gumbreg Tennis Court. All rights reserved.
    </div>

  </div>


</footer>

<script>
function toggleChat() {
    const chat = document.getElementById("chatbox");
    chat.classList.toggle("scale-0");
}
window.addEventListener("scroll", function() {
    const footer = document.getElementById("site-footer");
    const chatBtn = document.querySelector("[onclick='toggleChat()']");

    const footerTop = footer.getBoundingClientRect().top;
    const windowHeight = window.innerHeight;

    if (footerTop < windowHeight) {
        chatBtn.classList.remove("bg-yellow-500");  
        chatBtn.classList.add("bg-gray-800");
    } else {
        chatBtn.classList.add("bg-yellow-500");
        chatBtn.classList.remove("bg-gray-800");
}
});

</script>
