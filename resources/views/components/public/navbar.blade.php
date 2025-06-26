<nav class="navbar">
    <a href="{{ route('home') }}">
        <img src="{{ asset('img/logo.png') }}" alt="">
    </a>
    <ul>
        <li class="navbar__btn{{ request()->routeIs('home') ? ' active' : '' }}" data-btn="home">
            <a href="{{ route('home') }}">
                <i class="icon icon-home"></i>
                <span>{{ __('Home') }}</span>
            </a>
        </li>
        <li class="navbar__btn{{ request()->routeIs('search.index') ? ' active' : '' }}" data-btn="search">
            <a href="{{ route('search.index') }}">
                <i class="icon icon-search"></i>
                <span>{{ __('Search') }}</span>
            </a>
        </li>
        @if (auth()->user()->isPerformer())
            <li class="navbar__btn" data-btn="plus">
                <a href="#">
                    <i class="icon icon-plus"></i>
                    <span>{{ __('Add') }}</span>
                </a>
            </li>
        @endif
        <li class="navbar__btn{{ request()->routeIs('videos.index') ? ' active' : '' }}" data-btn="reels">
            <a href="{{ route('videos.index') }}">
                <i class="icon icon-reels"></i>
                <span>{{ __('Videos') }}</span>
            </a>
        </li>
        @if (!auth()->user()->isPerformer())
            <li class="navbar__btn{{ request()->routeIs('following.index') ? ' active' : '' }}" data-btn="following">
                <a href="{{ route('following.index') }}">
                    <i class="icon icon-following"></i>
                    <span>{{ __('Following') }}</span>
                </a>
            </li>
            <li class="navbar__btn{{ request()->routeIs('favorites.index') ? ' active' : '' }}" data-btn="favorites">
                <a href="{{ route('favorites.index') }}">
                    <i class="icon icon-favorites-f"></i>
                    <span>{{ __('Favorites') }}</span>
                </a>
            </li>
        @else
            <li class="navbar__btn" data-btn="stats">
                <a href="#">
                    <i class="icon icon-stats"></i>
                    <span>{{ __('Stats') }}</span>
                </a>
            </li>
        @endif
        {{-- <li class="navbar__btn menu-container" data-btn="user">
            <div class="navbar__user menu-btn">
                <img src="{{ asset('img/avatar.webp') }}" alt="Avatar">
                <div id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </li> --}}
    </ul>
</nav>
