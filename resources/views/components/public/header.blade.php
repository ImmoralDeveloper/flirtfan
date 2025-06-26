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
                <a href="{{ route('messages.index') }}">
                    <button data-action="conversations"
                        class="{{ request()->routeIs('messages.index') ? 'active' : '' }}">
                        <i class="icon icon-message-f"></i>
                        <span class="unread-conversations-count">
                            {{ auth()->user()->unread_conversations->count() < 10 ? auth()->user()->unread_conversations->count() : '9+' }}
                        </span>
                    </button>
                </a>
                <button data-action="notifications">
                    <i class="icon icon-notification-f"></i>
                    <span>5</span>
                </button>
            </div>
            <div class="header__user menu-container">
                <div class="menu-btn">
                    <x-user-avatar :user="auth()->user()" />
                    <a href="{{ route('profile.index', auth()->user()) }}" class="header__username">
                        <span>{{ auth()->user()->short_name }}</span>
                    </a>
                </div>
                <x-public.menu />
            </div>
        @endif
    </div>
</header>