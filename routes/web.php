<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppContentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Guest Routes (Solo accesibles si NO estás logueado)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.post');

        Route::get('register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [AuthController::class, 'register'])->name('register.post');

        // Vistas estáticas de recuperación (pueden ser controladas por AuthController después)
        Route::view('email', 'auth.email')->name('email');
        Route::view('confirm', 'auth.confirm')->name('confirm');
        Route::view('reset', 'auth.reset')->name('reset');
    });
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Requieren inicio de sesión)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    /**
     * Rutas del perfil
     */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('me', [ProfileController::class, 'index'])->name('me');
        Route::get('edit', function () { return view('profile.edit'); })->name('edit');
    });

    /**
     * AR & Camera
     */
    Route::get('/arCamera', function () { return view('arCamera.index'); })->name('arCamera');
    Route::get('/camera', function () { return view('camera.index'); })->name('camera');

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
        Route::get('/index', [AppContentController::class, 'multimediaIndex'])->name('index');
        Route::get('/{slug}', [AppContentController::class, 'watchMultimedia'])->name('watch');
    });

    /**
     * Scoreboard (Estadísticas BeSoccer)
     */
    Route::prefix('scoreboard')->name('scoreboard.')->group(function () {
        Route::get('/', function () { return view('scoreboard.index'); })->name('index');
        Route::get('matches', function () { return view('scoreboard.matches'); })->name('matches');
        Route::get('match-status', function () { return view('scoreboard.match-status'); })->name('match-status');
    });
});