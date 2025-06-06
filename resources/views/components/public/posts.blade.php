@push('scripts')
    @vite('resources/js/posts.js')
@endpush
<div class="posts">
    @foreach ($posts as $post)
        <x-public.post :post="$post" />
    @endforeach
</div>
