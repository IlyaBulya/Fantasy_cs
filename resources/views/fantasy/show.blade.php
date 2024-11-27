<x-app-layout>
    @push('scripts')
    <script>
        let currentSlot = null;

        function openTeamSelector(slotNumber) {
            currentSlot = slotNumber;
            document.getElementById('teamSelector').classList.remove('hidden');
        }

        function showPlayers(roster) {
            document.getElementById('teamSelector').classList.add('hidden');
            const playersList = document.getElementById('playersList');
            playersList.innerHTML = '';

            roster.players.forEach(player => {
                const playerCard = document.createElement('div');
                playerCard.className = 'player-card w-48 p-4 bg-gray-700 rounded-xl cursor-pointer transform transition-all duration-200 hover:scale-105 hover:bg-gray-600 flex-shrink-0';
                playerCard.onclick = () => selectPlayer(player, roster.team);
                
                playerCard.innerHTML = `
                    <div class="flex flex-col items-center space-y-3">
                        <div class="w-20 h-20 flex items-center justify-center">
                            <img src="${player.image_url || '/default-player.png'}" 
                                 alt="${player.name}" 
                                 class="w-20 h-20 rounded-full object-cover border-2 border-indigo-500">
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-white">${player.name}</div>
                            <div class="text-sm text-indigo-400">${player.first_name} ${player.last_name}</div>
                            <div class="text-xs text-gray-400">Age: ${player.age || 'N/A'}</div>
                        </div>
                    </div>
                `;
                
                playersList.appendChild(playerCard);
            });

            document.getElementById('playerSelector').classList.remove('hidden');
        }

        function selectPlayer(player, team) {
            const slot = document.querySelector(`[data-slot="${currentSlot}"]`);
            const emptyState = slot.querySelector('.empty-state');
            const selectedPlayer = slot.querySelector('.selected-player');
            
            emptyState.classList.add('hidden');
            selectedPlayer.classList.remove('hidden');
            
            selectedPlayer.querySelector('img').src = player.image_url || '/default-player.png';
            selectedPlayer.querySelector('.player-name').textContent = player.name;
            selectedPlayer.querySelector('.team-name').textContent = team.name;

            document.getElementById('playerSelector').classList.add('hidden');
        }
    </script>
    @endpush

    <div class="min-h-screen bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white mb-2">Fantasy CS2</h1>
                <p class="text-indigo-400 text-xl">Build Your Dream Team</p>
            </div>
            
            <!-- Player slots - теперь горизонтально -->
            <div class="flex justify-between items-center gap-4 mb-8 overflow-x-auto pb-4">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="player-slot flex-shrink-0 w-64 h-80 bg-gray-800 rounded-xl border-2 border-dashed border-gray-600 cursor-pointer hover:border-indigo-500 transition-all duration-300 transform hover:scale-105"
                         data-slot="{{ $i }}"
                         onclick="openTeamSelector({{ $i }})">
                        <div class="empty-state h-full flex flex-col items-center justify-center p-4">
                            <div class="w-16 h-16 rounded-full bg-gray-700 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <span class="text-gray-400 font-medium">Player {{ $i }}</span>
                            <span class="text-gray-500 text-sm mt-2">Click to select</span>
                        </div>
                        <div class="selected-player hidden h-full flex flex-col items-center justify-center p-4">
                            <img src="" alt="" class="w-32 h-32 rounded-full border-4 border-indigo-500 mb-4 object-cover">
                            <span class="player-name text-xl font-bold text-white mb-1 text-center"></span>
                            <span class="team-name text-indigo-400 text-center"></span>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Team selector modal -->
            <div id="teamSelector" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 max-w-7xl mx-auto p-4">
                    <div class="bg-gray-800 rounded-xl shadow-2xl">
                        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-white">Select Team</h3>
                            <button onclick="document.getElementById('teamSelector').classList.add('hidden')" 
                                    class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <div class="flex gap-4 min-w-max">
                                @foreach($tournament['expected_roster'] as $roster)
                                    <div class="team-card w-48 p-4 bg-gray-700 rounded-xl cursor-pointer transform transition-all duration-200 hover:scale-105 hover:bg-gray-600 flex-shrink-0"
                                         onclick="showPlayers({{ json_encode($roster) }})">
                                        <div class="flex flex-col items-center space-y-3">
                                            <div class="w-20 h-20 flex items-center justify-center">
                                                <img src="{{ $roster['team']['image_url'] }}" 
                                                     alt="{{ $roster['team']['name'] }}" 
                                                     class="max-w-full max-h-full object-contain">
                                            </div>
                                            <span class="text-lg font-bold text-white text-center">
                                                {{ $roster['team']['name'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Player selector modal -->
            <div id="playerSelector" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50">
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 max-w-7xl mx-auto p-4">
                    <div class="bg-gray-800 rounded-xl shadow-2xl">
                        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                            <h3 class="text-2xl font-bold text-white">Select Player</h3>
                            <button onclick="document.getElementById('playerSelector').classList.add('hidden')" 
                                    class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-6 overflow-x-auto">
                            <div id="playersList" class="flex gap-4 min-w-max">
                                <!-- Players will be added here via JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Team Button -->
            <div class="text-center mt-8">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transform transition-all duration-200 hover:scale-105">
                    Save Team
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
