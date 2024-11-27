<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class FantasyController extends Controller
{
    public function index(): View
    {
        // PandaScore API endpoints
        $runningTournamentsUrl = 'https://api.pandascore.co/csgo/tournaments/running';
        $upcomingTournamentsUrl = 'https://api.pandascore.co/csgo/tournaments/upcoming';
        $apiKey = env('PANDASCORE_API_TOKEN'); // Fetch API key from the .env file

        // Fetch running tournaments
        $runningResponse = Http::withToken($apiKey)->get($runningTournamentsUrl);
        $runningTournaments = $runningResponse->json();

        // Fetch upcoming tournaments
        $upcomingResponse = Http::withToken($apiKey)->get($upcomingTournamentsUrl);
        $upcomingTournaments = $upcomingResponse->json();

        return view('fantasy.index', [
            'ongoingTournaments' => $runningTournaments,
            'upcomingTournaments' => $upcomingTournaments,
        ]);
    }
}
