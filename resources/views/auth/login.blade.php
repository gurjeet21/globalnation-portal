<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="john@doe.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="***************" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <button class="block w-full text-center px-4 py-2 mt-4 text-sm font-medium leading-5  text-white bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8] focus:outline-none">
            {{ __('Log in') }}
        </button>

        <hr class="my-8" />

        <p class="mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#297a99] hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </p>

        <p class="mt-1">
        @if (Route::has('register'))
            <a class="text-sm font-medium text-[#297a99] hover:underline" href="{{ route('register') }}">
                {{ __('Create account') }}
            </a>
        @endif
        </p>
    </form>
</x-guest-layout>
