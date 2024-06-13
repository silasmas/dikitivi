                                <div class="card border rounded-4">
                                    <div class="card-header bg-light">
                                        <h3 class="mb-0 text-muted fw-bold">@lang('miscellaneous.account.watchlist')</h3>
                                    </div>

@if (count($watchlist) > 0)
                                    <div class="list-group list-group-flush">
    @foreach ($watchlist as $item)
        @if (!empty($item->media))
                                        <a href="{{ route('media.datas', ['id' => $item->media->id]) }}" class="list-group-item list-group-item-action position-relative">
                                            <button type="button" class="btn btn-link text-muted py-1 rounded-pill float-end position-relative" style="z-index: 999; padding-left: 0.47rem; padding-right: 0.47rem;" title="@lang('miscellaneous.public.withdraw_watchlist')" data-bs-toggle="tooltip" data-bs-placement="left" data-watchlist-id="{{ $watchlist_id }}" onclick="event.preventDefault(); toggleAction(this, {{ $item->media->id }}, 'delete_from_watchlist');">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <img src="{{ !empty($item->media->cover_url) ? $item->media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $item->media->media_title }}" width="160" class="float-sm-start rounded-4 me-3">
                                            <h4 class="my-2 dktv-text-green fw-bold">{{ $item->media->media_title ?? '' }}</h4>
                                            <p class="text-muted">{{ !empty($item->media->media_description) ? Str::limit($item->media->media_description, 20, '...') : $item->media->author_names }}</p>
                                        </a>
        @endif
    @endforeach
                                    </div>

    @if ($lastPage > 1)
                                    <div class="card-body text-center">
        @include('partials.pagination')
                                    </div>
    @endif
@else
                                    <div class="card-body text-center">
                                        <h5 class="mb-4">@lang('miscellaneous.empty_list')</h5>
    @if ($for_youth == 1)
                                        <a href="{{ route('home') }}" class="btn dktv-btn-green px-3 py-1 me-sm-2 mb-sm-0 mb-1 rounded-pill shadow-0">
                                            <span class="zmdi zmdi-home me-3"></span>@lang('miscellaneous.back_home')
                                        </a>
    @else
                                        <a href="{{ route('home') }}" class="btn dktv-btn-yellow px-3 py-1 me-sm-2 mb-sm-0 mb-1 rounded-pill shadow-0">
                                            <span class="zmdi zmdi-home me-3"></span>@lang('miscellaneous.back_home')
                                        </a>
                                        <a href="{{ route('account.entity', ['entity' => 'videos']) }}" class="btn dktv-btn-pink px-3 py-1 rounded-pill shadow-0">
                                            <span class="zmdi zmdi-download me-3"></span>@lang('miscellaneous.account.my_videos')
                                        </a>
    @endif
                                    </div>
@endif
                                </div>
