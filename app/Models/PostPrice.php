<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostPrice extends Model
{
    protected $fillable = ['post_id', 'price', 'currency'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
