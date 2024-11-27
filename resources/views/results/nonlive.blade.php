<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold text-yellow-400 mb-6">Non-Live Match Results (CS2)</h1>
                    
                    @if(empty($matches) || count($matches) === 0)
                        <p class="text-gray-400">No matches available.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($matches as $match)
                                <div class="bg-gray-800 text-white p-4 rounded-lg">
                                    <!-- Логотипы -->
                                    <div class="flex items-center justify-between">
                                        <img src="{{ $match['opponents'][0]['opponent']['image_url'] ?? asset('images/placeholder.png') }}" 
                                             alt="Team A Logo" style="max-width: 60px; height: auto;">
                                        <h3 class="text-lg font-bold">
                                            {{ $match['opponents'][0]['opponent']['name'] ?? 'TBD' }}
                                            vs
                                            {{ $match['opponents'][1]['opponent']['name'] ?? 'TBD' }}
                                        </h3>
                                        <img src="{{ $match['opponents'][1]['opponent']['image_url'] ?? asset('images/placeholder.png') }}" 
                                             alt="Team B Logo" style="max-width: 60px; height: auto;">
                                    </div>

                                    <!-- Лига, время и счет -->
                                    <div class="mt-4 text-center">
                                        <p><strong>League:</strong> {{ $match['league']['name'] ?? 'Unknown' }}</p>
                                        <p><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($match['begin_at'])->format('F jS, Y h:i A') }}</p>
                                        <p><strong>Overall Score:</strong>
                                            @if(isset($match['results']) && count($match['results']) >= 2)
                                                {{ $match['results'][0]['score'] ?? 'N/A' }} - {{ $match['results'][1]['score'] ?? 'N/A' }}
                                            @else
                                                Not available
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Кнопки -->
                                    <div class="mt-4 flex justify-center space-x-4">
                                        <a href="{{ route('match.stats', ['id' => $match['id']]) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            View Stats
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
