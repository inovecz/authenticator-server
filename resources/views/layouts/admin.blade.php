<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @hasSection('title')
            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>{{ config('app.name') }}</title>
        @endif
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    <body>
        <div class="flex items-top justify-center min-h-screen">
            <div class="flex-none">
                @livewire('admin.menu')
            </div>
            <div class="grow bg-gray-50 min-h-screen max-h-screen overflow-y-auto p-4">
                @yield('content')
            </div>
        </div>
        @include('helpers.screen-size', ['location' => 'bottom-center'])
        @livewireScripts
        @livewire('livewire-ui-modal')
        @stack('scripts')
    </body>
</html>
