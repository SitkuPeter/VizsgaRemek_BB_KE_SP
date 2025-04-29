<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function index()
    {
        return view('pages.games');
    }

    public function blackjack()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.blackjack', ['userData' => $userData]);
    }

    public function roulette()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.roulette', ['userData' => $userData]);
    }

    public function crash()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.crash', ['userData' => $userData]);
    }

    public function coinflip()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.coinflip', ['userData' => $userData]);
    }

    public function slot()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.slot', ['userData' => $userData]);
    }

    public function rock()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.rock', ['userData' => $userData]);
    }

    public function mines()
    {
        $user = Auth::user();
        $userData = $this->getUserData($user);
        return view('pages.games.mines', ['userData' => $userData]);
    }

    private function getUserData($user)
    {
        // Fetch and return relevant user data for games
        return [
            'id' => $user->id,
            'name' => $user->name,
            'balance' => $user->balance,
            'total_games_played' => $user->total_games_played,
            'total_wins' => $user->total_wins,
            'total_losses' => $user->total_losses,
            'total_winnings' => $user->total_winnings,
            'total_losses_amount' => $user->total_losses_amount,
            'last_played_at' => $user->last_played_at,
            'game_statistics' => $user->game_statistics
        ];
    }

    public function proxyDrawCards(Request $request)
    {
        $deckId = $request->input('deck_id');
        $count = $request->input('count');
        $url = "http://127.0.0.1:8001/api/deck/{$deckId}/draw/?count={$count}";

        try {
            $response = Http::get($url);
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
