@extends('layouts.admin')

@section('content')
    <div class="px-4 py-16 mx-auto lg:max-w-screen-xl lg:px-8">
        <div class="grid grid-cols-3 row-gap-8 md:grid-cols-3 divide-x">
            <div class="text-center">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">{{ number_format_short($usersCount) }}</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Uživatelů
                </p>
            </div>
            <div class="text-center">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">{{ number_format_short($loginCount) }}</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Přihlášení
                </p>
            </div>
            <div class="text-center">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">{{ round($averageScore, 1) }}</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Ø skóre
                </p>
            </div>
        </div>
    </div>
@endsection
