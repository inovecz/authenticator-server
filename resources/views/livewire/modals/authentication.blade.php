<div class="flex bg-white min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="w-full max-w-md space-y-8">
        <div>
            <svg class="fill-gray-900 h-10 mx-auto" viewBox="0 0 103 23" xmlns="http://www.w3.org/2000/svg">
                <path d="M-2.22044605e-16,1.98 L-2.22044605e-16,20.34 C-1.24649665e-16,21.13529 0.64470996,21.78 1.44,21.78 C2.23529004,21.78 2.88,21.13529 2.88,20.34 L2.88,1.98 C2.88,1.18470996 2.23529004,0.54 1.44,0.54 C0.64470996,0.54 -3.19439545e-16,1.18470996 -2.22044605e-16,1.98 Z M13.23,0.54 C12.1861818,0.54 11.34,1.38618182 11.34,2.43 L11.34,20.34 C11.34,21.13529 11.98471,21.78 12.78,21.78 C13.57529,21.78 14.22,21.13529 14.22,20.34 L14.22,4.32 L14.28,4.32 L25.5050687,20.9011929 C25.8771227,21.4507752 26.4975717,21.78 27.161247,21.78 L27.93,21.78 C28.9406811,21.78 29.76,20.9606811 29.76,19.95 L29.76,1.98 C29.76,1.18470996 29.11529,0.54 28.32,0.54 C27.52471,0.54 26.88,1.18470996 26.88,1.98 L26.88,18 L26.82,18 L15.7141469,1.42665002 C15.3428316,0.872533317 14.7197097,0.54 14.0526862,0.54 L13.23,0.54 Z M47.97,0 C41.61,0 36.9,4.77 36.9,11.16 C36.9,17.67 41.76,22.32 47.97,22.32 C54.48,22.32 59.04,17.4 59.04,11.16 C59.04,4.53 54.12,0 47.97,0 Z M39.96,11.16 C39.96,6.33 43.32,2.7 47.94,2.7 C52.83,2.7 55.98,6.48 55.98,11.16 C55.98,15.99 52.62,19.62 47.97,19.62 C43.08,19.62 39.96,15.78 39.96,11.16 Z M64.935,0.54 C64.7944496,0.54 64.6551057,0.565934434 64.5239666,0.616500773 C63.9352439,0.843508251 63.6420158,1.50478821 63.8690233,2.0935109 L70.9743055,20.5203966 C71.2669658,21.2793839 71.9965433,21.78 72.81,21.78 C73.6245777,21.78 74.3563008,21.2818604 74.6549477,20.5240037 L81.952561,2.00532905 C82.0018943,1.88013918 82.0272224,1.74678195 82.0272224,1.61222238 C82.0272224,1.02005031 81.5471721,0.54 80.955,0.54 L80.7660009,0.54 C79.9323118,0.54 79.1860704,1.05714567 78.8933426,1.83775312 L72.9,17.82 L72.84,17.82 L67.0769234,1.86071107 C66.7907223,1.06815401 66.0384649,0.54 65.1958156,0.54 L64.935,0.54 Z M90.08,0.54 C88.9754305,0.54 88.08,1.4354305 88.08,2.54 L88.08,19.78 C88.08,20.8845695 88.9754305,21.78 90.08,21.78 L100.98,21.78 C101.725584,21.78 102.33,21.1755844 102.33,20.43 C102.33,19.6844156 101.725584,19.08 100.98,19.08 L90.96,19.08 L90.96,12.27 L99.69,12.27 C100.435584,12.27 101.04,11.6655844 101.04,10.92 C101.04,10.1744156 100.435584,9.57 99.69,9.57 L90.96,9.57 L90.96,3.24 L100.44,3.24 C101.185584,3.24 101.79,2.63558441 101.79,1.89 C101.79,1.14441559 101.185584,0.54 100.44,0.54 L90.08,0.54 Z"></path>
            </svg>
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
                @endif
                @if($action === 'register')
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-sm text-gray-900">Jméno</label>
                        <input id="name" wire:model="name" type="text" autocomplete="name" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Jméno">
                        @error('name') <span class="validation-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="surname" class="text-sm text-gray-900">Příjmení</label>
                        <input id="surname" wire:model="surname" type="text" autocomplete="surname" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Příjmení">
                        @error('surname') <span class="validation-error">{{ $message }}</span> @enderror
                    </div>
                @endif
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm text-gray-900">E-mailová adresa</label>
                    <input id="email" wire:model="email" type="email" autocomplete="email" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="E-mailová adresa">
                    @error('email') <span class="validation-error">{{ $message }}</span> @enderror
                </div>
                @if($action === 'login' || $action === 'register')
                    <div class="flex flex-col gap-2">
                        <label for="password" class="text-sm text-gray-900">Heslo</label>
                        <input id="password" wire:model="password" type="password" autocomplete="current-password" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Heslo">
                        @error('password') <span class="validation-error">{{ $message }}</span> @enderror
                    </div>
                @endif
                @if($action === 'register')
                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation" class="text-sm text-gray-900">Ověření hesla</label>
                        <input id="password_confirmation" wire:model="password_confirmation" type="password" required class="relative block w-full appearance-none rounded-md shadow-sm border border-gray-300 border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm" placeholder="Ověření hesla">
                        @error('password_confirmation') <span class="validation-error">{{ $message }}</span> @enderror
                    </div>
                @endif
                <div wire:loading wire:target="submit">
                    <div class="flex items-center justify-center ">
                        <div class="w-20 h-20 border-t-4 border-b-4 border-green-900 rounded-full animate-spin"></div>
                    </div>
                </div>

                @if($loginScoreResponse)
                    <div wire:loading.remove wire:target="submit" class="flex flex-col text-center">
                        <div class="text-2xl font-bold">{{ $loginScoreResponse['score'] ?? 'N/A' }}</div>
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
