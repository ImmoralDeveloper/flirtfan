<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        return view('messages.index', ['section' => 'messages']);
    }

    public function show()
    {
        return view('messages.show', ['section' => 'messages']);
    }
}
