<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function accept($id)
{
    $request = FriendRequest::findOrFail($id);

    if ($request->receiver_id !== auth()->id()) {
        abort(403);
    }

    Friendship::create([
        'user_id' => auth()->id(),
        'friend_id' => $request->sender_id,
    ]);

    Friendship::create([
        'user_id' => $request->sender_id,
        'friend_id' => auth()->id(),
    ]);

    $request->delete();

    return back()->with('success', 'Request accepted!');
}

public function decline($id)
{
    $request = FriendRequest::findOrFail($id);

    if ($request->receiver_id !== auth()->id()) {
        abort(403);
    }

    $request->delete();

    return back()->with('success', 'Request declined!');
}

}
