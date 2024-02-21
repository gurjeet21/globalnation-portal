<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value='__("What is your email address?")' />
            <x-text-input 
            id="email" 
            class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray" 
            type="email" 
            name="email" 
            :value="old('email')" 
            required 
            autofocus
            placeholder="john@deo.com"
            autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('What username would you like?')" />
            <x-text-input id="name" 
            class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray"
            type="text" 
            name="name" 
            :value="old('name')" 
            required 
            placeholder="jogndeo"
            autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Create a password')" />

            <x-text-input id="password" class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <span class="text-xs dark:text-gray-400">Use 8 or more characters with a mix of letters, numbers & symbols</span>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Repeat password')" />

            <x-text-input id="password_confirmation" class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray"
                            type="password"
                            placeholder="Repeat your password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="block w-full text-center px-4 py-2 text-sm font-medium leading-5  text-white bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8] focus:outline-none">
                {{ __('Register') }}
            </button>
        </div>

        <hr class="my-5" />

        <p class="mt-4">
        <a
            class="text-sm font-medium text-[#297a99] hover:underline"
            href="{{ route('login') }}"
        >
            {{ __('Already have an account? Login') }}
        </a>
        </p>
    </form>
</x-guest-layout>
