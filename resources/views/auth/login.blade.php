<x-guest-layout>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Login
    </h1>

    <p class="text-gray-500 mb-8 text-sm">
        Welcome back to Gumbreg Court
    </p>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- GOOGLE LOGIN BUTTON -->
        <a href="#"
           class="w-full flex items-center justify-center gap-3 border border-gray-300 py-3 rounded-xl hover:bg-gray-50 transition font-medium">

            <!-- Google SVG -->
            <svg class="w-5 h-5" viewBox="0 0 48 48">
                <path fill="#EA4335"
                    d="M24 9.5c3.9 0 7.4 1.3 10.2 3.9l7.6-7.6C36.6 2.4 30.7 0 24 0 14.6 0 6.5 5.4 2.6 13.2l8.8 6.8C13.5 13.4 18.3 9.5 24 9.5z"/>
                <path fill="#34A853"
                    d="M46.5 24.5c0-1.6-.1-2.8-.4-4H24v8h12.8c-.3 2-1.9 5-5.4 7.1l8.4 6.5c4.9-4.5 7.7-11.1 7.7-17.6z"/>
                <path fill="#FBBC05"
                    d="M11.4 28.9c-1-2-1.5-4.1-1.5-6.4s.5-4.4 1.5-6.4l-8.8-6.8C.9 12.6 0 16.2 0 20.5s.9 7.9 2.6 11.2l8.8-6.8z"/>
                <path fill="#4285F4"
                    d="M24 48c6.7 0 12.6-2.2 16.8-6l-8.4-6.5c-2.3 1.5-5.2 2.5-8.4 2.5-5.7 0-10.5-3.9-12.2-9.1l-8.8 6.8C6.5 42.6 14.6 48 24 48z"/>
            </svg>

            Continue with Google
        </a>

        <!-- Divider -->
        <div class="flex items-center gap-4">
            <div class="flex-1 h-px bg-gray-300"></div>
            <span class="text-sm text-gray-400">or sign in with email</span>
            <div class="flex-1 h-px bg-gray-300"></div>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">
                Email
            </label>
            <input type="email" name="email"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">
                Password
            </label>
            <input type="password" name="password"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
        </div>

        <button type="submit"
            class="w-full bg-yellow-500 text-white py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
            Login
        </button>

        <!-- REGISTER LINK -->
        <p class="text-sm text-center text-gray-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="text-yellow-500 font-medium hover:underline">
                Register
            </a>
        </p>

    </form>

</x-guest-layout>
