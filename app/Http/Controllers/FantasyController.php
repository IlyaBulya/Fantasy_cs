<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\FantasyTournament;
use Exception;

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
        try {
            // Получаем данные о турнире через API
            $tournamentUrl = 'https://api.pandascore.co/tournaments/' . $id;
            
            // Используем тот же метод получения токена, что и в index
            $apiKey = env('PANDASCORE_API_TOKEN');
            
            $response = Http::withToken($apiKey)
                ->get($tournamentUrl);
            
            // Логируем ответ API для отладки
            Log::info('API Response:', [
                'url' => $tournamentUrl,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
                
            if (!$response->successful()) {
                throw new Exception('Не удалось загрузить данные турнира: ' . $response->body());
            }

            $tournament = $response->json();

            // Создаем или получаем существующий фэнтези-турнир
            $fantasyTournament = FantasyTournament::firstOrCreate(
                [
                    'tournament_id' => $id,
                    'user_id' => auth()->id(),
                ],
                [
                    'name' => 'Fantasy Tournament #' . $id
                ]
            );

            // Получаем составы команд, используя тот же метод авторизации
            $teamsUrl = 'https://api.pandascore.co/tournaments/' . $id . '/teams';
            $teamsResponse = Http::withToken($apiKey)
                ->get($teamsUrl);
            
            $expected_roster = [];
            if ($teamsResponse->successful()) {
                $teams = $teamsResponse->json();
                foreach ($teams as $team) {
                    $expected_roster[] = [
                        'team' => $team,
                        'players' => $team['players'] ?? []
                    ];
                }
            }

            return view('fantasy.show', [
                'fantasyTournament' => $fantasyTournament,
                'tournament' => [
                    'expected_roster' => $expected_roster
                ]
            ]);

        } catch (Exception $e) {
            Log::error('Ошибка при загрузке турнира', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->route('fantasy.index')
                ->with('error', 'Ошибка при загрузке турнира: ' . $e->getMessage());
        }
    }
}
