<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="@lang('miscellaneous.keywords')">
        <meta name="dktv-url" content="{{ getWebURL() }}">
        <meta name="dktv-api-url" content="{{ getApiURL() }}">
        <meta name="dktv-visitor" content="{{ !empty($current_user) ? $current_user->id : null }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="dktv-ref" content="{{ !empty($current_user) ? $current_user->api_token : null }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- ============ Favicon ============ -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">

        <!-- ============ Font Icons Files ============ -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap-icons/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css">

        <!-- ============ Addons CSS Files ============ -->
        <link rel="stylesheet" id="mdb-style" href="{{ asset('assets/addons/custom/mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" id="bootstrap-style" href="{{ asset('assets/addons/custom/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/jquery/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/cropper/css/cropper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/sweetalert2/dist/sweetalert2.min.css') }}">

        <!-- ============ Streamo CSS File ============ -->
        <link rel="stylesheet" href="{{ asset('assets/addons/streamo/css/plugins.css') }}">
        <link rel="stylesheet" id="custom-style" href="{{ asset('assets/addons/streamo/css/style.css') }}">

        <!-- ============ Modernizer JS ============ -->
        <script src="{{ asset('assets/addons/streamo/js/vendor/modernizr-3.6.0.min.js') }}"></script>

        <!-- ============ Custom CSS ============ -->
        <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}" blp-theme="Light" blp-user-id="{{ Auth::user()->id }}">

        <title>
            DikiTivi / 
@if (Route::is('home_mockup'))
            @lang('miscellaneous.menu.home')
@endif
@if (Route::is('live'))
            @lang('miscellaneous.menu.live')
@endif
@if (Route::is('films.home') || Route::is('film.datas'))
            @lang('miscellaneous.menu.films')
@endif
@if (Route::is('series.home') || Route::is('series.datas') || Route::is('series.episode.datas'))
            @lang('miscellaneous.menu.series')
@endif
@if (Route::is('programmes.home') || Route::is('programme.datas'))
            @lang('miscellaneous.menu.programmes')
@endif
@if (Route::is('songs.home') || Route::is('songs.datas'))
            @lang('miscellaneous.menu.songs')
@endif
@if (Route::is('books.home') || Route::is('books.datas'))
            @lang('miscellaneous.menu.books')
@endif
        </title>
    </head>

    <body>
        <!-- Main Wrapper Start -->
        <div class="main-wrapper">
            <!-- header-medea -->
            <header class="header-medea clearfix header-sticky">
                <div class="container-fluid ">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="header-medea-inner-area">
                                <div class="left-side">
                                    <div class="logo-medea">
                                        <a href="{{ route('home_mockup') }}"><img src="{{ asset('assets/img/logo-text.png') }}" alt="" width="140"></a>
                                    </div>
                                </div>
                                <div class="right-side d-flex">
                                    <!-- search-input-box start -->
                                    <div class="search-input-box">
                                        <input type="text" placeholder="Search">
                                        <button><i class="bi bi-search"></i></button>
                                    </div>
                                    <!-- search-input-box end -->

                                    <!-- notifications start -->
                                    <div class="notifications-bar btn-group">
                                        <a href="#" class="notifications-iocn"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            <i
                                                class="zmdi zmdi-notifications"></i>
                                            <span>5</span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <h5>Notifications</h5>
                                            <ul>
                                                <li
                                                    class="single-notifications">
                                                    <a href="#">
                                                        <span class="image"><img
                                                                src="assets/images/review/author-01.png"
                                                                alt></span>
                                                        <span
                                                            class="notific-contents">
                                                            <span>Lorem ipsum
                                                                dolor sit amet
                                                                consectetur.</span>
                                                            <span
                                                                class="time">21
                                                                hours ago</span>
                                                        </span>

                                                    </a>
                                                </li>
                                                <li
                                                    class="single-notifications">
                                                    <a href="#">
                                                        <span class="image"><img
                                                                src="assets/images/review/author-01.png"
                                                                alt></span>
                                                        <span
                                                            class="notific-contents">
                                                            <span>Lorem ipsum
                                                                dolor sit amet
                                                                consectetur.</span>
                                                            <span
                                                                class="time">21
                                                                hours ago</span>
                                                        </span>

                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- notifications end -->

                                    <!-- our-profile-area start -->
                                    <div class="our-profile-area ">
                                        <a href="#" class="our-profile-pc"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            <img
                                                src="assets/images/review/author-01.png"
                                                alt>
                                        </a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li class="single-list"><a
                                                        href="my-profile.html">My
                                                        Profile</a></li>
                                                <li class="single-list"><a
                                                        href="my-account.html">My
                                                        Account</a></li>
                                                <li class="single-list"><a
                                                        href="login-and-register.html">Log
                                                        Out</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- our-profile-area end -->
                                    <div class="main-menu d-block d-lg-none">
                                        <nav class="main-navigation">
                                            <ul>
                                                <li><a href="index-3.html"><i
                                                            class="zmdi zmdi-tv-alt-play"></i>
                                                        TV Series</a></li>
                                                <li><a href="playlists.html"><i
                                                            class="zmdi zmdi-collection-music"></i>
                                                        Playlist</a></li>
                                                <li><a
                                                        href="new-arrivals.html"><i
                                                            class="zmdi zmdi-cocktail"></i>
                                                        New Arrivals</a></li>
                                                <li><a href="animation.html"><i
                                                            class="zmdi zmdi-slideshare"></i>
                                                        Animation</a></li>
                                                <li><a href="talk-show.html"><i
                                                            class="zmdi zmdi-accounts-alt"></i>
                                                        Talk Show</a></li>
                                                <li><a
                                                        href="coming-soon.html"><i
                                                            class="zmdi zmdi-spinner"></i>
                                                        Coming Soon</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- mobile-menu start -->
                                    <div
                                        class="mobile-menu menu-black d-block d-lg-none"></div>
                                    <!-- mobile-menu end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!--// header-medea -->

            <!-- side-main-menu -->
            <div class="side-main-menu">
                <nav class="sidebar-menu" data-simplebar>
                    <ul>
                        <li class="normal-item-pro">
                            <a href="index-3.html">
                                <i class="zmdi zmdi-tv-alt-play"></i>
                                <span>TV Series</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="playlists.html">
                                <i class="zmdi zmdi-collection-music"></i>
                                <span>Playlist</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="new-arrivals.html">
                                <i class="zmdi zmdi-cocktail"></i>
                                <span>New Arrivals</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="animation.html">
                                <i class="zmdi zmdi-slideshare"></i>
                                <span>Animation</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="talk-show.html">
                                <i class="zmdi zmdi-accounts-alt"></i>
                                <span>Talk Show</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="coming-soon.html">
                                <i class="zmdi zmdi-spinner"></i>
                                <span>Coming Soon</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--// side-main-menu -->

@yield('app-content')

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
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery-ui.min.js') }}"></script>
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
        <!-- Main JS -->
        <script src="{{ asset('assets/addons/streamo/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
    </body>
</html>
