                                <div class="card border rounded-4">
@if ($for_youth != 1)
    @if (request()->has('id'))
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <a href="{{ route('account.entity', ['entity' => 'children']) }}" class="btn btn-link px-2 pt-1 text-muted fw-semibold">
                                            <i class="bi bi-arrow-left me-3"></i>@lang('miscellaneous.back_list')
                                        </a>
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('account.entity', ['entity' => 'update_child']) }}">
        @csrf
                                            <input type="hidden" name="user_id" value="{{ $child->id }}">
                                            <input type="hidden" name="api_token" value="{{ $current_user->api_token }}">

                                            <div class="row g-3">
                                                <div class="col-sm-5 mx-auto">
                                                    <div id="profileImageWrapper" class="row mt-3">
                                                        <div class="col-sm-7 col-9 mx-auto">
                                                            <p class="small mb-1 text-center dktv-line-height-1_4">@lang('miscellaneous.account.child.click_to_change_picture')</p>

                                                            <div class="bg-image hover-overlay">
                                                                <img src="{{ asset($child->avatar_url) }}" alt="{{ $child->firstname . ' ' . $child->lastname }}" class="other-user-image img-fluid rounded-circle">
                                                                <div class="mask rounded-circle" style="background-color: rgba(5, 5, 5, 0.5);">
                                                                    <label role="button" for="image_profile" class="d-flex h-100 justify-content-center align-items-center">
                                                                        <i class="bi bi-pencil-fill text-white fs-2"></i>
                                                                        <input type="file" name="image_profile" id="image_profile" class="d-none">
                                                                    </label>
                                                                    <input type="hidden" name="data_profile" id="data_profile">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-7 mx-auto">
                                                    <!-- First name -->
                                                    <div class="form-floating mt-3">
                                                        <input type="text" name="register_firstname" id="update_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" value="{{ $child->firstname }}" required autofocus />
                                                        <label class="form-label" for="update_firstname">@lang('miscellaneous.firstname')</label>
                                                    </div>

                                                    <!-- Last name -->
                                                    <div class="form-floating mt-3">
                                                        <input type="text" name="register_lastname" id="update_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ $child->lastname }}" />
                                                        <label class="form-label" for="update_lastname">@lang('miscellaneous.lastname')</label>
                                                    </div>

                                                    <!-- Surname -->
                                                    <div class="form-floating mt-3">
                                                        <input type="text" name="register_surname" id="update_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ $child->surname }}" />
                                                        <label class="form-label" for="update_surname">@lang('miscellaneous.surname')</label>
                                                    </div>

                                                    <!-- Username -->
                                                    <div class="form-floating mt-3">
                                                        <input type="text" name="register_username" id="update_username" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ $child->username }}" />
                                                        <label class="form-label" for="update_username">@lang('miscellaneous.username')</label>
                                                    </div>

                                                    <!-- Birth date -->
                                                    <div class="form-floating mt-3">
                                                        <input type="text" name="register_birthdate" id="update_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" value="{{ !empty($child->birth_date) ? str_starts_with(app()->getLocale(), 'fr') ? \Carbon\Carbon::createFromFormat('Y-m-d', $child->birth_date)->format('d/m/Y') : \Carbon\Carbon::createFromFormat('Y-m-d', $child->birth_date)->format('m/d/Y') : null }}" />
                                                        <label class="form-label" for="update_birthdate">@lang('miscellaneous.birth_date.label')</label>
                                                    </div>

                                                    <!-- Gender -->
                                                    <div class="mt-3 text-center">
                                                        <p class="mb-lg-1 mb-0">@lang('miscellaneous.gender_title')</p>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="register_gender" id="update_male" value="M"{{ $child->gender == 'M' ? ' checked' : '' }}>
                                                            <label class="form-check-label text-muted" for="male">@lang('miscellaneous.gender1')</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="register_gender" id="update_female" value="F"{{ $child->gender == 'F' ? ' checked' : '' }}>
                                                            <label class="form-check-label text-muted" for="female">@lang('miscellaneous.gender2')</label>
                                                        </div>
                                                    </div>

                                                    <button class="btn dktv-btn-green btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register_update')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="card-body pt-3 border-top">
                                        <h3 class="text-muted fw-bold">@lang('miscellaneous.account.recently_watched_videos')</h3>

        @if (count($viewed_medias) > 0)
                                        <div class="list-group">
            @foreach ($viewed_medias as $media)
                                            <a href="{{ route('media.datas', ['id' => $media->id]) }}" class="list-group-item list-group-item-action position-relative">
                                                <img src="{{ !empty($media->cover_url) ? $media->cover_url : asset('assets/img/blank-media-video.png') }}" alt="{{ $media->media_title }}" width="160" class="float-sm-start rounded-4 me-3">
                                                <h4 class="my-2 dktv-text-green fw-bold">{{ $media->media_title }}</h4>
                                                <p class="text-muted">{{ !empty($media->media_description) ? Str::limit($media->media_description, 20, '...') : $media->author_names }}</p>
                                            </a>
            @endforeach
                                        </div>

                                        <div class="p-3 text-center">
            @include('partials.pagination')
                                        </div>

        @else
                                        <p class="pt-3 text-center">@lang('miscellaneous.empty_list')</p>
        @endif
                                    </div>
    @else
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h3 class="mb-0 text-muted fw-bold">@lang('miscellaneous.account.parental_control')</h3>
        @if (!empty($children))
            @if (count($children) > 0)
                                        <button type="button" class="btn dktv-btn-blue px-3 py-1 rounded-pill shadow-0" data-bs-toggle="modal" data-bs-target="#registerModalChild">
                                            <span class="zmdi zmdi-plus me-lg-3"></span><span class="d-lg-inline d-none">@lang('miscellaneous.account.add_child.link')</span>
                                        </button>
            @endif
        @endif
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
        @forelse ($children as $child)
                                            <div class="col-xl-6 col-sm-8 mx-auto">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="dropdown float-end">
                                                            <a role="button" id="childAction" class="btn btn-link p-1 text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </a>

                                                            <ul class="dropdown-menu" aria-labelledby="childAction">
                                                                <li><a class="dropdown-item" href="{{ route('account.entity', ['entity' => 'children', 'id' => $child->id]) }}">@lang('miscellaneous.details')</a></li>
                                                                <li><a class="dropdown-item" href="{{ route('account.entity.datas', ['entity' => 'children', 'id' => $child->id]) }}">@lang('miscellaneous.delete')</a></li>
                                                            </ul>
                                                        </div>

                                                        <img src="{{ $child->avatar_url }}" alt="{{ $child->firstname . ' ' . $child->lastname }}" width="70" class="float-start rounded-circle me-3">
                                                        <h4 class="mt-2 mb-1 dktv-text-green fw-bold text-truncate">{{ $child->firstname . ' ' . $child->lastname }}</h4>
                                                        <p class="m-0 text-muted text-truncate">{{ '@' . $child->username }}</p>
                                                    </div>
                                                </div>
                                            </div>
        @empty
                                            <div class="col-lg-7 col-sm-9 col-11 mx-auto">
                                                <div class="text-center">
                                                    <p>@lang('miscellaneous.account.add_child.message')</p>
                                                    <button type="button" class="btn dktv-btn-blue px-3 py-1 rounded-pill shadow-0" data-bs-toggle="modal" data-bs-target="#registerModalChild">
                                                        <span class="zmdi zmdi-plus me-lg-3"></span>@lang('miscellaneous.account.add_child.link')
                                                    </button>
                                                </div>
                                            </div>
        @endforelse
                                        </div>
                                    </div>
    @endif
@else
                                    <div class="card-body py-5 text-center">
                                        <h1 class="display-1 dktv-text-pink"><i class="bi bi-exclamation-triangle-fill"></i></h1>
                                        <h3 class="m-0 text-muted">@lang('miscellaneous.adult_content')</h3>
                                    </div>
@endif
                                </div>
