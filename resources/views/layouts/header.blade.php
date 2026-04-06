<header id="navbar" x-data="{ open: false, active: 'home', scrolled: false }" x-init="window.addEventListener('scroll', () => {
    scrolled = window.scrollY > 50;

    const sections = ['home', 'about', 'court', 'pricing'];
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            const top = window.scrollY;
            const offset = el.offsetTop - 120;
            const height = el.offsetHeight;

            if (top >= offset && top < offset + height) {
                active = id;
            }
        }
    });
});

window.addEventListener('hashchange', () => open = false);"
    :class="scrolled
        ?
        'bg-white/80 backdrop-blur-xl shadow-md border-b border-gray-200' :
        'bg-transparent'"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-out">

    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <a href="#home" class="text-2xl font-bold tracking-tight">

            <!-- Gumbreg (dynamic) -->
            <span :class="scrolled ? 'text-gray-900' : 'text-white'">
                Gumbreg
            </span>

            <!-- Court (FIXED KUNING) -->
            <span class="text-yellow-500">
                Court
            </span>

        </a>

        <!-- DESKTOP MENU -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium relative">

            <a href="#home"
                :class="active === 'home'
                    ?
                    (scrolled ? 'text-yellow-500' : 'text-white') :
                    (scrolled ? 'text-gray-700' : 'text-white')"
                class="relative hover:text-yellow-500 transition">

                Home

                <span x-show="active === 'home' && scrolled"
                    class="absolute -bottom-2 left-0 w-full h-[2px] bg-yellow-500 rounded-full">
                </span>

            </a>

            <a href="#about"
                :class="active === 'about'
                    ?
                    'text-yellow-500' :
                    (scrolled ? 'text-gray-700' : 'text-white')"
                class="relative hover:text-yellow-500 transition">
                About
                <span x-show="active === 'about'"
                    class="absolute -bottom-2 left-0 w-full h-[2px] bg-yellow-500 rounded-full"></span>
            </a>

            <a href="#court"
                :class="active === 'court'
                    ?
                    'text-yellow-500' :
                    (scrolled ? 'text-gray-700' : 'text-white')"
                class="relative hover:text-yellow-500 transition">
                Courts
                <span x-show="active === 'court'"
                    class="absolute -bottom-2 left-0 w-full h-[2px] bg-yellow-500 rounded-full"></span>
            </a>

            <a href="#pricing"
                :class="active === 'pricing'
                    ?
                    'text-yellow-500' :
                    (scrolled ? 'text-gray-700' : 'text-white')"
                class="relative hover:text-yellow-500 transition">
                Pricing
                <span x-show="active === 'pricing'"
                    class="absolute -bottom-2 left-0 w-full h-[2px] bg-yellow-500 rounded-full"></span>
            </a>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-3">

            @guest
                <a href="{{ route('login') }}"
                    class="hidden md:flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-lg hover:scale-[1.03]"
                    :class="scrolled
                        ?
                        'bg-yellow-500 text-white hover:bg-yellow-400' :
                        'bg-white text-black hover:bg-gray-200'">

                    <i data-lucide="log-in" class="w-4 h-4 opacity-90"></i>
                    Masuk
                </a>
            @endguest

            <!-- HAMBURGER -->
            <button @click="open = true" :class="scrolled ? 'text-gray-800' : 'text-white'" class="md:hidden text-xl">
                <i data-lucide="menu"></i>
            </button>

        </div>

    </nav>

    <!-- OVERLAY -->
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 bg-black/40 backdrop-blur-md z-50"
        x-transition.opacity>
    </div>

    <!-- SIDEBAR -->
    <div x-show="open" x-cloak class="fixed inset-0 z-[60] flex justify-end p-4 pointer-events-none">

        <div class="w-[70%] max-w-xs h-full
           bg-black/40 backdrop-blur-xl
           rounded-2xl shadow-2xl
           border border-white/10
           p-6 text-white overflow-y-auto
           pointer-events-auto"
            x-transition:enter="transform transition duration-300 ease-out"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform transition duration-200 ease-in"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-full opacity-0 scale-95">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-lg text-white">Menu</h2>
                <button @click="open = false" class="text-gray-500 hover:text-black">✕</button>
            </div>

            <!-- DESC -->
            <p class="text-sm text-white/60 mb-6">
                Navigasi ke bagian yang ingin kamu lihat
            </p>

            <!-- MENU -->
            <nav class="flex flex-col gap-4 font-medium">

                <a href="#home" @click="open=false"
                    :class="active === 'home'
                        ?
                        'bg-white text-black shadow' :
                        'text-white/80 hover:text-white hover:bg-white/10'"
                    class="flex items-center gap-3 px-4 py-3 rounded-full transition duration-300">

                    <i data-lucide="home" class="w-5 h-5"></i>
                    Home
                </a>

                <a href="#about" @click="open=false"
                    :class="active === 'about'
                        ?
                        'bg-white text-black shadow' :
                        'text-white/80 hover:text-white hover:bg-white/10'"
                    class="flex items-center gap-3 px-4 py-3 rounded-full transition duration-300">
                    <i data-lucide="info" class="w-5 h-5"></i>
                    About
                </a>

                <a href="#court" @click="open=false"
                    :class="active === 'court'
                        ?
                        'bg-white text-black shadow' :
                        'text-white/80 hover:text-white hover:bg-white/10'"
                    class="flex items-center gap-3 px-4 py-3 rounded-full transition duration-300">
                    <i data-lucide="map" class="w-5 h-5"></i>
                    Courts
                </a>

                <a href="#pricing" @click="open=false"
                    :class="active === 'pricing'
                        ?
                        'bg-white text-black shadow' :
                        'text-white/80 hover:text-white hover:bg-white/10'"
                    class="flex items-center gap-3 px-4 py-3 rounded-full transition duration-300">
                    <i data-lucide="tag" class="w-5 h-5"></i>
                    Pricing
                </a>

                <hr class="my-2">

                @guest
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center gap-2 bg-yellow-500 text-white px-4 py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        Login
                    </a>
                @endguest

            </nav>

        </div>
    </div>
</header>

<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const target = document.querySelector(this.getAttribute('href'));

            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 30,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
