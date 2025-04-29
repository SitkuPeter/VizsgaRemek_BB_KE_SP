<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Home útvonal definiálása (ha szükséges)
Route::get('/home', function () {
    return redirect()->route('dashboard'); // Átirányítás a dashboardra
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authentikált felhasználók útvonalai
Route::middleware('auth')->group(function () {

    // Profil kezelés
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Alkalmazás oldalak
    Route::get('/mainpage', [MainPageController::class, 'index'])->name('pages.mainpage');
    Route::get('/games', [GameController::class, 'index'])->name('pages.games');
    Route::get('/friends', [FriendController::class, 'index'])->name('pages.friends');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('pages.leaderboard');

    // Pénztárca és hirdetések
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::post('/wallet/process-ad', [WalletController::class, 'processAd'])->name('wallet.process-ad');

    // Hirdetés médiafájlok
    Route::get('/ads/{id}/video', [AdvertisementController::class, 'getVideo'])->name('ads.video');
    Route::get('/ads/{id}/image', [AdvertisementController::class, 'getImage'])->name('ads.image');

    //Shop - coming soon
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');

    // Fórum főoldal
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');

    // Poszt műveletek
    Route::post('/forum/post', [ForumController::class, 'store'])->name('forum.post.store');
    Route::delete('/forum/post/{id}', [ForumController::class, 'destroy'])->name('forum.post.destroy');

    // Poszt megtekintése és kommentek
    Route::get('/forum/post/{id}', [PostController::class, 'show'])->name('forum.post.show');
    Route::post('/forum/post/{id}/comment', [PostController::class, 'addComment'])->name('forum.comment.store');
    Route::delete('/forum/comment/{id}', [PostController::class, 'destroyComment'])->name('forum.comment.destroy');
});

//Friends cucc

Route::post('/friend-request/{id}/accept', [FriendController::class, 'acceptRequest'])->name('friend.request.accept');
Route::post('/friend-request/{id}/decline', [FriendController::class, 'declineRequest'])->name('friend.request.decline');
Route::get('/friends/list', [FriendController::class, 'friendsList'])->name('friends.list');

//Friends Messages cucc

Route::get('/friends/messages', [MessageController::class, 'index'])->name('friends.messages');
Route::post('/friends/messages/send', [MessageController::class, 'send'])->name('friends.messages.send');


// Játék útvonalak
Route::get('/games/blackjack', [GameController::class, 'blackjack'])->name('blackjack');
Route::get('/games/roulette', [GameController::class, 'roulette'])->name('roulette');
Route::get('/games/crash', [GameController::class, 'crash'])->name('crash');
Route::get('/games/coinflip', [GameController::class, 'coinflip'])->name('coinflip');
Route::get('/games/slot', [GameController::class, 'slot'])->name('slot');
Route::get('/games/rock-paper-scissors', [GameController::class, 'rock'])->name('rock-paper-scissors');
Route::get('/games/mines', [GameController::class, 'mines'])->name('mines');


// Felhasználói statisztikák
Route::get('/userstats', [UserController::class, 'index'])->name('profile.statistics');

//Admin útvonalak
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/{user}/suspend', [UserController::class, 'suspend'])->name('admin.suspend');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.destroy');

    Route::prefix('ads')->group(function () {
        Route::get('/', [AdvertisementController::class, 'index'])->name('admin.ads.index');
        Route::get('/create', [AdvertisementController::class, 'create'])->name('admin.ads.create');
        Route::post('/', [AdvertisementController::class, 'store'])->name('admin.ads.store');
        Route::get('/{ad}/edit', [AdvertisementController::class, 'edit'])->name('admin.ads.edit');
        Route::put('/{ad}', [AdvertisementController::class, 'update'])->name('admin.ads.update');
        Route::delete('/{ad}', [AdvertisementController::class, 'destroy'])->name('admin.ads.destroy');
        Route::delete('/{ad}/force', [AdvertisementController::class, 'forceDestroy'])
            ->name('admin.ads.forceDestroy');
    });
});

// Auth alapú útvonalak
require __DIR__ . '/auth.php';
Route::post('/friends/request/{id}', [FriendController::class, 'sendRequest'])->name('friends.request');

Route::get('/admin', [AdminController::class, 'dashboard'])
    ->middleware(['auth', AdminMiddleware::class])
    ->name('admin.dashboard');

Route::get('/admin/{id}', [AdminController::class, 'showById'])->name('profile.show');
