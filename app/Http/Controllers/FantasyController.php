<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use GuzzleHttp\Client;
use Carbon\Carbon;

class FantasyController extends Controller
{
    public function index(): View
    {
        $runningTournamentsUrl = 'https://api.pandascore.co/csgo/tournaments/running';
        $upcomingTournamentsUrl = 'https://api.pandascore.co/csgo/tournaments/upcoming';
        $apiKey = env('PANDASCORE_API_TOKEN');

        $runningResponse = Http::withToken($apiKey)->get($runningTournamentsUrl);
        $runningTournaments = $runningResponse->successful() ? $runningResponse->json() : [];

        $upcomingResponse = Http::withToken($apiKey)->get($upcomingTournamentsUrl);
        $upcomingTournaments = $upcomingResponse->successful() ? $upcomingResponse->json() : [];

        return view('fantasy.index', [
            'ongoingTournaments' => $runningTournaments,
            'upcomingTournaments' => $upcomingTournaments,
        ]);
    }

    public function show($id)
    {
        $client = new Client();
        $response = $client->get("https://api.pandascore.co/tournaments/{$id}", [
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.pandascore.token')
            ]
        ]);

        $tournament = json_decode($response->getBody(), true);
        $matches = collect($tournament['matches'] ?? [])
            ->sortBy('begin_at')
            ->groupBy(function ($match) {
                return Carbon::parse($match['begin_at'])->format('Y-m-d');
            });

        return view('fantasy.show', [
            'tournament' => $tournament,
            'matches' => $matches,
            'expectedTeams' => collect($tournament['expected_roster'] ?? [])
                ->pluck('team')
                ->sortBy('name')
        ]);
    }
}
