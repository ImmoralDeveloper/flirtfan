@push('styles')
    @vite('resources/css/messages.css')
@endpush
@push('scripts')
    @vite('resources/js/messages.js')
@endpush
<x-layouts.app section="messages">
    <div class="messages__container">
        <x-public.messages.list />
        <x-public.messages.conversation :conversation="auth()->user()->latest_conversation" />
    </div>
</x-layouts.app>
