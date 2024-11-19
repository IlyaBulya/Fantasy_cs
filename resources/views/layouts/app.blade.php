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
        <!-- Навигация с логином/выходом -->
        <div class="bg-gray-800 p-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div>
                    <!-- Логотип и навигация -->
                    <a href="{{ route('welcome') }}" class="text-xl font-semibold text-white">
                        <img src="{{ asset('images/logo.png') }}" alt="FantasyCS Logo" class="h-16 w-auto">
                    </a>
                </div>

                <div class="flex items-center space-x-4 flex-grow justify-left p-4 text-lg">
                    <!-- Навигационные ссылки -->
                    <a href="{{ route('results') }}" 
                    class="text-white px-4 py-2 rounded {{ request()->routeIs('results') ? 'bg-blue-600' : 'bg-transparent' }} hover:bg-blue-400">
                        Results
                    </a>
                    <a href="{{ route('fantasy') }}" 
                    class="text-white px-4 py-2 rounded {{ request()->routeIs('fantasy') ? 'bg-blue-600' : 'bg-transparent' }} hover:bg-blue-400">
                        Fantasy
                    </a>
                    <a href="{{ route('translations') }}" 
                    class="text-white px-4 py-2 rounded {{ request()->routeIs('translations') ? 'bg-blue-600' : 'bg-transparent' }} hover:bg-blue-400">
                        Translations
                    </a>
                </div>



                <div class="flex items-center space-x-4">
                    <!-- Аккаунт и кнопка выхода -->
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

        <div class="min-h-screen">
            <header class="bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-0 px-4 sm:px-6 lg:px-8">
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
