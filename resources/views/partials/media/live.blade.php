<?php $lastPage = $lastPage_lives ?>
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
                                <a href="{{ route('media.datas', ['id' => $media['id']]) }}" title="{{ $media['media_title'] }}">
                                    <img src="{{ asset('assets/img/blank-media-slider-01.png') }}" alt="{{ $media['media_title'] }}">
                @if (!empty($media['cover_url']))
                                    <div class="position-absolute w-100 h-100" style="top: 0; background: transparent url({{ $media['cover_url'] }}) no-repeat center center; background-size: cover;"></div>
                @endif
                                    <div class="position-absolute w-100 pt-3" style="bottom: 0; background-image: linear-gradient(to bottom, rgba(255,0,0,0), rgba(0,0,0,0.5));">
                                        <h4 class="px-5 text-center text-white fw-bold">{{ $media['media_title'] }}</h4>
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
                                        <a href="{{ route('media.datas', ['id' => $media['']id]) }}" title="{{ $media['media_title'] }}">
                                            <img src="{{ asset('assets/img/blank-media-cover.png') }}" alt="{{ $media['media_title'] }}">
        @if (!empty($media['thumbnail_url']))
                                            <div class="position-absolute w-100 h-100" style="top: 0; right: 0; background: transparent url({{ $media['thumbnail_url'] }}) no-repeat center center; background-size: cover;"></div>
        @endif
                                        </a>
        @if (Auth::check())
                                        <button title="{{ inArrayR($media['id'], $watchlist->orders, 'media_id') ? __('miscellaneous.public.withdraw_watchlist') : __('miscellaneous.public.add_watchlist') }}" class="Watch-list-btn{{ inArrayR($media['id'], $watchlist->orders, 'media_id') ? ' dktv-btn-green' : '' }}" type="button" data-status="{{ inArrayR($media['id'], $watchlist->orders, 'media_id') ? 'added' : 'withdrawn' }}" data-watchlist-id="{{ $watchlist->id }}" onclick="event.preventDefault(); toggleAction(this, {{ $media['id'] }}, 'watchlist');">
                                            <i class="zmdi zmdi-{{ inArrayR($media['id'], $watchlist->orders, 'media_id') ? 'check' : 'plus' }}"></i>
                                        </button>
        @else
                                        <button title="@lang('miscellaneous.public.add_watchlist')" class="Watch-list-btn" type="button" onclick="event.preventDefault(); window.location.replace('{{ route('login') }}');">
                                            <i class="zmdi zmdi-plus"></i>
                                        </button>
        @endif
                                    </div>
                                    <div class="movie-content">
                                        <h3 class="title mb-2"><a href="{{ route('media.datas', ['id' => $media['id']]) }}l">{{ Str::limit($media['media_title'], 20, '...') }}</a></h3>
                                        <div class="movie-btn">
                                            <a href="{{ route('media.datas', ['id' => $media['id']]) }}" class="btn-style-hm4-2 animated">@lang('miscellaneous.public.watch_now')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
    @empty
                            <div class="col-12 justify-content-center text-center">
                                <h1 class="display-1 dktv-text-green"><i class="bi bi-exclamation-circle"></i></h1>
                                <h4 class="text-muted">@lang('miscellaneous.empty_list')</h4>
                            </div>
    @endforelse
                        </div>

    @include('partials.pagination')
                    </div>
                </div>
                <!--// movies list end  -->
    
@endsection
