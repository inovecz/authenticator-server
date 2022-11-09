<nav x-cloak x-data="{menuCollapsed: $persist(false)}" :class="menuCollapsed ? 'w-11' : 'w-64'" class="flex flex-col justify-between min-h-screen flex flex-col bg-slate-800 text-gray-50 pb-10">
    <div x-show="!menuCollapsed" class="flex flex-col gap-4 my-4">
        <svg class="fill-gray-50 h-10 mx-auto" viewBox="0 0 103 23" xmlns="http://www.w3.org/2000/svg">
            <path d="M-2.22044605e-16,1.98 L-2.22044605e-16,20.34 C-1.24649665e-16,21.13529 0.64470996,21.78 1.44,21.78 C2.23529004,21.78 2.88,21.13529 2.88,20.34 L2.88,1.98 C2.88,1.18470996 2.23529004,0.54 1.44,0.54 C0.64470996,0.54 -3.19439545e-16,1.18470996 -2.22044605e-16,1.98 Z M13.23,0.54 C12.1861818,0.54 11.34,1.38618182 11.34,2.43 L11.34,20.34 C11.34,21.13529 11.98471,21.78 12.78,21.78 C13.57529,21.78 14.22,21.13529 14.22,20.34 L14.22,4.32 L14.28,4.32 L25.5050687,20.9011929 C25.8771227,21.4507752 26.4975717,21.78 27.161247,21.78 L27.93,21.78 C28.9406811,21.78 29.76,20.9606811 29.76,19.95 L29.76,1.98 C29.76,1.18470996 29.11529,0.54 28.32,0.54 C27.52471,0.54 26.88,1.18470996 26.88,1.98 L26.88,18 L26.82,18 L15.7141469,1.42665002 C15.3428316,0.872533317 14.7197097,0.54 14.0526862,0.54 L13.23,0.54 Z M47.97,0 C41.61,0 36.9,4.77 36.9,11.16 C36.9,17.67 41.76,22.32 47.97,22.32 C54.48,22.32 59.04,17.4 59.04,11.16 C59.04,4.53 54.12,0 47.97,0 Z M39.96,11.16 C39.96,6.33 43.32,2.7 47.94,2.7 C52.83,2.7 55.98,6.48 55.98,11.16 C55.98,15.99 52.62,19.62 47.97,19.62 C43.08,19.62 39.96,15.78 39.96,11.16 Z M64.935,0.54 C64.7944496,0.54 64.6551057,0.565934434 64.5239666,0.616500773 C63.9352439,0.843508251 63.6420158,1.50478821 63.8690233,2.0935109 L70.9743055,20.5203966 C71.2669658,21.2793839 71.9965433,21.78 72.81,21.78 C73.6245777,21.78 74.3563008,21.2818604 74.6549477,20.5240037 L81.952561,2.00532905 C82.0018943,1.88013918 82.0272224,1.74678195 82.0272224,1.61222238 C82.0272224,1.02005031 81.5471721,0.54 80.955,0.54 L80.7660009,0.54 C79.9323118,0.54 79.1860704,1.05714567 78.8933426,1.83775312 L72.9,17.82 L72.84,17.82 L67.0769234,1.86071107 C66.7907223,1.06815401 66.0384649,0.54 65.1958156,0.54 L64.935,0.54 Z M90.08,0.54 C88.9754305,0.54 88.08,1.4354305 88.08,2.54 L88.08,19.78 C88.08,20.8845695 88.9754305,21.78 90.08,21.78 L100.98,21.78 C101.725584,21.78 102.33,21.1755844 102.33,20.43 C102.33,19.6844156 101.725584,19.08 100.98,19.08 L90.96,19.08 L90.96,12.27 L99.69,12.27 C100.435584,12.27 101.04,11.6655844 101.04,10.92 C101.04,10.1744156 100.435584,9.57 99.69,9.57 L90.96,9.57 L90.96,3.24 L100.44,3.24 C101.185584,3.24 101.79,2.63558441 101.79,1.89 C101.79,1.14441559 101.185584,0.54 100.44,0.54 L90.08,0.54 Z"></path>
        </svg>
        <div class="text-center text-xl">Authenticator</div>
    </div>
    <ul class="flex flex-col flex-1">
        @if(Auth::user())
            @foreach($menuItems['top']['admin'] as $menuItem)
                <a href="{{ route($menuItem['link']) }}">
                    <li :class="menuCollapsed ? 'pl-3' : 'pl-4'" class="relative px-4 py-2 h-10 border-y border-y-transparent {{ request()->is($menuItem['activeRoute']) ? 'bg-gray-50' : 'hover:bg-slate-700 hover:border-y-gray-500'}}">
                        <i class="absolute {{ $menuItem['icon'] }} text-slate-400 mt-1"></i>
                        <span x-show="!menuCollapsed" class="pl-8 {{ request()->is($menuItem['activeRoute']) ? 'text-slate-900' : 'text-slate-50'}}">{{ $menuItem['name'] }}</span>
                        @if(request()->is($menuItem['activeRoute']))
                            @include('components.active-menu-beaks')
                        @endif
                    </li>
                </a>
            @endforeach
        @else
            @foreach($menuItems['top']['guest'] as $menuItem)
                <a href="{{ route($menuItem['link']) }}">
                    <li :class="menuCollapsed ? 'pl-3' : 'pl-4'" class="relative px-4 py-2 h-10 border-y border-y-transparent {{ request()->is($menuItem['activeRoute']) ? 'bg-gray-50' : 'hover:bg-slate-700 hover:border-y-gray-500'}}">
                        <i class="absolute {{ $menuItem['icon'] }} text-slate-400 mt-1"></i>
                        <span x-show="!menuCollapsed" class="pl-8 {{ request()->is($menuItem['activeRoute']) ? 'text-slate-900' : 'text-slate-50'}}">{{ $menuItem['name'] }}</span>
                        @if(request()->is($menuItem['activeRoute']))
                            @include('components.active-menu-beaks')
                        @endif
                    </li>
                </a>
            @endforeach
        @endif
        <li class="flex-1"></li>
        @if(Auth::user())
            @foreach($menuItems['bottom']['admin'] as $menuItem)
                <a href="{{ route($menuItem['link']) }}">
                    <li :class="menuCollapsed ? 'pl-3' : 'pl-4'" class="relative px-4 py-2 h-10 border-y border-y-transparent {{ request()->is($menuItem['activeRoute']) ? 'bg-gray-50' : 'hover:bg-slate-700 hover:border-y-gray-500'}}">
                        <i class="absolute {{ $menuItem['icon'] }} text-slate-400 mt-1"></i>
                        <span x-show="!menuCollapsed" class="pl-8 {{ request()->is($menuItem['activeRoute']) ? 'text-slate-900' : 'text-slate-50'}}">{{ $menuItem['name'] }}</span>
                        @if(request()->is($menuItem['activeRoute']))
                            @include('components.active-menu-beaks')
                        @endif
                    </li>
                </a>
            @endforeach
            <li :class="menuCollapsed ? 'pl-3 flex-col-reverse' : 'pl-4'"  class="relative px-4 py-2 flex gap-4 justify-between z-10">
                <button class="text-slate-400 hover:text-slate-300 w-3" @click="menuCollapsed = !menuCollapsed">
                    <i x-show="!menuCollapsed" class="fa-solid fa-ellipsis-vertical"></i>
                    <i x-show="menuCollapsed" class="fa-solid fa-bars"></i>
                </button>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-slate-300">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </li>
        @endif
    </ul>

</nav>
