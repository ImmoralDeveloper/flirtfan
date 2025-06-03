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
        @foreach ($performers as $suggestion)
            <div class="suggestion">
                <img src="{{ asset('img/suggestion.png') }}" alt="">
                <div>
                    <x-user-avatar :user="$suggestion->user" />
                    <div>
                        <a href="{{ route('profile.index', $suggestion->user->username) }}">{{ $suggestion->user->name }}</a>
                        <a
                            href="{{ route('profile.index', $suggestion->user->username) }}">{{ "@{$suggestion->user->username}" }}</a>
                    </div>
                    <button class="button">{{ __('Follow') }}</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
