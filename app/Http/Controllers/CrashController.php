<?php

namespace App\Http\Controllers;

use App\Models\GameLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CrashController extends Controller
{
    public function start(Request $request)
    {
        $validated = $request->validate([
            'bet_amount' => 'required|numeric|min:1|max:1000'
        ]);

        $user = Auth::user();
        
        // Prevent concurrent games
        if (Cache::has('crash-active-'.$user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Finish your current game first.'
            ], 429);
        }

        // Store active game for 2 minutes
        Cache::put('crash-active-'.$user->id, true, now()->addMinutes(2));

        $betAmount = $validated['bet_amount'];

        if ($betAmount > $user->balance) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance'
            ], 422);
        }

        $user->balance -= $betAmount;
        $user->save();

        return response()->json([
            'success' => true,
            'balance' => (float)$user->balance // Explicitly cast to float
        ]);
    }

    public function end(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|string',
            'result' => 'required|in:win,lose',
            'bet_amount' => 'required|numeric',
            'cashout_multiplier' => 'nullable|numeric',
            'crash_point' => 'required|numeric',
            'winnings' => 'required|numeric'
        ]);

        $user = Auth::user();

        // Prevent duplicate processing of the same game
        $cacheKey = 'crash-processed-'.$validated['game_id'];
        
        if (Cache::has($cacheKey)) {
            return response()->json([
                'success' => false,
                'message' => 'This game has already been processed.'
            ], 409);
        }

        // Mark the game as processed for 24 hours
        Cache::put($cacheKey, true, now()->addDay());

        // Clear active game lock
        Cache::forget('crash-active-'.$user->id);

        if ($validated['result'] === 'win') {
            // Add winnings to balance
            $user->balance += $validated['winnings'];
            
            // Calculate net winnings (total payout - original bet)
            $netWinnings = $validated['winnings'] - $validated['bet_amount'];
            
            // Update statistics for a win
            $user->updateGameStatistics(true, $netWinnings, 'crash');
            
            Log::info("Crash Win: User {$user->id} won {$netWinnings}");
        } else {
            // Update statistics for a loss
            $user->updateGameStatistics(false, $validated['bet_amount'], 'crash');
            
            Log::info("Crash Loss: User {$user->id} lost {$validated['bet_amount']}");
        }

        $user->save();

        // Log the game in GameLog table
        GameLog::create([
            'user_id' => $user->id,
            'game_type' => 'crash',
            'bet_amount' => $validated['bet_amount'],
            'win_amount' => ($validated['result'] === 'win') ? $validated['winnings'] : 0,
            'is_win' => ($validated['result'] === 'win'),
            'game_data' => json_encode([
                'crash_point' => $validated['crash_point'],
                'cashout_multiplier' => $validated['cashout_multiplier'],
                'result' => $validated['result']
            ]),
            'played_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'balance' => (float)$user->balance // Explicitly cast to float
        ]);
    }
}
