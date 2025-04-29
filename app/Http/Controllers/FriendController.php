<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FriendController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // Barátságok, ahol a user már kapcsolatban van
        $relatedUserIds = Friendship::where(function ($query) use ($authUser) {
            $query->where('sender_id', $authUser->id)
                ->orWhere('receiver_id', $authUser->id);
        })
            ->whereIn('status', ['pending', 'accepted'])
            ->get()
            ->flatMap(function ($friendship) {
                return [$friendship->sender_id, $friendship->receiver_id];
            })
            ->unique();

        // Akiknek már küldtél kérelmet
        $sentRequestUserIds = FriendRequest::where('sender_id', $authUser->id)
            ->pluck('receiver_id');

        // Akik már küldtek neked kérelmet
        $receivedRequestUserIds = FriendRequest::where('receiver_id', $authUser->id)
            ->pluck('sender_id');

        // Összes kizárt user ID
        $excludeIds = $relatedUserIds
            ->merge($sentRequestUserIds)
            ->merge($receivedRequestUserIds)
            ->push($authUser->id)
            ->unique();

        // Lekérjük azokat a usereket, akik még nem barátok, nincs függőben kérelmük
        $query = User::whereNotIn('id', $excludeIds);

        // Keresés
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Rendezés
        if ($request->has('sort')) {
            if ($request->sort === 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($request->sort === 'name_desc') {
                $query->orderBy('name', 'desc');
            } elseif ($request->sort === 'balance_asc') {
                $query->orderBy('balance', 'asc');
            } elseif ($request->sort === 'balance_desc') {
                $query->orderBy('balance', 'desc');
            }
        }

        $users = $query->get();

        return view('pages.friends', compact('users'));
    }


    public function friendsList()
    {
        $user = auth()->user();

        // Friends
        $friends = $user->friends();

        // Pending requests you received (from others to you)
        $pendingRequests = FriendRequest::where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->with('sender') // Ensure sender relationship is loaded
            ->get();

        return view('pages.friendslist', compact('friends', 'pendingRequests'));
    }

    public function sendRequest($id)
    {
        $senderId = Auth::id();
        $receiverId = $id;

        // Ne engedje önmagának küldeni vagy ha már van függőben lévő kérelem
        if ($senderId === $receiverId || FriendRequest::where('sender_id', $senderId)->where('receiver_id', $receiverId)->where('status', 'pending')->exists()) {
            return back()->with('error', 'Nem küldhetsz kétszer barátkérést.');
        }

        FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Barátkérés elküldve!');
    }

    public function acceptRequest($id)
    {
        $request = FriendRequest::findOrFail($id);

        Friendship::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'status' => 'accepted', // ha van ilyen meződ, opcionális
        ]);

        $request->delete();

        return back()->with('success', 'Barátkérelem elfogadva!');
    }

    public function declineRequest($id)
    {
        $request = FriendRequest::findOrFail($id);

        if ($request->receiver_id !== Auth::id()) {
            abort(403);
        }

        $request->delete();

        return back()->with('info', 'Barátkérelem elutasítva.');
    }

}
