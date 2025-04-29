<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get users ordered by balance (highest to lowest)
        $users = User::orderBy('balance', 'desc')->paginate(20);
        
        return view('pages.leaderboard', compact('users'));
    }
}
