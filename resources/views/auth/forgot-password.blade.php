<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" 
            class="block w-full mt-1 bg-gray-100 text-sm dark:border-gray-600 focus:border-[#61d5d8] focus:outline-none focus:shadow-outline-[#61d5d8] focus:bg-white dark:text-gray-300 dark:focus:shadow-outline-gray" 
            placeholder="john@deo.com" 
            type="email" 
            name="email" 
            :value="old('email')" 
            required 
            autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="block w-full text-center px-4 py-2 text-sm font-medium leading-5  text-white bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8] focus:outline-none">
            {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
