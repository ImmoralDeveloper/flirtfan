<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function getLatestMessagesAttribute()
    {
        // ordenar de antiguo a nuevo
        return $this->messages()->orderBy('created_at', 'asc')->get();
    }
    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

}
