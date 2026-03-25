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
        'bg-white shadow-md backdrop-blur-md' :
        'bg-white/30 backdrop-blur-sm'"
    class="fixed top-0 left-0 w-full z-50 border-b border-white/20 transition-all duration-300">

    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <a href="#home" class="text-2xl font-bold tracking-tight">
            <span :class="scrolled ? 'text-gray-900' : 'text-white'">Gumbreg</span>
            <span class="text-yellow-500">Court</span>
        </a>

        <!-- DESKTOP MENU -->
        <div class="hidden md:flex items-center gap-8 text-sm font-medium relative">

            <a href="#home"
                :class="active === 'home'
                    ?
                    'text-yellow-500' :
                    (scrolled ? 'text-gray-700' : 'text-white')"
                class="relative hover:text-yellow-500 transition">
                Home
                <span x-show="active === 'home'"
                    class="absolute -bottom-2 left-0 w-full h-[2px] bg-yellow-500 rounded-full"></span>
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
                    class="hidden md:block px-5 py-2.5 rounded-full text-sm font-semibold transition shadow-lg"
                    :class="scrolled
                        ?
                        'bg-yellow-500 text-white hover:bg-yellow-400' :
                        'bg-white text-black hover:bg-gray-200'">
                    Login
                </a>
            @endguest

            <!-- HAMBURGER -->
            <button @click="open = true" class="md:hidden text-gray-700 text-xl">
                ☰
            </button>

        </div>

    </nav>

    <!-- OVERLAY -->
    <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/40 z-50" x-transition.opacity>
    </div>

    <!-- SIDEBAR -->
    <div x-show="open" class="fixed top-0 left-0 w-64 h-full bg-white z-[60] shadow-xl p-6 overflow-y-auto"
        x-transition:enter="transform transition duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform transition duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

        <div class="flex justify-between items-center mb-6">
            <h2 class="font-bold text-lg">Menu</h2>
            <button @click="open = false">✕</button>
        </div>

        <nav class="flex flex-col gap-4 text-gray-700 font-medium">

            <a href="#home" @click="open=false">Home</a>
            <a href="#about" @click="open=false">About</a>
            <a href="#court" @click="open=false">Courts</a>
            <a href="#pricing" @click="open=false">Pricing</a>

            <hr>

            @guest
                <a href="{{ route('login') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-center">
                    Login
                </a>
            @endguest

        </nav>

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
