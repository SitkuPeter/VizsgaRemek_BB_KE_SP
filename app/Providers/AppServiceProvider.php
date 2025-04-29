<?php

namespace App\Providers;

use App\Models\Advertisement;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Observers\AdvertisementObserver;
use App\Observers\CommentObserver;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\DeckService;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        $this->app->bind(DeckService::class, function ($app) {
            return new DeckService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Csak akkor töltünk be kérelmeket, ha valóban van ilyen
                $friendRequests = FriendRequest::where('receiver_id', Auth::id())
                    ->where('status', 'pending')
                    ->with('sender')
                    ->get();

                // Csak akkor adjuk át a változót, ha nem üres
                if ($friendRequests->count() > 0) {
                    $view->with('friendRequests', $friendRequests);
                } else {
                    // Biztos, ami biztos, küldünk egy üreset, hogy ne dobjon hibát
                    $view->with('friendRequests', collect());
                }
            }
        });

        Advertisement::observe(AdvertisementObserver::class);
        User::observe(UserObserver::class);
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);
    }

}
