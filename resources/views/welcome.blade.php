<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto text-center">
            <!-- Заголовок -->
            <h1 class="text-4xl font-bold text-white">Welcome to FantasyCS</h1>
            <p class="text-lg text-gray-300 mt-4">
                Build your dream eSports fantasy team and dominate tournaments!
            </p>

            <!-- Кнопки для входа или действий -->
            @guest
                <div class="mt-6">
                    <a href="{{ route('register') }}" class="bg-yellow-500 text-black px-6 py-3 rounded-md font-bold hover:bg-yellow-400 mr-4">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="bg-gray-800 text-gray-300 px-6 py-3 rounded-md font-bold hover:bg-gray-700">
                        Log In
                    </a>
                </div>
            @else
                <div class="mt-6">
                    <a href="{{ route('profile.edit') }}" class="bg-yellow-500 text-black px-6 py-3 rounded-md font-bold hover:bg-yellow-400 mr-4">
                        Go to Your Profile
                    </a>
                    <a href="{{ route('fantasy.team.show', $fantasyTournament ?? 1) }}" class="bg-gray-800 text-gray-300 px-6 py-3 rounded-md font-bold hover:bg-gray-700 mr-4">
                        Your Teams
                    </a>
                    <a href="{{ route('results.live') }}" class="bg-gray-800 text-gray-300 px-6 py-3 rounded-md font-bold hover:bg-gray-700">
                        Explore Live Matches
                    </a>
                </div>
            @endguest
        </div>

        <!-- Why FantasyCS -->
        <div class="mt-16 bg-gray-800 text-gray-300 py-8 px-6 rounded-lg">
            <h2 class="text-3xl font-bold text-center mb-4">Why Choose FantasyCS?</h2>
            <p class="text-lg text-center">
                Join thousands of fans to create, manage, and compete with your fantasy eSports teams. Track your players' performance, join tournaments, and become the ultimate champion!
            </p>
        </div>

        <!-- Top Players -->
        <div class="mt-16 bg-gray-900 text-gray-100 py-8 px-6 rounded-lg">
            <h2 class="text-3xl font-bold text-center mb-4">Top 5 Players</h2>
            <ul class="text-lg space-y-4">
                <li class="flex justify-between items-center border-b border-gray-700 pb-2">
                    <span>1. <strong class="text-yellow-500">CS_Maestro</strong></span>
                    <span>Points: <strong>1250</strong></span>
                </li>
                <li class="flex justify-between items-center border-b border-gray-700 pb-2">
                    <span>2. <strong class="text-yellow-500">Headshot_King</strong></span>
                    <span>Points: <strong>1190</strong></span>
                </li>
                <li class="flex justify-between items-center border-b border-gray-700 pb-2">
                    <span>3. <strong class="text-yellow-500">Tactical_Genius</strong></span>
                    <span>Points: <strong>1145</strong></span>
                </li>
                <li class="flex justify-between items-center border-b border-gray-700 pb-2">
                    <span>4. <strong class="text-yellow-500">Eco_Warrior</strong></span>
                    <span>Points: <strong>1120</strong></span>
                </li>
                <li class="flex justify-between items-center">
                    <span>5. <strong class="text-yellow-500">Clutch_Master</strong></span>
                    <span>Points: <strong>1095</strong></span>
                </li>
            </ul>
        </div>

        <script>
        // Добавьте JavaScript для заполнения hidden поля selected-players
        // при выборе игроков в вашем интерфейсе
        document.querySelector('form').addEventListener('submit', function(e) {
            // Получаем выбранных игроков из вашего интерфейса
            const selectedPlayers = /* ваш код для получения выбранных игроков */;
            
            // Преобразуем в JSON и сохраняем в hidden поле
            document.getElementById('selected-players').value = JSON.stringify(selectedPlayers);
        });
        </script>
    </div>
</x-app-layout>
