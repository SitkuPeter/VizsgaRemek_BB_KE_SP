<?php

namespace App\Http\Controllers;

use App\Models\GameLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SlotController extends Controller
{
    public function start(Request $request)
    {
        $user = Auth::user();
        $betAmount = $request->input('bet_amount');
        
        if ($betAmount > $user->balance) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance']);
        }

        // Log the bet amount and balance before deduction
        Log::info('User ' . $user->id . ' starting Slot Machine game with bet: ' . $betAmount . ', initial balance: ' . $user->balance);

        $user->balance -= $betAmount;
        $user->save();

        // Log the balance after deduction
        Log::info('User ' . $user->id . ' balance after bet: ' . $user->balance);

        return response()->json(['success' => true, 'balance' => $user->balance]);
    }

    public function end(Request $request)
    {
        Log::info('End game request received', $request->all());
    
        $user = Auth::user();
        $result = $request->input('result');
        $betAmount = $request->input('bet_amount');
        $reels = $request->input('reels');
        $winnings = $request->input('winnings');
    
        Log::info("User: {$user->id}, Result: {$result}, Bet: {$betAmount}");
    
        if ($result === 'win') {
            $user->balance += $winnings;
            Log::info("Win: User {$user->id} won {$winnings}");
        } else {
            Log::info("Loss: User {$user->id} lost {$betAmount}");
        }
    
        $user->save();
        Log::info("User balance after game: {$user->balance}");
    
        $user->updateGameStatistics($result === 'win', $betAmount, 'slot-machine');
    
        $gameLog = GameLog::create([
            'user_id' => $user->id,
            'game_type' => 'slot-machine',
            'bet_amount' => $betAmount,
            'win_amount' => $winnings,
            'is_win' => ($result === 'win'),
            'game_data' => json_encode([
                'reels' => $reels,
                'result' => $result
            ]),
            'played_at' => now()
        ]);
    
        Log::info("GameLog created: ", $gameLog->toArray());
    
        return response()->json(['success' => true, 'balance' => $user->balance]);
    }
}
