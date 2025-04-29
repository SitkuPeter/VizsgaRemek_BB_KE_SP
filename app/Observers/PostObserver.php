<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleting(Post $post)
    {
        if (!$post->isForceDeleting() && Auth::check()) {
            $post->deleted_by = Auth::id();
            $post->save();
        }
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
