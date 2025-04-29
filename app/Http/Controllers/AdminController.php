<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::withTrashed()->get();

        return view('pages.admin.dashboard', compact('users'));
    }

    public function showById($id)
    {
        // Admin jogosultság ellenőrzése
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized'); // Ha nem admin, 403-as hibát adunk vissza
        }

        $user = User::findOrFail($id); // Automatikusan 404 hibát dob, ha nem létezik

        // JSON adatok kezelése
        $user->game_statistics = is_string($user->game_statistics) 
            ? json_decode($user->game_statistics, true) 
            : $user->game_statistics;

        if (!is_array($user->game_statistics)) {
            $user->game_statistics = [];
        }

        return view('profile.statistics', compact('user'));
    }
}
