<div class="menu">
    <button data-action="close">
        <i class="icon icon-times"></i>
    </button>
    <ul>
        <li>
            <a href="{{ route('profile.index', auth()->user()) }}">
                <i class="icon icon-user"></i>
                {{ __('Profile') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-card"></i>
                {{ __('Add card') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-bank"></i>
                {{ __('Add bank') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-wallet"></i>
                {{ __('Wallet') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-favorites"></i>
                {{ __('Favorites') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-save"></i>
                {{ __('Saved') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-settings"></i>
                {{ __('Settings') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-important-dialog"></i>
                {{ __('About') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-clipboard-check"></i>
                {{ __('Term & Conditions') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-privacy"></i>
                {{ __('Privacy') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-tel-email"></i>
                {{ __('Contact us') }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="icon icon-question"></i>
                {{ __('Support') }}
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="icon icon-logout"></i>
                    {{ __('Logout') }}
                </button>
            </form>
        </li>
    </ul>
</div>
