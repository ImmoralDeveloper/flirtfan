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
                <img src="{{ asset('storage/uploads/users/' . $suggestion->user->id . '/images/normal/1.webp') }}" alt="">
                <div>
                    <x-user-avatar :user="$suggestion->user" />
                    <div>
                        <a
                            href="{{ route('profile.index', $suggestion->user->username) }}">{{ Illuminate\Support\Str::limit($suggestion->user->short_name, limit: 18) }}</a>
                        <a
                            href="{{ route('profile.index', $suggestion->user->username) }}">{{ '@' . Illuminate\Support\Str::limit($suggestion->user->username, 15) }}</a>
                    </div>
                    <button class="button">{{ __('Follow') }}</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
