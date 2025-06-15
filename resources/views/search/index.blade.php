{{-- <x-layouts.app section="dashboard">
    <div class="search__container">
        <h1>Search</h1>
    </div>
</x-layouts.app> --}}

@php
    dd(auth()->user()->unread_conversations->count());
@endphp