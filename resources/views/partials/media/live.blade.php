@extends('layouts.app')

@section('app-content')

    @if (count($lives) > 0)
                <!-- slider area start -->
                <div class="slider-area bg-black">
                    <div class="container-fluid p-0">
                        <div class="series-slider-active nav-style-1">
        @foreach ($lives as $media)
            @if ($loop->index < 2)
                            <div class="single-hero-img-2">
                                <a href="{{ route('media.datas', ['id' => $media->id]) }}">
                                    <img src="{{ asset('assets/img/blank-media-slider-01.png') }}" alt="{{ $media->media_title }}">
                @if (!empty($media->cover_url))
                                    <div class="position-absolute w-100 h-100" style="top: 0; background: transparent url({{ $media->cover_url }}) no-repeat center center; background-size: cover;"></div>
                @endif
                                    <div class="position-absolute w-100 pt-3" style="bottom: 0; background-image: linear-gradient(to bottom, rgba(255,0,0,0), rgba(0,0,0,0.5));">
                                        <h4 class="px-5 text-center text-white fw-bold">{{ $media->media_title }}</h4>
                                    </div>
                                </a>
                            </div>
            @endif
        @endforeach
                        </div>
                    </div>
                </div>
                <!--// slider area end  -->
    @endif

                <!-- movies list start  -->
                <div class="movie-list section-padding-lr section-pt-50 section-pb-50">
                    <div class="container-fluid">
                        <div class="row">
    @forelse ($lives as $media)
                            <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                <div class="movie-wrap text-center mb-30">
                                    <div class="movie-img">
                                        <a href="{{ route('media.datas', ['id' => $media->id]) }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $media->media_title }}">
        @if (!empty($med->cover_url))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $med->cover_url }}) no-repeat right top; background-size: cover;"></div>
        @endif
                                        </a>
                                        <button title="@lang('miscellaneous.public.add_watchlist')" class="Watch-list-btn" type="button"><i class="zmdi zmdi-plus"></i></button> 
                                    </div>
                                    <div class="movie-content">
                                        <h3 class="title mb-2"><a href="{{ route('media.datas', ['id' => $media->id]) }}l">{{ Str::limit($media->media_title, 19, '...') }}</a></h3>
                                        <div class="movie-btn">
                                            <a href="{{ route('media.datas', ['id' => $media->id]) }}" class="btn-style-hm4-2 animated">@lang('miscellaneous.public.watch_now')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
    @empty
    @endforelse

    @if ($lastPage > 1)
                            <div class="pagination-style mt-30">
                                <ul>
                                    <li><a class="prev{{ !request()->has('page') || request()->get('page') == 1 ? ' d-none' : '' }}" href="?page=1"><i class="zmdi zmdi-chevron-left"></i></a></li>
        @for ($i = 1; $i <= $lastPage; $i++)
            @if (!request()->has('page') || request()->get('page') == 1)
                                    <li><a class="active" href="?page={{ $i }}">{{ $i }}</a></li>
            @else
                                    <li><a class="{{ request()->has('page') && request()->get('page') == $lastPage ? 'active' : '' }}" href="?page={{ $i }}">{{ $i }}</a></li>
            @endif
        @endfor
                                    <li><a class="next{{ !request()->has('page') || request()->get('page') == $lastPage ? ' d-none' : '' }}" href="?page={{ $lastPage }}"><i class="zmdi zmdi-chevron-right"></i></a></li>
                                </ul>
                            </div>
    @endif
                        </div>
                    </div>
                </div>
                <!--// movies list end  -->
    
@endsection
