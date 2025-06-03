<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performer extends Model
{
    protected $fillable = [
        'user_id',
        'website',
        'social_links',
    ];
    protected $casts = [
        'social_links' => 'array', // Automatically cast social_links to an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
