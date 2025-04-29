<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'game_type',
        'bet_amount',
        'win_amount',
        'is_win',
        'game_data',
        'played_at',
    ];

    protected $casts = [
        'bet_amount' => 'decimal:2',
        'win_amount' => 'decimal:2',
        'is_win' => 'boolean',
        'game_data' => 'json',
        'played_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'game_logs';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
