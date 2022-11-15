@php
    $borderColor = match ($type) {
        'success' => 'border-emerald-300',
        'warning' => 'border-amber-300',
        'danger' => 'border-red-300',
        default => 'border-blue-300',
    };

    $textColor = match ($type) {
        'success' => 'text-emerald-700',
        'warning' => 'text-amber-700',
        'danger' => 'text-red-700',
        default => 'text-blue-700',
    };

    $headingBgColor = match ($type) {
        'success' => 'bg-emerald-100',
        'warning' => 'bg-amber-100',
        'danger' => 'bg-red-100',
        default => 'bg-blue-100',
    };
@endphp

<div class="rounded-lg border bg-white {{ $borderColor }} overflow-hidden">
    <div class="text-lg {{ $textColor }} {{ $headingBgColor }} px-4 py-2 border-b {{ $borderColor }}">{{ $title }}</div>
    <div class="p-4">{{ $text }}</div>
    <div class="px-4 py-2 flex justify-end gap-4">
        <div wire:click.prevent="cancel()">
            <x-button type="button" button="text">Zrušit</x-button>
        </div>
        <div wire:click.prevent="process()">
            <x-button type="button" button="{{ $type }}">Potvrdit</x-button>
        </div>
    </div>
</div>
