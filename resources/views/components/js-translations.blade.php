<script>
    window.trans = {
        follow: @json(__('Follow')),
        unfollow: @json(__('Unfollow')),
        read_more: @json(__('Ver más')),
        read_less: @json(__('Ver menos')),
        // Agrega aquí más traducciones según necesidad
    };
    window.__ = function(key) {
        return window.trans && window.trans[key] ? window.trans[key] : key;
    };
</script> 