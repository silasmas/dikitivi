<?php $lastPage = $lastPage_searchResults ?>
@extends('layouts.app')

@section('app-content')

                <!-- movies list start  -->
                <div class="movie-list section-padding-lr section-pt-50 section-pb-50">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card border rounded-4">
                                    <h3 class="mb-4">@lang('miscellaneous.search_result', ['data' => 'search_content'])</h3>

                                    <div class="list-group list-group-flush">
    @foreach ($medias as $media)
                                        <a href="{{ route('media.datas', ['id' => $media->id]) }}" class="list-group-item list-group-item-action position-relative">
                                            <img src="{{ !empty($media->cover_url) ? $media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $media->media_title }}" width="160" class="float-sm-start rounded-4 me-3">
                                            <h4 class="my-2 dktv-text-green fw-bold">{{ $media->media_title ?? '' }}</h4>
                                            <p class="text-muted">{{ !empty($media->media_description) ? Str::limit($media->media_description, 20, '...') : $media->author_names }}</p>
                                        </a>
    @endforeach
                                    </div>

    @if ($lastPage > 1)
                                    <div class="card-body text-center">
        @include('partials.pagination')
                                    </div>
    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--// movies list end  -->
    
@endsection
