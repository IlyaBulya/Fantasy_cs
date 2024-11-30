<?php

namespace App\Http\Controllers;

use App\Models\FantasyTournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FantasyTeam;

class FantasyTeamController extends Controller
{
    public function store(Request $request, FantasyTournament $fantasyTournament)
    {
        try {
            // Логируем входящие данные
            \Log::info('Starting team creation:', [
                'request_data' => $request->all(),
                'tournament_id' => $fantasyTournament->id
            ]);

            $validated = $request->validate([
                'players' => 'required|array',
                'players.*.player_id' => 'required|integer',
                'players.*.name' => 'required|string',
                'players.*.team' => 'required|string',
                'players.*.image_url' => 'nullable|string',
            ]);

            \Log::info('Validation passed:', [
                'validated_data' => $validated
            ]);

            // Проверяем существующие записи
            $existingTeam = FantasyTeam::where('fantasy_tournament_id', $fantasyTournament->id)->first();
            \Log::info('Existing team check:', [
                'exists' => !is_null($existingTeam),
                'team_id' => $existingTeam ? $existingTeam->id : null
            ]);

            DB::beginTransaction();

            try {
                if ($existingTeam) {
                    $existingTeam->update([
                        'players' => $validated['players']
                    ]);
                    $fantasyTeam = $existingTeam;
                    \Log::info('Updated existing team:', [
                        'team_id' => $fantasyTeam->id
                    ]);
                } else {
                    $fantasyTeam = FantasyTeam::create([
                        'fantasy_tournament_id' => $fantasyTournament->id,
                        'name' => 'Team-' . time(),
                        'players' => $validated['players']
                    ]);
                    \Log::info('Created new team:', [
                        'team_id' => $fantasyTeam->id
                    ]);
                }

                DB::commit();

                \Log::info('Transaction committed successfully');

                return response()->json([
                    'success' => true,
                    'redirect' => route('fantasy.team.show', $fantasyTournament)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Error in team creation:', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'tournament_id' => $fantasyTournament->id,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при сохранении команды: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show(FantasyTournament $fantasyTournament = null)
    {
        // Получаем все команды без привязки к конкретному турниру
        $teams = FantasyTeam::orderBy('created_at', 'desc')->get();
        
        \Log::info('Found teams:', [
            'count' => $teams->count(),
            'teams' => $teams->toArray()
        ]);

        return view('fantasy.tournament.show', [
            'teams' => $teams,
            'tournament' => $fantasyTournament // оставляем для обратной совместимости
        ]);
    }

    public function destroy(FantasyTournament $fantasyTournament, FantasyTeam $team)
    {
        try {
            $team->delete();
            return redirect()->route('welcome')->with('success', 'Team has been deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting team');
        }
    }
} 