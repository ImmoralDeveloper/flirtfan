@push('styles')
    @vite('resources/css/profile.css')
@endpush
<?php
$sections = [
    'index' => __('Feed'),
    'media' => __('Media'),
];
?>


<x-layouts.app section="profile">
    <div class="profile__container">

        <div class="profile__header">
            <div class="profile__info">
                <div class="profile__avatar">
                    <img src="{{ asset('img/profile-avatar.png') }}" alt="">
                    <button></button>
                </div>
                <h1>{{ $user->name }}</h1>
                <span>{{ '@' . $user->username }}</span>
            </div>
            <img src="{{ asset('img/profile-cover.png') }}" alt="">
        </div>
        <div class="profile__body">
            <div class="profile__meta">
                <div class="profile__stats">
                    <div>
                        <span>1.7k</span>
                        <p>{{ __('Likes') }}</p>
                    </div>
                    <div>
                        <span>366</span>
                        <p>{{ __('Followers') }}</p>
                    </div>
                    <div>
                        <span>57</span>
                        <p>{{ __('Posts') }}</p>
                    </div>
                </div>
                <p>{{ $user->bio }}</p>
                <ul>
                    <li><i class="icon icon-web"></i> <a href="https://immoral.dev">https://immoral.dev</a></li>
                    <li><i class="icon icon-email"></i> <a href="#">giovanni@immoral.dev</a></li>
                    <li><i class="icon icon-facebook"></i> <a href="https://fb.com/immoral.dev">immoral.dev</a></li>
                    <li><i class="icon icon-instagram"></i> <a href="https://instagram.com/immoral.dev">immoral.dev</a>
                    </li>
                </ul>
            </div>
            <div class="profile__content">
                <div class="profile__sections">
                    @foreach ($sections as $key => $label)
                        <a href="{{ route("profile.{$key}", auth()->user()) }}"
                            class="profile__section {{ $section === $key ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
                <div>
                    @switch ($section)
                        @case('media')
                            <x-public.model.media />
                        @break

                        @default
                            <x-public.editor />
                            <x-public.posts />
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
