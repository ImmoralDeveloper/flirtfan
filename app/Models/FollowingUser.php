<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowingUser extends Model
{
    //

    protected $fillable = ['follower_id', 'following_id'];

}
