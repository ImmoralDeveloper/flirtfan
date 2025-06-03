@props(['checked' => false])
<div class="story" checked="{{ auth()->check() && auth()->user()->hasViewedStory($story) ? 1 : 0 }}">
    <div class="story__img">
        <img src="{{ asset('img/avatar.png') }}" alt="Avatar">
    </div>
    <p>Username</p>
</div>
