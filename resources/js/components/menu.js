const menuItems = [
    {
        name: 'Profile',
        icon: 'user'
    },
    {
        name: 'Add card',
        icon: 'card'
    },
    {
        name: 'Add bank',
        icon: 'bank'
    },
    {
        name: 'Wallet',
        icon: 'wallet'
    },
    {
        name: 'Favorites',
        icon: 'like'
    },
    {
        name: 'Save',
        icon: 'bookmarks'
    },
    {
        name: 'Wallet',
        icon: 'wallet'
    },
    {
        name: 'settings',
        icon: 'Settings'
    },
    {
        name: 'important-dialog',
        icon: 'About'
    },
    {
        name: 'clipboard-check',
        icon: 'Term & Conditions'
    },
    {
        name: 'privacy',
        icon: 'Privacy'
    },
    {
        name: 'tel-email',
        icon: 'Contact us'
    },
    {
        name: 'question',
        icon: 'Support'
    },
    {
        name: 'important-dialog',
        icon: 'About'
    }
]
export function getMenuHtml() {
    let csrfToken = document.querySelector(`meta[name="csrf-token"]`).content;
    let list = document.createElement('ul');
    menuItems.forEach(item => {
        let li = document.createElement('li');
        let a = document.createElement('a');

    })

}



