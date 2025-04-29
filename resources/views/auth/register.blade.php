<x-guest-layout>
    <!-- Register Header -->
    <div class="text-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-100">Create Account</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Join our casino and start playing today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <x-text-input id="name" class="block w-full pl-10 pr-3 py-2 rounded-lg" type="text" name="name"
                :value="old('name')" placeholder="Full Name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <x-text-input id="email" class="block w-full pl-10 pr-3 py-2 rounded-lg" type="email" name="email"
                :value="old('email')" placeholder="Email Address" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <x-text-input id="password" class="block w-full pl-10 pr-3 py-2 rounded-lg" type="password" name="password"
                placeholder="Password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <x-text-input id="password_confirmation" class="block w-full pl-10 pr-3 py-2 rounded-lg" type="password"
                name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox"
                        class="rounded dark:bg-zinc-800 border-gray-300 dark:border-gray-700 text-yellow-500 shadow-sm focus:ring-yellow-500 dark:focus:ring-yellow-400 dark:focus:ring-offset-zinc-800"
                        required>
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="text-gray-600 dark:text-gray-400">I agree to the <a href="#"
                            class="text-yellow-500 dark:text-yellow-400 hover:text-yellow-600 dark:hover:text-yellow-300">Terms
                            and Conditions</a></label>
                </div>
            </div>
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit"
                class="w-full py-3 px-4 bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-400 dark:hover:bg-yellow-500 text-black font-bold rounded-lg shadow-md transition duration-300 flex items-center justify-center">
                <span>{{ __('Create Account') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}"
                    class="font-medium text-yellow-500 dark:text-yellow-400 hover:text-yellow-600 dark:hover:text-yellow-300">
                    {{ __('Sign in') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
