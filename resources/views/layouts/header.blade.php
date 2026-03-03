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

   @auth
<div class="flex items-center gap-6">

    <a href="{{ route('dashboard') }}"
       class="text-sm text-gray-700 hover:text-yellow-500 transition">
        Dashboard
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="text-sm text-red-500 hover:text-red-400 transition">
            Logout
        </button>
    </form>

</div>
@endauth

@guest
<a href="{{ route('login') }}"
   class="bg-yellow-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-yellow-400 transition">
   Login
</a>
@endguest

  </nav>
</header>
