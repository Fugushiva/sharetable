<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta, styles, etc. -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 h-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 ">
        <div class="flex justify-between items-center h-24">
            <!-- Logo -->
            <div class="shrink-0 flex start-0 w-24">
                <a href="{{route('welcome')}}"><x-application-logo class="custom-logo block fill-current text-gray-800"/></a>
            </div>
            <div class="flex items-center justify-between">
                <!-- Dashboard Link -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex items-center">
                    @if(Auth::user())
                        @if(Auth::user()->hasRole('admin'))
                            <x-nav-link :href="route('filament.admin.pages.dashboard')" :active="request()->routeIs('filament.admin.pages.dashboard')">
                                {{ __('content.admin') }}
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('content.register') }}
                        </x-nav-link>
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('content.login') }}
                        </x-nav-link>
                    @endif
                </div>
                <!-- Listing Link -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('annonce.index')" :active="request()->routeIs('annonce.index')">
                        {{ __('content.explore') }}
                    </x-nav-link>
                </div>
                <!-- Host Link -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex items-center">
                    @if (Auth::user() && !Auth::user()->host)
                        <!-- Lien pour devenir un hôte -->
                        <x-nav-link :href="route('host.create')" :active="request()->routeIs('host.create')">
                            {{ __('content.become_host') }}
                        </x-nav-link>
                    @elseif(!Auth::user())
                        <!-- Lien pour s'enregistrer -->
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('content.become_host') }}
                        </x-nav-link>
                    @elseif(Auth::user() && Auth::user()->host && !Auth::user()->host->hasStripeAccount())
                        <!-- Lien pour connecter son compte Stripe s'il est hôte mais n'a pas de compte Stripe -->
                        <x-nav-link :href="route('host.stripe-connect', Auth::user()->host->id )" :active="request()->routeIs('host.stripe-connect')">
                            {{ __('connect to stripe') }}
                        </x-nav-link>
                    @else
                        <!-- Lien pour créer une annonce si l'hôte a un compte Stripe -->
                        <x-nav-link :href="route('annonce.create')" :active="request()->routeIs('annonce.create')">
                            {{ __('content.create_experience') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>


            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="w-full flex items-center"> <!-- Ajout de flex items-center -->
                    <form id="language-form" action="{{ route('change.language') }}" method="POST">
                        @csrf
                        <select id="language" class="w-1/2 mr-12 select" name="language"
                                onchange="document.getElementById('language-form').submit()">
                            @foreach($languages as $language)
                                <option
                                    value="{{ $language->code }}" {{ app()->getLocale() == $language->code ? 'selected' : '' }}>
                                    {{ $language->code }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="flex items-center gap-4"> <!-- Ajout de items-center ici -->
                    <!-- Notification -->
                    <div id="notification-container" class="relative">
                        <i class="fa-solid fa-bell cursor-pointer text-3xl relative" id="notification-icon">
                            <span id="notification-count"
                                  class="absolute bottom-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">0</span>
                        </i>
                        <ul id="notification-list"
                            class="hidden absolute top-8 right-0 bg-white border border-gray-300 rounded-md w-80 max-h-80 overflow-y-auto shadow-lg">
                            <!-- Notifications will be added here by JavaScript -->
                        </ul>
                    </div>
                    <!-- Messages -->
                    <div class="relative">
                        <a href="{{ route('conversations.index') }}">
                            <i class="fa-solid fa-message cursor-pointer text-3xl"></i>
                            @if($unreadCount > 0)
                                <span
                                    class="absolute top-0 right-0 inline-block w-6 h-6 bg-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Profile dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-red-750 focus:outline-none transition ease-in-out duration-150">
                            @if(Auth::user())
                                <div class="flex items-center">
                                    <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile picture"
                                         class="w-8 h-8 rounded-full me-2">
                                    <p class="me-2">{{ Auth::user()->firstname }}</p>
                                </div>
                            @else
                                <div>S'enregistrer ou se connecter</div>
                            @endif
                            <div class="ms-1">
                                <svg class=" ml-5 h-4 w-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 011.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    @if(Auth::user())
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.show')">
                                {{ __('content.profile') }}
                            </x-dropdown-link>
                            @if(Auth::user()->isHost())
                                <x-dropdown-link :href="route('host.profile')">
                                    {{ __('content.switch_host') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('host.create')">
                                    {{ __('content.become_host') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('reservation.index')">
                                {{ __('content.my_reservations') }}
                            </x-dropdown-link>
                            @if(Auth::user()->hasRole('admin'))
                                <x-dropdown-link :href="route('filament.admin.pages.dashboard')">
                                    {{ __('content.admin_panel') }}
                                </x-dropdown-link>
                            @endif
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('content.logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    @else
                        <x-slot name="content">
                            <x-dropdown-link :href="route('register')">
                                {{ __("content.signin") }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('login')">
                                {{ __("content.login") }}
                            </x-dropdown-link>
                        </x-slot>
                    @endif
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                {{ __('content.dashboard.title') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @if(Auth::user())
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->firstname }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @else
                    <div class="font-medium text-base text-gray-800">{{__('content.register_connect')}}</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user())
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('content.profile') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('content.login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __("content.signin") }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                @if(Auth::user())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('content.logout') }}
                        </x-responsive-nav-link>
                    </form>
                @endif
            </div>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">S'enregistrer ou se connecter</div>
            </div>
            <x-responsive-nav-link :href="route('register')">
                {{ __("content.signin") }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('login')">
                {{ __("content.login") }}
            </x-responsive-nav-link>
        </div>

    </div>
</nav>
</body>
</html>
