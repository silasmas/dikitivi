                                <div class="card border rounded-4">
                                    <div class="card-header bg-light">
                                        <h3 class="mb-0 text-muted fw-bold">@lang('miscellaneous.account.watchlist')</h3>
                                    </div>

                                    <div class="list-group list-group-flush">
                @foreach ($watchlist as $item)
                                        <a href="{{ route('media.datas', ['id' => $item->media->id]) }}" class="list-group-item list-group-item-action">
                                            <img src="{{ !empty($item->media->cover_url) ? $item->media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $item->media->media_title }}" width="160" class="float-start rounded-4 me-3">
                                            <h4 class="my-2 dktv-text-green fw-bold">{{ $item->media->media_title }}</h4>
                                            <p class="text-muted">{{ !empty($item->media->media_description) ? Str::limit($item->media->media_description, 20, '...') : $item->media->author_names }}</p>
                                        </a>
                @endforeach
                                    </div>
                                </div>
