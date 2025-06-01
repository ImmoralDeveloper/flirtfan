@push('styles')
    @vite('resources/css/components/media.css')
@endpush
<ul class="media-list">
    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $item)
        <x-public.model.media-item :item="$item" />
    @endforeach
</ul>
