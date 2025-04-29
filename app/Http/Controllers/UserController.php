<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Ellenőrizzük, hogy a mező tényleg tömb-e, ha nem, akkor dekódoljuk
        if (!is_array($user->game_statistics)) {
            $user->game_statistics = json_decode($user->game_statistics, true);
        }
    
        return view('profile.statistics', compact('user'));
    }
    

    public function suspend(string $user)
    {
        $user = User::withTrashed()->findOrFail($user);
    
        if ($user->trashed()) {
            $user->restore();
            return redirect()->back()->with('status', 'User restored successfully.');
        } else {
            $user->delete();
            return redirect()->back()->with('status', 'User suspended successfully.');
        }
    }
    
    public function destroy(string $user)
    {
        $user = User::withTrashed()->findOrFail($user);
    
        if (!$user->trashed()) {
            return redirect()->back()->with('error', 'User must be suspended before permanent deletion.');
        }
    
        $user->forceDelete();
        return redirect()->back()->with('status', 'User permanently deleted.');
    }
}