<form action="{{ route('register') }}" method="POST">
    @csrf
    @method('POST')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h2>{{ __('Welcome to') }} <span>Flirt Fan</span></h2>
    <p>{{ __('Create an account') }}</p>
    <input type="text" name="name" id="" placeholder="{{ __(' Full Name') }}">
    <input type="email" name="email" id="" placeholder="{{ __(' Email Address') }}">
    <input type="password" name="password" id="" placeholder="{{ __(' Password') }}">
    <input type="password" name="password_confirmation" id="" placeholder="{{ __(' Confirm Password') }}">
    <button class="button" type="submit">
        {{ __('Sign Up') }}
    </button>
    <b>{{ __('or') }}</b>
    <a href="{{ route('login') }}">{{ __('Already have an account?') }}</a>
</form>
