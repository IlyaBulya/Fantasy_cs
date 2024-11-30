<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FantasyController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\PandascoreController;
use App\Http\Controllers\SteamAuthController;
use App\Http\Controllers\MatchStatsController;
use App\Http\Controllers\FantasyTeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\FantasyTournamentController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Матчи (Live и Non-Live)
Route::prefix('results')->group(function () {
    Route::get('/live', [PandascoreController::class, 'showLiveMatches'])->name('results.live');
    Route::get('/nonlive', [PandascoreController::class, 'showNonLiveMatches'])->name('results.nonlive');
    Route::redirect('/', '/results/live')->name('results');
});

// Страницы функциональности
Route::get('/fantasy', [FantasyController::class, 'index'])->name('fantasy');
Route::get('/translations', [TranslationsController::class, 'index'])->name('translations');

// Профиль пользователя
Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
        Route::delete('/delete-avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.delete.avatar');
    });
});

// Просмотр статистики матча
Route::get('/match/{id}/stats', [MatchStatsController::class, 'show'])->name('match.stats');

// Аутентификация через Steam
Route::prefix('auth/steam')->group(function () {
    Route::get('/', [SteamAuthController::class, 'redirectToSteam'])->name('auth.steam');
    Route::get('/callback', [SteamAuthController::class, 'handleSteamCallback'])->name('auth.steam.callback');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/fantasy', [FantasyController::class, 'index'])->name('fantasy.index');
    Route::get('/fantasy/tournament/{id}', [FantasyController::class, 'show'])->name('fantasy.show');
    Route::post('/fantasy/{fantasyTournament}/team', [FantasyTeamController::class, 'store'])->name('fantasy.team.store');
    Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
    Route::get('/tournaments/{id}', [TournamentController::class, 'show'])->name('tournaments.show');
    Route::get('/fantasy-tournaments/{fantasyTournament}/commands', [FantasyTournamentController::class, 'showCommands'])
        ->name('fantasy-tournaments.commands');
    Route::get('/fantasy/tournament/{fantasyTournament}/team', [FantasyTeamController::class, 'show'])
        ->name('fantasy.team.show');
    Route::get('/fantasy/tournaments/{fantasyTournament}', [FantasyTournamentController::class, 'show'])
        ->name('fantasy.tournaments.show');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::get('/fantasy/{fantasyTournament}/team/create', [FantasyTeamController::class, 'create'])
        ->name('fantasy.team.create');
    Route::post('/fantasy/{fantasyTournament}/team', [FantasyTeamController::class, 'store'])
        ->name('fantasy.team.store');
    Route::get('/fantasy/tournaments', [FantasyTournamentController::class, 'index'])
        ->name('fantasy.tournaments.index');
    Route::delete('/fantasy/{fantasyTournament}/team/{team}', [FantasyTeamController::class, 'destroy'])
        ->name('fantasy.team.destroy');
    Route::post('/fantasy-teams', [FantasyTeamController::class, 'store'])
        ->name('fantasy-teams.store');
});

// Подключение стандартной аутентификации
require __DIR__.'/auth.php';
