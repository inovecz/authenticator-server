@extends('layouts.admin')

@section('content')
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Přihlášení do administrace</h2>
            </div>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-sm text-gray-900">E-mailová adresa</label>
                        <input id="email" name="email" type="email" autocomplete="email" required autofocus
                               value="{{ old('email') }}"
                               class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="E-mailová adresa">
                        @error('email') <span class="validation-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-sm text-gray-900">Heslo</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               value="{{ old('password') }}"
                               class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Heslo">
                        @error('password') <span class="validation-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex items-top">
                        <input id="remember_me" name="remember" type="checkbox" value="1"
                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Zapamatovat přihlášení</label>
                    </div>
                    <x-button type="submit" button="primary" awesome-icon="fa-solid fa-lock">Přihlásit se</x-button>
                </div>
            </form>
        </div>
    </div>

@endsection
