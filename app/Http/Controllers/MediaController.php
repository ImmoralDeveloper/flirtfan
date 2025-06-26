<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function load(Request $request, \App\Models\User $user){
        $perPage = 5;
        $page = $request->input('page', 1);
        $skip = ($page - 1) * $perPage;
        $media = $user->posts()->with('media')->get()->pluck('media')->flatten(1);
        $media = $media->sortByDesc('created_at')->values();
        $total = $media->count();
        $mediaPage = $media->slice($skip, $perPage + 1)->values();
        $hasMore = $mediaPage->count() > $perPage;
        $data = $mediaPage->slice(0, $perPage)->map(function($item) {
            return [
                'id' => $item->id,
                'type' => $item->type,
                'url' => asset('storage/' . $item->path),
                'thumbnail' => $item->thumbnail ? asset('storage/' . $item->thumbnail) : null,
            ];
        });
        return response()->json([
            'media' => $data,
            'hasMore' => $hasMore,
        ]);
    }
}
