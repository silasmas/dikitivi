@extends('layouts.app')

@section('app-content')

                <!-- Hero Slider start -->
                <div class="hero-slider hero-slider-three">
    @foreach ($series as $ser)
        @if ($loop->first)
                    <div class="single-slide-3 d-flex align-items-center bg-image-two bg-grey" data-bgimage="{{ $ser->cover_url }}">
                        <div class="position-absolute w-100 h-100" style="background: rgba(3, 5, 7, 0.7); z-index: 8;"></div>
                        <!-- Hero Content One Start -->
                        <div class="hero-content-three container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider-text-info position-relative" style="z-index: 9;">
                                        <h3 class="dktv-text-green"><i class="bi bi-collection-play me-2"></i>{{ $ser->type->type_name }}</h3>
                                        <h1 class="dktv-text-yellow">{{ $ser->media_title }}</h1>
                                        <p style="color: #fff!important">{{ Str::limit($ser->media_description, 100, '...') }}</p>
                                        <div class="slider-button">
                                            <a href="{{ route('series.datas', ['id' => $ser->id]) }}" class="default-btn dktv-btn-blue mr--10 rounded-pill">@lang('miscellaneous.see_more')</a>
            @if ($ser->teaser_url != null)
                                            <a href="#Video-one" class="video-play-btn afterglow ml--10">
                                                <i class="zmdi zmdi-play"></i>
                                            </a>
                                            <video id="Video-one" width="960" height="540">
                                                <source src="{{ $ser->teaser_url }}" type="video/*">
                                            </video>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hero Content One End -->
                    </div>
        @endif
    @endforeach
    @foreach ($albums as $alb)
        @if ($loop->first)
                    <div class="single-slide-3 d-flex align-items-center bg-image-two bg-grey" data-bgimage="{{ $alb->cover_url }}">
                        <div class="position-absolute w-100 h-100" style="background: rgba(3, 5, 7, 0.7); z-index: 8;"></div>
                        <!-- Hero Content One Start -->
                        <div class="hero-content-three container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="slider-text-info position-relative" style="z-index: 9;">
                                        <h3 class="dktv-text-yellow"><i class="bi bi-music-note-list me-2"></i>{{ $alb->type->type_name }}</h3>
                                        <h1 class="dktv-text-blue">{{ $alb->media_title }}</h1>
                                        <p style="color: #fff!important">{{ Str::limit($alb->media_description, 100, '...') }}</p>
                                        <div class="slider-button">
                                            <a href="{{ route('song.datas', ['id' => $alb->id]) }}" class="default-btn dktv-btn-green mr--10 rounded-pill">@lang('miscellaneous.see_more')</a>
            @if ($alb->teaser_url != null)
                                            <a href="#Video-one" class="video-play-btn afterglow ml--10">
                                                <i class="zmdi zmdi-play"></i>
                                            </a>
                                            <video id="Video-one" width="960" height="540">
                                                <source src="{{ $alb->teaser_url }}" type="video/*">
                                            </video>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hero Content One End -->
                    </div>
        @endif
    @endforeach
                </div>
                <!-- Hero Slider end -->

@endsection
