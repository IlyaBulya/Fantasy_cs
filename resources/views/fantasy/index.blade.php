<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Fantasy Tournaments</h1>

    <!-- Ongoing Tournaments -->
    <div class="bg-gray-800 text-white p-6 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-4">Ongoing Tournaments</h2>
        @if(is_array($ongoingTournaments) && count($ongoingTournaments) > 0)
            @foreach($ongoingTournaments as $tournament)
                <div class="bg-gray-700 p-4 rounded mb-2">
                    <h4 class="font-bold">{{ $tournament['name'] ?? 'Unnamed Tournament' }}</h4>
                    <p class="text-sm text-gray-400">
                        Start: {{ $tournament['start_at'] ?? 'TBD' }}<br>
                        End: {{ $tournament['end_at'] ?? 'TBD' }}
                    </p>
                    <a href="#" class="mt-4 inline-block bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded">
                        Join Tournament
                    </a>
                </div>
            @endforeach
        @else
            <p class="text-gray-400">No ongoing tournaments at the moment.</p>
        @endif
    </div>

    <!-- Upcoming Tournaments -->
    <div class="bg-gray-800 text-white p-6 rounded shadow mb-6">
        <h2 class="text-lg font-semibold mb-4">Upcoming Tournaments</h2>
        @if(is_array($upcomingTournaments) && count($upcomingTournaments) > 0)
            @foreach($upcomingTournaments as $tournament)
                <div class="bg-gray-700 p-4 rounded mb-2">
                    <h4 class="font-bold">{{ $tournament['name'] ?? 'Unnamed Tournament' }}</h4>
                    <p class="text-sm text-gray-400">
                        Start: {{ $tournament['start_at'] ?? 'TBD' }}<br>
                        End: {{ $tournament['end_at'] ?? 'TBD' }}
                    </p>
                    <a href="#" class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-400 text-black px-4 py-2 rounded">
                        Pre-register
                    </a>
                </div>
            @endforeach
        @else
            <p class="text-gray-400">No upcoming tournaments at the moment.</p>
        @endif
    </div>
</x-app-layout>
