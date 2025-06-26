<form action="{{ route('login') }}" method="POST">
    @csrf
    @method('POST')
    <h2>Welcome <span>Back</span></h2>
    <p style="margin-bottom: 15px">{{ __('Sign in to') }} Flirt Fan</p>
    <div
        style="background: var(--primaryColor); padding: 10px 15px; border-radius: 10px; display: flex; flex-direction: column; width: 100%; gap: 5px;">
        <h3>Demo:</h3>
        <span style="font-size: 15px; opacity: .7; font-weight: 500;"><b style="font-size: 15px;font-weight: 600;">email:</b>
            test@example.com</span>
        <span style="font-size: 15px; opacity: .7; font-weight: 500;"><b style="font-size: 15px;font-weight: 600;">password:</b>
            password</span>
    </div>
    <input type="email" name="email" id="" placeholder="{{ __('Email Address') }}">
    <input type="password" name="password" id="" placeholder="{{ __('Password') }}">
    <a class="forgot-password-link" href="#">{{ __('Forget password?') }}</a>
    <button class="button" type="submit">
        {{ __('Sign In') }}
    </button>
    <b>{{ __('or') }}</b>
    <a href="{{ route('register') }}">{{ __('Create a new account?') }}</a>
</form>
