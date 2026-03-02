<header id="navbar" class="fixed top-0 left-0 w-full z-50 bg-white shadow-sm transition-all duration-300">
  <nav class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

    <!-- Logo -->
    <a href="{{ url('/#home') }}" class="text-2xl font-bold tracking-tight">
      <span class="text-gray-900">Gumbreg</span>
      <span class="text-yellow-500">Court</span>
    </a>

    <!-- Menu -->
    <div class="hidden md:flex items-center gap-10 text-sm font-medium text-gray-700">
      <a href="{{ url('/#home') }}" class="hover:text-yellow-500 transition">Home</a>
      <a href="{{ url('/#about') }}" class="hover:text-yellow-500 transition">About</a>
      <a href="{{ url('/#court') }}" class="hover:text-yellow-500 transition">Courts</a>
      <a href="{{ url('/#pricing') }}" class="hover:text-yellow-500 transition">Pricing</a>
      <a href="{{ route('contact') }}" class="hover:text-yellow-500 transition">Contact</a>
    </div>

    <!-- CTA -->
    <a href="#pricing"
       class="hidden md:inline-block bg-yellow-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-yellow-400 transition">
       Book Now
    </a>

  </nav>
</header>
