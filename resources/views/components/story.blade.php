@props(['checked' => false])
<div class="story" checked="{{ $checked }}">
    <div class="story__img">
        <img src="{{ asset('img/avatar.png') }}" alt="Avatar">
    </div>
    <p>Username</p>
</div>