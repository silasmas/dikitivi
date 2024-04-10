@extends('layouts.app')

@section('app-content')

                <!-- Our-product-area Area  -->
                <div class="movie-details-wrap section-pb-50">
                    <div class="container-sm container-fluid">
                        <div class="row mb-3">
                            <div class="col-12">
    @switch($current_media->type->type_name)
        @case(__('miscellaneous.media_types.feature_film'))
                                <a href="{{ route('films.home') }}" class="btn bg-transparent text-muted text-start rounded-0 shadow-0"><i class="bi bi-arrow-left me-3 fs-4 align-middle"></i>@lang('miscellaneous.public.media.datas.return_link.film')</a>
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
                            <div class="col-lg-10 col-sm-9 mx-auto">
    @if ($current_media->type->type_name == __('miscellaneous.media_types.tv_series') || $current_media->type->type_name == __('miscellaneous.media_types.music_album'))
                                <div class="bg-image">
                                    <img src="{{ $current_media->cover_url }}" alt="{{ $current_media->media_title }}" class="w-100 rounded-4">
                                    <div class="mask"></div>
                                </div>
    @endif

    @if ($current_media->type->type_name != __('miscellaneous.media_types.tv_series') && $current_media->type->type_name != __('miscellaneous.media_types.music_album'))
                                <div class="ratio ratio-16x9">
                                    <iframe id="ytplayer" src="{{ $current_media->media_url }}?showinfo=0&modestbranding=1&enablejsapi=1&origin={{ getWebURL() }}"frameborder="0"></iframe>
                                </div>
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="count">
                                        <i class="bi bi-eye" title="@lang('miscellaneous.views')"></i> {{ count($views->data) }}
                                        <i class="bi bi-heart ms-3" title="@lang('miscellaneous.likes')"></i> {{ count($likes->data) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-3 mx-auto">
                                <h3 class="text-secondary pb-2 border-bottom">@lang('miscellaneous.public.media.categories')</h3>

    @forelse ($current_media->categories as $cat)
                                <h3 class="me-lg-0 me-2">
                                    <span class="badge bg-info fw-normal">{{ $cat->category_name }}</span>
                                </h3>
    @empty
    @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->
    
@endsection
