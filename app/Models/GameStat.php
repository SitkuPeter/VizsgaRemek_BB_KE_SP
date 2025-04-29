<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameStat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'total_games_played',
        'total_wins',
        'total_losses',
        'total_winnings',
        'total_losses_amount',
        'last_played_at',
        'game_statistics'
    ];

    protected $casts = [
        'last_played_at' => 'datetime',
        'game_statistics' => 'array',
        'total_winnings' => 'decimal:2',
        'total_losses_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
