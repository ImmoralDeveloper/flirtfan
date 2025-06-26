@push('styles')
    @vite('resources/css/components/custom-video-player.css')
@endpush
@push('scripts')
    @vite('resources/js/posts.js')
    @vite('resources/js/components/CustomVideoPlayer.js')
    <script>
        window.postsLoadRoute = "{{ route('posts.load') }}";
        window.postComponent = `
<div class="post">
    <article class="post__article">
        <header class="post__header">
            <div class=\"post__user-avatar\">__USER_AVATAR__</div>
            <div class="post__user-info">
                <a href="__PROFILE_URL__">__USER_NAME__</a>
                <div class="post__meta">
                    <a href="#">
                        <i class="icon icon-clock"></i>
                        <time datetime="__CREATED_AT__">__CREATED_AT_HUMAN__</time>
                    </a>
                    <button type="button">
                        __POST_TYPE__
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
            <p>__POST_BODY__</p>
        </div>
        __MEDIA_CONTAINER__
        <footer class="post__footer">
            <button type="button" class="post__like __LIKE_ACTIVE__">
                <i class="icon icon-like"></i>
                <span>Like</span>
            </button>
            <button type="button" class="post__comment">
                <i class="icon icon-comment"></i>
                <span>Comment</span>
            </button>
            __TIP_BUTTON__
        </footer>
    </article>
</div>
        `;
    </script>
@endpush
<div class="posts">
</div>
