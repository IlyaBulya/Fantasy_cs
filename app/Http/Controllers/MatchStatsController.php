<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MatchStatsController extends Controller
{
    public function show($id)
    {
        // Получаем основную информацию о матче
        $response = Http::withToken(config('services.pandascore.token'))
            ->get("https://api.pandascore.co/matches/{$id}");
            
        $match = $response->json();

        // Получаем информацию о играх
        $gamesResponse = Http::withToken(config('services.pandascore.token'))
            ->get("https://api.pandascore.co/csgo/matches/{$id}/games");
            
        $games = $gamesResponse->json();

        return view('results.stats', [
            'match' => $match,
            'games' => $match['games'] ?? [],
            'opponents' => $match['opponents'] ?? []
        ]);
    }
} 