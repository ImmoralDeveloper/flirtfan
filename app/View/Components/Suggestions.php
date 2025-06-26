<?php

namespace App\View\Components;

use App\Models\Performer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Suggestions extends Component
{
    /**
     * Create a new component instance.
     */

    public function __construct(public $performers = [])
    {
        $this->performers = Performer::all()->take(5);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.public.suggestions');
    }
}
