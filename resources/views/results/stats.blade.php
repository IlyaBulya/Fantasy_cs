<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Match Statistics</h1>

                    <!-- Match Info -->
                    <h2 class="text-lg font-semibold">Teams</h2>
                    <p>
                        {{ $match['opponents'][0]['opponent']['name'] ?? 'Team A' }} 
                        vs 
                        {{ $match['opponents'][1]['opponent']['name'] ?? 'Team B' }}
                    </p>
                    <p><strong>League:</strong> {{ $match['league']['name'] ?? 'Unknown League' }}</p>
                    <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($match['begin_at'])->format('F jS, Y h:i A') }}</p>

                    <!-- Player Statistics -->
                    <h2 class="text-lg font-semibold mt-4">Player Statistics</h2>
                    <ul>
                        @forelse($players as $player)
                            <li>
                                {{ $player['name'] ?? 'Unknown Player' }} 
                                - Kills: {{ $player['kills'] ?? 'N/A' }}, 
                                Deaths: {{ $player['deaths'] ?? 'N/A' }}
                            </li>
                        @empty
                            <li>No player statistics available.</li>
                        @endforelse
                    </ul>

                    <!-- Map Scores -->
                    <h2 class="text-lg font-semibold mt-4">Map Scores</h2>
                    @forelse($maps as $map)
                        <p>
                            <strong>Map:</strong> {{ $map['map']['name'] ?? 'Unknown Map' }}<br>
                            <strong>Score:</strong> 
                            {{ $map['teams'][0]['score'] ?? 'N/A' }} - 
                            {{ $map['teams'][1]['score'] ?? 'N/A' }}
                        </p>
                    @empty
                        <p>No map scores available.</p>
                    @endforelse

                    <!-- Live Frames -->
                    <h2 class="text-lg font-semibold mt-4">Live Frames</h2>
                    @forelse($frames as $frame)
                        <p>
                            <strong>Round:</strong> {{ $frame['round'] ?? 'Unknown' }}<br>
                            <strong>CT Score:</strong> {{ $frame['counter_terrorists']['round_score'] ?? 'N/A' }}<br>
                            <strong>T Score:</strong> {{ $frame['terrorists']['round_score'] ?? 'N/A' }}
                        </p>
                    @empty
                        <p>No live frames available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
