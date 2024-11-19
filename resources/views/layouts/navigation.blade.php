<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-4">
                <!-- Логотип -->
                <div class="shrink-0">
                    <a href="{{ route('welcome') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="FantasyCS Logo" class="h-16 w-auto">
                    </a>
                </div>


            <!-- Account Settings and Auth links -->
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('profile.edit') }}" class="text-white">{{ Auth::user()->name }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white">Log In</a>
                    <a href="{{ route('register') }}" class="text-white">Register</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('results') }}" class="block text-white">Results</a>
            <a href="{{ route('fantasy') }}" class="block text-white">Fantasy</a>
            <a href="{{ route('translations') }}" class="block text-white">Translations</a>
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="text-gray-400">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-400">Log Out</a>
                </form>
            </div>
        </div>
        @endauth

        @guest
        <div class="pt-4 pb-1 border-t border-gray-200">
            <a href="{{ route('login') }}" class="block text-white">Log In</a>
            <a href="{{ route('register') }}" class="block text-white">Register</a>
        </div>
        @endguest
    </div>
</nav>
