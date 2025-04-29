<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Advertisement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'duration_seconds',
        'reward_amount',
        'image',        // Thumbnail fájlnév (pl: "thumbnail.jpg")
        'media_type',   // "image" vagy "video"
        'image_path',   // Fő kép relatív útvonala (pl: "ads/1/image.jpg")
        'video_path',   // Videó relatív útvonala (pl: "ads/1/video.mp4")
        'is_active',
        'user_id',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'reward_amount' => 'decimal:2'
    ];

    // Kapcsolatok
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }


    public function balanceUploads()
    {
        return $this->hasMany(BalanceUpload::class);
    }

    // Scope aktív hirdetésekhez
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessorok a teljes URL-ekhez
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url("ads/{$this->id}/thumbnails/{$this->image}");
        }
        return null;
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }
        return null;
    }

    public function getVideoUrlAttribute()
    {
        if ($this->video_path) {
            return Storage::url($this->video_path);
        }
        return null;
    }
}
