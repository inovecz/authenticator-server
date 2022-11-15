<div class="rounded-lg bg-white border border-blue-300 overflow-hidden">
    <div class="text-lg bg-blue-100 text-blue-700 px-4 py-2 border-b border-blue-300">Úprava záznamu</div>
    <form wire:submit.prevent="submit" class="p-4 space-y-6">
        <div class="flex flex-col gap-4">
            <input type="hidden" wire:model="blacklistId">
            <input type="hidden" wire:model="type">
            <div class="flex flex-col gap-2">
                <label for="value" class="text-sm text-gray-900">Hodnota</label>
                <input id="value" wire:model="value" type="text" autocomplete="value" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Hodnota">
                @error('value') <span class="validation-error">{{ $message }}</span> @enderror
            </div>
            <div class="flex flex-col gap-2">
                <label for="reason" class="text-sm text-gray-900">Důvod</label>
                <input id="reason" wire:model="reason" type="text" autocomplete="reason" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Důvod">
                @error('reason') <span class="validation-error">{{ $message }}</span> @enderror
            </div>
            <div class="flex items-top">
                <input id="active" wire:model="active" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="1">
                <label for="active" class="ml-2 block text-sm text-gray-900">Aktivní</label>
            </div>
            <div class="flex justify-end">
                <x-button type="button" button="text">Zrušit</x-button>
                <x-button type="submit" button="primary">Uložit</x-button>
            </div>
        </div>
    </form>
</div>
