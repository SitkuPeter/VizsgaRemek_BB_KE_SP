<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status', // ha használsz státusz mezőt
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
