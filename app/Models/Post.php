<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "body",
        "status",
        "subscription_required",
        "payment_required",
    ];

    protected $casts = [
        'payment_required' => 'boolean',
        'subscription_required' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getShortCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans(null, true, false, 1);
    }
    public function paymentRequired()
    {
        return $this->payment_required ?? false;
    }
    public function price()
    {
        return $this->hasOne(PostPrice::class);
    }
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    public function likesCount(): int
    {
        return $this->likedByUsers()->count();
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
    
    public function hasMedia(): bool
    {
        return $this->media()->exists();
    }

    public function getMediaAttribute()
    {
        return $this->media()->get();
    }

}
