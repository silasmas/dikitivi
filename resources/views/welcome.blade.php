@extends('layouts.welcome')

@section('welcome-content')

        <!-- Hero Slider start -->
        <div class="hero-slider">
            <div class="single-slide-2 bg-image-two d-flex align-items-center bg-sky-blue" data-bgimage="{{ asset('assets/img/pub/bg-home.png') }}">
                <!-- Hero Content One Start -->
                <div class="hero-content-two container">
                    <div class="row align-items-center mt-lg-0 mt-sm-5 mt-0">
                        <div class="col-lg-7 mb-4">
                            <div class="slider-text-info">
                                <h3 class="text-white">@lang('miscellaneous.welcome')</h3>
                                <h1 class="text-white">@lang('miscellaneous.public.home.hero.title')</h1>
                                <p class="text-white fs-4">@lang('miscellaneous.public.home.hero.content')</p>
                                <div class="slider-button two-c-theme">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <a href="" class="default-btn shakespeare btn-block py-3 rounded-pill fs-5 shadow-0 text-center">@lang('miscellaneous.public.home.hero.link1')</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="" class="default-btn bg-tow btn-block py-3 rounded-pill fs-5 shadow-0 text-center">@lang('miscellaneous.public.home.hero.link2')</a>
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

        <!-- About Area -->
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
                                <a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}" class="default-btn mb-2 brilliantrose">@lang('miscellaneous.public.about.terms_of_use.title')</a>
                                <a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="primary-btn ms-lg-2">@lang('miscellaneous.public.about.privacy_policy.title')</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row g-5 videos-main-area align-items-center mt-5">
                    <div class="col-lg-7 col-md-7 s--mt--30">
                        <div class="videos-contents-wrap">
                            <div class="section-title-two">
                                <h2>@lang('miscellaneous.public.home.download_mobile_app.title')</h2>
                            </div>
                            <p>@lang('miscellaneous.public.home.download_mobile_app.content')</p>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5">
                        <div class="bg-image mb-4">
                            <img src="{{ asset('assets/img/button-playstore-white.png') }}" alt="" class="img-fluid">
                            <div class="mask"><a href="#" class="stretched-link"></a></div>
                        </div>

                        <div class="bg-image">
                            <img src="{{ asset('assets/img/button-applestore-white.png') }}" alt="" class="img-fluid">
                            <div class="mask"><a href="#" class="stretched-link"></a></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!--// About Area -->

        <!-- Pricing Area -->
        <div id="pricing" class="pricing-plan-area section-pt py-5 border-top border-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <!-- Section Title -->
                        <div class="section-title mb-3 text-center">
                            <h2>@lang('miscellaneous.public.home.pricing.title')</h2>
                            <p>@lang('miscellaneous.public.home.pricing.content')</p>
                        </div><!--// Section Title -->
                    </div>
                </div>

                <div class="row">
@forelse ($pricings->data as $pricing)
                    <div class="col-lg-4 col-md-6 mx-auto">
                        <!-- Pricing-panel -->
                        <div class="pricing-panal-wrap free-panel mt--30 d-block">
                            <span></span>
                            <div class="pricing-panel text-center">
                                <div class="pricing-heading">
                                    <h2>{{ '$' . $pricing->price }}</h2>
                                    <h4 class="text-warning">{{ $pricing->deadline }}</h4>
                                </div>
                                <div class="pricing-body">
                                </div>
                                <div class="pricing-footer">
                                    <a href="#" class="plan-btn"><i class="bi bi-cart me-2"></i>@lang('miscellaneous.buy')</a>
                                </div>
                            </div>
                        </div>
                        <!-- Pricing-panel -->
                    </div>

@empty
@endforelse
                </div>
            </div>
        </div>
        <!--// Pricing Area -->

        <!-- Contact Area -->
        <div id="contact" class="contact-us-wrapper section-ptb py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <!-- Section Title -->
                        <div class="section-title mb-5 text-center">
                            <h2>@lang('miscellaneous.public.about.contact.title')</h2>
                            <p>@lang('miscellaneous.public.about.contact.description')</p>
                        </div><!--// Section Title -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact-form-wrap">
                            <form id="contact-form" action="assets/php/mail.php" method="POST">
                                <div class="contact-page-form">
                                    <div class="row contact-input">
                                        <div class="col-lg-6 col-md-6 contact-inner">
                                            <input name="name" type="text" placeholder="@lang('miscellaneous.firstname')" id="first-name">
                                        </div>
                                        <div class="col-lg-6 col-md-6 contact-inner">
                                            <input name="lastname" type="text" placeholder="@lang('miscellaneous.lastname')" id="last-name">
                                        </div>
                                        <div class="col-lg-6 col-md-6 contact-inner">
                                            <input type="text" placeholder="@lang('miscellaneous.email')" id="email" name="email">
                                        </div>
                                        <div class="col-lg-6 col-md-6 contact-inner">
                                            <input name="subject" type="text" placeholder="@lang('miscellaneous.public.about.contact.message_subject')" id="subject">
                                        </div>
                                        <div class="col-lg-12 col-md-12 contact-inner contact-message">
                                            <textarea name="message"  placeholder="@lang('miscellaneous.public.about.contact.message_content')"></textarea>
                                        </div>
                                    </div>
                                    <div class="contact-submit-btn text-center">
                                        <button class="submit-btn" type="submit"><i class="bi bi-send me-2"></i>@lang('miscellaneous.send')</button>
                                        <p class="form-messege"></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// Contact Area -->

        <!-- Map location Area -->
        <div class="map-wrapper relative">
            <div class="gogle_map">
                <div id="googleMap">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254595.4750351303!2d15.157927977869083!3d-4.4009432564518205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a3130fe066a8b%3A0x168b7e4e1f52378d!2sKinshasa!5e0!3m2!1sfr!2scd!4v1708596477903!5m2!1sfr!2scd" style="width:100%; height: 100%; border:0;" allowfullscreen="true" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="contact-info-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 ms-auto">
                            <div class="contact-info-inner">
                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-home"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p>@lang('miscellaneous.public.footer.head_office.address')</p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->

                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-phone"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><a href="#">@lang('miscellaneous.public.footer.head_office.phone')</a></p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->

                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-email"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><a href="#">@lang('miscellaneous.public.footer.head_office.email')</a> </p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->

                                <!-- Single-contact-info -->
                                <div class="single-contact-info">
                                    <div class="contact-info-icon">
                                        <i class="zmdi zmdi-globe-alt"></i>
                                    </div>
                                    <div class="contact-info-text">
                                        <p><a href="{{ route('home') }}">www.dikitivi.com</a></p>
                                    </div>
                                </div>
                                <!--// Single-contact-info -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--// Map location Area -->

@endsection
