<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleting(Comment $comment)
    {
        if (!$comment->isForceDeleting() && Auth::check()) {
            $comment->deleted_by = Auth::id();
            $comment->save();
        }
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
