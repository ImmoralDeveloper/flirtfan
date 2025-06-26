<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'type',
        'path',
        'thumbnail',
        'size',
        'orientation',
        'duration',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'duration' => 'float',
        'size' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

}
