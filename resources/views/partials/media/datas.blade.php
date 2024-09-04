{{-- {{ dd($other_medias) }} --}}
@extends('layouts.app')

@section('app-content')

                <!-- Our-product-area Area  -->
                <div class="movie-details-wrap section-pb-50">
                    <div class="container-sm container-fluid">
                        <div class="row mb-3 d-sm-inline-block d-none">
                            <div class="col-12">
    @switch($current_media->type->type_name)
        @case(__('miscellaneous.media_types.feature_film'))
                                <a href="{{ route('films.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.film')</a>
            @break
        @case(__('miscellaneous.media_types.cartoons'))
                                <a href="{{ route('cartoons.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.cartoons')</a>
            @break
        @case(__('miscellaneous.media_types.episode'))
<?php
if (!empty($current_media->belongs_to)) {
    $series = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                <a href="{{ route('media.datas', ['id' => $series->data->id]) }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.episode')</a>
<?php
} else {
?>
                                <a href="{{ route('series.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.series')</a>
<?php
}
?>
            @break
        @case(__('miscellaneous.media_types.tv_series'))
                                <a href="{{ route('series.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.series')</a>
            @break
        @case(__('miscellaneous.media_types.song'))
<?php
if (!empty($current_media->belongs_to)) {
    $album = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                <a href="{{ route('media.datas', ['id' => $album->data->id]) }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.song')</a>
<?php
} else {
?>
                                <a href="{{ route('songs.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.album')</a>
<?php
}
?>
            @break
        @case(__('miscellaneous.media_types.music_album'))
                                <a href="{{ route('songs.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.album')</a>
            @break
        @case(__('miscellaneous.media_types.tv_program'))
                                <a href="{{ inArrayR(__('miscellaneous.category.preach'), $current_media->categories, 'category_name') ? route('programs.entity.home', ['entity' => 'preach']) : route('programs.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>{{ inArrayR(__('miscellaneous.category.preach'), $current_media->categories, 'category_name') ? __('miscellaneous.public.media.datas.return_link.program.preach') : __('miscellaneous.public.media.datas.return_link.program.default') }}</a>
            @break
        @default
                                <a href="{{ route('home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.back_home')</a>
    @endswitch
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-7 mx-auto">
    @if ($current_media->type->type_name == __('miscellaneous.media_types.tv_series') || $current_media->type->type_name == __('miscellaneous.media_types.music_album'))
                                <div class="bg-image">
                                    <img src="{{ !empty($current_media->cover_url) ? $current_media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $current_media->media_title }}" class="w-100 rounded-4">
                                    <div class="mask"></div>
                                </div>
    @endif

    @if ($current_media->type->type_name != __('miscellaneous.media_types.tv_series') && $current_media->type->type_name != __('miscellaneous.media_types.music_album'))
        @if (!empty($current_media->media_url))
            @if ($current_media->source == 'AWS')
                                <div class="ratio ratio-16x9 bg-dark overflow-hidden rounded-4">
                                    <video src="{{ $current_media->media_url }}" loop controls class="hover-to-play w-100" poster="{{ $current_media->cover_url }}"></video>
                                </div>
            @else
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $current_media->media_url }}?rel=0" allowfullscreen frameborder="0"></iframe>
                                </div>
            @endif
        @else
                                <div class="bg-image">
                                    <img src="{{ !empty($current_media->cover_url) ? $current_media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $current_media->media_title }}" class="w-100 rounded-4">
                                    <div class="mask"></div>
                                </div>
        @endif
    @endif

                                <div class="movie-details-video-content-wrap pt-0">
                                    <div class="movie-details-content">
                                        <div class="movie-details-info">
                                            <h2 class="h2 mb-4 fw-bold">{{ $current_media->media_title }}</h2>

                                            <ul>
    @if (!empty($current_media->author_names))
                                                <li class="text-muted fw-normal"><span>@lang('miscellaneous.public.media.label.author')@lang('miscellaneous.colon_after_word') </span> {{ $current_media->author_names }}</li>
    @endif
    @if (!empty($current_media->media_description))
                                                <li class="mb-3 text-muted fw-normal">{{ $current_media->media_description }}</li>
    @endif
    @if (!empty($current_media->belongs_to))
        @if ($current_media->type->type_name == __('miscellaneous.media_types.episode'))
<?php
if (!empty($current_media->belongs_to)) {
    $series = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                                <li><span>@lang('miscellaneous.public.media.label.series')@lang('miscellaneous.colon_after_word') </span> <a href="{{ route('media.datas', ['id' => $series->data->id]) }}" class="fw-normal text-decoration-underline">{{ $series->data->media_title }}</a></li>
<?php
}
?>
        @endif

        @if ($current_media->type->type_name == __('miscellaneous.media_types.song'))
<?php
if (!empty($current_media->belongs_to)) {
    $album = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                                <li><span>@lang('miscellaneous.public.media.label.album')@lang('miscellaneous.colon_after_word') </span> <a href="{{ route('media.datas', ['id' => $album->data->id]) }}" class="fw-normal text-decoration-underline">{{ $album->data->media_title }}</a></li>
<?php
}
?>
        @endif
    @endif
    @if (!empty($current_media->artist_names))
                                                <li class="text-muted fw-normal"><span>@lang('miscellaneous.public.media.label.artist')@lang('miscellaneous.colon_after_word') </span> {{ $current_media->artist_names }}</li>
    @endif
    @if (!empty($current_media->writer))
                                                <li class="text-muted fw-normal"><span>@lang('miscellaneous.public.media.label.writter')@lang('miscellaneous.colon_after_word') </span> {{ $current_media->writer }}</li>
    @endif
    @if (!empty($current_media->director))
                                                <li class="text-muted fw-normal"><span>@lang('miscellaneous.public.media.label.director')@lang('miscellaneous.colon_after_word') </span> {{ $current_media->director }}</li>
    @endif
    @if (!empty($current_media->published_date))
                                                <li class="text-muted fw-normal"><span>@lang('miscellaneous.public.media.label.published_date')@lang('miscellaneous.colon_after_word') </span> {{ $current_media->published_date }}</li>
    @endif
    @if (count($current_media->categories) > 0)
                                                <li class="mt-4" style="width: 80%!important; white-space: normal!important;">
        @foreach ($current_media->categories as $cat)
                                                    <h3 class="me-lg-0 me-2">
                                                        <span class="badge bg-info fw-normal">{{ $cat->category_name }}</span>
                                                    </h3>
        @endforeach
                                                </li>
    @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
    @include('partials.count')
    @if (Auth::check())
                                    <div class="action">
                                        <button title="{{ inArrayR($current_media->id, $current_user->watchlist->orders, 'media_id') ? __('miscellaneous.public.withdraw_watchlist') : __('miscellaneous.public.add_watchlist') }}" class="Watch-list-btn{{ inArrayR($current_media->id, $current_user->watchlist->orders, 'media_id') ? ' dktv-btn-green' : '' }}" type="button" data-status="{{ inArrayR($current_media->id, $current_user->watchlist->orders, 'media_id') ? 'added' : 'withdrawn' }}" data-watchlist-id="{{ $current_user->watchlist_id }}" onclick="event.preventDefault(); toggleAction(this, {{ $current_media->id }}, 'watchlist');">
                                            <i class="zmdi zmdi-{{ inArrayR($current_media->id, $current_user->watchlist->orders, 'media_id') ? 'check' : 'plus' }}"></i>
                                        </button>
                                        <button title="{{ inArrayR($current_user->email, $likes, 'email') ? __('miscellaneous.public.retire_like') : __('miscellaneous.public.send_like') }}" class="Watch-list-btn ms-2{{ inArrayR($current_user->email, $likes, 'email') ? ' dktv-btn-pink' : '' }}" type="button" data-status="{{ inArrayR($current_user->email, $likes, 'email') ? 'liked' : 'unliked' }}" onclick="event.preventDefault(); toggleAction(this, {{ $current_media->id }}, 'like');">
                                            <i class="bi bi-{{ inArrayR($current_user->email, $likes, 'email') ? 'heart-fill' : 'heart' }} align-text-bottom"></i>
                                        </button>
                                    </div>
    @else
                                    <div class="action">
                                        <button title="@lang('miscellaneous.public.add_watchlist')" class="Watch-list-btn" type="button" onclick="event.preventDefault(); window.location.replace('{{ route('login') }}');">
                                            <i class="zmdi zmdi-plus"></i>
                                        </button>
                                        <button title="@lang('miscellaneous.public.send_like')" class="Watch-list-btn ms-2" type="button" onclick="event.preventDefault(); window.location.replace('{{ route('login') }}');">
                                            <i class="bi bi-heart align-text-bottom"></i>
                                        </button>
                                    </div>
    @endif
                                </div>

    @if ($current_media->type->type_name == __('miscellaneous.media_types.tv_series') || $current_media->type->type_name == __('miscellaneous.media_types.music_album') || $current_media->type->type_name == __('miscellaneous.media_types.tv_program'))
<?php
$belonging_medias = $api_client_manager::call('GET', getApiURL() . '/media/find_by_belongs_to/' . $current_media->id);
?>

        @if ($belonging_medias->success)
            @if (count($belonging_medias->data) > 0)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h3 class="mt-4 mb-3 text-muted fw-bold">
                @if ($current_media->type->type_name == __('miscellaneous.media_types.tv_series'))
                                            @lang('miscellaneous.public.media.all_episodes')
                @endif
                @if ($current_media->type->type_name == __('miscellaneous.media_types.music_album'))
                                            @lang('miscellaneous.public.media.all_songs')
                @endif
                                        </h3>
                                    </div>
                                    <div class="col-12">
                                        <div class="list-group list-group-flush">
                @foreach ($belonging_medias->data as $media)
                                            <a href="{{ route('media.datas', ['id' => $media->id]) }}" class="list-group-item list-group-item-action">
                                                <div class="ratio ratio-16x9 float-start me-3" style="width: 160px;">
                                                    <img src="{{ !empty($media->cover_url) ? $media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $media->media_title }}" width="190" class="float-start rounded-4 me-3">
                                                </div>
                                                <h4 class="my-2 dktv-text-green fw-bold">{{ Str::limit($media->media_title, 40, '...') }}</h4>
                                                <p class="text-muted">{{ !empty($media->media_description) ? Str::limit($media->media_description, 20, '...') : $media->author_names }}</p>
                                            </a>
                @endforeach
                                        </div>
                                    </div>
                                </div>
            @endif
        @endif
    @endif
                            </div>

                            <div class="col-sm-5 mx-auto">
                                <h3 class="text-secondary pb-2 border-bottom">@lang('miscellaneous.public.media.related_medias')</h3>

                                <div class="list-group list-group-flush">
    @forelse ($other_medias as $media)
        @if ($media['id'] != $current_media->id)
                                    <a href="{{ route('media.datas', ['id' => $media['id']]) }}" class="list-group-item list-group-item-action bg-transparent" title="{{ $media['media_title'] }}">
                                        <div class="ratio ratio-16x9 float-start me-3" style="width: 160px;">
                                            <img src="{{ !empty($media['cover_url']) ? $media['cover_url'] : asset('assets/img/blank-media-video.png') }}" alt="{{ $media['media_title'] }}" width="140" class="float-start rounded-4 me-3">
                                        </div>
                                        <h4 class="my-2 dktv-text-green fw-bold">{{ Str::limit($media['media_title'], 40, '...') }}</h4>
                                        <p class="text-muted">{{ !empty($media['media_description']) ? Str::limit($media['media_description'], 20, '...') :$media['author_names'] }}</p>
                                    </a>
        @endif
    @empty
    @endforelse

    @switch($current_media->type->type_name)
        @case(__('miscellaneous.media_types.feature_film'))
                                    <a href="{{ route('films.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
            @break
        @case(__('miscellaneous.media_types.cartoons'))
                                    <a href="{{ route('cartoons.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
            @break
        @case(__('miscellaneous.media_types.episode'))
<?php
if (!empty($current_media->belongs_to)) {
    $series = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                    <a href="{{ route('media.datas', ['id' => $series->data->id]) }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
<?php
} else {
?>
                                    <a href="{{ route('series.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
<?php
}
?>
            @break
        @case(__('miscellaneous.media_types.tv_series'))
                                    <a href="{{ route('series.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
            @break
        @case(__('miscellaneous.media_types.song'))
<?php
if (!empty($current_media->belongs_to)) {
    $album = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                    <a href="{{ route('media.datas', ['id' => $album->data->id]) }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
<?php
} else {
?>
                                    <a href="{{ route('songs.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
<?php
}
?>
            @break
        @case(__('miscellaneous.media_types.music_album'))
                                    <a href="{{ route('songs.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">@lang('miscellaneous.see_all')<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
            @break
        @case(__('miscellaneous.media_types.tv_program'))
                                    <a href="{{ inArrayR(__('miscellaneous.category.preach'), $current_media->categories, 'category_name') ? route('programs.entity.home', ['entity' => 'preach']) : route('programs.home') }}" class="list-group-item list-group-item-action border-bottom-0 bg-transparent text-center">{{ inArrayR(__('miscellaneous.category.preach'), $current_media->categories, 'category_name') ? __('miscellaneous.see_all') : __('miscellaneous.see_all') }}<i class="bi bi-chevron-double-right ms-2 fs-5 align-middle"></i></a>
            @break
        @default
    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->
@endsection
