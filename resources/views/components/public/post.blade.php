<div class="post">
    <article class="post__article">
        <header class="post__header">
            <x-user-avatar :user="$post->user" />
            <div class="post__user-info">
                <a href="{{ route('profile.index', $post->user->username) }}">{{ $post->user->short_name }}</a>
                <div class="post__meta">
                    <a href="#">
                        <i class="icon icon-clock"></i>
                        <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</time>
                    </a>
                    <button type="button">
                        @if ($post->payment_required || $post->subscription_required)
                            <i class="icon icon-dollar"></i>
                            {{ __('Exclusive') }}
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
        @if ($post->hasMedia())
            @php
                $mediaItems = $post->media; // se carga desde getMediaAttribute
                $total = $mediaItems->count();
            @endphp

            <div class="post__media-container{{ $total > 1 ? ' slider-container' : '' }}" data-current-index="0"
                data-slides-count="{{ $total }}">

                <div class="post__media-wrapper{{ $total > 1 ? ' slider-wrapper' : '' }}"
                    style="grid-template-columns: repeat({{ $total }}, 100%);">

                    @foreach ($mediaItems as $media)
                        <div class="post__media{{ $total > 1 ? ' slide' : '' }}">
                            @if ($media->type === 'image')
                                <img loading="lazy" src="{{ asset('storage/' . $media->path) }}" alt="Post image">
                            @elseif ($media->type === 'video')
                                <div class="custom-video-player">
                                    <video class="custom-video" preload="metadata">
                                        <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="controls">
                                        <button type="button" class="play-pause">
                                            <i class="icon icon-play" style="--iconSizePercent:.5"></i>
                                        </button>
                                        <input type="range" class="progress-bar" value="0" min="0" step="1">
                                        <span class="duration">0:00</span>
                                        <div class="speed-control">
                                            <button type="button" class="speed-btn">
                                                <span class="speed-label">1x</span>
                                            </button>
                                            <ul class="speed-menu">
                                                <li data-speed="0.5">0.5x</li>
                                                <li data-speed="0.75">0.75x</li>
                                                <li data-speed="1" class="active">1x</li>
                                                <li data-speed="1.25">1.25x</li>
                                                <li data-speed="1.5">1.5x</li>
                                                <li data-speed="1.75">1.75x</li>
                                                <li data-speed="2">2x</li>
                                            </ul>
                                        </div>
                                        <div class="volume-control">
                                            <button type="button" class="volume-btn">
                                                <i class="icon icon-volume" style="--iconSizePercent:.5"></i>
                                            </button>
                                            <input type="range" class="volume-bar" min="0" max="1" step="0.01" value="1">
                                        </div>
                                        <button type="button" class="fullscreen">
                                            <i class="icon icon-fullscreen" style="--iconSizePercent:.5"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if ($total > 1)
                    <button class="slider-btn disabled" data-dir="prev" data-action="swipeSlider">
                        <i class="icon icon-left-angle-bracket"></i>
                    </button>
                    <button class="slider-btn" data-dir="next" data-action="swipeSlider">
                        <i class="icon icon-right-angle-bracket"></i>
                    </button>
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
                    <span>{{ __('Tip') }}</span>
                </button>
            @endif
        </footer>
    </article>
</div>
