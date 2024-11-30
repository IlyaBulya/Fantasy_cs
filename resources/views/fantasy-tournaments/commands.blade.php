<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ваши команды') }} - {{ $fantasyTournament->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($fantasyTournament->commands)
                        <div class="space-y-4">
                            @foreach(json_decode($fantasyTournament->commands) as $command)
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    {{ $command }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>У вас пока нет сохраненных команд.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 