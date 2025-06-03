@push('styles')
    @vite('resources/css/components/messages.css')
@endpush
<div class="messages-list">
    <form action="" method="GET" class="messages-list__search">
        <input type="text" name="search" placeholder="Search messages">
        <button type="submit">
            <i class="icon icon-search"></i>
        </button>
    </form>
    <ul>
        @foreach (auth()->user()->latest_conversations as $conversation)
            <x-public.messages.item :conversation="$conversation" />
        @endforeach
    </ul>
</div>
