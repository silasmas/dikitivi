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
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/mdb/css/mdb.min.css') }}">
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
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@if (request()->has('app_id'))
        <style>
            .detect-webview { display: none; }
        </style>
@endif

        <title>
@if (Route::is('home'))
            @lang('miscellaneous.welcome')
@else
            DikiTivi
    @if (Route::is('donation'))
             / @lang('miscellaneous.menu.donate')
    @endif

    @if (Route::is('transaction.waiting') || Route::is('transaction.message'))
             / @lang('miscellaneous.bank_transaction_description')
    @endif

    @if (Route::is('donated'))
             / {{ \Session::has('error_message') ? \Session::get('error_message') : $message_content }}
    @endif

    @if (Route::is('about'))
             / @lang('miscellaneous.menu.about')
    @endif

    @if (Route::is('about.entity'))
             / {{ $entity_title }}
    @endif
@endif
        </title>
    </head>

    <body>
        <div id="loadingMask" class="perfect-scrollbar d-flex position-fixed dktv-bg-yellow w-100 justify-items-center align-items-center" style="z-index: 9999; height: 100vh;">
            <div class="spinner-border mx-auto" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">@lang('miscellaneous.loading')</span>
            </div>
        </div>

        <!-- Main Wrapper Start -->
        <div class="main-wrapper">
            <header class="header-area inner-header detect-webview">
                <div class="container-sm container-fluid relative">
                    <div class="row{{ Route::is('home') ? ' align-items-center' : '' }}">
                        <div class="col-lg-3 col-7">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo-text.png') }}" alt=""></a>
                            </div>
                            <!-- Logo -->
                        </div>

@if (Route::is('home'))
                        <div class="col-lg-9 col-5">
                            <div class="menu-responsive">
                                <div class="main-menu">
                                    <nav id="mainNav" class="main-navigation">
                                        <ul>
                                            <li><a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a></li>
                                            <li><a href="{{ route('about') }}">@lang('miscellaneous.menu.about')</a></li>
                                            <li><a href="{{ route('about.entity', ['entity' => 'contact']) }}">@lang('miscellaneous.menu.contact')</a></li>
                                        </ul>
                                    </nav>
                                    <div class="login-button">
                                        <a href="{{ route('donation') }}" class="login-btn brilliantrose border-r-5 me-sm-2 me-1" title="@lang('miscellaneous.menu.donate')">
                                            <i class="bi bi-heart-fill align-middle me-sm-2"></i>
                                            <span class="d-lg-inline-block d-none">
                                                @lang('miscellaneous.menu.donate')
                                            </span>
                                        </a>

                                        <div class="dropdown d-inline-block">
                                            <a role="button" id="dropdownLanguage" class="dropdown-toggle hidden-arrow text-light" title="@lang('miscellaneous.your_language')" data-bs-toggle="dropdown" aria-expanded="false">
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
                                </div>
                                <!-- mobile-menu start -->
                                <div class="mobile-menu d-block d-lg-none"></div>
                                <!-- mobile-menu end -->
                            </div>
                        </div>
@else
                        <div class="col-lg-9 col-5">
                            <div class="main-menu">
                                <nav id="mainNav" class="main-navigation">
                                    <ul>
                                        <li><a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a></li>
                                        <li><a href="{{ route('about') }}">@lang('miscellaneous.menu.about')</a></li>
                                        <li><a href="{{ route('about.entity', ['entity' => 'contact']) }}">@lang('miscellaneous.menu.contact')</a></li>
                                    </ul>
                                </nav>
                                <div class="login-button">
                                    <a href="{{ route('donation') }}" class="login-btn brilliantrose border-r-5 me-sm-2 me-1" title="@lang('miscellaneous.menu.donate')">
                                        <i class="bi bi-heart-fill align-middle me-sm-2"></i>
                                        <span class="d-lg-inline-block d-none">
                                            @lang('miscellaneous.menu.donate')
                                        </span>
                                    </a>
                                    <div class="dropdown d-inline-block">
                                        <a role="button" id="dropdownLanguage" class="dropdown-toggle hidden-arrow text-light" title="@lang('miscellaneous.your_language')" data-bs-toggle="dropdown" aria-expanded="false">
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
                            </div>
                        </div>

                        <div class="col">
                            <!-- mobile-menu start -->
                            <div class="mobile-menu d-block d-lg-none"></div>
                            <!-- mobile-menu end -->
                        </div>
@endif
                    </div>
                </div>
            </header>

@if (Route::is('donation') || Route::is('about') || Route::is('about.entity'))
    @include('partials.breacrumb')
@endif
@if (\Session::has('success_message'))

            <!-- Alert Start -->
            <div class="position-relative">
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 0; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-success alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-info-circle me-2 fs-4" style="vertical-align: -3px;"></i> {!! \Session::get('success_message') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alert End -->
@endif
@if (!empty($success_message))

            <!-- Alert Start -->
            <div class="position-relative">
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 0; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-success alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-info-circle me-2 fs-4" style="vertical-align: -3px;"></i> {!! $success_message !!}
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
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 0; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {!! \Session::get('error_message') !!}
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
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 0; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {!! $error_message !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alert End -->
@endif
@if (\Session::has('error_message_login'))

            <!-- Alert Start -->
            <div class="position-relative">
                <div class="row position-fixed w-100" style="opacity: 0.9; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {!! preg_match('/~/', \Session::get('error_message_login')) ? explode(', ', explode('~', \Session::get('error_message_login'))[0])[1] : \Session::get('error_message_login') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alert End -->
@endif

@yield('welcome-content')

            <!-- Footer Area -->
            <footer class="footer-area detect-webview">
                {{-- <div class="footer-top-tow bg-image-two" data-bgimage="{{ asset('assets/img/transit/footer-bg-02.jpg') }}"> --}}
                <div class="footer-top-tow dktv-bg-blue">
                    <div class="container">
                        <div class="row">
                            <div class="col-custom-4 mt--50">
                                <!-- footer-widget -->
                                <div class="footer-widget">
                                    <h4 class="footer-widget-title">@lang('miscellaneous.public.about.title')</h4>
                                    <div class="footer-contet">
                                        <p style="color: #fff!important;">@lang('miscellaneous.public.about.description')</p>
                                        <ul class="fotter-socail">
                                            <li><a href="https://www.facebook.com/DIKITIVI?mibextid=ZbWKwL" class="fs-4"><i class="bi bi-facebook align-middle"></i></a></li>
                                            <li><a href="https://x.com/DikiTivi?t=cuvFpqwKTw-5MN9JnIew5g&s=09" class="fs-4"><i class="bi bi-twitter-x align-middle"></i></a></li>
                                            <li><a href="https://youtube.com/@dikitivi?si=mV7Fuhx94Q7rk_Mk" class="fs-4"><i class="bi bi-youtube align-middle"></i></a></li>
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
                                            <li><a href="{{ route('home') }}" class="text-light">@lang('miscellaneous.menu.home')</a></li>
                                            <li><a href="{{ route('about') }}" class="text-light">@lang('miscellaneous.menu.about')</a></li>
                                            <li><a href="{{ route('about.entity', ['entity' => 'contact']) }}" class="text-light">@lang('miscellaneous.menu.contact')</a></li>
                                            <li><a href="{{ route('login') }}" class="text-light">@lang('miscellaneous.login_title1')</a></li>
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
                                            {{-- <li> <i class="zmdi zmdi-phone"></i> <a href="#" class="text-light">@lang('miscellaneous.public.footer.head_office.phone')</a></li> --}}
                                            <li> <i class="zmdi zmdi-home"></i> <a href="#" class="text-light">@lang('miscellaneous.public.footer.head_office.address')</a></li>
                                            <li> <i class="zmdi zmdi-email"></i> <a href="#" class="text-light">@lang('miscellaneous.public.footer.head_office.email')</a></li>
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
                                    <li><a href="{{ route('about.entity', ['entity' => 'terms_of_use']) }}" class="text-light">@lang('miscellaneous.menu.terms_of_use')</a></li>
                                    <li><a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="text-light">@lang('miscellaneous.menu.privacy_policy')</a></li>
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
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery-ui.min.js') }}"></script>
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
        <!-- Custom JS -->
        <script type="text/javascript">
            $(document).ready(function () {
                const navigator = window.navigator;
                const currentLanguage = $('html').attr('lang');
                const currentUser = $('[name="dktv-visitor"]').attr('content');
                const currentHost = $('[name="dktv-url"]').attr('content');
                const apiHost = $('[name="dktv-api-url"]').attr('content');

                /* Register form-data */
				$('form#data').submit(function (e) {
					e.preventDefault();

                    var formData = new FormData(this);
                    var categories = [];

                    document.querySelectorAll('[name="categories_ids"]').forEach(item => {
                        if (item.checked === true) {
                            categories.push(parseInt(item.value));
                        }
                    });

                    for (let i = 0; i < categories.length; i++) {
                        formData.append('categories_ids[' + i + ']', categories[i]);
                    }

                    $.ajax({
						headers: { 'Authorization': 'Bearer 23|fEmzaqAOGb6ld8Cej6NMU0VdXl3UISFkMDhoMLPp1754add6', 'Accept': 'multipart/form-data', 'X-localization': navigator.language },
						type: 'POST',
						contentType: 'multipart/form-data',
						url: apiHost + '/media',
						data: formData,
						beforeSend: function () {
							$('form#data .request-message').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
						},
						success: function (res) {
                            if ($('form#data .request-message').hasClass('text-danger')) {
                                $('form#data .request-message').removeClass('text-danger');
                            }

							$('form#data .request-message').addClass('text-success').html(res.message);

                            document.getElementById('data').reset();
							location.reload();
                        },
						cache: false,
						contentType: false,
						processData: false,
						error: function (xhr, error, status_description) {
                            if ($('form#data .request-message').hasClass('text-success')) {
                                $('form#data .request-message').removeClass('text-success');
                            }

                            if (xhr.responseJSON) {
                                $('form#data .request-message').addClass('text-danger').html(xhr.responseJSON.message);
                                console.log(xhr.responseJSON);
                            }

                            console.log(xhr.status);
							console.log(error);
							console.log(status_description);
						}
					});
				});

                /* On select change, update de country phone code */
                $('#select_country1').on('change', function () {
                    var countryData = $(this).val();
                    var countryDataArray = countryData.split('-');
                    // Get ID and Phone code from splitted data
                    var countryId = countryDataArray[1];
                    var countryPhoneCode = countryDataArray[0];

                    $('#phone_code_text1 .text-value').text(countryPhoneCode);
                    $('#country_id1').val(countryId);
                    $('#phone_code1').val(countryPhoneCode);
                });
                $('#select_country2').on('change', function () {
                    var countryData = $(this).val();
                    var countryDataArray = countryData.split('-');
                    // Get ID and Phone code from splitted data
                    var countryId = countryDataArray[1];
                    var countryPhoneCode = countryDataArray[0];

                    $('#phone_code_text2 .text-value').text(countryPhoneCode);
                    $('#country_id2').val(countryId);
                    $('#phone_code2').val(countryPhoneCode);
                });
                $('#select_country3').on('change', function () {
                    var countryData = $(this).val();
                    var countryDataArray = countryData.split('-');
                    // Get ID and Phone code from splitted data
                    var countryId = countryDataArray[1];
                    var countryPhoneCode = countryDataArray[0];

                    $('#phone_code_text3 .text-value').text(countryPhoneCode);
                    $('#country_id3').val(countryId);
                    $('#phone_code3').val(countryPhoneCode);
                });

                /* On check, show/hide some blocs */
                // OFFER TYPE
                $('#donationType .form-check-input').each(function () {
                    $(this).on('click', function () {
                        if ($('#anonyme').is(':checked')) {
                            $('#donorIdentity, #otherDonation').addClass('d-none');

                        } else {
                            $('#donorIdentity, #otherDonation').removeClass('d-none');
                        }
                    });
                });
                // TRANSACTION TYPE
                $('#paymentMethod .form-check-input').each(function () {
                    $(this).on('click', function () {
                        if ($('#bank_card').is(':checked')) {
                            $('#phoneNumberForMoney').addClass('d-none');

                        } else {
                            $('#phoneNumberForMoney').removeClass('d-none');
                        }
                    });
                });

                // At the bottom of your jQuery code, put this:
                $('#loadingMask').fadeOut().removeClass('d-flex').addClass('d-none');
            });
        </script>
    </body>
</html>
