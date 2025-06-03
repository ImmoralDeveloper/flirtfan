<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        // IDs de usuarios seguidos + el propio
        $followedUserIds = $user->following()->pluck('users.id')->toArray();
        $allUserIds = array_merge($followedUserIds, [$user->id]);

        // Obtener posts más recientes primero
        $posts = Post::with(['user', 'comments', 'likes'])
            ->whereIn('user_id', $allUserIds)
            ->latest()
            ->paginate(10); // Puedes usar infinite scroll en el frontend
        return view('home', compact('posts'));


    }
}
