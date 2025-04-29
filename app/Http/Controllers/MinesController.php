<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\GameLog;

class MinesController extends Controller
{
    public function start(Request $request)
    {
        $validated = $request->validate([
            'bet_amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $betAmount = $validated['bet_amount'];

        if ($betAmount > $user->balance) {
            return response()->json(['success' => false, 'message' => 'Insufficient balance']);
        }

        Log::info("Mines start - User: {$user->id}, Bet: {$betAmount}, Balance: {$user->balance}");

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
            'bet_amount' => 'required|numeric|min:1',
            'mines_count' => 'required|integer|min:1|max:24',
            'revealed_cells' => 'required|integer|min:0|max:25',
            'winnings' => 'required|numeric|min:0'
        ]);

        $user = Auth::user();
        $result = $validated['result'];
        $betAmount = $validated['bet_amount'];
        $minesCount = $validated['mines_count'];
        $revealedCells = $validated['revealed_cells'];
        $winnings = $validated['winnings'];

        Log::info("Mines end - User: {$user->id}, Result: {$result}, Bet: {$betAmount}, Mines: {$minesCount}, Revealed: {$revealedCells}");

        if ($result === 'win') {
            $user->balance += $winnings;
            $netWinnings = $winnings - $betAmount;
            $user->updateGameStatistics(true, $netWinnings, 'mines');
            Log::info("Win: User {$user->id} net winnings: {$netWinnings}");
        } else {
            $user->updateGameStatistics(false, $betAmount, 'mines');
            Log::info("Loss: User {$user->id} lost: {$betAmount}");
        }

        $user->save();

        GameLog::create([
            'user_id' => $user->id,
            'game_type' => 'mines',
            'bet_amount' => $betAmount,
            'win_amount' => $winnings,
            'is_win' => ($result === 'win'),
            'game_data' => json_encode([
                'mines_count' => $minesCount,
                'revealed_cells' => $revealedCells,
                'multiplier' => $result === 'win' ? ($winnings / $betAmount) : 0
            ]),
            'played_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'balance' => (float)$user->balance
        ]);
    }
}
