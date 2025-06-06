
document.addEventListener('DOMContentLoaded', function () {
    const conversationContainer = document.querySelector('.conversation');
    if (!conversationContainer) return;
    conversationContainer.addEventListener('click', function (e) {
        let actionTarget = e.target.closest('[data-action]');
        if (!actionTarget) return;
        switch (actionTarget.dataset.action) {
            case 'closeConversation':
                conversationContainer.classList.remove('active');
                break;
        }
    });
});