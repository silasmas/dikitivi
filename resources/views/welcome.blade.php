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
                                <h3 class="text-white">@lang('miscellaneous.welcome')</h3>
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
                                        <div class="form-floating mb-3">
                                            <input type="email" name="login_email" id="login_email" class="form-control" aria-describedby="login_email_error" placeholder="@lang('miscellaneous.email')" autofocus>
                                            <label for="login_email">@lang('miscellaneous.email')</label>
                                            {{-- <small id="login_email_error" class="form-text text-danger">Test 1 2 3</small> --}}
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" name="login_password" id="login_password" class="form-control" aria-describedby="login_password_error" placeholder="@lang('miscellaneous.password.label')">
                                            <label for="login_password">@lang('miscellaneous.password.label')</label>
                                            {{-- <small id="login_password_error" class="form-text text-danger"></small> --}}
                                        </div>
                                        <button type="submit" class="btn btn-block btn-primary rounded-pill shadow-0" style="text-transform: inherit!important;">@lang('auth.login')</button>
                                        <a href="{{ route('register') }}" class="btn btn-block btn-light border-0 rounded-pill text-dark shadow-0" style="text-transform: inherit!important;">@lang('miscellaneous.go_register')</a>
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

        <!-- Videos Area -->
        <div id="about" class="videos-area section-pb section-bg-shape-2 py-5">
            <div class="container">
                <div class="row g-5 videos-main-area align-items-center">
                    <div class="col-lg-5 col-md-5">
                        <div class="bg-image rounded-5 overflow-hidden">
                            <img src="{{ asset('assets/img/pub/pub001.png') }}" alt="" class="img-fluid">
                            <div class="mask"></div>
                       </div>
                    </div>

                    <div class="col-lg-7 col-md-7 s--mt--30">
                        <div class="videos-contents-wrap">
                            <div class="section-title-two">
                                <h2>@lang('miscellaneous.public.about.title')</h2>
                            </div>
                            <p> unde omnis iste natus error sit volupt atem accus antiumij doloremque laudantium, totam rem aperiam, quia voptas Neque porro quisquam est, qui dolosum quia dmet, consectetur, adipisci velit.</p>

                            <div class="choose-button  two-c-theme">
                                <a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}" class="default-btn mb-2 brilliantrose">@lang('miscellaneous.public.terms_of_use.title')</a>
                                <a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="primary-btn">@lang('miscellaneous.public.privacy_policy.title')</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!--// Videos Area -->

@endsection
