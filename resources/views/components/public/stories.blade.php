<div class="stories">
    <div class="stories__wrapper" style="grid-template-columns: repeat({{ 15 + 1 }}, 70px);">
        <div class="story story--add">
            <div class="story__img">
                <img src="{{ asset('img/avatar.png') }}" alt="Avatar">
                <span></span>
            </div>
            <p>{{ __('Add story') }}</p>
        </div>
        @for ($i = 0; $i < 15; $i++)
            <x-story :checked="rand(0, 1)" />
        @endfor
    </div>
</div>
