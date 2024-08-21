<?php 
$watchlist = paginate($current_user->watchlist->orders, 7);
$lastPage = $watchlist->lastPage(); 
?>
@extends('layouts.app')

@section('app-content')

                <!-- Our-product-area Area  -->
                <div class="our-product-area pb-5">
                    <div class="container-coustom">
                        <div class="row g-3">
                            <div class="col-lg-4 col-sm-5 mx-auto">
                                <div class="card border mb-3 rounded-4">
                                    <div class="card-body text-center">
                                        <div class="bg-image mb-3">
                                            <img src="{{ $current_user->avatar_url }}" alt="{{ $current_user->firstname . ' ' . $current_user->lastname }}" class="user-image img-fluid img-thumbnail rounded">
                                            <div class="mask">
                                                <form method="POST">
                                                    <input type="hidden" name="user_id" id="user_id" value="{{ $current_user->id }}">
                                                    <label for="avatar" class="btn btn-floating dktv-btn-yellow position-absolute pt-2 rounded-circle shadow" style="bottom: 1rem; right: 1rem; text-transform: inherit!important;" title="@lang('miscellaneous.change_image')" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                                        <span class="bi bi-pencil-fill"></span>
                                                        <input type="file" name="avatar" id="avatar" class="d-none">
                                                    </label>
                                                </form>
                                            </div>
                                        </div>

                                        <h3 class="h3 m-0 fw-bold">{{ $current_user->firstname . ' ' . $current_user->lastname }}</h3>
    @if (!empty($current_user->username))
                                        <p class="card-text m-0 text-muted">{{ '@' . $current_user->username }}</p>
    @endif
                                    </div>
                                </div>

                                <div class="list-group">
                                    <a href="{{ route('account') }}" class="list-group-item list-group-item-action{{ Route::is('account') ? ' active' : '' }}">
                                        <i class="bi bi-person-lines-fill me-3 fs-5 align-middle"></i>@lang('miscellaneous.account.personal_infos.title')
                                    </a>
                                    <a href="{{ route('account.entity', ['entity' => 'watchlist']) }}" class="list-group-item list-group-item-action{{ !empty($entity) && $entity == 'watchlist' ? ' active' : '' }}">
                                        <i class="bi bi-file-play me-3 fs-5 align-middle"></i>@lang('miscellaneous.account.watchlist')
                                    </a>
    @if ($for_youth != 1)
                                    <a href="{{ route('account.entity', ['entity' => 'videos']) }}" class="list-group-item list-group-item-action{{ !empty($entity) && $entity == 'videos' ? ' active' : '' }}">
                                        <i class="bi bi-download me-3 fs-5 align-middle"></i>@lang('miscellaneous.account.my_videos')
                                    </a>
                                    <a href="{{ route('account.entity', ['entity' => 'children']) }}" class="list-group-item list-group-item-action{{ !empty($entity) && $entity == 'children' ? ' active' : '' }}">
                                        <i class="bi bi-people me-3 fs-5 align-middle"></i>@lang('miscellaneous.account.child.title')
                                    </a>
    @endif
                                </div>
                            </div>

                            <div class="col-lg-8 col-sm-7 col-12">
    @if (Route::is('account.entity'))
        @include('partials.account.' . $entity)
    @else
        @include('partials.account.home')
    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!--// Our-product-area Area  -->

@endsection
