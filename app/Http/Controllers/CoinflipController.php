<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CoinflipController extends Controller
{
    public function start(Request $request)
    {
        $user = Auth::user();
        $betAmount = $request->input('bet_amount');

        if ($betAmount > $user->balance) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance']);
        }

        Log::info('User ' . $user->id . ' starting coinflip game with bet: ' . $betAmount . ', initial balance: ' . $user->balance);

        $user->balance -= $betAmount;
        $user->save();

        Log::info('User ' . $user->id . ' balance after bet: ' . $user->balance);

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }

    public function end(Request $request)
    {
        Log::info('End coinflip game request received', $request->all());

        $user = Auth::user();
        $result = $request->input('result');
        $betAmount = $request->input('bet_amount');
        $userChoice = $request->input('user_choice');
        $coinResult = $request->input('coin_result');

        Log::info("User: {$user->id}, Result: {$result}, Bet: {$betAmount}, Choice: {$userChoice}, Coin: {$coinResult}");

        $winAmount = 0;
        $isWin = false;

        if ($result === 'win') {
            $winAmount = $betAmount * 2;
            $user->balance += $winAmount;
            $isWin = true;
            Log::info("Win: User {$user->id} won {$winAmount} in the coin flip game.");
        } else {
            Log::info("Loss: User {$user->id} lost {$betAmount} in the coin flip game.");
        }

        $user->save();

        Log::info("User balance after game: {$user->balance}");

        $user->updateGameStatistics($isWin, $betAmount, 'coinflip');

        $gameLog = GameLog::create([
            'user_id' => $user->id,
            'game_type' => 'coinflip',
            'bet_amount' => $betAmount,
            'win_amount' => $winAmount,
            'is_win' => $isWin,
            'game_data' => json_encode([
                'user_choice' => $userChoice,
                'coin_result' => $coinResult
            ]),
            'played_at' => now()
        ]);

        Log::info("GameLog created: ", $gameLog->toArray());

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
}
