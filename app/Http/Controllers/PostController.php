<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Egy poszt és kommentjeinek megjelenítése
    public function show($id)
    {
        $post = Post::with(['user', 'comments.user'])->findOrFail($id);

        // Jogosultság ellenőrzése privát posztnál
        if ($post->is_private) {
            $user = Auth::user();
            $friendIds = $user->friends()->pluck('id');
            if ($post->user_id !== $user->id && !$friendIds->contains($post->user_id)) {
                abort(403, 'You have no permission to view this post.');
            }
        }

        return view('pages.forum.post', compact('post'));
    }

    // Új komment hozzáadása
    public function addComment(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $post = Post::findOrFail($postId);

        // Jogosultság ellenőrzése privát posztnál
        if ($post->is_private) {
            $user = Auth::user();
            $friendIds = $user->friends()->pluck('id');
            if ($post->user_id !== $user->id && !$friendIds->contains($post->user_id)) {
                abort(403, 'You have no permission to comment on this post.');
            }
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);

        return redirect()->route('forum.post.show', $post->id)->with('success', 'Comment Sent!');
    }

    // Komment törlése (csak admin vagy tulajdonos)
    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();

        if ($user->id === $comment->user_id || $user->is_admin) {
            $comment->delete();
            return back()->with('success', 'Comment Deleted!');
        }

        abort(403, 'You have no permission to delete this comment.');
    }
}
