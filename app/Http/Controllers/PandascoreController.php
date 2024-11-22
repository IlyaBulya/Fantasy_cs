<?php

namespace App\Http\Controllers;

use App\Services\PandascoreApiService;

class PandascoreController extends Controller
{
    protected $apiService;

    public function __construct(PandascoreApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function showLiveMatches()
    {
        $allMatches = $this->apiService->getLiveMatches();
        $csgoMatches = collect($allMatches)->filter(fn($match) => $match['videogame']['slug'] === 'cs-go');
        return view('results.live', ['matches' => $csgoMatches]);
    }

    public function showNonLiveMatches()
    {
        $allMatches = $this->apiService->getNonLiveMatches();
        $csgoMatches = collect($allMatches)->filter(fn($match) => $match['videogame']['slug'] === 'cs-go');
        return view('results.nonlive', ['matches' => $csgoMatches]);
    }

    public function showMatchStats($id)
    {
        $match = $this->apiService->getMatchById($id);
        if (!$match) {
            abort(404, 'Match not found');
        }

        $frames = $this->apiService->getMatchFrames($id);

        return view('results.stats', [
            'match' => $match,
            'frames' => $frames,
            'players' => $match['players'] ?? [],
            'maps' => $match['games'] ?? [],
        ]);
    }
}
