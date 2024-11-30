<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentController extends Controller
{
    public function index()
    {
        try {
            \Log::info('Начало загрузки турниров');
            
            DB::enableQueryLog(); // включаем логирование запросов
            
            $tournaments = Tournament::query()
                ->with(['fantasyTournaments'])
                ->get();
                
            \Log::info('SQL запросы:', DB::getQueryLog());
            \Log::info('Турниры загружены:', ['count' => $tournaments->count()]);
            
            return view('tournaments.index', compact('tournaments'));
        } catch (\Exception $e) {
            \Log::error('Ошибка загрузки турниров: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Не удалось загрузить данные турнира');
        }
    }

    public function show($id)
    {
        $tournament = Tournament::findOrFail($id);
        
        // Если турнира нет в локальной базе, попробуем получить его из API
        if (!$tournament) {
            try {
                $pandascoreData = app(PandascoreController::class)->getTournament($id);
                
                // Создаем турнир в локальной базе
                $tournament = Tournament::create([
                    'id' => $pandascoreData['id'],
                    'name' => $pandascoreData['name'],
                    // другие поля...
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Турнир не найден',
                    'message' => 'Не удалось загрузить данные турнира'
                ], 404);
            }
        }

        return view('tournaments.show', compact('tournament'));
    }

    public function create()
    {
        return view('tournaments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Tournament::create($validated);

        return redirect()->route('tournaments.index')
            ->with('success', 'Турнир успешно создан');
    }
}