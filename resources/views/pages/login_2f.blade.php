<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">

        @if(Session::has('error'))
                <div class="alert alert-danger" style="color: red;" role="alert">
              <strong class="font-bold">Error : </strong>
              <span class="">{{session('error')}}</span>
            </div>
            @endif
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{route('login_2fa')}}">
        @csrf

        <div>
            <x-input-label for="code" :value="__('Authentication Code')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <button class="block text-center px-4 py-2 text-sm font-medium leading-5  text-white bg-[#297a99] border border-transparent rounded-lg active:bg-[#61d5d8] hover:bg-[#61d5d8] focus:outline-none">
                {{ __('Verify') }}
            </button>
        </div>
    </form>
</x-guest-layout>
