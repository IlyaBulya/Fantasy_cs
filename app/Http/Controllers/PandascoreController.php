<?php

namespace App\Http\Controllers;

use App\Services\PandascoreApiService;
use Illuminate\Support\Facades\Http;
use App\Models\Tournament;
use Illuminate\Support\Facades\Cache;

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

    public function getTournament($id)
    {
        return Cache::remember("tournament.{$id}", 3600, function () use ($id) {
            try {
                $response = Http::withToken(config('services.pandascore.token'))
                    ->get("https://api.pandascore.co/tournaments/{$id}")
                    ->throw();

                return $response->json();
            } catch (\Exception $e) {
                \Log::error('Ошибка при получении турнира из Pandascore', [
                    'tournament_id' => $id,
                    'error' => $e->getMessage()
                ]);

                return Tournament::find($id)?->toArray() ?? [
                    'error' => 'Турнир не найден',
                    'message' => 'Не удалось загрузить данные турнира'
                ];
            }
        });
    }
}
