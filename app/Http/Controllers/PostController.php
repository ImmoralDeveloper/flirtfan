<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Blade;

class PostController extends Controller
{
    public function load(Request $request){
        $perPage = 4;
        $page = $request->input('page', 1);
        $skip = ($page - 1) * $perPage;
        $posts = Post::whereHas('media')
            ->with(['user', 'media'])
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($perPage + 1)
            ->get();

        $hasMore = $posts->count() > $perPage;
        $posts = $posts->slice(0, $perPage)->values();
        $user = auth()->user();

        $dataPosts = $posts->map(function($post) use ($user) {
            $postUser = $post->user;
            return [
                'id' => $post->id,
                'body' => $post->body,
                'created_at' => $post->created_at->toIso8601String(),
                'created_at_human' => $post->created_at->diffForHumans(),
                'payment_required' => $post->payment_required,
                'subscription_required' => $post->subscription_required,
                'user' => $postUser ? [
                    'id' => $postUser->id,
                    'username' => $postUser->username,
                    'short_name' => $postUser->short_name,
                    'is_performer' => $postUser->isPerformer(),
                    'avatar_url' => asset('storage/uploads/users/' . $postUser->id . '/avatar/profile_medium.webp'),
                ] : [
                    'id' => null,
                    'username' => '',
                    'short_name' => '',
                    'is_performer' => false,
                    'avatar_url' => asset('img/avatar.webp'),
                ],
                'media' => $post->media->map(function($media) {
                    return [
                        'type' => $media->type,
                        'path' => $media->path,
                        'url' => asset('storage/' . $media->path),
                    ];
                })->values()->toArray(),
                'has_liked' => $user ? $user->hasLiked($post) : false,
            ];
        })->values()->toArray();

        return response()->json([
            'posts' => $dataPosts,
            'hasMore' => $hasMore,
        ]);
    }
}
