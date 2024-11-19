<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\FantasyController;
use App\Http\Controllers\TranslationsController;
use App\Models\GameMatch;
use Illuminate\Support\Facades\Route;

// Маршрут для главной страницы (Welcome)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/results', function () {
    $matches = GameMatch::all(); // Получение всех записей из таблицы game_matches
    return view('results', compact('matches')); // Передача данных в представление
})->name('results');

Route::get('/fantasy', [FantasyController::class, 'index'])->name('fantasy');

Route::get('/translations', [TranslationsController::class, 'index'])->name('translations');




// Маршрут для страницы профиля пользователя
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Подключение аутентификации
require __DIR__.'/auth.php';



