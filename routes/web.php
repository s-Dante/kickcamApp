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
    Route::patch('/profile/avatar', [\App\Http\Controllers\ProfileAvatarController::class, 'update'])->name('profile.avatar.update');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    /**
     * Cámaras (AR y Filtros)
     */
    Route::get('/camara-ar', function () {
        $files = scandir(public_path('assets/ar-compiler-targets'));
        $images = array_values(array_filter($files, fn ($f) => pathinfo($f, PATHINFO_EXTENSION) === 'jpg'));

        return view('arCamera.index', compact('images'));
    })->name('arCamera');

    Route::get('/ar-compiler', function () {
        $files = scandir(public_path('assets/ar-compiler-targets'));
        $images = array_values(array_filter($files, fn ($f) => pathinfo($f, PATHINFO_EXTENSION) === 'jpg'));

        return view('arCamera.compiler', compact('images'));
    })->name('arCamera.compiler');

    Route::get('/camara-filtros', function () {
        return view('camera.index');
    })->name('camera');

    /**
     * Scoreboard (TheSportsDB)
     */
    Route::get('/marcadores', [\App\Http\Controllers\ScoreboardController::class, 'index'])->name('scoreboard.index');
    Route::prefix('marcadores')->name('scoreboard.')->group(function () {
        Route::get('/equipo/{id}', [\App\Http\Controllers\ScoreboardController::class, 'showTeam'])->name('team');
        Route::get('/api/equipo/{iso}', [\App\Http\Controllers\ScoreboardController::class, 'getTeamByIso'])->name('api.team');
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
     * Ayuda
     */
    Route::get('/ayuda', function () {
        return view('help');
    })->name('help');

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
        Route::get('/jugar/siluetas', [\App\Http\Controllers\TriviaController::class, 'playSilhouette'])->name('playSilhouette');
        Route::get('/compilador-siluetas', function () {
            return view('trivia.silhouette-compiler');
        })->name('silhouetteCompiler');
        Route::get('/jugar/{country}', [\App\Http\Controllers\TriviaController::class, 'play'])->name('play');
        Route::post('/enviar', [\App\Http\Controllers\TriviaController::class, 'submit'])->name('submit');
    });
});
