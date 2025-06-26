@props(['user'])

<a href="{{ route('profile.index', $user) }}"
    class="user-avatar{{ !$user->has_active_story ? '' : ' has-story' . (auth()->check() && $user->has_unviewed_story ? ' active' : '') }}">
    <img src="{{ asset('storage/uploads/users/' . $user->id . '/avatar/profile_medium.webp') }}" alt="Avatar" onerror="this.onerror=null; this.src='{{ asset('img/avatar.webp') }}';" alt="Imagen">
</a>
