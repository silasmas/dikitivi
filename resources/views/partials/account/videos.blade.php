                                <div class="card border rounded-4">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h3 class="mb-0 text-muted fw-bold">@lang('miscellaneous.account.my_videos')</h3>
                                    </div>

                                    <div class="card-body text-center">
@if ($current_user->status->status_name == __('miscellaneous.user_statuses.intermediate'))
                                        <h5 class="mb-4">@lang('miscellaneous.account.identity_document.message1')</h5>
                                        <h5 class="mb-1"><i class="bi bi-exclamation-circle"></i></h5>
                                        <p class="m-0 fw-semibold">@lang('miscellaneous.account.identity_document.message2')</p>

                                        <form method="POST" action="{{ route('account') }}">
                                            <input type="hidden" name="user_id" value="{{ $current_user->id }}">
                                            <input type="hidden" name="api_token" value="{{ $current_user->api_token }}">
        @csrf
                                            <div class="row g-4">
                                                <div class="col-lg-5 col-sm-7 mx-auto">
                                                    <select name="register_image_name" id="register_image_name" class="form-control mb-3">
                                                        <option class="small" {{ $current_user->id_card_recto != null ? '' : 'selected ' }}disabled>@lang('miscellaneous.account.identity_document.choose_type.title')</option>
                                                        <option value="Carte d'identité"{{ $current_user->id_card_type == 'Carte d\'identité' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.identity_card')</option>
                                                        <option value="Carte d'électeur"{{ $current_user->id_card_type == 'Carte d\'électeur' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.voter_card')</option>
                                                        <option value="Passeport"{{ $current_user->id_card_type == 'Passeport' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.passport')</option>
                                                        <option value="Permis de conduire"{{ $current_user->id_card_type == 'Permis de conduire' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.driving_license')</option>
                                                        <option value="Autre"{{ $current_user->id_card_type == 'Autre' ? ' selected' : '' }}>@lang('miscellaneous.account.identity_document.choose_type.other')</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-7"></div>
                                                <div class="col-sm-6">
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
                                                <div class="col-sm-6">
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

                                            <button class="btn btn-block btn-light border border-default rounded-pill shadow-0" type="submit">@lang('miscellaneous.register')</button>
                                        </form>

    @if ($current_user->id_card_recto != null)
                                        <h5 class="mb-4 text-center dktv-bg-green">@lang('miscellaneous.awaiting_approval')</h5>
    @endif
@else
    
@endif
                                    </div>
                                </div>
