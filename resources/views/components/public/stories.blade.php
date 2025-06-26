@push('scripts')
    @vite('resources/js/stories.js')
@endpush
<div class="stories carousel-container" id="stories-carousel">
    <button class="carousel-btn carousel-arrow" data-dir="prev">&lt;</button>
    <div class="stories__wrapper carousel-wrapper">
        @if (auth()->check() && auth()->user()->isPerformer())
            <div class="story story--add item">
                <div class="story__img">
                    <x-user-avatar :user="auth()->user()" />
                    <span></span>
                </div>
                <p>{{ __('Add story') }}</p>
            </div>
        @endif
        @foreach ($performersWithStories as $performer)
            <div class="story item">
                <x-user-avatar :user="$performer" />
                <p>{{ str($performer->name)->limit(10) }}</p>
            </div>
        @endforeach
    </div>
    <button class="carousel-btn carousel-arrow" data-dir="next">&gt;</button>
</div>
