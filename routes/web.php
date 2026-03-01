<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    /**
     * Cámaras (AR y Filtros)
     */
    Route::get('/camara-ar', function () {
        return view('arCamera.index');
    })->name('arCamera');

    Route::get('/camara-filtros', function () {
        return view('camera.index');
    })->name('camera');

    /**
     * Scoreboard (TheSportsDB)
     */
    Route::get('/marcadores', [\App\Http\Controllers\ScoreboardController::class, 'index'])->name('scoreboard.index');
    Route::prefix('marcadores')->name('scoreboard.')->group(function () {
        Route::get('/equipo/{id}', [\App\Http\Controllers\ScoreboardController::class, 'showTeam'])->name('team');
    });

    /**
     * Multimedia
     */
    Route::get('/multimedia', [\App\Http\Controllers\MultimediaController::class, 'index'])->name('multimedia.index');
    Route::prefix('multimedia')->name('multimedia.')->group(function () {
        Route::get('/ver/{slug}', [\App\Http\Controllers\MultimediaController::class, 'show'])->name('show');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    /**
     * Dashboard Central
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**
     * Trivia
     */
    Route::get('/trivia', [\App\Http\Controllers\TriviaController::class, 'index'])->name('trivia.index');
    Route::prefix('trivia')->name('trivia.')->group(function () {
        Route::get('/resultados', [\App\Http\Controllers\TriviaController::class, 'results'])->name('results');
        Route::get('/jugar/{country}', [\App\Http\Controllers\TriviaController::class, 'play'])->name('play');
        Route::post('/enviar', [\App\Http\Controllers\TriviaController::class, 'submit'])->name('submit');
    });
});
