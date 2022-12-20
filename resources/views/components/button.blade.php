@props(['click', 'type' => 'button', 'button' => 'primary', 'awesomeIcon', 'wide'])
@php
    $type = !in_array($type, ['button', 'submit', 'reset'], true) ? 'button' : $type;
    $buttonStyle = App\Enums\ButtonStyle::tryfrom($button) ?: App\Enums\ButtonStyle::PRIMARY;
@endphp
<button {{ $attributes->merge(['class' => $buttonStyle->getClass() . ' ' . (isset($awesomeIcon) && !isset($wide) ? 'pl-10' : '') . ' ' . (isset($wide) ? 'w-full' : '') . ' items-center group whitespace-nowrap relative flex justify-center py-2 px-4 text-sm font-medium ' . ($button !== 'text' ? 'focus:outline-none focus:ring-2 focus:ring-offset-2' : '') ]) }} {!! isset($click) ? 'onClick="' . $click . '"' : '' !!} type="{{ $type }}">
    @if(isset($awesomeIcon))
        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="{{ $awesomeIcon }}"></i></span>
    @endif
    {{ $slot }}
</button>
