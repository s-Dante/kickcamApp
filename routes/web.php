<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Rutas para la autentificacion
 */
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('email', function () {
        return view('auth.email');
    })->name('email');

    Route::get('confirm', function () {
        return view('auth.confirm');
    })->name('confirm');

    Route::get('reset', function () {
        return view('auth.reset');
    })->name('reset');
});


/**
 * las siguiente srutas serán envueltas en un middleware para proteger que no cualquiera inicie sesion
 */

/**
 * Rutas del perfil
 */
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('me', function () {
        return view('profile.index');
    })->name('me');

    Route::get('edit', function () {
        return view('profile.edit');
    })->name('edit');
});

/**
 * Rutas de la camara AR
 */
Route::get('/arCamera', function () {
    return view('arCamera.index');
})->name('arCamera');

/**
 * Routas para la camara e filtros
 */
Route::get('/camera', function () {
    return view('camera.index');
})->name('camera');

/**
 * Rutas para la trivia
 */
Route::prefix('trivia')->name('trivia.')->group(function () {
    Route::get('select', function () {
        return view('trivia.index');
    })->name('index');

    Route::get('questions', function () {
        return view('trivia.trivia');
    })->name('questions');
});

/**
 * Rutas para la multimedia
 */
Route::prefix('multimedia')->name('multimedia.')->group(function () {
    Route::get('/', function () {
        return view('multimedia.index');
    })->name('index');

    Route::get('videos-and-pictures', function () {
        return view('multimedia.watch');
    })->name('watch');
});

/**
 * Rutas para las estadisticas/marcadores
 */
Route::prefix('scoreboard')->name('scoreboard.')->group(function () {
    Route::get('/', function () {
        return view('scoreboard.index');
    })->name('index');

    Route::get('matches', function () {
        return view('scoreboard.matches');
    })->name('matches');

     Route::get('match-status', function () {
        return view('scoreboard.match-status');
    })->name('match-status');
});