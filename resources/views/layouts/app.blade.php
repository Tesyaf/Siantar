<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white flex flex-col">
            @include('partials.header')

            <!-- Main Content -->
            <div class="flex-1 flex flex-col transition-all duration-300">
                
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="w-full py-6 flex justify-between items-center">
                            <div>{{ $header }}</div>
                            <div class="text-sm text-gray-500">
                                {{ Auth::user()->name }} ({{ Auth::user()->roleLabel() }})
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            @include('partials.footer')
        </div>
        @stack('scripts')
    </body>
</html>



