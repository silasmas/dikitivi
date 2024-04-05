@extends('layouts.app')

@section('app-content')

                <!-- Our-product-area Area  -->
                <div class="movie-details-wrap section-pb-50">
                    <div class="container-sm container-fluid">
                        <div class="row">
                            <div class="col-lg-10 col-sm-9 mx-auto">
    @if ($current_media->type->type_name == __('miscellaneous.media_types.tv_series') || $current_media->type->type_name == __('miscellaneous.media_types.music_album'))
                                <div class="bg-image">
                                    <img src="{{ $current_media->cover_url }}" alt="{{ $current_media->media_title }}">
                                    <div class="mask"></div>
                                </div>
    @endif

    @if ($current_media->type->type_name != __('miscellaneous.media_types.tv_series') && $current_media->type->type_name != __('miscellaneous.media_types.music_album'))
                                <div class="ratio ratio-16x9">
                                    <iframe src="{{ $current_media->media_url }}?showInfo=0&amp;rel=0"></iframe>
                                </div>
    @endif

                                <div class="movie-details-video-content-wrap pt-0">
                                    <div class="movie-details-content">
                                        <div class="movie-details-info">
                                            <h2 class="h2 mb-4 fw-bold">{{ $current_media->media_title }}</h2>

                                            <ul>
    @if (!empty($current_media->author_names))
                                                <li class="text-muted fw-normal"><span>Author: </span> {{ $current_media->author_names }}</li>
    @endif
    @if (!empty($current_media->media_description))
                                                <li class="mb-3 text-muted fw-normal">{{ $current_media->media_description }}</li>
    @endif
    @if (!empty($current_media->belongs_to))
        @if ($current_media->type->type_name == __('miscellaneous.media_types.episode'))
<?php
$series = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                                <li><span>Series: </span> <a href="{{ route('media.datas', ['id' => $series->data->id]) }}" class="fw-normal text-decoration-underline">{{ $series->data->media_title }}</a></li>
        @endif

        @if ($current_media->type->type_name == __('miscellaneous.media_types.song'))
<?php
$album = $api_client_manager::call('GET', getApiURL() . '/media/' . $current_media->belongs_to);
?>
                                                <li><span>Album: </span> <a href="{{ route('media.datas', ['id' => $album->data->id]) }}" class="fw-normal text-decoration-underline">{{ $album->data->media_title }}</a></li>
        @endif
    @endif
    @if (!empty($current_media->artist_names))
                                                <li class="text-muted fw-normal"><span>Artist(s): </span> {{ $current_media->artist_names }}</li>
    @endif
    @if (!empty($current_media->writer))
                                                <li class="text-muted fw-normal"><span>Writting by: </span> {{ $current_media->writer }}</li>
    @endif
    @if (!empty($current_media->director))
                                                <li class="text-muted fw-normal"><span>Directed by: </span> {{ $current_media->director }}</li>
    @endif
    @if (!empty($current_media->published_date))
                                                <li class="text-muted fw-normal"><span>Publishing date: </span> {{ $current_media->published_date }}</li>
    @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-3 mx-auto">
    @forelse ($current_media->categories as $cat)
                                <h3 class="me-2">
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
