<div class="rounded-lg bg-white border border-blue-300 overflow-hidden">
  <div class="text-lg bg-blue-100 text-blue-700 px-4 py-2 border-b border-blue-300">
    @if($user)
      Úprava uživatele {{$user['surname'] . ' ' . $user['name']}}
    @else
      Nový uživatel
    @endif
  </div>
  <form wire:submit.prevent="submit" class="p-4 space-y-6">
    <div class="flex flex-col gap-4">
      <input type="hidden" wire:model="hash">
      <div class="flex flex-col gap-2">
        <label for="name" class="text-sm text-gray-900">Jméno</label>
        <input id="name" wire:model="name" type="text" autocomplete="name" required placeholder="Jméno" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @error('name') <span class="validation-error">{{ $message }}</span> @enderror
      </div>
      <div class="flex flex-col gap-2">
        <label for="surname" class="text-sm text-gray-900">Příjmení</label>
        <input id="surname" wire:model="surname" type="text" autocomplete="surname" required placeholder="Příjmení" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @error('surname') <span class="validation-error">{{ $message }}</span> @enderror
      </div>
      <div class="flex flex-col gap-2">
        <label for="gender" class="text-sm text-gray-900">Pohlaví</label>
        <select wire:model="gender" class="relative w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5">
          <option value="OTHER">Nespecifikováno</option>
          <option value="MALE">Muž</option>
          <option value="FEMALE">Žena</option>
        </select>
      </div>
      <div class="flex flex-col gap-2">
        <label for="email" class="text-sm text-gray-900">E-mail</label>
        <input id="email" wire:model="email" type="email" autocomplete="email" required placeholder="E-mail" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @error('email') <span class="validation-error">{{ $message }}</span> @enderror
      </div>
      <div class="flex flex-col gap-2">
        <label for="phone" class="text-sm text-gray-900">Telefon</label>
        <input id="phone" wire:model="phone" type="tel" autocomplete="phone" placeholder="Telefon ve formátu +123456789012" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @error('phone') <span class="validation-error">{{ $message }}</span> @enderror
      </div>

      <div class="flex flex-col gap-2">
        <label for="phone" class="text-sm text-gray-900">Heslo</label>
        <input id="phone" wire:model="password" type="password" placeholder="" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @error('password') <span class="validation-error">{{ $message }}</span> @enderror
      </div>
      <div class="flex flex-col gap-2">
        <label for="phone" class="text-sm text-gray-900">Kontrola hesla</label>
        <input id="phone" wire:model="passwordConfirmation" type="password" placeholder="" class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
        @error('passwordConfirmation') <span class="validation-error">{{ $message }}</span> @enderror
      </div>

      <div class="flex justify-end">
        <x-button wire:click="cancel()" type="button" button="text">Zrušit</x-button>
        <x-button type="submit" button="primary">Uložit</x-button>
      </div>
    </div>
  </form>
</div>
