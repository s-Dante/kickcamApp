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

use App\Http\Controllers\AppContentController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    /**
     * Dashboard Central
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    /**
     * Trivia
     */
    Route::prefix('trivia')->name('trivia.')->group(function () {
        Route::get('index', [AppContentController::class, 'triviaIndex'])->name('index');
        Route::get('questions/{slug}', [AppContentController::class, 'playTrivia'])->name('questions');
    });

    /**
     * Multimedia
     */
    Route::prefix('multimedia')->name('multimedia.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\MultimediaController::class, 'index'])->name('index');
        Route::get('/{slug}', [\App\Http\Controllers\MultimediaController::class, 'show'])->name('show');
    });
});

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
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/trivia', [\App\Http\Controllers\TriviaController::class, 'index'])->name('trivia.index');
    Route::get('/trivia/results', [\App\Http\Controllers\TriviaController::class, 'results'])->name('trivia.results');
    Route::get('/trivia/play/{country}', [\App\Http\Controllers\TriviaController::class, 'play'])->name('trivia.play');

    // Placeholders for the other sections
    Route::get('/ar-camera', function () {
        return view('dashboard');
    })->name('arCamera');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/trivia/submit', [\App\Http\Controllers\TriviaController::class, 'submit'])->name('trivia.submit');
});
