<div>
<nav class="fixed w-0 lg:sticky inset-0 h-screen shadow-lg flex duration-250 text-gray-100 transition-all dark:lg:border-r dark:border-white z-40" :class="{'w-0 overflow-hidden lg:flex lg:w-20' : menuOpen == false, 'w-full lg:w-72' : menuOpen == true}">
    <aside class="w-4/6 md:w-3/6 lg:w-full bg-gray-800 dark:bg-gray-900 shadow-md shadow-black border-x border-black overflow-scroll beautify-scrollbar">
        <a href="{{route('home')}}" class="flex lg:hidden items-center justify-center border-b border-gray-200 p-4">
            <img src="{{asset(auth()->user()->school->logoURL ?? config('app.logo'))  }}" alt="" class="rounded-full w-14 h-14 border border-gray-200 shadow-md">
            <h1 class="text-lg font-semibold mx-3 text-center capitalize">{{config('app.name')}}</h1>
        </a>
        <div class="p-3">
            @isset ($menu)
                @foreach ($menu as $menuItem)
                    @if (isset($menuItem['header']) & (!isset($menuItem['can']) || auth()->user()->can($menuItem['can'])))
                        <p x-show="menuOpen" x-transition class="my-3 text-gray-400 uppercase text-sm font-semibold">{{$menuItem['header']}}</p>
                    @elseif(!isset($menuItem['can']) || auth()->user()->can($menuItem['can']))
                        <div @click.outside="submenu = false" x-data="{
                            'submenu'  : {{ isset($menuItem['submenu']) && in_array(Route::currentRouteName() , array_column($menuItem['submenu']  , 'route')) ? '1' : '0'}}
                           }" >
                            @if (!isset($menuItem['submenu']))
                                <a class="flex items-center gap-2 p-3 px-4 my-2 rounded" href="{{route($menuItem['route'])}}" :class="{{Route::currentRouteName() == $menuItem['route'] ? '1' : '0'}} ? 'bg-orange-500 hover:bg-orange-400' : 'hover:bg-gray-700'" aria-label="{{$menuItem['text']}}" wire:navigate>
                                    <i class="{{$menuItem['icon'] ?? 'fa fa-circle'}} text-gray-300" aria-hidden="true" x-transition></i>
                                    <p x-show="menuOpen" class="text-white font-medium">{{$menuItem['text']}}</p>
                                </a>
                            @else
                                <div class="flex items-center justify-between gap-2 p-3 my-2 px-4 rounded" @click="submenu = !submenu" :class="{{in_array(Route::currentRouteName() , array_column($menuItem['submenu'] , 'route')) ? '1' : '0'}} ? 'bg-orange-500 hover:bg-orange-400' : 'hover:bg-gray-700'">
                                    <div class="flex items-center gap-2">
                                        <i class="{{$menuItem['icon'] ?? 'fa fa-circle'}} text-gray-300" aria-hidden="true" x-transition></i>
                                        <p x-show="menuOpen" class="cursor-default text-white font-medium">{{$menuItem['text']}}</p>
                                    </div>
                                    <i class="transition-all text-gray-300" :class="{'fas fa-angle-left' : submenu == false , 'fas fa-angle-down ' : submenu == true}" x-show="menuOpen"></i>
                                </div>
                                @foreach ($menuItem['submenu'] as $submenu)
                                    @if ($submenu['can'] && auth()->user()->can($submenu['can']))
                                        <a class="flex items-center gap-2 p-3 px-4 my-2 transition-all rounded whitespace-nowrap {{( Route::currentRouteName() == $submenu['route'] ? 'bg-orange-500 text-white': 'hover:bg-gray-700' )}}" :class="{'h-0 my-auto overflow-hidden py-0' : submenu == false,}" x-transition href="{{route($submenu['route'])}}" aria-label="{{$submenu['text']}}" @focus="submenu = true" @blur="submenu = false" wire:navigate>
                                            <i class="{{$submenu['icon'] ?? 'far fa-fw fa-circle'}} text-gray-300" aria-hidden="true"></i>
                                            <p x-show="menuOpen" class="text-white font-medium">{{$submenu['text']}}</p>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </aside>
    <div class="lg:hidden w-2/6 md:w-4/6 bg-gray-600 opacity-30" @click="menuOpen = false" x-show="menuOpen" x-transition:enter="transition-all ease-in duration-200 delay-250" x-transition:enter-start="opacity-0"></div>
</nav>

<style>
    /* Sidebar background and general styles */
    aside {
        background: linear-gradient(135deg, #6d757f 0%, #6d757f 100%) !important;
        color: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Remove border-x and shadow for a cleaner look as in the image */
    aside.border-x.border-black {
        border: none !important;
        box-shadow: none !important;
    }

    /* Beautify scrollbar */
    .beautify-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .beautify-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .beautify-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .beautify-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Logo and app name section */
    .flex.lg\:hidden.items-center.justify-center {
        background-color: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.112);
    }

    .flex.lg\:hidden.items-center.justify-center img {
        border: none !important;
        box-shadow: none !important;
        width: 40px !important;
        height: 40px !important;
    }

    .flex.lg\:hidden.items-center.justify-center h1 {
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
    }

    /* Menu items */
    .flex.items-center.gap-2.p-3.px-4.my-2.rounded {
        transition: all 0.2s ease;
    }

    .flex.items-center.justify-between.gap-2.p-3.my-2.px-4.rounded {
        transition: all 0.2s ease;
    }

    /* Hover and active states */
    .hover\:bg-gray-700:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
    }

    .bg-orange-500 {
        background-color: rgba(255, 69, 0, 0.15) !important;
        border-left: 3px solid #ff4500 !important;
        color: white !important;
    }

    .hover\:bg-orange-400:hover {
        background-color: rgba(255, 69, 0, 0.3) !important;
    }

    /* Submenu items */
    .flex.items-center.gap-2.p-3.px-4.my-2.transition-all.rounded.whitespace-nowrap {
        padding-left: 2.5rem !important;
        background-color: rgba(0, 0, 0, 0.25);
    }

    /* Overlay for mobile */
    .lg\:hidden.w-2\/6.md\:w-4\/6.bg-gray-600.opacity-30 {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
</style>
</div>

