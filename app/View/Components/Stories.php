<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Stories extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Collection $performersWithStories)
    {
        $viewer = auth()->user();
        $viewer->load('viewedStories'); // Optimiza para evitar consultas por historia

        $this->performersWithStories = User::whereHas('stories', function ($q) {
            $q->where('created_at', '>=', now()->subHours(21114));
        })
            ->with([
                'stories' => function ($q) {
                    $q->where('created_at', '>=', now()->subHours(21114))
                        ->orderBy('created_at', 'desc');
                }
            ])
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.public.stories');
    }
}
