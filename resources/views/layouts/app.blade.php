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
        <link rel="stylesheet" id="custom-style" href="{{ asset('assets/addons/streamo/css/style.css') }}">

        <!-- ============ Custom CSS ============ -->
        <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <style>
<?php
if (request()->has('app_id')) {
?>
            .detect-webview { display: none;!important }
<?php
}
?>
            .mobile-menu { color: #a0a0a0; }
            @media only screen (max-width: 900px) {
                .header-medea-inner-area { padding: 30px 80px; }
            }
            #notifIcon i { color: inherit!important; }
        </style>

        <!-- ============ Modernizer JS ============ -->
        <script src="{{ asset('assets/addons/streamo/js/vendor/modernizr-3.6.0.min.js') }}"></script>

        <title>
@if (!empty($current_media))
            {{ $current_media->media_title }}
@else
            DikiTivi / 
    @if (Route::is('home'))
            @lang('miscellaneous.menu.home')
    @endif
    @if (Route::is('account'))
            @lang('miscellaneous.menu.account')
    @endif
    @if (Route::is('account.entity') || Route::is('account.entity.datas'))
            {{ $entity_title }}
    @endif
    @if (Route::is('live.home'))
            @lang('miscellaneous.menu.live')
    @endif
    @if (Route::is('films.home'))
            @lang('miscellaneous.menu.films')
    @endif
    @if (Route::is('series.home'))
            @lang('miscellaneous.menu.series')
    @endif
    @if (Route::is('programs.home'))
            @lang('miscellaneous.menu.programs')
    @endif
    @if (Route::is('programs.entity.home'))
            {{ $entity_title }}
    @endif
    @if (Route::is('songs.home'))
            @lang('miscellaneous.menu.songs')
    @endif
    @if (Route::is('books.home') || Route::is('books.datas'))
            @lang('miscellaneous.menu.books')
    @endif
    @if (Route::is('dona'))
            @lang('miscellaneous.menu.books')
    @endif
@endif
        </title>
    </head>

    <body>
        <!-- MODALS-->
@if (Route::is('account') || Route::is('account.entity') || Route::is('account.entity.datas'))
        <!-- ### Add a child ### -->
        <div class="modal fade" id="registerModalChild" tabindex="-1" aria-labelledby="registerModalChildLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="registerModalChildLabel">{{ __('miscellaneous.account.child.add') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('account.entity', ['entity' => 'children']) }}">
    @csrf

                            <!-- First name -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" required />
                                <label class="form-label" for="register_firstname">@lang('miscellaneous.firstname')</label>
                            </div>

                            <!-- Last name -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" />
                                <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                            </div>

                            <!-- Birth date -->
                            <div class="form-floating mt-sm-0 mt-2">
                                <input type="text" name="register_birth_date" id="register_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" />
                                <label class="form-label" for="register_birthdate">@lang('miscellaneous.birth_date.label')</label>
                            </div>

                            <!-- Gender -->
                            <div class="mt-3 text-center">
                                <p class="mb-lg-1 mb-0">@lang('miscellaneous.gender_title')</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="register_gender" id="male" value="M">
                                    <label class="form-check-label" for="male">@lang('miscellaneous.gender1')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="register_gender" id="female" value="F">
                                    <label class="form-check-label" for="female">@lang('miscellaneous.gender2')</label>
                                </div>
                            </div>

                            <div id="profileImageWrapper" class="row mt-3">
                                <div class="col-sm-7 col-9 mx-auto">
                                    <p class="small mb-1 text-center">@lang('miscellaneous.account.child.click_to_change_picture')</p>

                                    <div class="bg-image hover-overlay">
                                        <img src="{{ asset('assets/img/user.png') }}" alt="" class="other-user-image img-fluid rounded-4">
                                        <div class="mask rounded-4" style="background-color: rgba(5, 5, 5, 0.5);">
                                            <label role="button" for="image_profile" class="d-flex h-100 justify-content-center align-items-center">
                                                <i class="bi bi-pencil-fill text-white fs-2"></i>
                                                <input type="file" name="image_profile" id="image_profile" class="d-none">
                                            </label>
                                            <input type="hidden" name="data_profile" id="data_profile">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mt-3">
                                <div class="col-sm-6">
                                    <button class="btn dktv-btn-blue btn-block rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-light btn-block border rounded-pill" data-bs-dismiss="modal">@lang('miscellaneous.cancel')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### Crop user image ### -->
        <div class="modal fade" id="cropModalUser" tabindex="-1" aria-labelledby="cropModalUserLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="cropModalUserLabel">{{ __('miscellaneous.crop_before_save') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-sm-0 mb-4">
                                    <div class="bg-image">
                                        <img src="" id="retrieved_image" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light border rounded-pill" data-bs-dismiss="modal">@lang('miscellaneous.cancel')</button>
                        <button type="button" id="crop_avatar" class="btn dktv-btn-blue rounded-pill"data-bs-dismiss="modal">{{ __('miscellaneous.register') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### Crop other user image ### -->
        <div class="modal fade" id="cropModal_profile" tabindex="-1" aria-labelledby="cropModal_profileLabel" aria-hidden="true" data-bs-backdrop="{{ Route::is('branch.home') ? 'static' : 'true' }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="cropModal_profileLabel">{{ __('miscellaneous.crop_before_save') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-sm-0 mb-4">
                                    <div class="bg-image">
                                        <img src="" id="retrieved_image_profile" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light border rounded-pill" data-bs-dismiss="modal">@lang('miscellaneous.cancel')</button>
                        <button type="button" id="crop_profile" class="btn dktv-btn-green rounded-pill" data-bs-dismiss="modal">{{ __('miscellaneous.register') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### Crop recto image ### -->
        <div class="modal fade" id="cropModal_recto" tabindex="-1" aria-labelledby="cropModalRectoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="cropModalRectoLabel">{{ __('miscellaneous.crop_before_save') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-sm-0 mb-4">
                                    <div class="bg-image">
                                        <img src="" id="retrieved_image_recto" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light border border-default shadow-0" data-bs-dismiss="modal">{{ __('miscellaneous.cancel') }}</button>
                        <button type="button" id="crop_recto" class="btn dktv-btn-blue btn-color shadow-0" data-bs-dismiss="modal">{{ __('miscellaneous.register') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### Crop verso image ### -->
        <div class="modal fade" id="cropModal_verso" tabindex="-1" aria-labelledby="cropModalVersoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="cropModalVersoLabel">{{ __('miscellaneous.crop_before_save') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-sm-0 mb-4">
                                    <div class="bg-image">
                                        <img src="" id="retrieved_image_verso" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light border border-default shadow-0" data-bs-dismiss="modal">{{ __('miscellaneous.cancel') }}</button>
                        <button type="button" id="crop_verso" class="btn dktv-btn-blue btn-color shadow-0" data-bs-dismiss="modal">{{ __('miscellaneous.register') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODALS-->
@endif

        <span class="d-none perfect-scrollbar"></span>
        <!-- Main Wrapper Start -->
        <div class="main-wrapper">
            <!-- header-medea -->
            <header class="header-medea clearfix header-sticky">
                <div class="container-fluid">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="header-medea-inner-area px-2 py-3">
                                <div class="left-side">
                                    <div class="logo-medea">
                                        <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo-text.png') }}" alt="" width="140"></a>
                                    </div>
                                </div>
                                <div class="right-side d-flex">
                                    <!-- search-input-box start -->
                                    <div class="search-input-box">
                                        <input type="text" placeholder="Search">
                                        <button><i class="bi bi-search"></i></button>
                                    </div>
                                    <!-- search-input-box end -->

@if (Auth::check())
                                    <!-- notifications start -->
                                    <div class="notifications-bar btn-group shadow-0">
                                        <a href="#" class="notifications-iocn shadow-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="zmdi zmdi-notifications"></i>
    @if (count($unread_notifications) > 0)
                                            <span style="color: #fff!important;">{{ count($unread_notifications) }}</span>
    @endif
                                        </a>
    @if (count($unread_notifications) > 0)
                                        <div class="dropdown-menu">
                                            <div>
                                                <a role="button" class="float-end position-relative" style="top: -6px;" title="@lang('miscellaneous.mark_all_read')" data-bs-toggle="tooltip">
                                                    <i style="color: #555!important;" class="bi bi-circle"></i>
                                                </a>
                                                <h5 style="color: #333!important;">@lang('miscellaneous.menu.notifications')</h5>
                                            </div>
                                            <ul>
        @forelse ($unread_notifications as $notif)
            @if ($loop->index < 4)
                                                <li class="single-notifications pb-2 border-bottom" style="border-color: #d4d4d4!important;">
                                                    <a href="{{ $notif->notification_url }}">
                                                        <span id="notifIcon">
                                                            <i style="color: #555!important;" class="{{ $notif->icon }} fs-4"></i>
                                                        </span>
                                                        <span class="notific-contents">
                                                            <span style="color: #555!important; font-weight: {{ $notif->status->id == 12 ? 'normal' : 'bold' }}!important;" data-bs-toggle="tooltip">
                                                                {{ Str::limit($notif->notification_content, 46, '...') }}
                                                            </span>
                                                            <span class="time small" style="color: #aaa!important;">{{ $notif->created_at }}</span>
                                                        </span>
                                                    </a>
                                                </li>
            @endif
        @empty
        @endforelse
                                            </ul>
                                            <p class="m-0 pt-2 pb-0 text-center">
                                                <a href="{{ route('notification.home') }}" class="small dktv-text-blue">@lang('miscellaneous.see_all_notifications')</a>
                                            </p>
                                        </div>
    @endif
                                    </div>
                                    <!-- notifications end -->

                                    <!-- our-profile-area start -->
                                    <div class="our-profile-area ">
                                        <a href="#" class="our-profile-pc" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{ $current_user->avatar_url }}" alt="{{ $current_user->firstname . ' ' . $current_user->lastname }}" width="37" class="user-image rounded-circle">
                                        </a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li class="single-list">
                                                    <a href="{{ route('account') }}">@lang('miscellaneous.menu.account')</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="{{ route('account.entity', ['entity' => 'watchlist']) }}">@lang('miscellaneous.account.watchlist')</a>
                                                </li>
                                                <li class="single-list">
                                                    <a href="{{ route('account.entity', ['entity' => 'parental_control']) }}">@lang('miscellaneous.account.parental_control')</a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li class="single-list">
                                                    <a href="{{ route('logout') }}">@lang('miscellaneous.logout')</a>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li id="themeToggler" class="d-flex justify-content-between" aria-label="Theme toggler">
                                                    <a role="button" class="btn bg-transparent light"><i class="bi bi-sun"></i></a>
                                                    <a role="button" class="btn bg-transparent dark"><i class="bi bi-moon-fill"></i></a>
                                                    <a role="button" class="btn bg-transparent auto"><i class="bi bi-circle-half"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- our-profile-area end -->
@else

                                    <!-- for-youth settings start -->
                                    <div title="@lang('miscellaneous.change')">
                                        <a class="btn bg-transparent text-muted ms-3 px-3 rounded-pill shadow-0 dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    @if ($for_youth == 1)
                                            <i class="bi bi-person-down d-sm-none d-inline-block fs-3 align-middle"></i>
                                            <pan class="d-sm-inline-block d-none">@lang('miscellaneous.public.home.hero.link2')</pan>
    @endif
    @if ($for_youth == 0)
                                            <i class="bi bi-person-up d-sm-none d-inline-block fs-3 align-middle"></i>
                                            <pan class="d-sm-inline-block d-none">@lang('miscellaneous.public.home.hero.link1')</pan>
    @endif
                                        </a>

                                        <div class="dropdown-menu rounded-0">
                                            <ul>
                                                <li class="dropdown-item">
                                                    <a href="{{ route('choose_age', ['for_youth' => 1]) }}">
                                                        <i class="bi bi-person-down d-sm-none d-inline-block fs-3" style="vertical-align: -3px;"></i>@lang('miscellaneous.public.home.hero.link2')
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="{{ route('choose_age', ['for_youth' => 0]) }}">
                                                        <i class="bi bi-person-up d-sm-none d-inline-block fs-3" style="vertical-align: -3px;"></i>@lang('miscellaneous.public.home.hero.link1')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- for-youth settings end -->

                                    <!-- theme toggler start -->
                                    <div title="@lang('miscellaneous.toggle_theme')">
                                        <a role="button" id="dropdownTheme" class="btn bg-transparent text-muted border btn-sm dropdown-toggle py-1 px-2 hidden-arrow shadow-0" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-circle-half align-middle"></i>
                                        </a>
                    
                                        <div class="dropdown-menu" aria-labelledby="dropdownTheme">
                                            <ul id="themeToggler">
                                                <li role="button" class="dropdown-item light">
                                                    <a>
                                                        <i class="bi bi-sun me-2 fs-5" style="vertical-align: -3px;"></i>@lang('miscellaneous.theme.light')
                                                    </a>
                                                </li>
                                                <li role="button" class="dropdown-item dark">
                                                    <a>
                                                        <i class="bi bi-moon-fill me-2 fs-5" style="vertical-align: -3px;"></i>@lang('miscellaneous.theme.dark')
                                                    </a>
                                                </li>
                                                <li role="button" class="dropdown-item auto">
                                                    <a>
                                                        <i class="bi bi-circle-half me-2 fs-5" style="vertical-align: -3px;"></i>@lang('miscellaneous.theme.auto')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- theme toggler end -->
@endif
                                    <div class="main-menu d-block d-lg-none">
                                        <nav class="main-navigation">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('live.home') }}">
                                                        <i class="bi bi-broadcast"></i> @lang('miscellaneous.menu.live')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('films.home') }}">
                                                        <i class="bi bi-film"></i> @lang('miscellaneous.menu.films')
                                                    </a></li>
                                                <li>
                                                    <a href="{{ route('series.home') }}">
                                                        <i class="bi bi-collection-play"></i> @lang('miscellaneous.menu.series')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('programs.home') }}">
                                                        <i class="bi bi-camera-reels"></i> @lang('miscellaneous.menu.programs')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('programs.entity.home', ['entity' => 'preach']) }}">
                                                        <i class="bi bi-mic"></i> @lang('miscellaneous.menu.preach')
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('songs.home') }}">
                                                        <i class="bi bi-music-note-list"></i> @lang('miscellaneous.menu.songs')
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <!-- mobile-menu start -->
                                    <div class="mobile-menu d-block d-lg-none"></div>
                                    <!-- mobile-menu end -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!--// header-medea -->
@if (\Session::has('success_message'))

            <!-- Alert Start -->
            <div class="position-relative">
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 1rem; z-index: 999;">
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
@if (\Session::has('error_message'))

            <!-- Alert Start -->
            <div class="position-relative">
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 1rem; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {!! preg_match('/~/', \Session::get('error_message')) ? explode('-', explode('~', \Session::get('error_message'))[0])[1] : \Session::get('error_message') !!}
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
                <div class="row position-fixed w-100" style="opacity: 0.9;  top: 1rem; z-index: 999;">
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

            <!-- side-main-menu -->
            <div class="side-main-menu">
                <nav class="sidebar-menu" data-simplebar>
                    <!-- donation start -->
                    <a href="{{ route('donation') }}" class="btn dktv-btn-pink w-100 mb-1 rounded" style="margin-bottom: 0.2rem;">
                        <is class="bi bi-heart-fill me-2 fs-5" style="vertical-align: -2px;"></is>
                        <pan>@lang('miscellaneous.menu.donate')</pan>
                    </a>
                    <!-- donation end -->

                    <ul>
                        <li class="normal-item-pro">
                            <a href="{{ route('live.home') }}">
                                <i class="bi bi-broadcast fs-3"></i>
                                <span>@lang('miscellaneous.menu.live')</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="{{ route('programs.entity.home', ['entity' => 'preach']) }}">
                                <i class="bi bi-mic fs-3"></i>
                                <span>@lang('miscellaneous.menu.preach')</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="{{ route('films.home') }}">
                                <i class="bi bi-film fs-3"></i>
                                <span>@lang('miscellaneous.menu.films')</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="{{ route('series.home') }}">
                                <i class="bi bi-collection-play fs-3"></i>
                                <span>@lang('miscellaneous.menu.series')</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="{{ route('programs.home') }}">
                                <i class="bi bi-camera-reels fs-3"></i>
                                <span>@lang('miscellaneous.menu.programs')</span>
                            </a>
                        </li>
                        <li class="normal-item-pro">
                            <a href="{{ route('songs.home') }}">
                                <i class="bi bi-music-note-list fs-3"></i>
                                <span>@lang('miscellaneous.menu.songs')</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--// side-main-menu -->

            <!-- Page Conttent -->
            <main class="page-content-wrapper">
@yield('app-content')

                <!-- Footer Area -->
                <footer class="footer-area detect-webview">
                    {{-- <div class="footer-top-tow bg-image-two" data-bgimage="{{ asset('assets/img/transit/footer-bg-02.jpg') }}"> --}}
                    <div class="footer-top-tow dktv-bg-blue">
                        <div class="container px-sm-5">
                            <div class="row">
                                <div class="col-custom-4 mt--50">
                                    <!-- footer-widget -->
                                    <div class="footer-widget">
                                        <h4 class="footer-widget-title">@lang('miscellaneous.public.about.title')</h4>
                                        <div class="footer-contet">
                                            <p style="color: #fff!important;">@lang('miscellaneous.public.about.description')</p>
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
@empty(Auth::check())
                                                <li><a href="{{ route('login') }}" class="text-light">@lang('miscellaneous.login_title1')</a></li>
                                                <li><a href="{{ route('register') }}" class="text-light">@lang('miscellaneous.register_title1')</a></li>
@endempty
                                                <li><a href="{{ route('about') }}" class="text-light">@lang('miscellaneous.menu.about')</a></li>
                                                <li><a href="{{ route('about.entity', ['entity' => 'contact']) }}" class="text-light">@lang('miscellaneous.menu.contact')</a></li>
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
                                    <p class="copyright-text" style="color: #fff!important;">Copyright &copy; {{ date('Y') }} @lang('miscellaneous.all_right_reserved')</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul class="footer-bottom-list">
                                        <li><a href="{{ route('about.entity', ['entity' => 'term_of_use']) }}" class="text-light">@lang('miscellaneous.menu.terms_of_use')</a></li>
                                        <li><a href="{{ route('about.entity', ['entity' => 'privacy_policy']) }}" class="text-light">@lang('miscellaneous.menu.privacy_policy')</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!--// Footer Area -->
            </main>
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
        <script src="{{ asset('assets/js/script.js') }}"></script>
@if (Route::is('media.datas'))
        <script>
            // Load the IFrame Player API code asynchronously.
            var tag = document.createElement('script');

            tag.src = "https://www.youtube.com/player_api";

            var firstScriptTag = document.getElementsByTagName('script')[0];

            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            // Replace the 'ytplayer' element with an <iframe> and YouTube player after the API code downloads.
            var player;

            function onYouTubePlayerAPIReady() {
                player = new YT.Player('ytplayer', {
                    // height: '',
                    // width: '',
                    // videoId: '',
                    playerVars: {
                        rel: 0,
                        autoplay: 0,
                        autohide: 1,
                        iv_load_policy: 3,
                        modestbranding: 1,
                        showinfo: 0,
                        showsearch: 0
                    }
                });
            }
        </script>
@endif
    </body>
</html>
