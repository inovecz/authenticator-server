<div class="flex bg-white min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
  <div class="w-full max-w-md space-y-8">
    <div>
      @switch($action)
        @case('register')
          <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Registrujte si účet</h2>
          @break
        @case('forgottenPassword')
          <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Zapomenuté heslo</h2>
          @break
        @default
          <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Přihlašte se ke svému účtu</h2>
      @endswitch
    </div>
    <form wire:submit.prevent="submit" class="mt-8 space-y-6">
      <div class="flex flex-col gap-4">
        @if($action === 'login')
          <input type="hidden" name="remember" value="true">
          <input wire:model.defer="elapsedTime" id="elapsedTime" type="hidden" name="elapsedTime" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseMaxSpeed" id="mouseMaxSpeed" type="hidden" name="mouseMaxSpeed" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseAvgSpeed" id="mouseAvgSpeed" type="hidden" name="mouseAvgSpeed" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseMaxAccel" id="mouseMaxAccel" type="hidden" name="mouseMaxAccel" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseAvgAccel" id="mouseAvgAccel" type="hidden" name="mouseAvgAccel" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseMovement" id="mouseMovement" type="hidden" name="mouseMovement" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseClicks" id="mouseClicks" type="hidden" name="mouseClicks" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseSelections" id="mouseSelections" type="hidden" name="mouseSelections" @change="$dispatch('input', $event.target.value)">
          <input wire:model.defer="mouseScrolls" id="mouseScrolls" type="hidden" name="mouseScrolls" @change="$dispatch('input', $event.target.value)">
        @endif
        @if($action === 'register')
          <div class="flex flex-col gap-2">
            <label for="name" class="text-sm text-gray-900">Jméno</label>
            <input id="name" wire:model="name" type="text" autocomplete="name" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Jméno">
            @error('name') <span class="validation-error">{{ $message }}</span> @enderror
          </div>
          <div class="flex flex-col gap-2">
            <label for="surname" class="text-sm text-gray-900">Příjmení</label>
            <input id="surname" wire:model="surname" type="text" autocomplete="surname" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Příjmení">
            @error('surname') <span class="validation-error">{{ $message }}</span> @enderror
          </div>
        @endif
        <div class="flex flex-col gap-2">
          <label for="email" class="text-sm text-gray-900">E-mailová adresa</label>
          <input id="email" wire:model="email" type="email" autocomplete="email" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="E-mailová adresa">
          @error('email') <span class="validation-error">{{ $message }}</span> @enderror
        </div>
        @if($action === 'login' || $action === 'register')
          <div class="flex flex-col gap-2">
            <label for="password" class="text-sm text-gray-900">Heslo</label>
            <input id="password" wire:model="password" type="password" autocomplete="current-password" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Heslo">
            @error('password') <span class="validation-error">{{ $message }}</span> @enderror
          </div>
        @endif
        @if($action === 'register')
          <div class="flex flex-col gap-2">
            <label for="password_confirmation" class="text-sm text-gray-900">Ověření hesla</label>
            <input id="password_confirmation" wire:model="password_confirmation" type="password" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Ověření hesla">
            @error('password_confirmation') <span class="validation-error">{{ $message }}</span> @enderror
          </div>
        @endif
        @if($twoFactorRequired)
          <div class="flex flex-col gap-2">
            <label for="verification_code" class="text-sm text-gray-900">Ověřovací kód</label>
            <input id="verification_code" wire:model="verification_code" type="text" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Ověřovací kód">
            @error('verification_code') <span class="validation-error">{{ $message }}</span> @enderror
          </div>
          <input type="hidden" wire:model="loginAttemptId">
        @endif
        <div wire:loading wire:target="submit">
          <div class="flex items-center justify-center ">
            <div class="w-20 h-20 border-t-4 border-b-4 border-green-900 rounded-full animate-spin"></div>
          </div>
        </div>

        @if($loginScoreResponse)
          <div wire:loading.remove wire:target="submit" class="flex flex-col text-center">
            <div class="text-2xl font-bold">{{ isset($loginScoreResponse['score']) ? round($loginScoreResponse['score'], 2) : 'N/A' }}</div>
            <div class="text-xs text-gray-500">Login score</div>
            <div class="text-left">
              @dump($loginScoreResponse)
            </div>
          </div>
        @endif
      </div>

      <div class="flex items-top justify-between">
        <div class="flex items-top">
          @if($action === 'login')
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="remember-me" class="ml-2 block text-sm text-gray-900">Zapamatovat přihlášení</label>
          @endif
        </div>

        <div class="text-sm">
          @if($action === 'login')
            <a wire:click.prevent="switchTo('register')" href="#" class="block font-medium text-blue-600 hover:text-blue-500">Chcete se registrovat?</a>
          @endif
          @if($action === 'register' || $action === 'forgottenPassword')
            <a wire:click.prevent="switchTo('login')" href="#" class="block font-medium text-blue-600 hover:text-blue-500">Chtěli jste se přihlásit?</a>
          @endif
          <a wire:click.prevent="switchTo('forgottenPassword')" href="#" class="block font-medium text-blue-600 hover:text-blue-500">Zapomněli jste heslo?</a>
        </div>
      </div>

      @error('scoring_engine') <span class="validation-error">{{ $message }}</span> @enderror

      @switch($action)
        @case('register')
          <x-button type="submit" button="primary" awesome-icon="fa-solid fa-user-plus" wide>Registrovat se</x-button>
          @break
        @case('forgottenPassword')
          <x-button type="submit" button="primary" awesome-icon="fa-solid fa-user-key" wide>Obnovit heslo</x-button>
          @break
        @default
          <x-button type="submit" button="primary" awesome-icon="fa-solid fa-lock" wide>Přihlásit se</x-button>
      @endswitch

    </form>
  </div>
</div>



