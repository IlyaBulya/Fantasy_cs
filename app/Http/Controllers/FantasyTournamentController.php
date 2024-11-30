<?php

namespace App\Http\Controllers;

use App\Models\FantasyTournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FantasyTournamentController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Создаем турнир
            $fantasyTournament = FantasyTournament::create([
                'user_id' => auth()->id(),
                'tournament_id' => $request->tournament_id,
                'name' => $request->tournament_name ?? 'Tournament ' . $request->tournament_id,
                'start_date' => now(),
                'end_date' => now()->addDays(7)
            ]);

            // Создаем команду для турнира
            $fantasyTeam = $fantasyTournament->fantasyTeams()->create([
                'name' => $request->team_name,
                'players' => $request->players
            ]);

            DB::commit();

            // Проверяем создание
            if ($fantasyTournament->exists && $fantasyTeam->exists) {
                \Log::info('Успешно создан турнир и команда', [
                    'tournament_id' => $fantasyTournament->id,
                    'team_id' => $fantasyTeam->id
                ]);

                return redirect()
                    ->route('fantasy.show', $fantasyTournament)
                    ->with('success', 'Турнир и команда успешно созданы!');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Ошибка при создании турнира', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()
                ->with('error', 'Произошла ошибка при создании турнира')
                ->withInput();
        }
    }

    public function showCommands(FantasyTournament $fantasyTournament)
    {
        return view('fantasy-tournaments.commands', compact('fantasyTournament'));
    }

    public function show($fantasyTournament)
    {
        // Здесь вы можете добавить логику для получения данных о турнире
        // Например, получить турнир из базы данных
        // $tournament = Tournament::find($fantasyTournament);

        // Вернуть представление с данными о турнире
        return view('fantasy.tournament.show', compact('fantasyTournament'));
    }

    public function index()
    {
        $tournaments = FantasyTournament::where('user_id', auth()->id())
            ->with('team')
            ->get();

        return view('fantasy.index', [
            'tournaments' => $tournaments,
            'ongoingTournaments' => [],  // Оставляем пустым, так как это другой список
            'upcomingTournaments' => []  // Оставляем пустым, так как это другой список
        ]);
    }
} 