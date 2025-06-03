<div class="stories">
    <div class="stories__wrapper" style="grid-template-columns: repeat({{ $performersWithStories->count() + 1 }}, 70px);">
        <div class="story story--add">
            <div class="story__img">
                <x-user-avatar :user="auth()->user()" />
                <span></span>
            </div>
            <p>{{ __('Add story') }}</p>
        </div>
        @foreach ($performersWithStories as $performer)
            {{-- ME QUEDE AQUI, ESTO MUESTRA LAS PERFORMER QUE TIENEN HISTORIA O HISTORIAS Y DEBERIA PENSAR COMO IMPRIMIR SUS HISTORIAS, CREO QUE USARÉ EL COMPONENTE DEL USER AVATAR PARA VER SI TIENEN HISTORIAS Y LUEGO USAR UN MODAL COMO INSTAGRAM PARA MOSTRARLAS. --}}
            {{-- TAMBIEN DEBERIA CAMBIAR EL COMPONENTE DE STORIES, DEBERIA PONERLE STORIES-BY-PERFORMER --}}
            {{-- <x-story :checked="rand(0, 1)" /> --}}
            {{-- <div>
                <img src="{{asset('img/avatars/avatar-1.png')}}" alt="">
            </div> --}}
            <div class="story">
                <x-user-avatar :user="$performer" />
                <p>{{str($performer->name)->limit(10)}}</p>
            </div>
        @endforeach
    </div>
</div>
