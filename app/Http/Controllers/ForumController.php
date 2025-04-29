<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Fórum főoldal, posztok listázása szűrésekkel
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Post::query()->whereNull('deleted_by');

        // Friends filter
        if ($request->has('friends_only') && $request->get('friends_only')) {
            $friendIds = $user->friends()->pluck('id');
            $query->whereIn('user_id', $friendIds);
        }

        // Privacy filter
        $query->where(function($q) use ($user) {
            $friendIds = $user->friends()->pluck('id');
            $q->where('is_private', false)
              ->orWhere(function($q2) use ($user, $friendIds) {
                  $q2->where('is_private', true)
                     ->where(function($q3) use ($user, $friendIds) {
                         $q3->where('user_id', $user->id)
                            ->orWhereIn('user_id', $friendIds);
                     });
              });
        });

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'most_commented':
                $query->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            default: // newest
                $query->latest();
        }

        $posts = $query->with(['user', 'comments'])->paginate(10)->withQueryString();

        return view('pages.forum.forum', compact('posts'));
    }


    // Új poszt létrehozása
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_private' => 'boolean'
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'is_private' => $request->input('is_private', false)
        ]);

        return redirect()->route('forum.index')->with('success', 'Post Created!');
    }

    // Poszt törlése (csak admin vagy tulajdonos)
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if ($user->id === $post->user_id || $user->is_admin) {
            $post->delete();
            return redirect()->route('forum.index')->with('success', 'Post deleted!');
        }

        abort(403, 'You have no permission to delete this post.');
    }
}
