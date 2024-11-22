<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FantasyController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\PandascoreController;
use Illuminate\Support\Facades\Route;

// Маршрут для главной страницы (Welcome)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Маршрут для страницы Results (Live и Non-Live)
Route::get('/results/live', [PandascoreController::class, 'showLiveMatches'])->name('results.live');
Route::get('/results/nonlive', [PandascoreController::class, 'showNonLiveMatches'])->name('results.nonlive');

// Дефолтный маршрут для Results, который перенаправляет на Live
Route::redirect('/results', '/results/live')->name('results');

// Маршрут для страницы Fantasy
Route::get('/fantasy', [FantasyController::class, 'index'])->name('fantasy');

// Маршрут для страницы Translations
Route::get('/translations', [TranslationsController::class, 'index'])->name('translations');

// Маршрут для страницы профиля пользователя
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/match/{id}/stats', [PandascoreController::class, 'showMatchStats'])->name('match.stats');


// Подключение аутентификации
require __DIR__.'/auth.php';
