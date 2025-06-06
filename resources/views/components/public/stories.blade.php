@push('scripts')
    @vite('resources/js/stories.js')
@endpush
<div class="stories slider-container">
    <div class="stories__wrapper slider-wrapper" style="grid-template-columns: repeat({{ $performersWithStories->count() + 1 }}, 70px);" data-current-index=0 data-slides-count="{{ $performersWithStories->count() + 1 }}">
        <div class="story story--add slide">
            <div class="story__img">
                <x-user-avatar :user="auth()->user()" />
                <span></span>
            </div>
            <p>{{ __('Add story') }}</p>
        </div>
        @foreach ($performersWithStories as $performer)
            <div class="story slide">
                <x-user-avatar :user="$performer" />
                <p>{{str($performer->name)->limit(10)}}</p>
            </div>
        @endforeach
    </div>
</div>
