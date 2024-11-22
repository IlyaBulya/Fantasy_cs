<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'FantasyCS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="font-sans antialiased">
        <!-- Навигация -->
        <div class="bg-gray-800 p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <!-- Логотип -->
                <div>
                    <a href="{{ route('welcome') }}" class="text-xl font-semibold text-white flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="FantasyCS Logo" class="h-16 w-auto">
                    </a>
                </div>

                <!-- Навигационные ссылки -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('results.live') }}" 
                       class="text-white px-4 py-2 rounded {{ request()->routeIs('results.live') ? 'bg-yellow-500 text-black' : 'bg-transparent' }} hover:bg-yellow-400">
                        Live Matches
                    </a>
                    <a href="{{ route('results.nonlive') }}" 
                       class="text-white px-4 py-2 rounded {{ request()->routeIs('results.nonlive') ? 'bg-yellow-500 text-black' : 'bg-transparent' }} hover:bg-yellow-400">
                        Results
                    </a>
                    <a href="{{ route('fantasy') }}" 
                       class="text-white px-4 py-2 rounded {{ request()->routeIs('fantasy') ? 'bg-yellow-500 text-black' : 'bg-transparent' }} hover:bg-yellow-400">
                        Fantasy
                    </a>
                    <a href="{{ route('translations') }}" 
                       class="text-white px-4 py-2 rounded {{ request()->routeIs('translations') ? 'bg-yellow-500 text-black' : 'bg-transparent' }} hover:bg-yellow-400">
                        Translations
                    </a>
                </div>

                <!-- Аутентификация -->
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

        <!-- Основной контент -->
        <div class="min-h-screen">
            <header class="bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header ?? '' }}
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
