<x-guest-layout>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Create Account
    </h1>

    <p class="text-gray-500 mb-8 text-sm">
        Join Gumbreg Court and start booking today
    </p>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">
                Full Name
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">
                Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">
                Password
            </label>
            <input type="password" name="password" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block text-sm text-gray-700 mb-2">
                Confirm Password
            </label>
            <input type="password" name="password_confirmation" required
                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition">
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-yellow-500 text-white py-3 rounded-xl font-semibold hover:bg-yellow-400 transition">
            Register
        </button>

        <!-- Login Link -->
        <p class="text-sm text-center text-gray-500 mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-yellow-500 font-medium hover:underline">
                Login
            </a>
        </p>

    </form>

</x-guest-layout>
