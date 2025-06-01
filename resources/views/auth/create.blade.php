@push('styles')
    @vite('resources/css/auth.css')
@endpush
<x-layouts.app section="login">
    <div class="auth-container">
        <img src="{{ asset('img/auth-bg.png') }}" alt="">
        <div>
            <h1>Lorem ipsum dolor <span>sit.</span></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione ullam dolorem ex officiis dolore,
                laborum, doloribus cupiditate culpa nihil excepturi facere vitae repellat! Eaque vero ratione ex
                asperiores suscipit accusamus.</p>
            <div class="icons">
                <a href="#"><i class="icon icon-facebook"></i></a>
                <a href="#"><i class="icon icon-x"></i></a>
                <a href="#"><i class="icon icon-instagram"></i></a>
                <a href="#"><i class="icon icon-telegram"></i></a>
                <a href="#"><i class="icon icon-youtube"></i></a>
            </div>
            <button class="button">{{ __("Become a creator") }}</button>
        </div>
        <div>
            @include("components.public.auth.{$route}-form")
        </div>
    </div>
</x-layouts.app>