<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BlackjackController extends Controller
{
    public function start(Request $request)
    {
        $user = Auth::user();
        $betAmount = $request->input('bet_amount');

        if ($betAmount > $user->balance) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance']);
        }

        // Log the bet amount and balance before deduction
        Log::info('User ' . $user->id . ' starting game with bet: ' . $betAmount . ', initial balance: ' . $user->balance);

        $user->balance -= $betAmount;
        $user->save();

        // Log the balance after deduction
        Log::info('User ' . $user->id . ' balance after bet: ' . $user->balance);

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
    private function checkBlackjack(array $hand)
    {
        if (count($hand) !== 2) {
            return false; 
        }

        $values = array_column($hand, 'value'); 
        return (in_array('A', $values) && (in_array('10', $values) || in_array('J', $values) || in_array('Q', $values) || in_array('K', $values)));
    }
    public function end(Request $request)
    {
        Log::info('End game request received', $request->all());
    
        $user = Auth::user();
        $result = $request->input('result');
        $betAmount = $request->input('bet_amount');
        $playerHand = $request->input('player_hand');
        $dealerHand = $request->input('dealer_hand');
    
        Log::info("User: {$user->id}, Result: {$result}, Bet: {$betAmount}");
    
        $winAmount = 0;
        $isWin = false;
    
        if ($result === 'win') {
            $winAmount = $betAmount * 2;
            $user->balance += $winAmount;
            $isWin = true;
            Log::info("Win: User {$user->id} won {$winAmount}");
        } elseif ($result === 'tie') {
            $winAmount = $betAmount;
            $user->balance += $winAmount;
            Log::info("Tie: User {$user->id} got back {$winAmount}");
        } else {
            Log::info("Loss: User {$user->id} lost {$betAmount}");
        }
    
        $user->save();
        Log::info("User balance after game: {$user->balance}");
    
        if ($result !== 'tie') {
            $user->updateGameStatistics($isWin, $betAmount, 'blackjack');
        }
    
        $gameLog = GameLog::create([
            'user_id' => $user->id,
            'game_type' => 'blackjack',
            'bet_amount' => $betAmount,
            'win_amount' => $winAmount,
            'is_win' => ($result === 'win'),
            'game_data' => json_encode([
                'player_hand' => $playerHand,
                'dealer_hand' => $dealerHand,
                'result' => $result
            ]),
            'played_at' => now()
        ]);
    
        Log::info("GameLog created: ", $gameLog->toArray());
    
        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
}
