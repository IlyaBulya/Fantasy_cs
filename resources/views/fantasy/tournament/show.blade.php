<x-app-layout>
    <div class="min-h-screen bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white mb-2">Your Fantasy Teams</h1>
            </div>

            @if($teams->isNotEmpty())
                <div class="flex flex-nowrap gap-6 overflow-x-auto pb-6">
                    @foreach($teams as $team)
                        <div class="flex-none w-[1100px] bg-gray-800 rounded-xl p-6 relative">
                            <form action="{{ route('fantasy.team.destroy', ['fantasyTournament' => $team->fantasy_tournament_id, 'team' => $team]) }}" 
                                  method="POST" 
                                  class="absolute right-4 top-4"
                                  onsubmit="return confirm('Are you sure you want to delete this team?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white rounded-full p-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>

                            <h3 class="text-xl font-bold text-white mb-2">
                                @php
                                    $tournamentName = match(true) {
                                        isset($team->fantasyTournament->tournament_id) && $team->fantasyTournament->tournament_id == 1 => 'ESL Pro League Season 19',
                                        isset($team->fantasyTournament->tournament_id) && $team->fantasyTournament->tournament_id == 2 => 'BLAST Premier Spring Finals 2024',
                                        isset($team->fantasyTournament->tournament_id) && $team->fantasyTournament->tournament_id == 3 => 'IEM Katowice 2024',
                                        default => 'Tournament ' . $team->fantasy_tournament_id
                                    };
                                @endphp
                                {{ $tournamentName }}
                            </h3>
                            <p class="text-indigo-400 text-sm mb-4">{{ $team->name }}</p>
                            
                            <div class="flex gap-4">
                                @foreach($team->players as $slot => $player)
                                    <div class="flex-none w-48">
                                        <div class="h-full flex flex-col items-center justify-center p-4">
                                            <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center mb-4 border-4 border-indigo-500">
                                                <img src="{{ $player['image_url'] !== '/default-player.png' ? $player['image_url'] : '/images/placeholder.png' }}" 
                                                     alt="{{ $player['name'] ?? 'Player' }}" 
                                                     class="w-full h-full rounded-full object-cover"
                                                     onerror="this.src='/images/placeholder.png'">
                                            </div>
                                            <span class="text-lg font-bold text-white mb-1 text-center">
                                                {{ $player['name'] ?? 'Unknown Player' }}
                                            </span>
                                            <span class="text-sm text-indigo-400 text-center">
                                                {{ $player['team'] ?? 'Unknown Team' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-400 py-12">
                    <p class="text-xl mb-4">You don't have any teams yet</p>
                </div>
            @endif

            <div class="mt-8 text-center">
                <a href="{{ route('welcome') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Welcome Page
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
