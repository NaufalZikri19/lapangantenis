<x-guest-layout>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Login
    </h1>

    <p class="text-gray-500 mb-8 text-sm">
        Welcome back to Gumbreg Court
    </p>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

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
            <a href="{{ route('register') }}" class="text-yellow-500 font-medium hover:underline">
                Register
            </a>
        </p>

    </form>

    @if ($errors->has('email'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login gagal',
                    text: 'Email atau password salah!',
                    confirmButtonColor: '#FBBF24'
                });
            });
        </script>
    @endif

</x-guest-layout>
