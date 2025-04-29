<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'suspended_by',
        'restored_by',
        'destroyed_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:2',
    ];

    protected $table = 'users';

    public function gameLogs(): HasMany
    {
        return $this->hasMany(GameLog::class);
    }

    public function balanceUploads(): HasMany
    {
        return $this->hasMany(BalanceUpload::class);
    }

    public function updateGameStatistics(bool $isWin, float $amount, string $gameType): void
    {
        $gameStat = $this->gameStat()->firstOrNew(); // Létezőt keres vagy újat hoz létre

        $gameStat->total_games_played++;
        $gameStat->last_played_at = now();

        if ($isWin) {
            $gameStat->total_wins++;
            $gameStat->total_winnings += $amount;
        } else {
            $gameStat->total_losses++;
            $gameStat->total_losses_amount += $amount;
        }

        $gameStats = $gameStat->game_statistics ?? [];

        if (!isset($gameStats[$gameType])) {
            $gameStats[$gameType] = ['wins' => 0, 'losses' => 0, 'total_played' => 0];
        }

        $gameStats[$gameType]['total_played']++;
        $gameStats[$gameType][$isWin ? 'wins' : 'losses']++;

        $gameStat->game_statistics = $gameStats;
        $gameStat->save();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    public function friends()
    {
        // Get accepted friendships where user is sender
        $sentFriends = $this->sentFriendRequests()
            ->where('status', 'accepted')
            ->pluck('receiver_id');

        // Get accepted friendships where user is receiver
        $receivedFriends = $this->receivedFriendRequests()
            ->where('status', 'accepted')
            ->pluck('sender_id');

        // Combine and deduplicate IDs
        $friendIds = $sentFriends->merge($receivedFriends)->unique();

        return User::whereIn('id', $friendIds)->get();
    }

    // Posztok kapcsolata
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Kommentek kapcsolata
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function gameStat()
    {
        return $this->hasOne(GameStat::class);
    }
}



