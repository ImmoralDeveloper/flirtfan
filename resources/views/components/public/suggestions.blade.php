<div class="suggestions">
    <div class="suggestions__header">
        <h2>{{ __('Suggestions') }}</h2>
        <div>
            <button>
                <i class="icon icon-refresh"></i>
            </button>
        </div>
    </div>
    <div class="suggestions__container">
        @foreach ([1, 2, 3, 4, 5] as $suggestion)
            <div class="suggestion">
                <img src="{{ asset('img/suggestion.png') }}" alt="">
                <div>
                    <a href="#">
                        <img src="{{ asset('img/avatar.png') }}" alt="">
                    </a>
                    <div>
                        <a href="#">Username</a>
                        <a href="#">@username</a>
                    </div>
                    <button class="button">{{ __('Follow') }}</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
