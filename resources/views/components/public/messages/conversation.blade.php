@push('styles')
    @vite('resources/css/components/conversation.css')
@endpush
@push('scripts')
    @vite('resources/js/conversation.js')
@endpush
<div class="conversation active">
    <div class="conversation__header">
        <div class="conversation__user">
            @php
                $talkingTo =
                    $conversation->userOne->id === auth()->id() ? $conversation->userTwo : $conversation->userOne;
            @endphp
            <x-user-avatar :user="$talkingTo" />
            <div class="conversation__info">
                <h3><a href="{{ route('profile.index', $talkingTo->username) }}">{{ $talkingTo->short_name }}</a></h3>
                <a href="{{ route('profile.index', $talkingTo->username) }}">{{ "@{$talkingTo->username}" }}</a>
                <b>{{ __('Online') }}</b>
            </div>
        </div>
        <div class="conversation__actions">
            <button class="conversation__more" data-action="moreOptions">
                <i class="icon icon-more"></i>
            </button>
            <button class="conversation__close" data-action="closeConversation">
                <i class="icon icon-times"></i>
            </button>
        </div>
    </div>
    <div class="conversation__body">
        <ul class="conversation__messages">
            @foreach ($conversation->latest_messages as $message)
                <li class="conversation__message{{ $message->sender->id === auth()->id() ? ' sent' : ' received' }}">
                    @if ($message->body)
                        <div class="conversation__text">
                            <p>{{ $message->body }}</p>
                        </div>
                    @endif
                    @if ($message->media)
                        <div class="conversation__media" count="{{ count($message->media) }}">
                            <img src="{{ asset('img/media-1.png') }}">
                        </div>
                    @endif
                    <span class="conversation__time">{{ $message->created_at->isToday() ? $message->created_at->format('h:i A') : $message->created_at->format('M d, h:i A') }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="conversation__footer">
        <div contenteditable="true" class="conversation__input" style='--placeHolder: "{{ __('Type a message...') }}"'></div>
        <div class="conversation__actions">
            <button>
                <i class="icon icon-image"></i>
            </button>
            <button>
                <i class="icon icon-send"></i>
            </button>
        </div>
    </div>
</div>
