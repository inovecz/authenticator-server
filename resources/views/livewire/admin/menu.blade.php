<nav x-cloak x-data="{menuCollapsed: $persist(false), isMobile: window.innerWidth > 0 ? window.innerWidth < 640 : false}"
     @resize.window="isMobile = window.innerWidth > 0 ? window.innerWidth < 640 : false"
     :class="menuCollapsed || isMobile ? 'w-11' : 'w-64'"
     class="flex flex-col justify-between min-h-screen flex flex-col bg-slate-800 text-gray-50 pb-10">
    <div x-show="!menuCollapsed && !isMobile" class="flex flex-col gap-4 my-4">
        <div class="text-center text-xl">Authenticator</div>
    </div>
    <ul class="flex flex-col flex-1">
        @if(Auth::guard('admin')->user())
            @foreach($menuItems['top']['admin'] as $menuItem)
                <a href="{{ route($menuItem['link']) }}">
                    <li :class="menuCollapsed || isMobile ? 'pl-3' : 'pl-4'" class="relative px-4 py-2 h-10 border-y border-y-transparent {{ request()->is($menuItem['activeRoute']) ? 'bg-gray-50' : 'hover:bg-slate-700 hover:border-y-gray-500'}}">
                        <i class="absolute {{ $menuItem['icon'] }} text-slate-400 mt-1"></i>
                        <span x-show="!menuCollapsed && !isMobile" class="pl-8 {{ request()->is($menuItem['activeRoute']) ? 'text-slate-900' : 'text-slate-50'}}">{{ $menuItem['name'] }}</span>
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
                        <span x-show="!menuCollapsed && !isMobile && !isMobile" class="pl-8 {{ request()->is($menuItem['activeRoute']) ? 'text-slate-900' : 'text-slate-50'}}">{{ $menuItem['name'] }}</span>
                        @if(request()->is($menuItem['activeRoute']))
                            @include('components.active-menu-beaks')
                        @endif
                    </li>
                </a>
            @endforeach
        @endif
        <li class="flex-1"></li>
        @if(Auth::guard('admin')->user())
            @foreach($menuItems['bottom']['admin'] as $menuItem)
                <a href="{{ route($menuItem['link']) }}">
                    <li :class="menuCollapsed && isMobile ? 'pl-3' : 'pl-4'" class="relative px-4 py-2 h-10 border-y border-y-transparent {{ request()->is($menuItem['activeRoute']) ? 'bg-gray-50' : 'hover:bg-slate-700 hover:border-y-gray-500'}}">
                        <i class="absolute {{ $menuItem['icon'] }} text-slate-400 mt-1"></i>
                        <span x-show="!menuCollapsed && !isMobile" class="pl-8 {{ request()->is($menuItem['activeRoute']) ? 'text-slate-900' : 'text-slate-50'}}">{{ $menuItem['name'] }}</span>
                        @if(request()->is($menuItem['activeRoute']))
                            @include('components.active-menu-beaks')
                        @endif
                    </li>
                </a>
            @endforeach
            <li :class="menuCollapsed ? 'pl-3 flex-col-reverse' : 'pl-4'"  class="relative px-4 py-2 flex gap-4 justify-between z-10">
                <button x-show="!isMobile" class="text-slate-400 hover:text-slate-300 w-3" @click="menuCollapsed = !menuCollapsed">
                    <i x-show="!menuCollapsed" class="fa-solid fa-ellipsis-vertical"></i>
                    <i x-show="menuCollapsed" class="fa-solid fa-bars"></i>
                </button>
                <form method="POST" action="{{ route('admin.logout') }}" x-data>
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-slate-300">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </li>
        @endif
    </ul>

</nav>
