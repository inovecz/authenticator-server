<div>
    <button wire:click="{!! $click !!}" type="{{ $type }}" class="{{ $buttonStyle->getClass() }} group whitespace-nowrap relative flex w-full justify-center py-2 px-4 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2">
        @if($awesomeIcon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="{{ $awesomeIcon }}"></i></span>
        @endif
        {{ $title }}
    </button>
</div>
