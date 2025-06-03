<div class="post">
    <article class="post__article">
        <header class="post__header">
            <x-user-avatar :user="$post->user" />
            <div class="post__user_info">
                <a href="{{ route('profile.index', $post->user->username) }}">{{ $post->user->name }}</a>
                <a href="{{ route('profile.index', $post->user->username) }}">{{ "@{$post->user->username}" }}</a>
            </div>
            <div class="post__meta">
                <a href="#{{ $post->id }}"><time>{{ $post->created_at->isToday() ? $post->created_at->format('h:i A') : $post->created_at->format('M d, h:i A') }}</time></a>
                <button type="button" class="post__more">
                    <i class="icon icon-more"></i>
                </button>
            </div>
        </header>
        <div class="post__text">
            <p>{{ $post->body }}</p>
        </div>
        @if (count($post->media) > 0)
            <div class="post__media-container">
                <div class="post__media-wrapper"
                    style="grid-template-columns: repeat({{ count($post->media) }}, 100%);">
                    @foreach ($post->media as $media)
                        <div class="post__media">
                            <img loading="lazy" src="{{ asset("img/posts/{$media['image']}") }}" />
                        </div>
                    @endforeach
                </div>
                @if (count($post->media) > 1)
                    <button class="post__media-btn disabled" data-dir="prev"><i
                            class="icon icon-left-angle-bracket"></i></button>
                    <button class="post__media-btn" data-dir="next"><i
                            class="icon icon-right-angle-bracket"></i></button>
                @endif
            </div>
        @endif
        <footer class="post__footer">
            <button type="button" class="post__like{{ auth()->user()->hasLiked($post) ? ' active' : '' }}">
                <i class="icon icon-like"></i>
                <span>{{ __('Like') }}</span>
            </button>
            <button type="button" class="post__comment">
                <i class="icon icon-comment"></i>
                <span>{{ __('Comment') }}</span>
            </button>
            @if ($post->user->isPerformer())
                <button type="button" class="post__tip button">
                    <i class="icon icon-tip"></i>
                    <span>{{ __('Send tip') }}</span>
                </button>
            @endif
        </footer>
    </article>
</div>
