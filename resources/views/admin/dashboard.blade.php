@extends('layouts.admin')

@section('content')
    <div class="mx-auto my-4 lg:max-w-screen-xl ">
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

    <div class="mx-auto mt-10 lg:max-w-screen-xl border border-gray-200 rounded bg-white flex px-4">
        <div class="grow">
            <div class="text-3xl font-extralight py-2">Blacklist</div>
            <div class="grid grid-cols-3 py-2 text-lg">
                <div>
                    <span class="text-xl text-gray-700 leading-wide">IP adresy:</span>
                    <span class="text-xl font-bold text-gray-900">{{ $blacklistCount['IP'] }}</span>
                </div>
                <div>
                    <span class="text-xl text-gray-700 leading-wide">Domény:</span>
                    <span class="text-xl font-bold text-gray-900">{{ $blacklistCount['DOMAIN'] }}</span>
                </div>
                <div>
                    <span class="text-xl text-gray-700 leading-wide">Emaily:</span>
                    <span class="text-xl font-bold text-gray-900">{{ $blacklistCount['EMAIL'] }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
