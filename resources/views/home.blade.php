<x-layouts.app section="dashboard">
    <x-stories />
    <div class="home__container">
        <div>
            @if (auth()->check() && auth()->user()->isPerformer())
                <x-public.editor />
            @endif
            <x-public.posts  />
        </div>
        <aside>
            <x-suggestions />
        </aside>
    </div>
</x-layouts.app>
