@push('styles')
    @vite('resources/css/components/conversation.css')
@endpush
<div class="conversation">
    <div class="conversation__header">
        <div class="conversation__user">
            <a href="#" class="conversation__avatar">
                <img src="{{ asset('img/avatars/avatar-1.png') }}" alt="">
                <span></span>
            </a>
            <div class="conversation__info">
                <h3><a href="#">Florencio Dorrance</a></h3>
                <a href="#">@Florenciodorrance2362</a>
                <b>{{ __('Online') }}</b>
            </div>
        </div>
        <div>
            <button>
                <i class="icon icon-tel"></i>
            </button>
            <button>
                <i class="icon icon-more"></i>
            </button>
            <button>
                <i class="icon icon-webcam"></i>
            </button>
        </div>
    </div>
    <div class="conversation__body">
        <ul class="conversation__messages">
            @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20] as $message)
                @if (!$message % 3 == 0)
                    <li class="conversation__message{{ $message % 3 == 0 ? ' sent' : ' received' }}">
                        <div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, quia.</p>
                            <span>2:44 AM</span>
                        </div>
                        {{-- <div class="conversation__message-media"></div> --}}
                    </li>
                @endif
                <li class="conversation__message{{ $message % 3 == 0 ? ' sent' : ' received' }}">
                    <div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, quia.</p>
                        <span>2:44 AM</span>
                    </div>
                    {{-- <div class="conversation__message-media"></div> --}}
                </li>
            @endforeach
        </ul>
    </div>
    <div class="conversation__footer">
        <div contenteditable="true" class="conversation__input" style='--placeHolder: "{{ __('Type a message...') }}"'></div>
        <div class="conversation__send-buttons">
            <button>
                <i class="icon icon-image"></i>
            </button>
            <button>
                <i class="icon icon-send"></i>
            </button>
        </div>
    </div>
</div>
