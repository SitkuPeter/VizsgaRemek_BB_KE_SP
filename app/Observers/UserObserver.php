<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    public function deleting(User $user)
    {
        // Only set if soft deleting (suspending)
        if (!$user->isForceDeleting()) {
            $user->suspended_by = Auth::id();
            $user->saveQuietly();
        }
    }

    public function restored(User $user)
    {
        $user->restored_by = Auth::id();
        $user->saveQuietly();
    }

    public function forceDeleted(User $user)
    {
        $user->destroyed_by = Auth::id();
        $user->saveQuietly();
    }
}
