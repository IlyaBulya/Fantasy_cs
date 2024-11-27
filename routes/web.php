<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FantasyController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\PandascoreController;
use App\Http\Controllers\SteamAuthController;
use App\Http\Controllers\MatchStatsController;
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

Route::get('/fantasy', [FantasyController::class, 'index'])->name('fantasy');
Route::get('/fantasy/tournament/{id}', [FantasyController::class, 'show'])->name('fantasy.tournament');

Route::get('/fantasy', [FantasyController::class, 'index'])->name('fantasy.index');
Route::get('/fantasy/tournament/{id}', [FantasyController::class, 'show'])->name('fantasy.show');
Route::post('/fantasy/assign-team', [FantasyController::class, 'assignTeamToSlot'])->name('fantasy.assign-team');



// Подключение стандартной аутентификации
require __DIR__.'/auth.php';
