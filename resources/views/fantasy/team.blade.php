<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">
                        {{ $fantasyTournament->name }} - Your Team
                    </h2>

                    @if($team)
                        <div class="bg-gray-700 rounded-lg p-6">
                            <!-- Здесь будет отображение состава команды -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($team->players ?? [] as $player)
                                    <div class="bg-gray-600 p-4 rounded-lg">
                                        <h3 class="text-lg font-semibold text-white">{{ $player->name }}</h3>
                                        <p class="text-gray-300">Role: {{ $player->role }}</p>
                                        <p class="text-gray-300">Points: {{ $player->points }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center text-gray-300">
                            <p class="text-xl">You haven't created a team for this tournament yet.</p>
                            <a href="{{ route('fantasy.tournaments.show', $fantasyTournament) }}" 
                               class="inline-block mt-4 bg-yellow-500 text-black px-6 py-3 rounded-md font-bold hover:bg-yellow-400">
                                Create Your Team
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 