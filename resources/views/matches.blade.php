@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4 text-center">Live Matches</h1>

                    @if($matches->isEmpty())
                        <p class="text-gray-400 text-center">No matches available at the moment.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($matches as $match)
                                <div class="bg-gray-100 p-4 rounded-md shadow-md">
                                    <h3 class="text-xl font-semibold">{{ $match['team_a'] }} vs {{ $match['team_b'] }}</h3>
                                    <p class="text-sm text-gray-600">Score: {{ $match['score'] }}</p>
                                    <p class="text-sm text-gray-600">Event: {{ $match['event'] }}</p>
                                    <button class="bg-blue-500 text-white py-2 px-4 rounded-md mt-2">View Details</button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
