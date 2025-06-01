<nav class="navbar">
    <a href="{{ route('home') }}">
        <img src="{{ asset('img/logo.png') }}" alt="">
    </a>
    <ul>
        <li class="navbar__btn" data-btn="home">
            <a href="#">
                <span>{{ __('Home') }}</span>
                <i class="icon icon-home"></i>
            </a>
        </li>
        <li class="navbar__btn" data-btn="search">
            <a href="#">
                <span>{{ __('Search') }}</span>
                <i class="icon icon-search"></i>
            </a>
        </li>
        <li class="navbar__btn" data-btn="favorites">
            <a href="#">
                <span>{{ __('Favorites') }}</span>
                <i class="icon icon-favorites"></i>
            </a>
        </li>
        <li class="navbar__btn" data-btn="plus">
            <a href="#">
                <span>{{ __('Add') }}</span>
                <i class="icon icon-plus"></i>
            </a>
        </li>
        <li class="navbar__btn" data-btn="reels">
            <a href="#">
                <span>{{ __('Reels') }}</span>
                <i class="icon icon-reels"></i>
            </a>
        </li>
        <li class="navbar__btn" data-btn="bookmarks">
            <a href="#">
                <span>{{ __('Bookmarks') }}</span>
                <i class="icon icon-bookmarks"></i>
            </a>
        </li>
        <li class="navbar__btn" data-btn="user">
            <div class="navbar__user">
                <img src="{{ asset('img/avatar.png') }}" alt="Avatar">
                <i class="icon icon-settings"></i>
            </div>
        </li>
    </ul>
</nav>
