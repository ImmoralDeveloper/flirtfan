
document.addEventListener('DOMContentLoaded', function () {
    const messagesList = document.querySelector('.messages-list');
    if (!messagesList) return;
    messagesList.addEventListener('click', function (e) {
        let actionTarget = e.target.closest('[data-action]');
        if (!actionTarget) return;
        switch (actionTarget.dataset.action) {
            case 'openMessage':
                document.querySelector('.conversation')?.classList.add('active');
                break;
        }
    });
});