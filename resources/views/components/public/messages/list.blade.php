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
        @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] as $item)
            <x-public.messages.item :item="$item" />
        @endforeach
    </ul>
</div>
