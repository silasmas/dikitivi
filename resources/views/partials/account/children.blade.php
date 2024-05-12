                                <div class="card border rounded-4">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h3 class="mb-0 text-muted fw-bold">@lang('miscellaneous.account.parental_control')</h3>
@if (count($children) == 0)
                                        <button type="button" class="btn dktv-btn-blue px-3 py-1 rounded-pill shadow-0" data-bs-toggle="modal" data-bs-target="#registerModalChild">
                                            <span class="zmdi zmdi-plus me-lg-3"></span><span class="d-lg-inline d-none">@lang('miscellaneous.account.add_child.link')</span>
                                        </button>
@endif
                                    </div>

                                    <div class="card-body">
                                        <div class="row g-3">
@forelse ($children as $child)
                                            <div class="col-xl-6 col-sm-8 mx-auto">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <img src="{{ $child->avatar_url }}" alt="{{ $child->firstname . ' ' . $child->lastname }}" width="70" class="float-start rounded-circle me-3">
                                                        <h4 class="mt-2 mb-1 dktv-text-green fw-bold text-truncate">{{ $child->firstname . ' ' . $child->lastname }}</h4>
                                                        <p class="m-0 text-muted text-truncate">{{ '@' . $child->username }}</p>
                                                    </div>
                                                </div>
                                            </div>
@empty
                                            <div class="col-lg-7 col-sm-9 col-11 mx-auto">
                                                <div class="text-center">
                                                    <small class="m-0">@lang('miscellaneous.account.add_child.message')</small>
                                                    <button type="button" class="btn dktv-btn-blue px-3 py-1 rounded-pill shadow-0" data-bs-toggle="modal" data-bs-target="#registerModalChild">
                                                        <span class="zmdi zmdi-plus me-lg-3"></span>@lang('miscellaneous.account.add_child.link')
                                                    </button>
                                                </div>
                                            </div>
@endforelse
                                        </div>
                                    </div>
                                </div>
