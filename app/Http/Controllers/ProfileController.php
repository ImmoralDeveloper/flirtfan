<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index(User $user)
    {
        return view('profile.index', ['section' => 'index', 'user' => $user]);
    }

    public function media(User $user)
    {
        return view('profile.index', ['section' => 'media', 'user' => $user]);
    }

}
