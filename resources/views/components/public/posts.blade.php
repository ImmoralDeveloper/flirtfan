<div class="posts">
    @foreach ($posts as $post)
        <x-public.post :post="$post" />
    @endforeach
</div>
