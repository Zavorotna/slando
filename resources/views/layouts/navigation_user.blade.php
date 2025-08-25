<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('site.index')" :active="request()->routeIs('site.index')">
                        {{ __('Головна') }}
                    </x-nav-link>
                    <x-nav-link :href="route('site.catalogue')" :active="request()->routeIs('site.catalogue')">
                        {{ __('Каталог') }}
                    </x-nav-link>
                    
                    @if(Auth::user())
                        <x-nav-link :href="route('user.products.index')" :active="request()->routeIs('user.products.index')">
                            {{ __('Мої товари') }}
                        </x-nav-link>
                        <x-nav-link :href="route('user.order.index')" :active="request()->routeIs('user.order.index')">
                            {{ __('Мої замовлення') }}
                        </x-nav-link>
                        <x-nav-link :href="route('site.likedPage')" :active="request()->routeIs('site.likedPage')">
                            {{ __('Вподобані') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Увійти') }}
                        </x-nav-link>
                    @endif
                    
                </div>

                @if(Auth::user() && Auth::user()->customer->role == 'admin')
                    {{-- currency input --}}
                    <div class="currency hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-gray-500 gap-2">
                    {{-- {{ session()->forget('rates') }} --}}
                        @foreach (session()->get('rates') as $rate)
                            <form class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-gray-500 gap-2" action="{{ route('admin.rates.update') }}" method="post">
                                @csrf
                                @method('patch')
                                <label class="flex items-center w-32 gap-3">
                                    {{ strtoupper($rate['currency']) }}
                                    <input class="w-full bg-transparent border-none border-b border-gray-500" type="number" step="0.01" name="exchange_rate" value="{{ $rate['exchange_rate'] }}">
                                    <input type="hidden" name="id" value="{{ $rate['id'] }}">
                                </label>
                                <button style="margin-left: 0;" type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <ul class="lang gap-2 flex">
                    @foreach(config('app.available_locales') as $lang)
                        <li><a href="{{route('setLocale', $lang)}}">{{strtoupper($lang)}}</a></li>
                    @endforeach
                    <li class="cart_icon">
                        <a href="{{route('site.cart')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="#FFFFFF"><path d="M284.53-80.67q-30.86 0-52.7-21.97Q210-124.62 210-155.47q0-30.86 21.98-52.7Q253.95-230 284.81-230t52.69 21.98q21.83 21.97 21.83 52.83t-21.97 52.69q-21.98 21.83-52.83 21.83Zm400 0q-30.86 0-52.7-21.97Q610-124.62 610-155.47q0-30.86 21.98-52.7Q653.95-230 684.81-230t52.69 21.98q21.83 21.97 21.83 52.83t-21.97 52.69q-21.98 21.83-52.83 21.83ZM238.67-734 344-515.33h285.33l120-218.67H238.67ZM206-800.67h589.38q22.98 0 34.97 20.84 11.98 20.83.32 41.83L693.33-490.67q-11 19.34-28.87 30.67-17.87 11.33-39.13 11.33H324l-52 96h487.33V-286H278q-43 0-63-31.83-20-31.84-.33-68.17l60.66-111.33-149.33-316H47.33V-880h121.34L206-800.67Zm138 285.34h285.33H344Z"/></svg>
                            <span class="count_items">{{Cart::getTotalQuantity()}}</span>
                        </a>
                    </li>
                </ul>
                @if(Auth::user())
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->customer->name ?? "" }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('site.index')" :active="request()->routeIs('site.index')">
                {{ __('Головна') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('site.catalogue')" :active="request()->routeIs('site.catalogue')">
                {{ __('Каталог') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('site.cart')" :active="request()->routeIs('site.cart')">
                {{ __('Кошик') }}
            </x-responsive-nav-link>
            @if(Auth::user())
                <x-responsive-nav-link :href="route('user.products.index')" :active="request()->routeIs('user.products.index')">
                    {{ __('Мої товари') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('site.likedPage')" :active="request()->routeIs('site.likedPage')">
                    {{ __('Вподобані') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Увійти') }}
                </x-responsive-nav-link>
            @endif
            
            @if(Auth::user())
                {{-- currency input --}}
                <div class="currency hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-gray-500 gap-2">
                {{-- {{ session()->forget('rates') }} --}}
                    @foreach (session()->get('rates') as $rate)
                        <form class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-gray-500 gap-2" action="{{ route('admin.rates.update') }}" method="post">
                            @csrf
                            @method('patch')
                            <label class="flex items-center w-32 gap-3">
                                {{ strtoupper($rate['currency']) }}
                                <input class="w-full bg-transparent border-none border-b border-gray-500" type="number" step="0.01" name="exchange_rate" value="{{ $rate['exchange_rate'] }}">
                                <input type="hidden" name="id" value="{{ $rate['id'] }}">
                            </label>
                            <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                        </form>
                    @endforeach
                </div>
            @endif
        </div>
        <!-- Responsive Settings Options -->
        @if(Auth::user()) 
            {{-- currency input --}}
                <div class="currency sm:-my-px sm:ms-10 sm:flex text-gray-500 gap-2">
                    @foreach (session()->get('rates') as $rate)
                        <form class="space-x-4 sm:-my-px sm:ms-10 sm:flex text-gray-500 gap-2" action="{{ route('admin.rates.update') }}" method="post">
                            @csrf
                            @method('patch')
                            <label class="flex items-center w-32 gap-3">
                                {{ strtoupper($rate['currency']) }}
                                <input class="w-full bg-transparent border-none border-b border-gray-500" type="number" step="0.01" name="exchange_rate" value="{{ $rate['exchange_rate'] }}">
                                <input type="hidden" name="id" value="{{ $rate['id'] }}">
                            </label>
                            <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
                        </form>
                    @endforeach
                </div>
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->customer->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endif
    </div>
</nav>
