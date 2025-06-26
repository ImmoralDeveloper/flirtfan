<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 
        'sender_id', 
        'body', 
        'media', 
        'is_read',
        'created_at',
    ];

    protected $casts = [
        'media' => 'array',
        'is_read' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    
    public function getShortCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans(null, true, false, 1);
    }
}
