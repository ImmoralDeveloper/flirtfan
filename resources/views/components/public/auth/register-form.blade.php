<form action="">
    <h2>{{ __('Welcome to') }} <span>Flirt Fan</span></h2>
    <p>{{ __('Create an account') }}</p>
    <div>
        <input type="text" name="first_name" id="" placeholder="{{ __(' First Name') }}">
        <input type="text" name="last_name" id="" placeholder="{{ __(' Last Name') }}">
    </div>
    <input type="email" name="email" id="" placeholder="{{ __(' Email Address') }}">
    <input type="password" name="password" id="" placeholder="{{ __(' Password') }}">
    <input type="password" name="password_confirmation" id="" placeholder="{{ __(' Confirm Password') }}">
    <button class="button" type="submit">
        {{ __('Sign Up') }}
    </button>
    <b>{{ __('or') }}</b>
    <a href="{{ route('login') }}">{{ __('Already have an account?') }}</a>
</form>
