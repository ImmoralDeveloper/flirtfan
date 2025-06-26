<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;

class VideoController extends Controller
{
    public function index()
    {
        return view('videos.index');
    }

    public function loadVideos(Request $request)
    {
        $excludedIds = $request->input('exclude', []);

        $query = Media::where('type', 'video')
            ->where('duration', '>', 10)
            ->whereNotIn('id', $excludedIds);

        $videos = $query->inRandomOrder()->take(2)->get();

        return response()->json([
            'videos' => $videos->map(function ($video) {
                return [
                    'id' => $video->id,
                    'url' => asset('storage/' . $video->path),
                    'thumbnail' => asset('storage/' . $video->thumbnail),
                    'orientation' => $video->orientation ?? 'vertical',
                    'description' => $video->post->body ?? '',
                    'user' => [
                        'name' => $video->user->name ?? 'Unknown',
                        'username' => $video->user->username ?? 'Unknown',
                        'avatar' => asset('storage/uploads/users/' . $video->user->id . '/avatar/profile_medium.webp'),
                    ]
                ];
            }),
            'hasMore' => $query->count() > 2
        ]);

    }

}