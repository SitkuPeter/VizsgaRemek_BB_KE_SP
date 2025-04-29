<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Advertisement;
use App\Models\BalanceUpload;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ads = Advertisement::active()->get(); // Csak az aktív hirdetések lekérése

        return view('pages.wallet', [
            'balance' => $user->balance,
            'ads' => $ads,
        ]);
    }

    public function processAd(Request $request)
    {
        $request->validate([
            'ad_id' => 'required|exists:advertisements,id',
            'watched_seconds' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $ad = Advertisement::findOrFail($request->ad_id);
        $reward = $this->calculateAdReward($ad->id, $request->watched_seconds);

        DB::transaction(function () use ($user, $request, $reward, $ad) {
            // Egyenleg frissítése
            $user->increment('balance', $reward);
            
            // Feltöltés logolása
            BalanceUpload::create([
                'user_id' => $user->id,
                'advertisement_id' => $request->ad_id,
                'duration_watched' => $request->watched_seconds,
                'reward' => $reward,
                'status' => ($request->watched_seconds >= $ad->duration_seconds) 
                    ? 'completed' 
                    : 'partial'
            ]);
        });

        return response()->json([
            'new_balance' => $user->fresh()->balance,
            'reward' => $reward
        ]);
    }

    private function calculateAdReward($adId, $watchedSeconds)
    {
        $ad = Advertisement::findOrFail($adId);
        $percentage = min($watchedSeconds / $ad->duration_seconds, 1);
        return round($ad->reward_amount * $percentage, 2);
    }
}
