<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'advertisement_id',
        'duration_watched',
        'reward',
        'status'
    ];

    protected $casts = [
        'reward' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
