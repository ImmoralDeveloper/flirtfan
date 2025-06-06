<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "body",
        "media",
        "status",
        "subscription_required",
        "payment_required",
    ];

    protected $casts = [
        'media' => 'array', // Automatically cast social_links to an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

}
