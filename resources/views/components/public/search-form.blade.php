<div class="search-form">
    <form action="" method="GET">
        <input type="text" name="q" placeholder="{{ __("Search") }}" value="{{ request()->input('q') }}">
        <button type="submit">
            <i class="icon icon-search"></i>
        </button>
    </form>
</div>