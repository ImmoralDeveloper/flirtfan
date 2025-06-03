<x-layouts.app section="dashboard">
    <x-stories />
    <div class="home__container">
        <div>
            <x-public.editor />
            <x-public.posts :posts="$posts" />
        </div>
        <aside>
            <x-suggestions />
        </aside>
    </div>
</x-layouts.app>
