<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ $tournament['name'] ?? 'Unnamed Tournament' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="bg-gray-800 text-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Build Your Team</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($teams as $team)
                        <div class="bg-gray-700 p-4 rounded">
                            <h4 class="font-bold">{{ $team['name'] }}</h4>
                            <img src="{{ $team['image_url'] }}" alt="{{ $team['name'] }}" class="h-16 w-auto mx-auto mb-4">
                            <a href="#" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                                Add Player
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
