<?php

namespace App\Observers;

use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;

class AdvertisementObserver
{
    /**
     * Handle the Advertisement "created" event.
     */
    public function creating(Advertisement $advertisement): void
    {
        $userId = Auth::id() ?? 1;

        if (is_null($advertisement->user_id)) {
            $advertisement->user_id = $userId;
        }

        if (is_null($advertisement->updated_by)) {
            $advertisement->updated_by = $userId;
        }
    }

    /**
     * Handle the Advertisement "updated" event.
     */
    public function updating(Advertisement $advertisement): void
    {
        $advertisement->updated_by = Auth::id() ?? 1;
    }

    /**
     * Handle the Advertisement "deleted" event.
     */
    public function deleting(Advertisement $ad): void
    {
        $ad->deleted_by = Auth::id();
        $ad->saveQuietly();
    }

    /**
     * Handle the Advertisement "restored" event.
     */
    public function restored(Advertisement $advertisement): void
    {
        //
    }

    /**
     * Handle the Advertisement "force deleted" event.
     */
    public function forceDeleted(Advertisement $advertisement): void
    {
        //
    }
}
