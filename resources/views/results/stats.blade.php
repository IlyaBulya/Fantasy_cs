<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-white mb-6">Match Statistics</h1>

                    <!-- Teams and Main Score -->
                    <div class="bg-gray-700 p-6 rounded-lg mb-6">
                        <div class="flex justify-between items-center">
                            @foreach($match['opponents'] as $index => $opponent)
                                <div class="text-center flex-1">
                                    <img src="{{ $opponent['opponent']['image_url'] ?? '/images/placeholder.png' }}" 
                                         alt="{{ $opponent['opponent']['name'] }}"
                                         style="width: 40px; height: 40px; margin: 0 auto;"
                                         class="mb-2 object-contain"
                                         onerror="this.src='/images/placeholder.png'">
                                    <div class="text-xl text-white font-bold mb-1">
                                        {{ $opponent['opponent']['name'] }}
                                        @if($opponent['opponent']['acronym'])
                                            <span class="text-gray-400 text-sm">({{ $opponent['opponent']['acronym'] }})</span>
                                        @endif
                                    </div>
                                    <div class="text-3xl text-white font-bold">
                                        {{ $match['results'][$index]['score'] ?? '0' }}
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <div class="text-3xl text-white font-bold px-6">VS</div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Match Info -->
                    <div class="bg-gray-700 p-6 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <h3 class="text-gray-400 font-medium mb-1">Match Type</h3>
                                <p class="text-white">Best of {{ $match['number_of_games'] }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-400 font-medium mb-1">League</h3>
                                <p class="text-white">{{ $match['league']['name'] }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-400 font-medium mb-1">Start Time</h3>
                                <p class="text-white">{{ \Carbon\Carbon::parse($match['begin_at'])->format('F jS, Y h:i A') }}</p>
                            </div>
                            <div>
                                <h3 class="text-gray-400 font-medium mb-1">Status</h3>
                                <p class="text-white">{{ ucfirst($match['status']) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Games/Maps Status -->
                    <div class="bg-gray-700 p-6 rounded-lg">
                        <h2 class="text-xl font-bold text-white mb-4">Maps Status</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($match['games'] as $index => $game)
                                <div class="bg-gray-600 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-3">
                                        <h3 class="font-bold text-white">Map {{ $game['position'] }}</h3>
                                        <span class="px-2 py-1 rounded text-sm {{ $game['status'] === 'running' ? 'bg-green-500' : 'bg-gray-500' }} text-white">
                                            {{ ucfirst($game['status']) }}
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        @if($game['status'] === 'running')
                                            <div class="text-green-400 text-sm mb-1">Live Now</div>
                                        @endif
                                        @if($game['begin_at'])
                                            <div class="text-gray-400 text-sm">
                                                Started: {{ \Carbon\Carbon::parse($game['begin_at'])->format('H:i') }}
                                            </div>
                                        @endif
                                        @if(isset($game['results']) && count($game['results']) >= 2)
                                            <div class="text-2xl font-bold text-white mt-2">
                                                {{ $game['results'][0]['score'] ?? '0' }} - {{ $game['results'][1]['score'] ?? '0' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Stream Button -->
                    @if(!empty($match['streams_list']))
                        <div class="mt-6 text-center">
                            <a href="{{ $match['streams_list'][0]['raw_url'] }}" 
                               target="_blank"
                               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                                Watch Live Stream
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
