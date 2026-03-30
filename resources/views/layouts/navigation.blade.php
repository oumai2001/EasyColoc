<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo Professionnel -->
               <div class="flex items-center gap-2 mb-3">
                    <div class="text-[#78350f] p-2 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>

                    <span class="font-bold text-xl text-[#78350f]">
                        EasyColoc
                    </span>
                </div>

                <!-- Navigation Links Desktop -->
                <div class="hidden sm:flex sm:space-x-2 text-[#000000]">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[#000000] px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-[#000000]">Dashboard</span>
                        </div>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('colocations.index')" :active="request()->routeIs('colocations.*')" class="text-[#000000] px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-[#000000]">Mes Colocations</span>
                        </div>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Section Desktop -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <!-- Badge de réputation avec dégradé -->
                <div class="flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-[#000000] shadow-lg">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-bold">{{ Auth::user()->reputation }}</span>
                </div>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-3 px-3 py-2 rounded-lg   transition-all duration-200 border border-white/20 backdrop-blur-sm">
                            <div class="flex items-center">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="w-8 h-8 rounded-full border-2 border-white shadow-md">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 border-2 border-white shadow-md flex items-center justify-center text-black font-bold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="ml-2 text-[#000000] font-medium">{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="w-4 h-4 text-[#000000]/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="py-2 bg-white hover:bg-gray-50">
                            <!-- Header -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs text-[#000000]">Connecté en tant que</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Menu Items -->
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center px-4 py-3 hover:bg-gradient-to-r  hover:to-indigo-50">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-[#000000]">Mon Profil</p>
                                    <p class="text-xs text-gray-500">Modifier mes informations</p>
                                </div>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('colocations.index')" class="flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-[#000000]">Mes Colocations</p>
                                    <p class="text-xs text-gray-500">Gérer mes colocations</p>
                                </div>
                            </x-dropdown-link>

                            <!-- Déconnexion -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50">
                                    <div class="w-8 h-8 text-[#000000]rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">Déconnexion</p>
                                        <p class="text-xs text-gray-500">Quitter la session</p>
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Mobile -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-[#000000] hover:bg-white/20 focus:outline-none transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden bg-white/10 backdrop-blur-lg border-t border-white/20">
        <div class="px-4 py-3 space-y-1">
            <!-- Dashboard Mobile -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-[#000000] hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>
            
            <!-- Colocations Mobile -->
            <a href="{{ route('colocations.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-[#000000] hover:bg-white/20 transition-all duration-200 {{ request()->routeIs('colocations.*') ? 'bg-white/20' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="font-medium">Mes Colocations</span>
            </a>
        </div>

        <!-- Mobile User Info -->
        <div class="border-t border-white/20 px-4 py-4">
            <div class="flex items-center space-x-3 mb-4">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="w-12 h-12 rounded-full border-2 border-white shadow-md">
                @else
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 border-2 border-white shadow-md flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <div class="font-medium text-[#000000]">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-[#000000]/70">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <!-- Badge réputation mobile -->
            <div class="flex items-center justify-between px-4 py-3 bg-white/10 rounded-xl mb-3">
                <span class="text-[#000000]">Réputation</span>
                <span class="px-4 py-1.5 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-white font-bold shadow-md">
                    {{ Auth::user()->reputation }}
                </span>
            </div>

            <!-- Mobile Menu Items -->
            <div class="space-y-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-[#000000] hover:bg-white/20 transition-all duration-200">
                    <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Mon Profil</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-[#000000] hover:bg-white/20 transition-all duration-200">
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>