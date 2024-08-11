                                <div class="card border rounded-4">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h3 class="mb-0 text-muted fw-bold">@lang('miscellaneous.account.my_videos')</h3>
                                    </div>

                                    <div class="card-body text-center">
@if ($current_user->status->status_name == __('miscellaneous.user_statuses.intermediate'))
                                        <p class="mb-3 px-sm-5 dktv-line-height-1_4">@lang('miscellaneous.account.identity_document.message1')</p>
                                        <p class="mb-5 px-sm-5 fw-semibold dktv-line-height-1_4">@lang('miscellaneous.account.identity_document.message2')</p>

                                        {{-- <form method="POST" action="{{ route('account') }}"> --}}
                                        <form>
                                            <input type="hidden" name="user_id" value="{{ $current_user->id }}">
                                            <input type="hidden" name="api_token" value="{{ $current_user->api_token }}">
        @csrf
                                            <div class="row g-4">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-lg-5 col-sm-7 mx-auto">
                                                            <select name="register_image_name" id="register_image_name" class="form-select">
                                                                <option class="small" {{ $current_user->id_card_recto != null ? '' : 'selected ' }}disabled>@lang('miscellaneous.account.identity_document.choose_type.title')</option>
                                                                <option value="Carte d'identité"{{ $current_user->id_card_type == 'Carte d\'identité' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.identity_card')</option>
                                                                <option value="Carte d'électeur"{{ $current_user->id_card_type == 'Carte d\'électeur' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.voter_card')</option>
                                                                <option value="Passeport"{{ $current_user->id_card_type == 'Passeport' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.passport')</option>
                                                                <option value="Permis de conduire"{{ $current_user->id_card_type == 'Permis de conduire' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.driving_license')</option>
                                                                <option value="Autre"{{ $current_user->id_card_type == 'Autre' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.other')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="rectoImageWrapper" class="col-sm-6">
                                                    <p class="m-0 small"><strong class="text-uppercase">@lang('miscellaneous.recto')</strong> (@lang('miscellaneous.account.identity_document.click_to_change'))</p>
                                                    <div class="bg-image rounded overflow-hidden overlay mb-2">
                                                        <img src="{{ $current_user->id_card_recto != null ? $current_user->id_card_recto : asset('assets/img/blank-id-doc.png') }}" alt="@lang('miscellaneous.recto')" class="identity-recto img-fluid">
                                                        <div class="mask h-100">
                                                            <label role="button" for="image_recto" class="d-flex justify-content-center align-items-center h-100 fs-3 text-black text-uppercase">
                                                                <span class="{{ $current_user->id_card_recto != null ? 'opacity-0' : 'opacity-100' }}">@lang('miscellaneous.recto')</span>
                                                                <input type="file" name="image_recto" id="image_recto" class="d-none">
                                                            </label>
                                                            <input type="hidden" name="data_recto" id="data_recto">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="versoImageWrapper" class="col-sm-6">
                                                    <p class="m-0 small"><strong class="text-uppercase">@lang('miscellaneous.verso')</strong> (@lang('miscellaneous.account.identity_document.click_to_change'))</p>
                                                    <div class="bg-image rounded overflow-hidden overlay mb-3">
                                                        <img src="{{ $current_user->id_card_verso != null ? $current_user->id_card_verso : asset('assets/img/blank-id-doc.png') }}" alt="@lang('miscellaneous.verso')" class="identity-verso img-fluid">
                                                        <div class="mask h-100">
                                                            <label role="button" for="image_verso" class="d-flex justify-content-center align-items-center h-100 fs-3 text-black text-uppercase">
                                                                <span class="{{ $current_user->id_card_verso != null ? 'opacity-0' : 'opacity-100' }}">@lang('miscellaneous.verso')</span>
                                                                <input type="file" name="image_verso" id="image_verso" class="d-none">
                                                            </label>
                                                            <input type="hidden" name="data_verso" id="data_verso">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-lg-5 col-sm-7 mx-auto">
                                                    <button class="btn btn-block dktv-btn-green rounded-pill shadow-0" type="submit">@lang('miscellaneous.register')</button>
                                                </div>
                                            </div>
                                        </form>

    @if ($current_user->id_card_recto != null)
                                        <h5 class="mb-4 text-center dktv-bg-green">@lang('miscellaneous.awaiting_approval')</h5>
    @endif
@else
    @if (request()->has('act'))
        @if (request()->get('act') == 'add')
        @endif

        @if (request()->get('act') == 'update')
        @endif
    @else
        @if (count($user_medias) > 0)
                                    <div class="list-group list-group-flush">
            @foreach ($user_medias as $med)
                                        <a href="{{ route('media.datas', ['id' => $med->id]) }}" class="list-group-item list-group-item-action position-relative">
                                            <button type="button" class="btn btn-link text-muted py-1 rounded-pill float-end position-relative" style="z-index: 999; padding-left: 0.47rem; padding-right: 0.47rem;" title="@lang('miscellaneous.public.withdraw_watchlist')" data-bs-toggle="tooltip" data-bs-placement="left" data-watchlist-id="{{ $current_user->watchlist_id }}" onclick="event.preventDefault(); toggleAction(this, {{ $med->id }}, 'delete_from_watchlist');">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                            <img src="{{ !empty($med->cover_url) ? $med->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $med->media_title }}" width="160" class="float-sm-start rounded-4 me-3">
                                            <h4 class="my-2 dktv-text-green fw-bold">{{ $med->media_title }}</h4>
                                            <p class="text-muted">{{ !empty($med->media_description) ? Str::limit($med->media_description, 20, '...') : $med->author_names }}</p>
                                        </a>
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
                                        <a href="{{ route('account.entity', ['entity' => 'videos']) }}" class="btn dktv-btn-pink px-3 py-1 rounded-pill shadow-0">
                                            <span class="zmdi zmdi-download me-3"></span>@lang('miscellaneous.account.videos.add')
                                        </a>
                                    </div>
        @endif
    @endif
@endif
                                    </div>
                                </div>
