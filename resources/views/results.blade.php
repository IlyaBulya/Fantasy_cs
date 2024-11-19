<x-app-layout>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-yellow-400 mb-6">Live Match Results</h1>
                    
                    @if($matches->isEmpty())
                        <p class="text-gray-400">No matches available.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($matches as $match)
                                <div class="match-card">
                                    <h3>{{ $match->team_a }} vs {{ $match->team_b }}</h3>
                                    <p><strong>Score:</strong> {{ $match->score }}</p>
                                    <p><strong>Event:</strong> {{ $match->event }}</p>
                                    <button class="button-bright">View Details</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
