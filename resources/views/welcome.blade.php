@extends('layouts.welcome')

@section('welcome-content')

        <!-- Hero Slider start -->
        <div class="hero-slider">
            <div class="single-slide-2 bg-image-two d-flex align-items-center bg-sky-blue" data-bgimage="{{ asset('assets/img/transit/bg-home.png') }}">
                <!-- Hero Content One Start -->
                <div class="hero-content-two container">
                    <div class="row align-items-center mt-lg-0 mt-sm-5 mt-0">
                        <div class="col-lg-7 mb-4">
                            <div class="slider-text-info">
                                <h3 class="text-white">Bienvenue sur Diki Tivi</h3>
                                <h1 class="text-white">Médias chrétiens</h1>
                                <p class="text-white fs-4">Pour commencez, <a href="{{ route('login') }}" class="text-decoration-underline" style="color: #abff67">identifiez-vous</a> ou choisissez votre tranche d'âge afin de trouver les médias qui vous correspondent.</p>
                                <div class="slider-button two-c-theme">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <a href="" class="default-btn shakespeare btn-block py-3 rounded-pill fs-5 shadow-0 text-center">Je suis majeur.e</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="" class="default-btn bg-tow btn-block py-3 rounded-pill fs-5 shadow-0 text-center">Je suis mineur.e</a>
                                        </div>
                                        <div class="col-lg-6 d-lg-none d-inline-block">
                                            <div class="login-button pe-0">
                                                <a href="{{ route('login') }}" class="login-btn grey-light btn-block py-3 rounded-pill fs-5 shadow-0 text-center">@lang('miscellaneous.login_title1')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 d-lg-inline-block d-none">
                            <div class="card rounded-0 shadow-0">
                                <div class="card-body p-4">
                                    <h4 class="h4 mb-4 text-center">@lang('miscellaneous.login_title2')</h4>

                                    <form>
                                        <div class="mb-3">
                                            <label for="login_email" class="form-label">@lang('miscellaneous.email')</label>
                                            <input type="email" class="form-control rounded-0" id="login_email" aria-describedby="login_email_error" autofocus>
                                            {{-- <div id="login_email_error" class="form-text"></div> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label for="login_password" class="form-label">@lang('miscellaneous.password.label')</label>
                                            <input type="password" class="form-control rounded-0" id="login_password" aria-describedby="login_password_error">
                                            {{-- <div id="login_password_error" class="form-text"></div> --}}
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('auth.login')</button>
                                        <a href="{{ route('register') }}" class="btn btn-block bg-light border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.go_register')</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hero Content One End -->
            </div>
        </div>
        <!-- Hero Slider end -->


@endsection
