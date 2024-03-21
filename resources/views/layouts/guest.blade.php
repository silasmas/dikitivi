<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="@lang('miscellaneous.keywords')">
        <meta name="dktv-url" content="{{ getWebURL() }}">
        <meta name="dktv-api-url" content="{{ getApiURL() }}">
        <meta name="dktv-visitor" content="{{ !empty(Auth::user()) ? Auth::user()->id : null }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="dktv-ref" content="{{ !empty(Auth::user()) ? Auth::user()->api_token : null }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <link rel="stylesheet" id="bootstrap-style" href="{{ asset('assets/addons/custom/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" id="mdb-style" href="{{ asset('assets/addons/custom/mdb/css/mdb.min.css') }}">
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
        <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <title>
@if (!empty($exception))
            {{ $exception->getStatusCode() . ' - ' . __('notifications.' . $exception->getStatusCode() . '_title') }}
@else
    @if (!empty($error_title) || \Session::has('error_message'))
            {{ !empty($error_title) ? $error_title : ( \Session::has('error_message') ? (preg_match('/~/', \Session::get('error_message')) ? explode('-', explode('~', \Session::get('error_message'))[0])[2] : \Session::get('error_message')) : '') }}
    @endif

    @if (empty($error_title) && !\Session::has('error_message'))
		@if (Route::is('login'))
			@lang('auth.login')
		@endif

		@if (Route::is('register'))
			@lang('auth.register')
		@endif

		@if (Route::is('password.request'))
			@lang('auth.reset-password')
		@endif

		@if (!empty($request->redirect))
			@lang('auth.reset-password')
		@endif

		@if (!empty($token_sent))
			@lang('auth.otp-code')
		@endif
    @endif
@endif
        </title>
    </head>

    <body>
        <span class="d-none perfect-scrollbar"></span>
        <!-- Main Wrapper Start -->
        <div class="main-wrapper">
            <div class="d-flex justify-content-end mb-4 p-4 position-absolute w-100">
                <div class="dropdown d-inline-block">
                    <a role="button" id="dropdownLanguage" class="btn btn-light btn-sm dropdown-toggle py-1 px-2 hidden-arrow shadow-0" title="@lang('miscellaneous.your_language')" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-translate fs-4 align-middle"></i>
                    </a>
                    <ul class="dropdown-menu mt-1 p-0" aria-labelledby="dropdownLanguage">
@foreach ($available_locales as $locale_name => $available_locale)
    @if ($available_locale != $current_locale)
                        <li class="w-100">
                            <a class="dropdown-item px-3 py-2 text-dark" href="{{ route('change_language', ['locale' => $available_locale]) }}">
        @switch($available_locale)
            @case('ln')
                                <span class="fi fi-cd me-2"></span>
                @break
            @case('en')
                                <span class="fi fi-us me-2"></span>
                @break
            @default
                                <span class="fi fi-{{ $available_locale }} me-2"></span>
        @endswitch
                                {{ $locale_name }}
                            </a>
                        </li>
    @endif
@endforeach
                    </ul>
                </div>
            </div>

            <!-- Page Conttent -->
            <main class="page-content">
@if (\Session::has('success_message'))
                <!-- Alert Start -->
                <div class="position-relative">
                    <div class="row position-fixed w-100" style="opacity: 0.9; z-index: 999;">
                        <div class="col-lg-5 col-sm-6 mx-auto">
                            <div class="alert alert-success alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                                <i class="bi bi-info-circle me-2 fs-4" style="vertical-align: -3px;"></i> {{ \Session::get('success_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alert End -->

@endif

@if (\Session::has('error_message'))
                <!-- Alert Start -->
                <div class="position-relative">
                    <div class="row position-fixed w-100" style="opacity: 0.9; z-index: 999;">
                        <div class="col-lg-5 col-sm-6 mx-auto">
                            <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                                <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {{ preg_match('/~/', \Session::get('error_message')) ? explode('-', explode('~', \Session::get('error_message'))[0])[1] : \Session::get('error_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alert End -->

@endif

@if (!empty($error_message))
                <!-- Alert Start -->
                <div class="position-relative">
                    <div class="row position-fixed w-100" style="opacity: 0.9; z-index: 999;">
                        <div class="col-lg-5 col-sm-6 mx-auto">
                            <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                                <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {{ $error_message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alert End -->

@endif
                <!-- login-register  -->
                <div class="register-page py-5">
                    <div class="container-sm container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-sm-9 mx-auto">
                                <div class="bg-image mx-auto mb-sm-4 mb-3" style="width: 200px">
                                    <img src="{{ asset('assets/img/logo-text.png') }}" alt="DikiTivi" class="img-fluid">
                                    <div class="mask">
@if (empty($exception))
                                        <a href="{{ route('home') }}" class="stretched-link"></a>
@endif
                                    </div>
                                </div>
@yield('guest-content')
                                <p class="mt-3 mb-0 text-center">@lang('miscellaneous.toggle_theme')</p>
                                <div class="d-flex justify-content-center">
                                    <div role="group" id="themeToggler" class="btn-group shadow-0" aria-label="Theme toggler">
                                        <button type="button" class="btn btn-light light"  data-mdb-ripple-init><i class="bi bi-sun"></i></button>
                                        <button type="button" class="btn btn-light dark"  data-mdb-ripple-init><i class="bi bi-moon-fill"></i></button>
                                        <button type="button" class="btn btn-light auto"  data-mdb-ripple-init><i class="bi bi-circle-half"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--// login-register End -->
            </main>
            <!--// Page Conttent -->

            <!-- Footer Area -->
            <footer class="footer-area">
                <div class="footer-top-tow bg-image-two" data-bgimage="{{ asset('assets/img/transit/footer-bg-02.jpg') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">@lang('miscellaneous.public.about.title')</h4>
                                    <div class="footer-contet">
                                        <p>@lang('miscellaneous.public.about.description')</p>
                                        <ul class="fotter-socail">
                                            <li><a href="#" class="fs-4"><i class="bi bi-facebook align-middle"></i></a></li>
                                            <li><a href="#" class="fs-4"><i class="bi bi-instagram align-middle"></i></a></li>
                                            <li><a href="#" class="fs-4"><i class="bi bi-twitter-x align-middle"></i></a></li>
                                            <li><a href="#" class="fs-4"><i class="bi bi-youtube align-middle"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--// footer-widget -->
                            </div>

                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">@lang('miscellaneous.public.footer.useful_links')</h4>

                                    <div class="footer-contet">
                                        <ul class="footer-list">
                                            <li><a href="{{ route('about') }}">@lang('miscellaneous.menu.about')</a></li>
                                            <li><a href="{{ route('about.entity', ['entity' => 'contact']) }}">@lang('miscellaneous.menu.contact')</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!--// footer-widget -->
                            </div>

                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">@lang('miscellaneous.public.footer.head_office.title')</h4>

                                    <div class="footer-contet">
                                        <ul class="footer-contact-list">
                                            <li> <i class="zmdi zmdi-phone"></i> <a href="#">@lang('miscellaneous.public.footer.head_office.phone')</a></li>
                                            <li> <i class="zmdi zmdi-home"></i> <a href="#">@lang('miscellaneous.public.footer.head_office.address')</a></li>
                                            <li> <i class="zmdi zmdi-email"></i> <a href="#">@lang('miscellaneous.public.footer.head_office.email')</a></li>
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
                                    <li><a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}">@lang('miscellaneous.public.about.terms_of_use.title')</a></li>
                                    <li><a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}">@lang('miscellaneous.public.about.privacy_policy.title')</a></li>
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
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/jquery/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/jquery/scroll4ever/js/jquery.scroll4ever.js') }}"></script>
        <!-- Popper JS -->
        <script src="{{ asset('assets/addons/custom/bootstrap/js/popper.min.js') }}"></script>
        <!-- Material Design for Bootstrap -->
        <script src="{{ asset('assets/addons/custom/mdb/js/mdb.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('assets/addons/custom/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Plugins JS -->
        <script src="{{ asset('assets/addons/streamo/js/plugins.js') }}"></script>
        <!-- Ajax Mail -->
        <script src="{{ asset('assets/addons/streamo/js/ajax-mail.js') }}"></script>
        <!-- Perfect scrollbar -->
        <script src="{{ asset('assets/addons/custom/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <!-- CropperJS -->
        <script src="{{ asset('assets/addons/custom/cropper/js/cropper.min.js') }}"></script>
        <!-- SweetAlert -->
        <script src="{{ asset('assets/addons/custom/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <!-- DataTable -->
        <script src="{{ asset('assets/addons/custom/dataTables/datatables.min.js') }}"></script>
        <!-- Autosize -->
        <script src="{{ asset('assets/addons/custom/autosize/js/autosize.min.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ asset('assets/addons/streamo/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script type="text/javascript">
       </script>
    </body>
</html>
