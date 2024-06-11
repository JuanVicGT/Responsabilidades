<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tab-title', config('app.name', 'Laravel'))</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Custom Styles and Scripts -->
    @yield('custom-css')
    @yield('custom-js')
</head>

<body class="min-h-screen font-sans antialiased">

    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            <div class="ml-5 pt-5">App</div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main full-width>

        {{-- SIDEBAR --}}
        <x-layouts.sidebar />

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            @yield('content-header')

            @if (session('alerts'))
                @foreach (session('alerts') as $alert)
                    <x-mary-alert title="{{ $alert->message }}" icon="{{ $alert->icon }}"
                        class="mb-4 {{ $alert->type }}" shadow dismissible />
                @endforeach
            @endif

            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- Toast --}}
    <x-mary-toast />

    {{-- Scripts area --}}
    @livewireScripts
</body>

</html>
