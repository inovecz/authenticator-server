@extends('layouts.guest')

@section('content')

    <div class="flex items-center justify-center min-h-screen bg-transparent sm:items-center py-4 sm:pt-0">
        <div class="flex flex-col gap-8">
            <div class="flex items-center justify-center flex-col sm:flex-row gap-3 sm:gap-4">
                <span class="text-2xl sm:text-5xl text-gray-100 font-light">Authenticator Server</span>
            </div>
            <div class="relative flex flex-col sm:flex-row gap-4 backdrop-blur-lg bg-gray-500/30 border border-gray-200/30 rounded-xl px-8 sm:px-32 py-8 shadow-lg">
                <x-button :click="'Livewire.emit(\'openModal\', \'modals.authentication\', {\'action\': \'login\'})'" type="submit" button="primary" wide>Přihlášení</x-button>
                <x-button :click="'Livewire.emit(\'openModal\', \'modals.authentication\', {\'action\': \'register\'})'" type="submit" button="primary" wide>Registrace</x-button>
                <x-button :click="'Livewire.emit(\'openModal\', \'modals.authentication\', {\'action\': \'forgottenPassword\'})'" type="submit" button="secondary" wide>Zapomenuté heslo</x-button>
            </div>
        </div>
    </div>
@endsection
