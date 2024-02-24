<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GlobalNation TV - Create, Connect, Collect</title>
        <link rel="icon" type="image/png" href="{{asset('favicon.png')}}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
            <div
                class="flex-1 h-full max-w-4xl mx-auto p-2.5 border-solid border-4 bg-[#f0f0f0] border-[#e1e6e6] overflow-hidden rounded-lg shadow-xl dark:bg-gray-800"
            >
                <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img
                    aria-hidden="true"
                    class="object-cover w-full h-full dark:hidden"
                    src="../assets/img/GNTV-bg-home.svg"
                    alt="Office"
                    />
                    <img
                    aria-hidden="true"
                    class="hidden object-cover w-full h-full dark:block"
                    src="../assets/img/GNTV-bg-home.svg"
                    alt="Office"
                    />
                </div>

                <div class="flex items-center justify-center p-6 sm:p-8 md:w-1/2 bg-white">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            </div>

    </body>
</html>
