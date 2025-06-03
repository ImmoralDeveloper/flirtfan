<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{

    protected $fillable = ['user_id', 'media', 'views'];

    protected $casts = [
        'media' => 'array',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class, 'story_views')
            ->withPivot('viewed_at');
    }

    public function getMediaTypeAttribute()
    {
        return $this->media['type'] ?? null;
    }

    public function getMediaUrlAttribute()
    {
        return $this->media['url'] ?? null;
    }
    public function views()
    {
        return $this->hasMany(StoryView::class);
    }
}
