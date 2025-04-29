<nav class="bg-neutral-100 shadow-md py-4 dark:bg-neutral-900" x-data="{ mobileOpen: false }">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-xl font-bold text-black dark:text-white">
            Spin it Clean
        </a>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button @click="mobileOpen = !mobileOpen" class="text-black focus:outline-none dark:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex space-x-6">
            @auth
                <a href="{{ route('pages.mainpage') }}"
                    class="hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('pages.mainpage') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Main
                    Page</a>
                <a href="{{ route('pages.games') }}"
                    class="hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('pages.games') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Games</a>
                <a href="{{ route('friends.list') }}"
                    class="hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('friends.list') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Friends</a>
                <a href="{{ route('pages.leaderboard') }}"
                    class="hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('pages.leaderboard') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Leaderboard</a>
                <a href="{{ route('forum.index') }}"
                    class="hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('forum.index') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">
                    Forum
                </a>
                <a href="{{ route('shop') }}"
                    class="hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('shop') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">
                    Shop
                </a>
            @endauth
        </div>

        <!-- User Dropdown and Balance -->
        <div class="hidden md:flex items-center space-x-4">
            @guest
                <a href="{{ route('login') }}" class="text-yellow-500 dark:text-yellow-400">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-yellow-500 text-black dark:bg-yellow-400 dark:text-black px-4 py-2 rounded-md">Register</a>
            @else
                <!-- Balance Display as a Link -->
                <div class="text-black dark:text-white">
                    <a href="{{ route('wallet') }}" class="hover:text-yellow-500 dark:hover:text-yellow-400">
                        Balance: $<span id="user-balance">{{ number_format(Auth::user()->balance, 2) }}</span>
                    </a>
                </div>

                <div>
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-hippo text-2xl text-yellow-600 dark:text-yellow-500"></i>
                        </a>
                    @endif
                </div>

                <!-- Mailbox / Friend Requests -->
                <div x-data="{ showRequests: false }" class="relative" @click.away="showRequests = false">
                    <button @click="showRequests = !showRequests"
                        class="text-black dark:text-white focus:outline-none relative">
                        <i class="fas fa-envelope text-xl"></i>
                        @if ($friendRequests->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">
                                {{ $friendRequests->count() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="showRequests" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-80 bg-white dark:bg-neutral-800 rounded-lg shadow-lg z-30">
                        @forelse ($friendRequests as $request)
                            <div
                                class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <span class="text-black dark:text-white">{{ $request->sender->name }} has sent you a friend
                                    request!</span>
                                <a href="{{ route('friends.list') }}#pending"
                                    class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">
                                    Show
                                </a>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">Nincsenek barátkérelmek.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Dropdown Trigger -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 focus:outline-none text-black dark:text-white">
                        <span>{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7 7 7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-800 rounded-lg shadow-lg z-20">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-neutral-700">
                            Edit Profile
                        </a>
                        <a href="{{ route('profile.statistics') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-neutral-700">
                            View Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-neutral-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" class="md:hidden bg-neutral-200 dark:bg-neutral-800">
        <div class="px-4 py-2 space-y-2">
            @auth
                <a href="{{ route('pages.mainpage') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('pages.mainpage') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Main
                    Page</a>
                <a href="{{ route('pages.games') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('pages.games') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Games</a>
                <a href="{{ route('friends.list') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('friends.list') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Friends</a>
                <a href="{{ route('pages.leaderboard') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('pages.leaderboard') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">Leaderboard</a>
                <a href="{{ route('forum.index') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('forum.index') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">
                    Forum
                </a>
                <a href="{{ route('shop') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400 {{ request()->routeIs('shop') ? 'text-yellow-500 dark:text-yellow-400' : '' }}">
                    Shop
                </a>
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        class="block text-red-600 font-bold hover:text-red-500 dark:hover:text-red-400">
                        Admin Control
                    </a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}" class="block text-yellow-500 dark:text-yellow-400">Login</a>
                <a href="{{ route('register') }}"
                    class="block bg-yellow-500 text-black dark:bg-yellow-400 dark:text-black px-4 py-2 rounded-md">Register</a>
            @else
                <!-- Balance as Link in Mobile -->
                <a href="{{ route('wallet') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400">
                    Balance: $<span id="user-balance">{{ number_format(Auth::user()->balance, 2) }}</span>
                </a>

                <!-- Mailbox / Friend Requests (Mobile) -->
                <div x-data="{ showMobileRequests: false }" class="relative">
                    <button @click="showMobileRequests = !showMobileRequests"
                        class="text-black dark:text-white focus:outline-none flex items-center space-x-2">
                        <i class="fas fa-envelope text-xl"></i>
                        @if ($friendRequests->count() > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1 rounded-full">
                                {{ $friendRequests->count() }}
                            </span>
                        @endif
                    </button>
                    <div x-show="showMobileRequests" @click.away="showMobileRequests = false"
                        class="mt-2 bg-white dark:bg-neutral-800 rounded-lg shadow-lg z-30">
                        @forelse ($friendRequests as $request)
                            <div
                                class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <span class="text-black dark:text-white">{{ $request->sender->name }} has sent you a
                                    friend request!</span>
                                <a href="{{ route('friends.list') }}#pending"
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                    Show
                                </a>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">Nincsenek barátkérelmek.</div>
                        @endforelse
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400">Edit
                    Profile</a>
                <a href="{{ route('profile.statistics') }}"
                    class="block text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400">View
                    Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left text-black dark:text-white hover:text-yellow-500 dark:hover:text-yellow-400">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
