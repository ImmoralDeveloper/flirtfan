<div class="post">
    <article class="post__article">
        <header class="post__header">
            <x-user-avatar :user="$post->user" />
            <div class="post__user-info">
                <a href="{{ route('profile.index', $post->user->username) }}">{{ $post->user->name }}</a>
                <div class="post__meta">
                    <a href="#">
                        <i class="icon icon-clock"></i>
                        <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
                    </a>
                    <button type="button">
                        @if($post->payment_required || $post->subscription_required)
                            <i class="icon icon-private"></i>
                            {{ $post->payment_required ? __('Payment required') : __('Only subscribers')}}
                        @else
                            <i class="icon icon-globe"></i>
                            {{ __('Public') }}
                        @endif
                    </button>
                </div>
            </div>
            <div class="post__actions">
                <button type="button" class="post__more">
                    <i class="icon icon-more"></i>
                </button>
            </div>
        </header>
        <div class="post__text">
            <p>{!! Illuminate\Support\Str::limit($post->body, 200, '<a href="#"><b>... ' . __('See more') . '</b></a>') !!}</p>
        </div>
        @if (count($post->media) > 0)
            <div class="post__media-container{{ count($post->media) > 1 ? ' slider-container' : '' }}"
                data-current-index=0 data-slides-count="{{ count($post->media) }}">
                <div class="post__media-wrapper{{ count($post->media) > 1 ? ' slider-wrapper' : '' }}"
                    style="grid-template-columns: repeat({{ count($post->media) }}, 100%);">
                    @foreach ($post->media as $media)
                        <div class="post__media{{ count($post->media) > 1 ? ' slide' : '' }}">
                            <img loading="lazy" src="{{ asset("img/posts/{$media['image']}") }}" />
                        </div>
                    @endforeach
                </div>
                @if (count($post->media) > 1)
                    <button class="slider-btn disabled" data-dir="prev" data-action="swipeSlider"><i
                            class="icon icon-left-angle-bracket"></i></button>
                    <button class="slider-btn" data-dir="next" data-action="swipeSlider"><i
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
