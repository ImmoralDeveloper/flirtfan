@props(['user'])

{{-- <div
    class="story__img{{ !$user->has_active_story ? '' : ' has-story' . (auth()->check() && $user->has_unviewed_story ?  ' active' : '') }}">
    <img src="{{ asset('img/avatar.png') }}" alt="Avatar">
</div> --}}
<a href="{{ route('profile.index', $user) }}"
    class="user-avatar{{ !$user->has_active_story ? '' : ' has-story' . (auth()->check() && $user->has_unviewed_story ? ' active' : '') }}">
    <img src="{{ asset('img/avatar.png') }}" alt="Avatar">
</a>
