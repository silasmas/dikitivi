<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="dktv-url" content="{{ getWebURL() }}">
        <meta name="dktv-visitor" content="{{ !empty($current_user) ? random_int(10000, 99999) . '-' . $current_user->id : null }}">

        <!-- ============ Favicon ============ -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">

        <!-- ============ Font Icons Files ============ -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css">

        <!-- ============ Addons CSS Files ============ -->
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/jquery/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/cropper/css/cropper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/sweetalert2/dist/sweetalert2.min.css') }}">

        <!-- ============ Streamo CSS File ============ -->
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/plugins.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/style.css') }}">

        <!-- ============ Modernizer JS ============ -->
        <script src="{{ asset('assets/addons/streamo/js/vendor/modernizr-3.6.0.min.js') }}"></script>

        <!-- ============ Custom CSS ============ -->
        <style>
            .logo a img { width: 200px; }
            @media screen and (max-width: 375px) {
                .logo a img { width: 140px; }
            }
        </style>

        <title>
@if (Route::is('home.youth') || Route::is('home.adult') || Route::is('welcome'))
            @lang('miscellaneous.app_name')
@endif
@if (Route::is('about'))
            @lang('miscellaneous.menu.about')
@endif
@if (Route::is('search'))
            @lang('miscellaneous.search_result')
@endif
@if (Route::is('account'))
            @lang('miscellaneous.menu.account_settings')
@endif
@if (Route::is('account.update.password'))
            @lang('miscellaneous.pages_content.account.update_password.title')
@endif
@if (Route::is('notifications'))
            @lang('miscellaneous.menu.notifications')
@endif
        </title>
    </head>
    <body>
        <!-- Main Wrapper Start -->
        <div class="main-wrapper">
            <header class="header-area inner-header">
                <div class="container relative">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-7">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="{{ route('welcome') }}"><img src="{{ asset('assets/img/logo-text.png') }}" alt=""></a>
                            </div>
                            <!-- Logo -->
                        </div>
                        <div class="col-lg-9 col-5">
                            <div class="menu-responsive">
                                <div class="main-menu">
                                    <nav class="main-navigation">
                                        <ul>
                                            <li><a href="#about">@lang('miscellaneous.menu.public.about')</a></li>
                                            <li><a href="#pricing">@lang('miscellaneous.menu.public.pricing')</a></li>
                                            <li><a href="#help">@lang('miscellaneous.menu.public.help')</a></li>
                                        </ul>
                                    </nav>
                                    <div class="login-button">
                                        <a class="login-btn brilliantrose border-r-5 me-sm-2 me-1" href="">
                                            <i class="bi bi-heart-fill me-sm-2"></i>
                                            <span class="d-sm-inline-block d-none">
                                                @lang('miscellaneous.menu.public.donate')
                                            </span>
                                        </a>

                                        <div class="dropdown dropleft d-inline-block">
                                            <a role="button" id="dropdownLanguage" class="dropdown-toggle hidden-arrow text-light" href="#">
                                                <i class="bi bi-translate fs-4 align-middle"></i>
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownLanguage">
    @foreach ($available_locales as $locale_name => $available_locale)
        @if ($available_locale != $current_locale)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('change_language', ['locale' => $available_locale]) }}">
                                                        {{ $locale_name }}
            @switch($available_locale)
                @case('ln')
                                                        <span class="fi fi-cd"></span>
                    @break
                @case('en')
                                                        <span class="fi fi-us"></span>
                    @break
                @default
                                                        <span class="fi fi-{{ $available_locale }}"></span>
            @endswitch
                                                    </a>
                                                </li>
        @endif
    @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- mobile-menu start -->
                                <div class="mobile-menu d-block d-lg-none"></div>
                                <!-- mobile-menu end -->
                            </div>
                        </div>
                    </div>
                </div>
                    </header>

@yield('welcome-content')

            <!-- Footer Area -->
            <footer class="footer-area">
                <div class="footer-top-tow bg-image-two" data-bgimage="{{ asset('assets/img/transit/footer-bg-02.jpg') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">A propos de Diki Tivi</h4>
                                    <div class="footer-contet">
                                        <p>Eiusmod tempor incididunt ut la abore et minim ven exerc itation ulla mco lboris naliquip ex ea comm.</p>
                                        <ul class="fotter-socail">
                                            <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                            <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                            <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                            <li><a href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--// footer-widget -->
                            </div>

                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">Company</h4>

                                    <div class="footer-contet">
                                        <ul class="footer-list">
                                            <li><a href="#">About</a></li>
                                            <li><a href="#">Service</a></li>
                                            <li><a href="#">Contact</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--// footer-widget -->
                            </div>

                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">Contact</h4>

                                    <div class="footer-contet">
                                        <ul class="footer-contact-list">
                                            <li> <i class="zmdi zmdi-phone"></i> <a href="#">+022222222</a></li>
                                            <li> <i class="zmdi zmdi-home"></i> <a href="#">Queen meri street abc/23 Bangladesh</a></li>
                                            <li> <i class="zmdi zmdi-email"></i> <a href="#">demo@gmail.com</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--// footer-widget -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p class="copyright-text">Copyright &copy; {{ date('Y') }} @lang('miscellaneous.all_right_reserved')</p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <ul class="footer-bottom-list">
                                    <li><a href="#">Help</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">support</a></li>
                                    <li><a href="#">contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!--// Footer Area -->
        </div>
        <!-- Main Wrapper End -->

        <!-- ============ JavaScript Libraries ============ -->
        <!-- jquery -->
        <script src="{{ asset('assets/addons/streamo/js/vendor/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('assets/addons/streamo/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery-ui.min.js') }}"></script>
        <!-- Material Design for Bootstrap -->
        <script src="{{ asset('assets/addons/custom/mdb/js/mdb.min.js') }}"></script>
        <!-- Popper JS -->
        {{-- <script src="{{ asset('assets/addons/streamo/js/popper.min.js') }}"></script> --}}
        <!-- Bootstrap -->
        {{-- <script src="{{ asset('assets/addons/streamo/js/bootstrap.min.js') }}"></script> --}}
        <script src="{{ asset('assets/addons/streamo/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Plugins JS -->
        <script src="{{ asset('assets/addons/streamo/js/plugins.js') }}"></script>
        <!-- Material Design for Bootstrap -->
        <script src="{{ asset('assets/addons/custom/mdb/js/mdb.min.js') }}"></script>
        <!-- Ajax Mail -->
        <script src="{{ asset('assets/addons/streamo/js/ajax-mail.js') }}"></script>
        <!-- Perfect scrollbar -->
        <script src="{{ asset('assets/addons/custom/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <!-- CropperJS -->
        <script src="{{ asset('assets/addons/custom/cropper/js/cropper.min.js') }}"></script>
        <!-- SweetAlert -->
        <script src="{{ asset('assets/addons/custom/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ asset('assets/addons/streamo/js/main.js') }}"></script>
    </body>
</html>
