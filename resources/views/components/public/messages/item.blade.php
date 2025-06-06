<li class="message-item" data-action="openMessage">
    <x-user-avatar :user="$conversation->userOne->id === auth()->id() ? $conversation->userTwo : $conversation->userOne" />
    <div class="message-item__content">
        <p>{{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}
            <span>
                {{ $conversation->last_message->created_at->isToday() ? $conversation->last_message->created_at->format('h:i A') : $conversation->last_message->created_at->format('M d, h:i A') }}
            </span>
        </p>
        <p>
            {{ $conversation->last_message->sender->id === auth()->id() ? __('You') . ': ' : '' }}
            {{ str($conversation->last_message->body)->limit(20) }}
            @if ($conversation->last_message->media)
                <span class="message-item__media">[Media]</span>
            @endif
        </p>
    </div>
</li>
