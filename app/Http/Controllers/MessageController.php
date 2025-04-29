<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $withUser = null;
        $messages = collect();

        $friends = $user->friends(); 

        if ($request->has('with')) {
            $withUser = User::find($request->with);

            if ($withUser) {
                $messages = Message::where(function ($q) use ($user, $withUser) {
                    $q->where('sender_id', $user->id)
                        ->where('receiver_id', $withUser->id);
                })->orWhere(function ($q) use ($user, $withUser) {
                    $q->where('sender_id', $withUser->id)
                        ->where('receiver_id', $user->id);
                })->orderBy('created_at')->get();
            }
        }

        return view('pages.messages', compact('friends', 'withUser', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->content,
        ]);

        return redirect()->route('friends.messages', ['with' => $request->receiver_id])->with('success', 'Üzenet elküldve!');

    }

}
