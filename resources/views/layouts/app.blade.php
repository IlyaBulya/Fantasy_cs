<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'FantasyCS') }}</title>
    <meta name="description" content="{{ $description ?? 'FantasyCS: Create and manage your esports fantasy team!' }}">
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
                    <a href="{{ route('fantasy.index') }}"
                    class="text-white px-4 py-2 rounded {{ request()->routeIs('fantasy.index') ? 'bg-blue-700' : '' }}">
                    Fantasy
                    </a>

                </div>

                <!-- Аутентификация -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center">
                        @if(Auth::user()->uploaded_avatar)
                            <img src="{{ asset('storage/' . Auth::user()->uploaded_avatar) }}" alt="Avatar" class="h-10 w-10 rounded-full" style="margin-right: 10px;">
                        @else
                            <img src="{{ asset('images/default_avatar.jpg') }}" alt="Default Avatar" class="h-10 w-10 rounded-full" style="margin-right: 10px;">
                        @endif
                            <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white bg-red-600 px-4 py-2 rounded-md hover:bg-red-500">
                                Log Out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white">Log In</a>
                        <a href="{{ route('register') }}" class="text-white">Register</a>
                        <div class="mt-4">
                            <a href="{{ route('auth.steam') }}" style="
                                display: inline-block; 
                                background: #171a21; 
                                color: white; 
                                font-weight: bold; 
                                padding: 10px 20px; 
                                border-radius: 5px; 
                                text-decoration: none;
                                font-size: 16px;">
                                Sign in with Steam
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Flash сообщения -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 text-center font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 text-center font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- Основной контент -->
        <div class="min-h-screen">
            <header class="bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8" style="padding-bottom: 8px;">
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
