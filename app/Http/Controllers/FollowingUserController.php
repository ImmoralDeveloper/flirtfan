<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowingUserController extends Controller
{
    public function index(){
        return view('following.index');
    }
}
