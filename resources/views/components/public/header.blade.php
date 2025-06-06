@props(['section'])
<header class="header">
    <div class="header__container">
        <a href="{{ route('home') }}" class="header__logo">
            <img src="{{ asset('img/logo-2.png') }}" alt="">
        </a>
        @if ($section !== 'login' && $section !== 'register')
            <h2 id="page-title">{{ ucfirst($section) }}</h2>
            <x-public.search-form />
            <div class="header__buttons">
                <button>
                    <a href="{{ route('messages.show') }}" id="message-btn">
                        <i class="icon icon-message"></i>
                    </a>
                </button>
                <button id="notification-btn">
                    <i class="icon icon-notification"></i>
                </button>
            </div>
            <div class="header__user">
                <x-user-avatar :user="auth()->user()" />
                <a href="{{ route('profile.index', auth()->user()) }}" class="header__username">
                    <span>{{ auth()->user()->name }}</span>
                </a>
                <i class="icon icon-down-angle-bracket"></i>
            </div>
            <div id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        @endif
    </div>
</header>
