<?php $slides_data = array_merge((array_slice($lives, 0, 2)), (array_slice($series, 0, 2)), (array_slice($albums, 0, 2))) ?>
@extends('layouts.app')

@section('app-content')

                <!-- Hero Slider start -->
                <div class="hero-slider hero-slider-three">
    @if (count($slides_data) > 0)
        @foreach ($slides_data as $media)
{{ dd($media['type']->type_name) }}
                    <div class="single-slide-3 d-flex align-items-center bg-image-two bg-grey" data-bgimage="{{ $media->cover_url }}">
                        <div class="position-absolute w-100 h-100" style="background: rgba(3, 5, 7, 0.7); z-index: 8;"></div>
                        <!-- Hero Content One Start -->
                        <div class="hero-content-three container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider-text-info position-relative" style="z-index: 9;">
                                        <h3 class="text-muted"><i class="bi bi-camera-reels me-2"></i>{{ $media->type->type_name }}</h3>
                                        <h1 class="dktv-text-green" title="{{ $media->media_title }}">{{ Str::limit($media->media_title, 14, '...') }}</h1>
                                        <p style="color: #fff!important">{{ Str::limit($media->media_description, 140, '...') }}</p>
                                        <div class="slider-button">
                                            <a href="{{ route('media.datas', ['id' => $media->id]) }}" class="default-btn dktv-btn-yellow mr--10 rounded-pill">@lang('miscellaneous.see_more')</a>
            @if ($media->teaser_url != null)
                                            <a href="#Video-one" class="video-play-btn afterglow ml--10">
                                                <i class="zmdi zmdi-play"></i>
                                            </a>
                                            <video id="Video-one" width="960" height="540">
                                                <source src="{{ $media->teaser_url }}" type="video/*">
                                            </video>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hero Content One End -->
                    </div>
        @endforeach
    @else
                    <div class="single-slide-3 d-flex align-items-center bg-image-two bg-grey" data-bgimage="assets/img/blank-media-slider-01.png">
                        <div class="position-absolute w-100 h-100" style="background: rgba(3, 5, 7, 0.7); z-index: 8;"></div>
                        <!-- Hero Content One Start -->
                        <div class="hero-content-three container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider-text-info position-relative" style="z-index: 9;">
                                        <h1 class="dktv-text-green">@lang('miscellaneous.public.home.trends.title')</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hero Content One End -->
                    </div>
    @endif
                </div>
                <!-- Hero Slider end -->

                <!-- Our-product-area Area  -->
                <div class="our-product-area pt-5 pb-0">
                    <div class="container-coustom">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-3">
                                    <h2>@lang('miscellaneous.public.home.trends.title')</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row product-carousl-active">
    @if (count($trends) > 0)
        @foreach ($trends as $med)
<?php
// Views & Likes for a media
// $views = $api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $med->id);
// $likes = $api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $med->id);
?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap -->
                                <div class="single-product-wrap mt--15">
                                    <div class="product-image">
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $med->media_title }}">
            @if (!empty($med->thumbnail_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->thumbnail_url }}) no-repeat center center; background-size: cover;"></div>
            @endif
                                        </a>
                                    </div>
                                    <div class="product-contents">
                                        <h4><a href="{{ route('media.datas', ['id' => $med->id]) }}" class="d-block text-truncate" title="{{ $med->media_title }}">{{ $med->media_title }}</a></h4>
                                        <div class="pro-quality">
                                            {{-- <span>
                                                <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ thousandsCurrencyFormat(count($views->data)) }}
                                                <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ thousandsCurrencyFormat(count($likes->data)) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--// single-product-wrap -->        
                            </div>
        @endforeach
    @else
                            <div class="col-12">
                                <p class="lead">@lang('miscellaneous.empty_list')</p>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

                <!-- Our-product-area Area  -->
                <div class="our-product-area pt-5 pb-0">
                    <div class="container-coustom">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-3">
                                    <h2>@lang('miscellaneous.public.home.lives.title')</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row product-carousl-active">
    @if (count($lives) > 0)
        @foreach ($lives as $med)
<?php
// Views & Likes for a media
// $views = $api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $med->id);
// $likes = $api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $med->id);
?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap -->
                                <div class="single-product-wrap mt--15">
                                    <div class="product-image">
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $med->media_title }}">
            @if (!empty($med->thumbnail_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->thumbnail_url }}) no-repeat center center; background-size: cover;"></div>
            @endif
                                        </a>
                                    </div>
                                    <div class="product-contents">
                                        <h4><a href="{{ route('media.datas', ['id' => $med->id]) }}" class="d-block text-truncate" title="{{ $med->media_title }}">{{ $med->media_title }}</a></h4>
                                        <div class="pro-quality">
                                            {{-- <span>
                                                <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ thousandsCurrencyFormat(count($views->data)) }}
                                                <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ thousandsCurrencyFormat(count($likes->data)) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--// single-product-wrap -->        
                            </div>
        @endforeach
    @else
                            <div class="col-12">
                                <p class="lead">@lang('miscellaneous.empty_list')</p>
                            </div>
    @endif

                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

                <!-- Our-product-area Area  -->
                <div class="our-product-area pt-5 pb-0">
                    <div class="container-coustom">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-3">
                                    <h2>@lang('miscellaneous.public.home.films.title')</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row product-carousl-active">
    @if (count($films) > 0)
        @foreach ($films as $med)
<?php
// Views & Likes for a media
// $views = $api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $med->id);
// $likes = $api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $med->id);
?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap -->
                                <div class="single-product-wrap mt--15">
                                    <div class="product-image">
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $med->media_title }}">
            @if (!empty($med->thumbnail_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->thumbnail_url }}) no-repeat center center; background-size: cover;"></div>
            @endif
                                        </a>
                                    </div>
                                    <div class="product-contents">
                                        <h4><a href="{{ route('media.datas', ['id' => $med->id]) }}" class="d-block text-truncate" title="{{ $med->media_title }}">{{ $med->media_title }}</a></h4>
                                        <div class="pro-quality">
                                            {{-- <span>
                                                <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ thousandsCurrencyFormat(count($views->data)) }}
                                                <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ thousandsCurrencyFormat(count($likes->data)) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--// single-product-wrap -->        
                            </div>
        @endforeach
    @else
                            <div class="col-12">
                                <p class="lead">@lang('miscellaneous.empty_list')</p>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

                <!-- Our-product-area Area  -->
                <div class="our-product-area pt-5 pb-0">
                    <div class="container-coustom">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-3">
                                    <h2>@lang('miscellaneous.public.home.series.title')</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row product-carousl-active">
    @if (count($series) > 0)
        @foreach ($series as $med)
<?php
// Views & Likes for a media
// $views = $api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $med->id);
// $likes = $api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $med->id);
?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap -->
                                <div class="single-product-wrap mt--15">
                                    <div class="product-image">
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $med->media_title }}">
            @if (!empty($med->thumbnail_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->thumbnail_url }}) no-repeat center center; background-size: cover;"></div>
            @endif
                                        </a>
                                    </div>
                                    <div class="product-contents">
                                        <h4><a href="{{ route('media.datas', ['id' => $med->id]) }}" class="d-block text-truncate" title="{{ $med->media_title }}">{{ $med->media_title }}</a></h4>
                                        <div class="pro-quality">
                                            {{-- <span>
                                                <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ thousandsCurrencyFormat(count($views->data)) }}
                                                <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ thousandsCurrencyFormat(count($likes->data)) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--// single-product-wrap -->        
                            </div>
        @endforeach
    @else
                            <div class="col-12">
                                <p class="lead">@lang('miscellaneous.empty_list')</p>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

                <!-- Our-product-area Area  -->
                <div class="our-product-area pt-5 pb-0">
                    <div class="container-coustom">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-3">
                                    <h2>@lang('miscellaneous.public.home.programs.title')</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row product-carousl-active">
    @if (count($programs) > 0)
        @foreach ($programs as $med)
<?php
// Views & Likes for a media
// $views = $api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $med->id);
// $likes = $api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $med->id);
?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap -->
                                <div class="single-product-wrap mt--15">
                                    <div class="product-image">
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $med->media_title }}">
            @if (!empty($med->thumbnail_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->thumbnail_url }}) no-repeat center center; background-size: cover;"></div>
            @endif
                                        </a>
                                    </div>
                                    <div class="product-contents">
                                        <h4><a href="{{ route('media.datas', ['id' => $med->id]) }}" class="d-block text-truncate" title="{{ $med->media_title }}">{{ $med->media_title }}</a></h4>
                                        <div class="pro-quality">
                                            {{-- <span>
                                                <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ thousandsCurrencyFormat(count($views->data)) }}
                                                <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ thousandsCurrencyFormat(count($likes->data)) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--// single-product-wrap -->        
                            </div>
        @endforeach
    @else
                            <div class="col-12">
                                <p class="lead">@lang('miscellaneous.empty_list')</p>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

                <!-- Our-product-area Area  -->
                <div class="our-product-area py-5">
                    <div class="container-coustom">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-title-3">
                                    <h2>@lang('miscellaneous.public.home.songs.title')</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row product-carousl-active">
    @if (count($songs) > 0)
        @foreach ($songs as $med)
<?php
// Views & Likes for a media
// $views = $api_client_manager::call('GET', getApiURL() . '/media/find_views/' . $med->id);
// $likes = $api_client_manager::call('GET', getApiURL() . '/media/find_likes/' . $med->id);
?>
                            <div class="col-lg-3">
                                <!-- single-product-wrap -->
                                <div class="single-product-wrap mt--15">
                                    <div class="product-image">
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $med->media_title }}">
            @if (!empty($med->thumbnail_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->thumbnail_url }}) no-repeat center center; background-size: cover;"></div>
            @endif
                                        </a>
                                    </div>
                                    <div class="product-contents">
                                        <h4><a href="{{ route('media.datas', ['id' => $med->id]) }}" class="d-block text-truncate" title="{{ $med->media_title }}">{{ $med->media_title }}</a></h4>
                                        <div class="pro-quality">
                                            {{-- <span>
                                                <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ thousandsCurrencyFormat(count($views->data)) }}
                                                <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ thousandsCurrencyFormat(count($likes->data)) }}
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <!--// single-product-wrap -->        
                            </div>
        @endforeach
    @else
                            <div class="col-12">
                                <p class="lead">@lang('miscellaneous.empty_list')</p>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

@endsection
