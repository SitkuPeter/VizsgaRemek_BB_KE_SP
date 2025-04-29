<?php

namespace App\Http\Controllers;

use App\Models\GameLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RouletteController extends Controller
{
    public function start(Request $request)
    {
        $validated = $request->validate([
            'bet_amount' => 'required|numeric|min:1|max:1000',
            'bet_type' => 'required|in:even,odd,red,black,green'
        ]);

        $user = Auth::user();
        $betAmount = $validated['bet_amount'];
        $betType = $validated['bet_type'];

        if ($betAmount > $user->balance) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance']);
        }

        Log::info("Roulette start - User: {$user->id}, Bet: {$betAmount}, Type: {$betType}, Balance: {$user->balance}");

        $user->balance -= $betAmount;
        $user->save();

        return response()->json([
            'success' => true,
            'balance' => (float)$user->balance
        ]);
    }

    public function end(Request $request)
    {
        $validated = $request->validate([
            'result' => 'required|in:win,lose',
            'bet_amount' => 'required|numeric',
            'bet_type' => 'required|in:even,odd,red,black,green',
            'winnings' => 'required|numeric'
        ]);

        $user = Auth::user();
        $result = $validated['result'];
        $betAmount = $validated['bet_amount'];
        $betType = $validated['bet_type'];
        $winnings = $validated['winnings'];

        Log::info("Roulette end - User: {$user->id}, Result: {$result}, Bet: {$betAmount}, Type: {$betType}");

        if ($result === 'win') {
            $user->balance += $winnings;
            $netWinnings = $winnings - $betAmount;
            $user->updateGameStatistics(true, $netWinnings, 'roulette');
            Log::info("Win: User {$user->id} net winnings: {$netWinnings}");
        } else {
            $user->updateGameStatistics(false, $betAmount, 'roulette');
            Log::info("Loss: User {$user->id} lost: {$betAmount}");
        }

        $user->save();

        GameLog::create([
            'user_id' => $user->id,
            'game_type' => 'roulette',
            'bet_amount' => $betAmount,
            'bet_type' => $betType,
            'win_amount' => $winnings,
            'is_win' => ($result === 'win'),
            'game_data' => json_encode([
                'result' => $result,
                'bet_type' => $betType,
                'payout_multiplier' => $result === 'win' ? $this->getPayoutMultiplier($betType) : null
            ]),
            'played_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'balance' => (float)$user->balance
        ]);
    }

    private function getPayoutMultiplier(string $betType): int
    {
        return match($betType) {
            'green' => 35,
            default => 2
        };
    }
}
