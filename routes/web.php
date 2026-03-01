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

require __DIR__ . '/auth.php';

use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    /**
     * AR & Camera
     */
    Route::get('/arCamera', function () {
        return view('arCamera.index');
    })->name('arCamera');

    Route::get('/camera', function () {
        return view('camera.index');
    })->name('camera');

    /**
     * Scoreboard (TheSportsDB)
     */
    Route::prefix('scoreboard')->name('scoreboard.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ScoreboardController::class, 'index'])->name('index');
        Route::get('/team/{id}', [\App\Http\Controllers\ScoreboardController::class, 'showTeam'])->name('team');
    });

    /**
     * Multimedia
     */
    Route::prefix('multimedia')->name('multimedia.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\MultimediaController::class, 'index'])->name('index');
        Route::get('/{slug}', [\App\Http\Controllers\MultimediaController::class, 'show'])->name('show');
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
    Route::prefix('trivia')->name('trivia.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\TriviaController::class, 'index'])->name('index');
        Route::get('/results', [\App\Http\Controllers\TriviaController::class, 'results'])->name('results');
        Route::get('/play/{country}', [\App\Http\Controllers\TriviaController::class, 'play'])->name('play');
        Route::post('/submit', [\App\Http\Controllers\TriviaController::class, 'submit'])->name('submit');
    });
});
