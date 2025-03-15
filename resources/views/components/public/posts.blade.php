<div class="posts">
    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $post)
        <div class="post">
            <article class="post__article">
                <header class="post__header">
                    <a href="#" class="post__avatar">
                        <img src="{{ asset('img/avatar.png') }}" alt="username">
                    </a>
                    <div class="post__user_info">
                        <a href="#">Name Model</a>
                        <a href="#">@Model</a>
                    </div>
                    <div class="post__meta">
                        <time>4d</time>
                        <button type="button" class="post__more">
                            <i class="icon icon-more"></i>
                        </button>
                    </div>
                </header>
                <div class="post__text">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam asperiores reiciendis eveniet quas
                        consequuntur commodi, assumenda odit nihil, animi sed culpa, cum labore maiores et maxime
                        blanditiis
                        accusantium amet nobis.</p>
                </div>
                <div class="post__media-container">
                    @php
                        $rand = rand(1, 7);
                    @endphp
                    <div class="post__media-wrapper" style="grid-template-columns: repeat({{ $rand }}, 100%);">
                        @for ($i = 1; $i <= $rand; $i++)
                            <div class="post__media">
                                <img src="{{ asset("img/$i.jpeg") }}" />
                            </div>
                        @endfor
                    </div>
                    @if ($rand > 1)
                        <button class="post__media-btn disabled" data-dir="prev"><i class="icon icon-left-angle-bracket"></i></button>
                        <button class="post__media-btn" data-dir="next"><i class="icon icon-right-angle-bracket"></i></button>
                    @endif
                </div>
                <footer class="post__footer">
                    <button type="button" class="post__like">
                        <i class="icon icon-like"></i>
                        <span>{{ __('Like') }}</span>
                    </button>
                    <button type="button" class="post__comment">
                        <i class="icon icon-comment"></i>
                        <span>{{ __('Comment') }}</span>
                    </button>
                    <button type="button" class="post__tip button">
                        <i class="icon icon-tip"></i>
                        <span>{{ __('Send tip') }}</span>
                    </button>
                </footer>
            </article>
        </div>
    @endforeach
</div>
