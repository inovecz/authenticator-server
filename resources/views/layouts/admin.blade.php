<!doctype html>
<html lang="en">
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
        <div class="relative flex items-top justify-center min-h-screen">
            <div class="fixed top-0 left-0 flex-none flex flex-col justify-between w-64 min-h-full max-h-full bg-slate-800 text-gray-50 pb-10">
                @livewire('admin.menu')
            </div>
            <div class="flex-1 bg-gray-50 min-h-full pr-4 pl-72 py-4">
                @yield('content')
            </div>
        </div>
        @include('helpers.screen-size', ['location' => 'bottom-center'])
        @livewireScripts
        @livewire('livewire-ui-modal')
        @stack('scripts')
    </body>
</html>
