<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoinflipController;
use App\Http\Controllers\BlackjackController;
use App\Http\Controllers\CrashController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MinesController;
use App\Http\Controllers\RockPaperScissorsController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\SlotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/blackjack/start', [BlackjackController::class, 'start']);
    Route::post('/blackjack/end', [BlackjackController::class, 'end']);

    Route::post('/coinflip/start', [CoinflipController::class, 'start']);
    Route::post('/coinflip/end', [CoinflipController::class, 'end']);

    Route::post('/rock-paper-scissors/start', [RockPaperScissorsController::class, 'start']);
    Route::post('/rock-paper-scissors/end', [RockPaperScissorsController::class, 'end']);

    Route::post('/slot-machine/start', [SlotController::class, 'start']);
    Route::post('/slot-machine/end', [SlotController::class, 'end']);

    Route::post('/roulette/start', [RouletteController::class, 'start']);
    Route::post('/roulette/end', [RouletteController::class, 'end']);

    Route::post('/crash/start', [CrashController::class, 'start']);
    Route::post('/crash/end', [CrashController::class, 'end']);

    Route::post('/mines/start', [MinesController::class, 'start']);
    Route::post('/mines/end', [MinesController::class, 'end']);

});

Route::middleware('auth:sanctum')->get('/user/balance', function (Request $request) {
    return response()->json(['balance' => $request->user()->balance]);
});

Route::get('/proxy-draw-cards', [GameController::class, 'proxyDrawCards']);

Route::post('/generate-token', [AuthController::class, 'generateToken']);
